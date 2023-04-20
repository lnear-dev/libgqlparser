<?php
require_once __DIR__ . '/bootstrap.php';
    
class Printer implements LanguagePrinter
{
    private $type_name;
    private $fields = [];
    private $bases = [];
    private $deferredOutput = '';

    public function baseClass($type)
    {
        return isset($this->bases[$type]) ? $this->bases[$type] : 'Node';
    }

    public function startFile(): void
    {
        $this->deferredOutput = '';
            echo <<<'EOF'
            /** @generated */
        #pragma once
        
        #include "AstNode.h"
        
        #include <memory>
        #include <string>
        #include <utility>
        #include <vector>
        
        namespace lnear {
        namespace graphql {
        namespace ast {
        
        // The parser uses strdup to move from yytext to the heap, so we need
        // to use free instead of delete.
        struct CDeleter {
          void operator()(const char *p) const { free((void *)p); }
        };

        EOF;
    }

    public function endFile(): void
    {
        echo '';
        echo $this->deferredOutput;
        echo <<<'EOF'
        } // namespace ast
        } // namespace graphql
        } // namespace lnear
        
        EOF;
    }


    public function printFields()
    {
        foreach ($this->fields as $field) {
            list($type, $name, $nullable, $plural) = $field;
            $storage_type = $this->storageType($type);
            if ($plural) {
                $storage_type = "std::unique_ptr<std::vector<$storage_type>>";
            }
            $this->deferredOutput .= "  $storage_type {$name}_;

";
        }
    }

    public function storageType($type)
    {
        if ($type == 'string') {
            return 'std::unique_ptr<const char, CDeleter>';
        } elseif ($type == 'boolean') {
            return 'bool';
        } else {
            return "std::unique_ptr<$type>";
        }
    }

    public function ctorSingularType($type)
    {
        if ($type == 'string') {
            return 'const char *';
        } elseif ($type == 'boolean') {
            return 'bool';
        } else {
            return "$type *";
        }
    }

    public function ctorPluralType($type)
    {
        return "std::vector<{$this->storageType($type)}> *";
    }
    public function printConstructor()
    {
        $this->deferredOutput .= "  explicit {$this->type_name}(\n";
        $this->deferredOutput .= "    const yy::location &location\n";
        $cTorArg = function ($type, $name, $plural) {
            if ($plural) {
                $ctor_type = $this->ctorPluralType($type);
            } else {
                $ctor_type = $this->ctorSingularType($type);
            }
            return "      $ctor_type $name";
        };
        $cTorInit = function ($type, $name, $plural) {
            // Strings are const char *, just pass.
            // Vectors are passed by pointer and we take ownership.
            // Node types are passed in by pointer and we take ownership.
            $value = $name;
            return "    {$name}_($value)";
        };
        $args = array_map($cTorArg, array_column($this->fields, 0), array_column($this->fields, 1), array_column($this->fields, 3));
        $inits = array_map($cTorInit, array_column($this->fields, 0), array_column($this->fields, 1), array_column($this->fields, 3));
        $this->deferredOutput .= join(",\n", $args);
        $this->deferredOutput .= "\n  ) : {$this->baseClass($this->type_name)}(location)\n";
        $this->deferredOutput .= join(",\n", $inits);
        $this->deferredOutput .= "  {}\n";

    }

    public function printDestructorPrototype()
    {
        // $this->deferredOutput .= "  ~{$this->type_name}() {}\n";
        $this->deferredOutput .= "  ~{$this->type_name}() override {}\n";
    }

    public function printNoncopyable()
    {
        $this->deferredOutput .= "  {$this->type_name}(const {$this->type_name}&) = delete;\n";
        $this->deferredOutput .= "  {$this->type_name}& operator=(const {$this->type_name}&) = delete;\n";
    }


    public function startType($name): void
    {
        $this->type_name = $name;
        echo "class $name;" . PHP_EOL;
        $this->deferredOutput .= "class $name : public {$this->baseClass($name)} {\n";
        $this->fields = [];
    }

    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        if ($type == 'OperationKind') {
        $type = 'string';
      }
        $this->fields[] = [$type, $name, $nullable, $plural];
    }

    public function endType(string $name): void
    {
        $this->printFields();
        $this->deferredOutput .= " public:\n";
        $this->printConstructor();
        $this->deferredOutput .= "\n";
        $this->printDestructorPrototype();
        $this->deferredOutput .= "\n";
        $this->printNoncopyable();
        $this->deferredOutput .= "\n";
        $this->printGetters();
        $this->deferredOutput .= "  void accept(visitor::AstVisitor *visitor) const override;\n";
        $this->deferredOutput .= "};\n\n";

        $this->type_name = null;
        $this->fields = [];

    }

    private function  getterType($type, $nullable, $plural)
    {
       $t = $this->storageType($type);
         if ($plural && $nullable) {
            return "const std::vector<$t> *";
        } elseif ($plural) {
            return "const std::vector<$t> &";
        } 
        if(!$nullable) {
            if($type == 'boolean') {
                return "bool";
            }
            if ($type == 'string') {
                return "const char *";
            }
        } else {
            return "const $type*";
        }
        return "const $type&";
    }

    private function getterValueToReturn($rawValue, $type, $nullable, $plural)
    {
        if ($plural && $nullable) {
            return "$rawValue.get()";
        } elseif ($plural) {
            return "*$rawValue";
        } elseif ($type == 'boolean') {
            return "$rawValue";
        } elseif ($nullable || $type == 'string') {
            return "$rawValue.get()";
        } else {
            return "*$rawValue";
        }
    }


    public function printGetters()
    {
        foreach ($this->fields as $field) {
            list($type, $name, $nullable, $plural) = $field;
            $tName = title($name);
            $this->deferredOutput .= "  {$this->getterType($type, $nullable, $plural)} get{$tName}() const {\n";
            $name .= '_';
            $this->deferredOutput .= "    return {$this->getterValueToReturn($name, $type, $nullable, $plural)};\n";
            $this->deferredOutput .= "  }\n";
        }
    }

    public function startUnion($name): void
    {
        $this->type_name = $name;
        echo "class $name;\n";
        $this->deferredOutput .= "class $name : public Node {\n";
        $this->deferredOutput .= " public:\n";
        $this->printConstructor();
        $this->deferredOutput .= "};\n\n";
    }

    public function unionOption($type): void
    {
        assert(!isset($this->bases[$type]), "$type cannot appear in more than one union!");
        $this->bases[$type] = $this->type_name;
    }

    public function endUnion($name): void
    {
    }
}