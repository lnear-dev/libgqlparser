<?php
require_once __DIR__ . '/bootstrap.php';
class Printer implements LanguagePrinter
{
    private $currentType = null;

    public function startFile(): void
    {
        echo <<<'EOT'
/** @generated */

#include "GraphQLAst.h"
#include "../Ast.h"

using namespace lnear::graphql::ast;  // NOLINT

EOT;

    }
    public function endFile(): void
    {
    }
    public function startType(string $name): void
    {
        $this->currentType = $name;
    }
    public function field(string $type, string $name, bool $nullable, bool $plural): void
    {
        echo fieldPrototype($this->currentType, $type, $name, $nullable, $plural) . ' {' . PHP_EOL;
        echo '  const auto *realNode = reinterpret_cast<const ' . $this->currentType . ' *>(node);' . PHP_EOL;
        $titleName = title($name);
        $callGet = 'realNode->get' . $titleName . '()';
        if ($plural) {
            if ($nullable) {
                echo '  return ' . $callGet . ' ? ' . $callGet . '->size() : 0;' . PHP_EOL;
            } else {
                echo '  return ' . $callGet . '.size();' . PHP_EOL;
            }
        } else {
            if (in_array($type, ['string', 'OperationKind', 'boolean'])) {
                echo '  return ' . $callGet . ';' . PHP_EOL;
            } else {
                $fmt = '  return reinterpret_cast<const struct %s *>(%s%s);';
                echo sprintf($fmt, structName($type),  $nullable ? '':'&', $callGet) . PHP_EOL;
            }
        }
        echo '}' . PHP_EOL;
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
