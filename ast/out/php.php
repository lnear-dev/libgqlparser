<?php
/** @generated */

namespace LNE\GraphQL\Ast;

use LNE\GraphQL\Ast\Visitor\AstVisitor;

abstract class AstVisitor {
  public function visitNode(Node $node) {
    return $this->visit($node);
    }
    
  public function visit(Node $node) {
    $method = 'visit' . $node->getKind();
    if (method_exists($this, $method)) {
      return $this->$method($node);
    }
    return true;
  }
  
  public function endVisit(Node $node) {
    $method = 'endVisit' . $node->getKind();
    if (method_exists($this, $method)) {
      $this->$method($node);
    }
  }

  public function visitDocument(Document $document) {
    return true;
  }
  public function endVisitDocument(Document $document) {
  }
  public function visitOperationDefinition(OperationDefinition $operationDefinition) {
    return true;
  }
  public function endVisitOperationDefinition(OperationDefinition $operationDefinition) {
  }
  public function visitVariableDefinition(VariableDefinition $variableDefinition) {
    return true;
  }
  public function endVisitVariableDefinition(VariableDefinition $variableDefinition) {
  }
  public function visitSelectionSet(SelectionSet $selectionSet) {
    return true;
  }
  public function endVisitSelectionSet(SelectionSet $selectionSet) {
  }
  public function visitField(Field $field) {
    return true;
  }
  public function endVisitField(Field $field) {
  }
  public function visitArgument(Argument $argument) {
    return true;
  }
  public function endVisitArgument(Argument $argument) {
  }
  public function visitFragmentSpread(FragmentSpread $fragmentSpread) {
    return true;
  }
  public function endVisitFragmentSpread(FragmentSpread $fragmentSpread) {
  }
  public function visitInlineFragment(InlineFragment $inlineFragment) {
    return true;
  }
  public function endVisitInlineFragment(InlineFragment $inlineFragment) {
  }
  public function visitFragmentDefinition(FragmentDefinition $fragmentDefinition) {
    return true;
  }
  public function endVisitFragmentDefinition(FragmentDefinition $fragmentDefinition) {
  }
  public function visitVariable(Variable $variable) {
    return true;
  }
  public function endVisitVariable(Variable $variable) {
  }
  public function visitIntValue(IntValue $intValue) {
    return true;
  }
  public function endVisitIntValue(IntValue $intValue) {
  }
  public function visitFloatValue(FloatValue $floatValue) {
    return true;
  }
  public function endVisitFloatValue(FloatValue $floatValue) {
  }
  public function visitStringValue(StringValue $stringValue) {
    return true;
  }
  public function endVisitStringValue(StringValue $stringValue) {
  }
  public function visitBooleanValue(BooleanValue $booleanValue) {
    return true;
  }
  public function endVisitBooleanValue(BooleanValue $booleanValue) {
  }
  public function visitNullValue(NullValue $nullValue) {
    return true;
  }
  public function endVisitNullValue(NullValue $nullValue) {
  }
  public function visitEnumValue(EnumValue $enumValue) {
    return true;
  }
  public function endVisitEnumValue(EnumValue $enumValue) {
  }
  public function visitListValue(ListValue $listValue) {
    return true;
  }
  public function endVisitListValue(ListValue $listValue) {
  }
  public function visitObjectValue(ObjectValue $objectValue) {
    return true;
  }
  public function endVisitObjectValue(ObjectValue $objectValue) {
  }
  public function visitObjectField(ObjectField $objectField) {
    return true;
  }
  public function endVisitObjectField(ObjectField $objectField) {
  }
  public function visitDirective(Directive $directive) {
    return true;
  }
  public function endVisitDirective(Directive $directive) {
  }
  public function visitNamedType(NamedType $namedType) {
    return true;
  }
  public function endVisitNamedType(NamedType $namedType) {
  }
  public function visitListType(ListType $listType) {
    return true;
  }
  public function endVisitListType(ListType $listType) {
  }
  public function visitNonNullType(NonNullType $nonNullType) {
    return true;
  }
  public function endVisitNonNullType(NonNullType $nonNullType) {
  }
  public function visitName(Name $name) {
    return true;
  }
  public function endVisitName(Name $name) {
  }
  public function visitSchemaDefinition(SchemaDefinition $schemaDefinition) {
    return true;
  }
  public function endVisitSchemaDefinition(SchemaDefinition $schemaDefinition) {
  }
  public function visitOperationTypeDefinition(OperationTypeDefinition $operationTypeDefinition) {
    return true;
  }
  public function endVisitOperationTypeDefinition(OperationTypeDefinition $operationTypeDefinition) {
  }
  public function visitScalarTypeDefinition(ScalarTypeDefinition $scalarTypeDefinition) {
    return true;
  }
  public function endVisitScalarTypeDefinition(ScalarTypeDefinition $scalarTypeDefinition) {
  }
  public function visitObjectTypeDefinition(ObjectTypeDefinition $objectTypeDefinition) {
    return true;
  }
  public function endVisitObjectTypeDefinition(ObjectTypeDefinition $objectTypeDefinition) {
  }
  public function visitFieldDefinition(FieldDefinition $fieldDefinition) {
    return true;
  }
  public function endVisitFieldDefinition(FieldDefinition $fieldDefinition) {
  }
  public function visitInputValueDefinition(InputValueDefinition $inputValueDefinition) {
    return true;
  }
  public function endVisitInputValueDefinition(InputValueDefinition $inputValueDefinition) {
  }
  public function visitInterfaceTypeDefinition(InterfaceTypeDefinition $interfaceTypeDefinition) {
    return true;
  }
  public function endVisitInterfaceTypeDefinition(InterfaceTypeDefinition $interfaceTypeDefinition) {
  }
  public function visitUnionTypeDefinition(UnionTypeDefinition $unionTypeDefinition) {
    return true;
  }
  public function endVisitUnionTypeDefinition(UnionTypeDefinition $unionTypeDefinition) {
  }
  public function visitEnumTypeDefinition(EnumTypeDefinition $enumTypeDefinition) {
    return true;
  }
  public function endVisitEnumTypeDefinition(EnumTypeDefinition $enumTypeDefinition) {
  }
  public function visitEnumValueDefinition(EnumValueDefinition $enumValueDefinition) {
    return true;
  }
  public function endVisitEnumValueDefinition(EnumValueDefinition $enumValueDefinition) {
  }
  public function visitInputObjectTypeDefinition(InputObjectTypeDefinition $inputObjectTypeDefinition) {
    return true;
  }
  public function endVisitInputObjectTypeDefinition(InputObjectTypeDefinition $inputObjectTypeDefinition) {
  }
  public function visitTypeExtensionDefinition(TypeExtensionDefinition $typeExtensionDefinition) {
    return true;
  }
  public function endVisitTypeExtensionDefinition(TypeExtensionDefinition $typeExtensionDefinition) {
  }
  public function visitDirectiveDefinition(DirectiveDefinition $directiveDefinition) {
    return true;
  }
  public function endVisitDirectiveDefinition(DirectiveDefinition $directiveDefinition) {
  }
}
/** generated */

