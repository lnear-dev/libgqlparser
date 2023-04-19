<?php
require_once __DIR__ . '/bootstrap.php';
class Printer implements LanguagePrinter
{
    private static array $currentOptions = [];

    public function startFile(): void
    {
        echo <<<'EOT'
/* @flow */
/* @generated */
/* jshint ignore:start */

/**
 * Copyright 2023-present, Lnear
 *  All rights reserved.
 */

type Node = {
  kind: string;
  start?: ?number;
  end?: ?number;
};

type OperationKind = 'query' | 'mutation' | 'subscription';


EOT;
    }

    public function endFile(): void
    {
    }

    public function startType(string $name): void
    {
        echo PHP_EOL;
        echo 'type ' . $name . ' = Node & {' . PHP_EOL;
        $kind = $name;
        if ($kind == 'GenericType') {
            $kind = 'Type';
        }
        echo '  kind: \'' . $kind . '\';' . PHP_EOL;
    }

    public function endType(string $name): void
    {
        echo '}' . PHP_EOL;
    }

    public function _jsType(string $type, bool $plural): string
    {
        if ($plural) {
            $type = 'Array<' . $type . '>';
        }
        return $type;
    }

    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        $nullableChar = $nullable ? '?' : '';
        $jsType = $this->_jsType($type, $plural);
        echo '  ' . $name . $nullableChar . ': ' . $nullableChar . $jsType . ';' . PHP_EOL;
    }

    public function startUnion(string $name): void
    {
        echo 'type ' . $name . ' = ' . PHP_EOL;
        self::$currentOptions = [];
    }

    public function unionOption(string $type): void
    {
        self::$currentOptions[] = $type;
    }

    public function endUnion(string $name): void
    {
        echo PHP_EOL . '  | ' . join(PHP_EOL . '  | ', self::$currentOptions) . PHP_EOL;
        echo PHP_EOL;
        self::$currentOptions = [];
    }
}


