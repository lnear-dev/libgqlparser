<?php
require_once __DIR__ . '/bootstrap.php';
class Printer implements LanguagePrinter
{
    private $currentType = null;

    public function startFile(): void
    {
        echo <<<'EOT'
/** @generated */

#pragma once

#ifdef __cplusplus
extern "C" {
#endif

EOT;


    }
    public function endFile(): void
    {
        echo <<<'EOT'

#ifdef __cplusplus
}
#endif

EOT;

    }
    public function startType(string $name): void
    {
        $stName = structName($name);
        echo 'struct ' . $stName . ';' . PHP_EOL;
        $this->currentType = $name;
    }
    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        echo fieldPrototype($this->currentType, $type, $name, $nullable, $plural) . ';' . PHP_EOL;
    }
    public function endType(string $name): void
    {
        echo PHP_EOL;
    }
    public function startUnion(string $name): void
    {
        echo 'struct ' . structName($name) . ';' . PHP_EOL;
    }
    public function unionOption(string $optionType): void
    {
    }
    public function endUnion(string $name): void
    {
        echo PHP_EOL;
    }

}