namespace LNE\GraphQL\Ast;

use LNE\GraphQL\Ast\Visitor\AstVisitor;

use function LNE\GraphQL\print_ast;


class Document extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitDocument($this);

    { foreach ($this->definitions as $x) { $x->accept($visitor); } }

    $visitor->endVisitDocument($this);
  }
}

class OperationDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitOperationDefinition($this);

    if ($this->name) { $this->name->accept($visitor); }
    if ($this->variableDefinitions) { foreach ($this->variableDefinitions as $x) { $x->accept($visitor); } }
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitOperationDefinition($this);
  }
}

class VariableDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitVariableDefinition($this);

    $this->variable->accept($visitor);
    $this->type->accept($visitor);
    if ($this->defaultValue) { $this->defaultValue->accept($visitor); }

    $visitor->endVisitVariableDefinition($this);
  }
}

class SelectionSet extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitSelectionSet($this);

    { foreach ($this->selections as $x) { $x->accept($visitor); } }

    $visitor->endVisitSelectionSet($this);
  }
}

class Field extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitField($this);

    if ($this->alias) { $this->alias->accept($visitor); }
    $this->name->accept($visitor);
    if ($this->arguments) { foreach ($this->arguments as $x) { $x->accept($visitor); } }
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    if ($this->selectionSet) { $this->selectionSet->accept($visitor); }

    $visitor->endVisitField($this);
  }
}

class Argument extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitArgument($this);

    $this->name->accept($visitor);
    $this->value->accept($visitor);

    $visitor->endVisitArgument($this);
  }
}

class FragmentSpread extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitFragmentSpread($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }

    $visitor->endVisitFragmentSpread($this);
  }
}

class InlineFragment extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitInlineFragment($this);

    if ($this->typeCondition) { $this->typeCondition->accept($visitor); }
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitInlineFragment($this);
  }
}

class FragmentDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitFragmentDefinition($this);

    $this->name->accept($visitor);
    $this->typeCondition->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitFragmentDefinition($this);
  }
}

