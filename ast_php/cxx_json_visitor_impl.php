<?php
require_once __DIR__ . '/bootstrap.php';
class Printer implements LanguagePrinter
{
  private $fields = [];

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
    $this->fields = [];
  }

  public function endType(string $name): void
  {
    $titleName = title($name);
    $anyFieldIsANode = false;
    foreach ($this->fields as $field) {
      list($type, $name, $nullable, $plural) = $field;
      if ($type != 'OperationKind' && $type != 'string' && $type != 'boolean') {
        $anyFieldIsANode = true;
        break;
      }
    }
    if ($anyFieldIsANode) {
      echo 'bool JsonVisitor::visit' . $titleName . '(const ' . $titleName . ' &node) {' . PHP_EOL;
      echo '  visitNode();' . PHP_EOL;
      echo '  return true;' . PHP_EOL;
      echo '}' . PHP_EOL;
      echo PHP_EOL;
    }
    echo 'void JsonVisitor::endVisit' . $titleName . '(const ' . $titleName . ' &node) {' . PHP_EOL;
    echo '  NodeFieldPrinter fields(*this, "' . $titleName . '", node);' . PHP_EOL;

    foreach ($this->fields as $field) {
      list($type, $fieldName, $nullable, $plural) = $field;
      $funcName = null;
      if ($type == 'string') {
        assert(!$plural, 'plural string fields not supported yet');
        $funcName = 'printSingularPrimitiveField';
      } else if ($type == 'boolean') {
        assert(!$plural, 'plural boolean fields not supported yet');
        $funcName = 'printSingularBooleanField';
      } else if (!$nullable && !$plural) {
        // Special case: singular object fields don't need the value passed.
        echo '  fields.printSingularObjectField("' . $fieldName . '");' . PHP_EOL;
        continue;
      } else {
        $nullable_str = $nullable ? 'Nullable' : '';
        $plural_str = $plural ? 'Plural' : 'SingularObject';
        $funcName = 'print' . $nullable_str . $plural_str . 'Field';
      }

      assert($funcName !== null);
      echo '  fields.' . $funcName . '("' . $fieldName . '", node.get' . title($fieldName) . '());' . PHP_EOL;
    }

    if ($anyFieldIsANode) {
      echo '  endVisitNode(fields.finishPrinting());' . PHP_EOL;
      echo '}' . PHP_EOL;
      echo PHP_EOL;
    } else {
      echo '  printed_.back().emplace_back(fields.finishPrinting());' . PHP_EOL;
      echo '}' . PHP_EOL;
      echo PHP_EOL;
    }

  }

  public function field(string $type, string $name, bool $nullable, bool $plural): void
  {
    if ($type == 'OperationKind') {
      $type = 'string';
    }
    $this->fields[] = [$type, $name, $nullable, $plural];
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