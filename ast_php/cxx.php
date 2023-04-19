<?php
require __DIR__ . '/bootstrap.php';

class Printer implements LanguagePrinter
{
    private $type_name;
    private $fields = [];
    private $bases = [];
    private $deferredOutput = '';
    private $output = '';

    public function baseClass($type)
    {
        return isset($this->bases[$type]) ? $this->bases[$type] : 'Node';
    }

    public function startFile()
    {
        $this->output = '';
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

    public function endFile()
    {
        echo $this->deferredOutput;
        echo $this->output;
        echo <<<'EOF'
        } // namespace ast
        } // namespace graphql
        } // namespace lnear
        
        EOF;
    }

    public function startType($name, $isUnion)
    {
        $this->type_name = $name;
        $this->fields = [];
        $this->deferredOutput .= "class $name;\n";
        $this->output .= "class $name : public {$this->baseClass($name)} {\n";
        $this->output .= " public:\n";
        if ($isUnion) {
            $this->output .= "  enum Kind {\n";
            foreach ($this->bases as $type => $base) {
                if ($base === $name) {
                    $this->output .= "    k$base,\n";
                }
            }
            $this->output .= "  };\n";
            $this->output .= "  Kind getKind() const { return kind_; }\n";
        }
    }

    public function field($type, $name, $nullable, $plural)
    {
        $this->fields[] = [$type, $name, $nullable, $plural];
    }

    public function endType($name, $isUnion)
    {
        $this->printConstructor();
        $this->printGetters();
        $this->printDestructorPrototype();
        $this->printNoncopyable();
        $this->output .= "};\n\n";
    }

    private function printConstructor()
    {
        $this->output .= "  $this->type_name(Location location";
        foreach ($this->fields as list($type, $name, $nullable, $plural)) {
            $this->output .= ", ";
            if ($type === 'string') {
                $this->output .= "std::string $name";
            } elseif ($type === 'boolean') {
                $this->output .= "bool $name";
            } elseif ($plural) {
                $this->output .= "std::vector<std::unique_ptr<$type>> $name";
            } else {
                $this->output .= "std::unique_ptr<$type> $name";
            }
        }
        $this->output .= ") :" . $this->baseClass($this->type_name) . "(location)";
        foreach ($this->fields as list($type, $name, $nullable, $plural)) {
            $this->output .= ",\n    $name($name)";
        }
        $this->output .= " {}\n";
    }

    private function printGetters()
    {
        foreach ($this->fields as list($type, $name, $nullable, $plural)) {
            $this->output .= "  ";
            if ($type === 'string') {
                assert(!$nullable);
                $this->output .= "const char *";
            } elseif ($type === 'boolean') {
                assert(!$nullable);
                $this->output .= "bool";
            } elseif ($nullable) {
                $this->output .= "const $type *";
            } else {
                $this->output .= "const $type &";
            }
            $this->output .= " get".title($name)."() const {\n";
            if ($plural && $nullable) {
                $this->output .= "    return $name.get();\n";
            } elseif ($plural) {
                $this->output .= "    return *$name;\n";
            } elseif ($type === 'boolean') {
                $this->output .= "    return $name;\n";
            } elseif ($nullable || $type === 'string') {
                $this->output .= "    return $name.get();\n";
            } else {
                $this->output .= "    return *$name;\n";
            }
            $this->output .= "  }\n\n";
        }
    }

    private function printDestructorPrototype()
    {
        $this->output .= "  ~$this->type_name() {}\n";
    }

    private function printNoncopyable()
    {
        $this->output .= "  $this->type_name(const $this->type_name&) = delete;\n";
        $this->output .= "  $this->type_name& operator=(const $this->type_name&) = delete;\n";
    }

    public function startUnion($name)
    {
        $this->type_name = $name;
        $this->deferredOutput .= "class $name;\n";
        $this->deferredOutput .= "class $name : public Node {\n";
        $this->deferredOutput .= " public:\n";
        $this->printConstructor();
        $this->deferredOutput .= "};\n\n";
    }

    public function unionOption($type)
    {
        assert(!isset($this->bases[$type]), "$type cannot appear in more than one union!");
        $this->bases[$type] = $this->type_name;
    }

    public function endUnion($name)
    {
    }
}