<?php
require_once __DIR__ . '/bootstrap.php';


class Printer implements LanguagePrinter
{
    private static array $currentOptions = [];
    private static array $currentFields = [];

    private static array $collectTypes = [];


    public function startFile(): void
    {
        echo <<<'EOT'
<?php
declare(strict_types=1);
/* @generated */

/**
 * Copyright 2023-present, Lnear
 * All rights reserved.
 */

namespace Lnear\GraphQL\Language;

class OperationKind {
    const QUERY = 'query';
    const MUTATION = 'mutation';
    const SUBSCRIPTION = 'subscription';
}

class DirectiveLocation {
    const QUERY = 'QUERY';
    const MUTATION = 'MUTATION';
    const SUBSCRIPTION = 'SUBSCRIPTION';
    const FIELD = 'FIELD';
    const FRAGMENT_DEFINITION = 'FRAGMENT_DEFINITION';
    const FRAGMENT_SPREAD = 'FRAGMENT_SPREAD';
    const INLINE_FRAGMENT = 'INLINE_FRAGMENT';
    const SCHEMA = 'SCHEMA';
    const SCALAR = 'SCALAR';
    const OBJECT = 'OBJECT';
    const FIELD_DEFINITION = 'FIELD_DEFINITION';
    const ARGUMENT_DEFINITION = 'ARGUMENT_DEFINITION';
    const INTERFACE = 'INTERFACE';
    const UNION = 'UNION';
    const ENUM = 'ENUM';
    const ENUM_VALUE = 'ENUM_VALUE';
    const INPUT_OBJECT = 'INPUT_OBJECT';
    const INPUT_FIELD_DEFINITION = 'INPUT_FIELD_DEFINITION';
}

class TypeKind {
    const SCALAR = 'SCALAR';
    const OBJECT = 'OBJECT';
    const INTERFACE = 'INTERFACE';
    const UNION = 'UNION';
    const ENUM = 'ENUM';
    const INPUT_OBJECT = 'INPUT_OBJECT';
    const LIST = 'LIST';
    const NON_NULL = 'NON_NULL';
}

class ValueKind {
    const VARIABLE = 'VARIABLE';
    const INT = 'INT';
    const FLOAT = 'FLOAT';
    const STRING = 'STRING';
    const BOOLEAN = 'BOOLEAN';
    const NULL = 'NULL';
    const ENUM = 'ENUM';
    const LIST = 'LIST';
    const OBJECT = 'OBJECT';
}

EOT;
    }

    public static function getUpperSnake(string $str): string
    {
        return $output = ltrim(strtoupper(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $str)), '_');

    }

    public function endFile(): void
    {
        // echo 'const __collectTypes = ' . json_encode(static::$collectTypes) . ';' . PHP_EOL;
        // use this to generate the type map
        $cT = 'enum NodeKind: string {' . PHP_EOL;
        foreach (static::$collectTypes as $type) {
            $cT .= '    case ' . static::getUpperSnake($type) . ' = ' . $type . '::class;' . PHP_EOL;
        }
        echo $cT;
        echo '}' . PHP_EOL;

        echo <<<'EOT'

abstract class Node implements \Ds\Hashable{
    public string $kind;
    public array $loc;


    public static function fromArray(array $data): Node {
        return self::fromArrayInternal($data);
      }
  
    private static function fromArrayInternal(array $data): Node {
        $kind = $data['kind'];
        $class = NodeKind::${$kind};
        $node = new $class();
        foreach ($data as $key => $value) {
            if ($key === 'kind') {
            continue;
            }
            if ($key === 'loc') {
            $node->loc = $value;
            continue;
            }
            if (is_array($value)) {
            $node->{$key} = array_map(fn($v) => self::fromArrayInternal($v), $value);
            continue;
            }
            $node->{$key} = $value;
        }
        return $node;
    }

    public function __toString(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    public function hash(): string {
        return md5($this->__toString());
    }

    public function equals($other): bool {
        return $this->__toString() === $other->__toString();
    }
}



EOT;
    }

    public function startType(string $name): void
    {
        echo PHP_EOL;
        echo 'class ' . $name . ' extends Node {' . PHP_EOL;
        $kind = $name;
        if ($kind == 'GenericType') {
            $kind = 'Type';
        }
        echo '  public string $kind = NodeKind::' . static::getUpperSnake($kind) . ';' . PHP_EOL;

        static::$collectTypes[] = $name;
    }

    public function endType(string $name): void
    {
        echo '}' . PHP_EOL;
        static::$currentFields = [];
    }

    public function _phpType(string $type, bool $plural): string
    {
        if ($plural) {
            $type = 'array';
        }
        return $type;
    }

    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        static $currentOptions = [];
        $nullableChar = $nullable ? '?' : '';
        $phpType = $this->_phpType($type, $plural);
        echo '  public ' . $nullableChar . $phpType . ' $' . $name . ';' . PHP_EOL;
        static::$currentFields[] = $name;
    }

    public function startUnion(string $name): void
    {
        echo 'abstract class ' . $name . ' extends Node {' . PHP_EOL;
        $kind = $name;
        if ($kind == 'GenericType') {
            $kind = 'Type';
        }
        echo '  public string $kind = \'' . $kind . '\';' . PHP_EOL;

        echo '  public static function fromArray(array $data): ' . $name . ' {' . PHP_EOL;
        echo '    match ($data[\'kind\']) {' . PHP_EOL;
    }

    public function unionOption(string $type): void
    {
        echo '      \'' . $type . '\' => ' . $type . '::fromArray($data),' . PHP_EOL;
        self::$currentOptions[] = $type;

    }

    public function endUnion(string $name): void
    {
        echo '      default => throw new \Exception(\'Unknown kind: \' . $data[\'kind\']),' . PHP_EOL;
        echo '    };' . PHP_EOL;
        echo '  }' . PHP_EOL;
        echo '}' . PHP_EOL;

    }
}