class Variable extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitVariable($this);

    $this->name->accept($visitor);

    $visitor->endVisitVariable($this);
  }
}

class IntValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitIntValue($this);


    $visitor->endVisitIntValue($this);
  }
}

class FloatValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitFloatValue($this);


    $visitor->endVisitFloatValue($this);
  }
}

class StringValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitStringValue($this);


    $visitor->endVisitStringValue($this);
  }
}

class BooleanValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitBooleanValue($this);


    $visitor->endVisitBooleanValue($this);
  }
}

class NullValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitNullValue($this);


    $visitor->endVisitNullValue($this);
  }
}

class EnumValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitEnumValue($this);


    $visitor->endVisitEnumValue($this);
  }
}

class ListValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitListValue($this);

    { foreach ($this->values as $x) { $x->accept($visitor); } }

    $visitor->endVisitListValue($this);
  }
}

class ObjectValue extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitObjectValue($this);

    { foreach ($this->fields as $x) { $x->accept($visitor); } }

    $visitor->endVisitObjectValue($this);
  }
}

class ObjectField extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitObjectField($this);

    $this->name->accept($visitor);
    $this->value->accept($visitor);

    $visitor->endVisitObjectField($this);
  }
}

class Directive extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitDirective($this);

    $this->name->accept($visitor);
    if ($this->arguments) { foreach ($this->arguments as $x) { $x->accept($visitor); } }

    $visitor->endVisitDirective($this);
  }
}

class NamedType extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitNamedType($this);

    $this->name->accept($visitor);

    $visitor->endVisitNamedType($this);
  }
}

class ListType extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitListType($this);

    $this->type->accept($visitor);

    $visitor->endVisitListType($this);
  }
}

class NonNullType extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitNonNullType($this);

    $this->type->accept($visitor);

    $visitor->endVisitNonNullType($this);
  }
}

class Name extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitName($this);


    $visitor->endVisitName($this);
  }
}

class SchemaDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitSchemaDefinition($this);

    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->operationTypes as $x) { $x->accept($visitor); } }

    $visitor->endVisitSchemaDefinition($this);
  }
}

class OperationTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitOperationTypeDefinition($this);

    $this->type->accept($visitor);

    $visitor->endVisitOperationTypeDefinition($this);
  }
}

class ScalarTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitScalarTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }

    $visitor->endVisitScalarTypeDefinition($this);
  }
}

class ObjectTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitObjectTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->interfaces) { foreach ($this->interfaces as $x) { $x->accept($visitor); } }
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->fields as $x) { $x->accept($visitor); } }

    $visitor->endVisitObjectTypeDefinition($this);
  }
}

class FieldDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitFieldDefinition($this);

    $this->name->accept($visitor);
    if ($this->arguments) { foreach ($this->arguments as $x) { $x->accept($visitor); } }
    $this->type->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }

    $visitor->endVisitFieldDefinition($this);
  }
}

class InputValueDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitInputValueDefinition($this);

    $this->name->accept($visitor);
    $this->type->accept($visitor);
    if ($this->defaultValue) { $this->defaultValue->accept($visitor); }
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }

    $visitor->endVisitInputValueDefinition($this);
  }
}

class InterfaceTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitInterfaceTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->fields as $x) { $x->accept($visitor); } }

    $visitor->endVisitInterfaceTypeDefinition($this);
  }
}

class UnionTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitUnionTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->types as $x) { $x->accept($visitor); } }

    $visitor->endVisitUnionTypeDefinition($this);
  }
}

class EnumTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitEnumTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->values as $x) { $x->accept($visitor); } }

    $visitor->endVisitEnumTypeDefinition($this);
  }
}

class EnumValueDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitEnumValueDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }

    $visitor->endVisitEnumValueDefinition($this);
  }
}

class InputObjectTypeDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitInputObjectTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) { foreach ($this->directives as $x) { $x->accept($visitor); } }
    { foreach ($this->fields as $x) { $x->accept($visitor); } }

    $visitor->endVisitInputObjectTypeDefinition($this);
  }
}

class TypeExtensionDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitTypeExtensionDefinition($this);

    $this->definition->accept($visitor);

    $visitor->endVisitTypeExtensionDefinition($this);
  }
}

class DirectiveDefinition extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visitDirectiveDefinition($this);

    $this->name->accept($visitor);
    if ($this->arguments) { foreach ($this->arguments as $x) { $x->accept($visitor); } }
    { foreach ($this->locations as $x) { $x->accept($visitor); } }

    $visitor->endVisitDirectiveDefinition($this);
  }
}


