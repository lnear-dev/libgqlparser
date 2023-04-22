<?php
require_once __DIR__ . '/bootstrap.php';

class Printer implements LanguagePrinter
{
    public function startFile(): void
    {
        echo LICENSE. <<<'EOT'
#include "Ast.h"
#include "AstVisitor.h"

namespace lnear {
namespace graphql {
namespace ast {

EOT;

    }
    public function endFile(): void
    {
        echo <<<'EOT'
}  // namespace ast
}  // namespace graphql
}  // namespace lnear

EOT;

    }
    public function startType(string $name): void
    {
        $template = <<<'EOT'
void %s::accept(visitor::AstVisitor *visitor) const {
    if (visitor->visit%s(*this)) {
EOT;
        echo sprintf($template, $name, $name);
        echo PHP_EOL;

    }

    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        if ($type == 'OperationKind' || $type == 'string' || $type == 'boolean') {
            return;
        }

        if ($plural) {
            $accept = sprintf('{ for (const auto &x : *%s_) { x->accept(visitor); } }', $name);
            if ($nullable) {
                $accept = sprintf('if (%s_) %s', $name, $accept);
            }
            echo '    ' . $accept . PHP_EOL;
        } else {
            $accept = '%s_->accept(visitor);';
            if ($nullable) {
                $accept = sprintf('if (%s_) { %s }', $name, $accept);
            }
            echo '    ' . $accept . PHP_EOL;
        }
    }

    public function endType(string $name): void
    {
        $template = <<<'EOT'
    }
    visitor->endVisit%s(*this);
}
EOT;
        echo sprintf($template, $name);
        echo PHP_EOL;
    }

    public function startUnion(string $name): void {}
    public function unionOption(string $optionType): void {}
    public function endUnion(string $name): void {}

}