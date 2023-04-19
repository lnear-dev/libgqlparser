<?php
require_once __DIR__ . '/bootstrap.php';


class Printer implements LanguagePrinter
{
    private static array $currentOptions = [];

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

use Lnear\GraphQL\Language\AST\Node;

EOT;
    }

    public function endFile(): void
    {
    }

    public function startType(string $name): void
    {
        echo PHP_EOL;
        echo 'class ' . $name . ' extends Node {' . PHP_EOL;
        $kind = $name;
        if ($kind == 'GenericType') {
            $kind = 'Type';
        }
        echo '  public string $kind = \'' . $kind . '\';' . PHP_EOL;
    }

    public function endType(string $name): void
    {
        echo '}' . PHP_EOL;
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
        $nullableChar = $nullable ? '?' : '';
        $phpType = $this->_phpType($type, $plural);
        echo '  public '. $nullableChar . $phpType  . ' $' . $name . ';' . PHP_EOL;
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
        echo '    switch ($data[\'kind\']) {' . PHP_EOL;
    }

    public function unionOption(string $type): void
    {
        echo '      case \'' . $type . '\': return ' . $type . '::fromArray($data);' . PHP_EOL;

    }

    public function endUnion(string $name): void
    {
        echo '      default: throw new \Exception(\'Unknown kind: \' . $data[\'kind\']);' . PHP_EOL;
        echo '    }' . PHP_EOL;
        echo '  }' . PHP_EOL;
        echo '}' . PHP_EOL;

    }
}