abstract class Node {
  public ?Location $location = null;
  public string $kind;
  public function __construct( array $vars = []) {
    foreach ($vars as $key => $value) {
      if (! \property_exists($this, $key)) {
        $cls = \get_class($this);
        echo "Trying to set non-existing property '{$key}' on class '{$cls}'";
      }
      $this->{$key} = $value;
    }
  }
  public abstract function accept(Vistor $visitor);
  public function __toString() {
    return print_ast($this);
  }
  public function getType() {
    return $this->kind;
  }
}

class Location {
  public function __construct(
      public int $beginLine,
      public int $beginColumn,
      public int $endLine,
      public int $endColumn,
      public string $source) { }
}

enum OperationKind: string {
  case QUERY = "query";
  case MUTATION = "mutation";
  case SUBSCRIPTION = "subscription";
}
class Definition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitDefinition($this);
  }

}
class Document extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitDocument($this);
  }

  public Definition $definitions;

}

class OperationDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitOperationDefinition($this);
  }

  public OperationKind $operation;

  public Name $name;

  public VariableDefinition $variableDefinitions;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class VariableDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitVariableDefinition($this);
  }

  public Variable $variable;

  public Type $type;

  public Value $defaultValue;

}

class SelectionSet extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitSelectionSet($this);
  }

  public Selection $selections;

}

class Selection extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitSelection($this);
  }

}
class Field extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitField($this);
  }

  public Name $alias;

  public Name $name;

  public Argument $arguments;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class Argument extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitArgument($this);
  }

  public Name $name;

  public Value $value;

}

class FragmentSpread extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitFragmentSpread($this);
  }

  public Name $name;

  public Directive $directives;

}

class InlineFragment extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitInlineFragment($this);
  }

  public NamedType $typeCondition;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class FragmentDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitFragmentDefinition($this);
  }

  public Name $name;

  public NamedType $typeCondition;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class Value extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitValue($this);
  }

}
class Variable extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitVariable($this);
  }

  public Name $name;

}

class IntValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitIntValue($this);
  }

  public string $value;
}

class FloatValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitFloatValue($this);
  }

  public string $value;
}

class StringValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitStringValue($this);
  }

  public string $value;
}

class BooleanValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitBooleanValue($this);
  }

  public bool $value;
}

class NullValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitNullValue($this);
  }

}

class EnumValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitEnumValue($this);
  }

  public string $value;
}

class ListValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitListValue($this);
  }

  public Value $values;

}

class ObjectValue extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitObjectValue($this);
  }

  public ObjectField $fields;

}

class ObjectField extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitObjectField($this);
  }

  public Name $name;

  public Value $value;

}

class Directive extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitDirective($this);
  }

  public Name $name;

  public Argument $arguments;

}

class Type extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitType($this);
  }

}
class NamedType extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitNamedType($this);
  }

  public Name $name;

}

class ListType extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitListType($this);
  }

  public Type $type;

}

class NonNullType extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitNonNullType($this);
  }

  public Type $type;

}

class Name extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitName($this);
  }

  public string $value;
}

class SchemaDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitSchemaDefinition($this);
  }

  public Directive $directives;

  public OperationTypeDefinition $operationTypes;

}

class OperationTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitOperationTypeDefinition($this);
  }

  public OperationKind $operation;

  public NamedType $type;

}

class ScalarTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitScalarTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

}

class ObjectTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitObjectTypeDefinition($this);
  }

  public Name $name;

  public NamedType $interfaces;

  public Directive $directives;

  public FieldDefinition $fields;

}

class FieldDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitFieldDefinition($this);
  }

  public Name $name;

  public InputValueDefinition $arguments;

  public Type $type;

  public Directive $directives;

}

class InputValueDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitInputValueDefinition($this);
  }

  public Name $name;

  public Type $type;

  public Value $defaultValue;

  public Directive $directives;

}

class InterfaceTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitInterfaceTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public FieldDefinition $fields;

}

class UnionTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitUnionTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public NamedType $types;

}

class EnumTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitEnumTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public EnumValueDefinition $values;

}

class EnumValueDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitEnumValueDefinition($this);
  }

  public Name $name;

  public Directive $directives;

}

class InputObjectTypeDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitInputObjectTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public InputValueDefinition $fields;

}

class TypeExtensionDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitTypeExtensionDefinition($this);
  }

  public ObjectTypeDefinition $definition;

}

class DirectiveDefinition extends Node {
  public function accept(Visitor $visitor) {
    return $visitor->visitDirectiveDefinition($this);
  }

  public Name $name;

  public InputValueDefinition $arguments;

  public Name $locations;

}
?>