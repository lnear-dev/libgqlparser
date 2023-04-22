<?php
require_once __DIR__ . '/bootstrap.php';

class Printer implements LanguagePrinter
{
    public function startFile(): void
    {
        echo LICENSE. <<<'EOT'

/** @generated */

#pragma once

#include "Ast.h"

namespace lnear {
namespace graphql {
namespace ast {
namespace visitor {

class AstVisitor {
public:
  virtual ~AstVisitor() {}

EOT;

    }
    public function endFile(): void
    {
        echo <<<'EOT'
};
    
}
}
}
}

EOT;

    }

    public function startType(string $name): void
    {
        $titleName = title($name);
        $camelName = camel($titleName);
        echo '  virtual bool visit' . $titleName . '(const ' . $titleName . ' &' . $camelName . ') { return true; }' . PHP_EOL;
        echo '  virtual void endVisit' . $titleName . '(const ' . $titleName . ' &' . $camelName . ') { }' . PHP_EOL;
        echo PHP_EOL;

    }
    public function field(string $type, string $name, bool $nullable, bool $plural): void {}
    public function endType(string $name): void {}
    public function startUnion(string $name): void {}
    public function unionOption(string $optionType): void {}
    public function endUnion(string $name): void {}

}