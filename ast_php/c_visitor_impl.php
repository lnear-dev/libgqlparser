<?php
require __DIR__ . '/bootstrap.php';
class Printer implements LanguagePrinter
{
    private $types = [];
    private $currentType = null;

    public function startFile(): void
    {
        echo <<<'EOT'
/** @generated */

#define FOR_EACH_CONCRETE_TYPE(MACRO) \

EOT;

    }
    public function endFile(): void
    {
        echo join(' \\\n', array_map(function ($name) {
            return sprintf('MACRO(%s, %s)', $name, snake($name));
        }, $this->types));
    }
    public function startType(string $name): void
    {
        $this->types[] = $name;
        $this->currentType = $name;
    }
    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
    }
    public function endType(string $name): void
    {
    }
    public function startUnion(string $name): void
    {
    }
    public function unionOption(string $optionType): void
    {
    }
    public function endUnion(string $name): void
    {
    }

}