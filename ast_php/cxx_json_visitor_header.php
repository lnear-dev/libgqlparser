<?php
require __DIR__ . '/bootstrap.php';

class Printer implements LanguagePrinter
{
    private $anyFieldIsANode = false;
    public function startFile(): void
    {
        echo "/** @generated */";
    }

    public function endFile(): void
    {
        echo PHP_EOL;
    }

    public function startType(string $name): void
    {
        $this->anyFieldIsANode = false;
    }

    public function endType(string $name): void
    {
        $titleName = title($name);
        if ($this->anyFieldIsANode) {
            echo 'bool visit' . $titleName . '(const ' . $titleName . ' &node) override;' . PHP_EOL;
        }
        echo 'void endVisit' . $titleName . '(const ' . $titleName . ' &node) override;' . PHP_EOL;
        echo PHP_EOL;
    }

    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        if (!$this->anyFieldIsANode && $type != 'OperationKind' && $type != 'string' && $type != 'boolean') {
            $this->anyFieldIsANode = true;
        }
    }

    public function startUnion(string $name): void
    {
    }

    public function unionOption(string $option): void
    {
    }

    public function endUnion(string $name): void
    {
    }

}