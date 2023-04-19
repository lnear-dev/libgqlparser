<?php
namespace ast;

abstract class Node
{
  public ?Location $location = null;
  public string $kind;
  public function __construct(array $vars = [])
  {
    foreach ($vars as $key => $value) {
      if (!\property_exists($this, $key)) {
        $cls = \get_class($this);
        echo "Trying to set non-existing property '{$key}' on class '{$cls}'";
      }
      $this->{$key} = $value;
    }
  }
  public abstract function accept(Vistor $visitor);
  public function __toString()
  {
    return print_ast($this);
  }
  public function getKind()
  {
    return $this->kind;
  }
}

class Location
{
  public function __construct(
    public int $beginLine,
    public int $beginColumn,
    public int $endLine,
    public int $endColumn,
    public string $source
  ) {
  }
}

enum OperationKind: string
{
  case QUERY = "query";
  case MUTATION = "mutation";
  case SUBSCRIPTION = "subscription";

  public function __toString()
  {
    return $this->value;
  }

  public function accept(AstVisitor $visitor)
  {
    return $visitor->visitOperationKind($this);
  }
}
class Definition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    return $visitor->visitDefinition($this);
  }

}

class Document extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitDocument($this);

    foreach ($this->definitions as $definition) {
      $definition->accept($visitor);
    }

    $visitor->endVisitDocument($this);
  }

  public Definition $definitions;

}

class OperationDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitOperationDefinition($this);

    $this->operation->accept($visitor);
    if ($this->name) {
      $this->name->accept($visitor);
    }
    if ($this->variableDefinitions) {
      foreach ($this->variableDefinitions as $variableDefinition) {
        $variableDefinition->accept($visitor);
      }
    }
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitOperationDefinition($this);
  }

  public OperationKind $operation;

  public Name $name;

  public VariableDefinition $variableDefinitions;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class VariableDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitVariableDefinition($this);

    $this->variable->accept($visitor);
    $this->type->accept($visitor);
    if ($this->defaultValue) {
      $this->defaultValue->accept($visitor);
    }

    $visitor->endVisitVariableDefinition($this);
  }

  public Variable $variable;

  public Type $type;

  public Value $defaultValue;

}

class SelectionSet extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitSelectionSet($this);

    foreach ($this->selections as $selection) {
      $selection->accept($visitor);
    }

    $visitor->endVisitSelectionSet($this);
  }

  public Selection $selections;

}
class Selection extends Node
{
  public function accept(AstVisitor $visitor)
  {
    return $visitor->visitSelection($this);
  }

}

class Field extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitField($this);

    if ($this->alias) {
      $this->alias->accept($visitor);
    }
    $this->name->accept($visitor);
    if ($this->arguments) {
      foreach ($this->arguments as $argument) {
        $argument->accept($visitor);
      }
    }
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    if ($this->selectionSet) {
      $this->selectionSet->accept($visitor);
    }

    $visitor->endVisitField($this);
  }

  public Name $alias;

  public Name $name;

  public Argument $arguments;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class Argument extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitArgument($this);

    $this->name->accept($visitor);
    $this->value->accept($visitor);

    $visitor->endVisitArgument($this);
  }

  public Name $name;

  public Value $value;

}

class FragmentSpread extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitFragmentSpread($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }

    $visitor->endVisitFragmentSpread($this);
  }

  public Name $name;

  public Directive $directives;

}

class InlineFragment extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitInlineFragment($this);

    if ($this->typeCondition) {
      $this->typeCondition->accept($visitor);
    }
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitInlineFragment($this);
  }

  public NamedType $typeCondition;

  public Directive $directives;

  public SelectionSet $selectionSet;

}

class FragmentDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitFragmentDefinition($this);

    $this->name->accept($visitor);
    $this->typeCondition->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    $this->selectionSet->accept($visitor);

    $visitor->endVisitFragmentDefinition($this);
  }

  public Name $name;

  public NamedType $typeCondition;

  public Directive $directives;

  public SelectionSet $selectionSet;

}
class Value extends Node
{
  public function accept(AstVisitor $visitor)
  {
    return $visitor->visitValue($this);
  }

}

class Variable extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitVariable($this);

    $this->name->accept($visitor);

    $visitor->endVisitVariable($this);
  }

  public Name $name;

}

class IntValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitIntValue($this);

    $this->value->accept($visitor);

    $visitor->endVisitIntValue($this);
  }

  public string $value;

}

class FloatValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitFloatValue($this);

    $this->value->accept($visitor);

    $visitor->endVisitFloatValue($this);
  }

  public string $value;

}

class StringValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitStringValue($this);

    $this->value->accept($visitor);

    $visitor->endVisitStringValue($this);
  }

  public string $value;

}

class BooleanValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitBooleanValue($this);

    $this->value->accept($visitor);

    $visitor->endVisitBooleanValue($this);
  }

  public bool $value;
}

class NullValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitNullValue($this);


    $visitor->endVisitNullValue($this);
  }

}

class EnumValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitEnumValue($this);

    $this->value->accept($visitor);

    $visitor->endVisitEnumValue($this);
  }

  public string $value;

}

class ListValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitListValue($this);

    foreach ($this->values as $value) {
      $value->accept($visitor);
    }

    $visitor->endVisitListValue($this);
  }

  public Value $values;

}

class ObjectValue extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitObjectValue($this);

    foreach ($this->fields as $field) {
      $field->accept($visitor);
    }

    $visitor->endVisitObjectValue($this);
  }

  public ObjectField $fields;

}

class ObjectField extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitObjectField($this);

    $this->name->accept($visitor);
    $this->value->accept($visitor);

    $visitor->endVisitObjectField($this);
  }

  public Name $name;

  public Value $value;

}

class Directive extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitDirective($this);

    $this->name->accept($visitor);
    if ($this->arguments) {
      foreach ($this->arguments as $argument) {
        $argument->accept($visitor);
      }
    }

    $visitor->endVisitDirective($this);
  }

  public Name $name;

  public Argument $arguments;

}
class Type extends Node
{
  public function accept(AstVisitor $visitor)
  {
    return $visitor->visitType($this);
  }

}

class NamedType extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitNamedType($this);

    $this->name->accept($visitor);

    $visitor->endVisitNamedType($this);
  }

  public Name $name;

}

class ListType extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitListType($this);

    $this->type->accept($visitor);

    $visitor->endVisitListType($this);
  }

  public Type $type;

}

class NonNullType extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitNonNullType($this);

    $this->type->accept($visitor);

    $visitor->endVisitNonNullType($this);
  }

  public Type $type;

}

class Name extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitName($this);

    $this->value->accept($visitor);

    $visitor->endVisitName($this);
  }

  public string $value;

}

class SchemaDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitSchemaDefinition($this);

    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->operationTypes as $operationType) {
      $operationType->accept($visitor);
    }

    $visitor->endVisitSchemaDefinition($this);
  }

  public Directive $directives;

  public OperationTypeDefinition $operationTypes;

}

class OperationTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitOperationTypeDefinition($this);

    $this->operation->accept($visitor);
    $this->type->accept($visitor);

    $visitor->endVisitOperationTypeDefinition($this);
  }

  public OperationKind $operation;

  public NamedType $type;

}

class ScalarTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitScalarTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }

    $visitor->endVisitScalarTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

}

class ObjectTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitObjectTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->interfaces) {
      foreach ($this->interfaces as $interface) {
        $interface->accept($visitor);
      }
    }
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->fields as $field) {
      $field->accept($visitor);
    }

    $visitor->endVisitObjectTypeDefinition($this);
  }

  public Name $name;

  public NamedType $interfaces;

  public Directive $directives;

  public FieldDefinition $fields;

}

class FieldDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitFieldDefinition($this);

    $this->name->accept($visitor);
    if ($this->arguments) {
      foreach ($this->arguments as $argument) {
        $argument->accept($visitor);
      }
    }
    $this->type->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }

    $visitor->endVisitFieldDefinition($this);
  }

  public Name $name;

  public InputValueDefinition $arguments;

  public Type $type;

  public Directive $directives;

}

class InputValueDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitInputValueDefinition($this);

    $this->name->accept($visitor);
    $this->type->accept($visitor);
    if ($this->defaultValue) {
      $this->defaultValue->accept($visitor);
    }
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }

    $visitor->endVisitInputValueDefinition($this);
  }

  public Name $name;

  public Type $type;

  public Value $defaultValue;

  public Directive $directives;

}

class InterfaceTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitInterfaceTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->fields as $field) {
      $field->accept($visitor);
    }

    $visitor->endVisitInterfaceTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public FieldDefinition $fields;

}

class UnionTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitUnionTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->types as $type) {
      $type->accept($visitor);
    }

    $visitor->endVisitUnionTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public NamedType $types;

}

class EnumTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitEnumTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->values as $value) {
      $value->accept($visitor);
    }

    $visitor->endVisitEnumTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public EnumValueDefinition $values;

}

class EnumValueDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitEnumValueDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }

    $visitor->endVisitEnumValueDefinition($this);
  }

  public Name $name;

  public Directive $directives;

}

class InputObjectTypeDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitInputObjectTypeDefinition($this);

    $this->name->accept($visitor);
    if ($this->directives) {
      foreach ($this->directives as $directive) {
        $directive->accept($visitor);
      }
    }
    foreach ($this->fields as $field) {
      $field->accept($visitor);
    }

    $visitor->endVisitInputObjectTypeDefinition($this);
  }

  public Name $name;

  public Directive $directives;

  public InputValueDefinition $fields;

}

class TypeExtensionDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitTypeExtensionDefinition($this);

    $this->definition->accept($visitor);

    $visitor->endVisitTypeExtensionDefinition($this);
  }

  public ObjectTypeDefinition $definition;

}

class DirectiveDefinition extends Node
{
  public function accept(AstVisitor $visitor)
  {
    $visitor->visitDirectiveDefinition($this);

    $this->name->accept($visitor);
    if ($this->arguments) {
      foreach ($this->arguments as $argument) {
        $argument->accept($visitor);
      }
    }
    foreach ($this->locations as $location) {
      $location->accept($visitor);
    }

    $visitor->endVisitDirectiveDefinition($this);
  }

  public Name $name;

  public InputValueDefinition $arguments;

  public Name $locations;

}


/** @generated */

abstract class AstVisitor
{
  public function visitNode(Node $node)
  {
    return $this->visit($node);
  }

  public function visit(Node $node)
  {
    $method = 'visit' . $node->getKind();
    if (method_exists($this, $method)) {
      return $this->$method($node);
    }
    return true;
  }

  public function endVisit(Node $node)
  {
    $method = 'endVisit' . $node->getKind();
    if (method_exists($this, $method)) {
      $this->$method($node);
    }
  }

  public function visitDocument(Document $document)
  {
    return true;
  }
  public function endVisitDocument(Document $document)
  {
  }
  public function visitOperationDefinition(OperationDefinition $operationDefinition)
  {
    return true;
  }
  public function endVisitOperationDefinition(OperationDefinition $operationDefinition)
  {
  }
  public function visitVariableDefinition(VariableDefinition $variableDefinition)
  {
    return true;
  }
  public function endVisitVariableDefinition(VariableDefinition $variableDefinition)
  {
  }
  public function visitSelectionSet(SelectionSet $selectionSet)
  {
    return true;
  }
  public function endVisitSelectionSet(SelectionSet $selectionSet)
  {
  }
  public function visitField(Field $field)
  {
    return true;
  }
  public function endVisitField(Field $field)
  {
  }
  public function visitArgument(Argument $argument)
  {
    return true;
  }
  public function endVisitArgument(Argument $argument)
  {
  }
  public function visitFragmentSpread(FragmentSpread $fragmentSpread)
  {
    return true;
  }
  public function endVisitFragmentSpread(FragmentSpread $fragmentSpread)
  {
  }
  public function visitInlineFragment(InlineFragment $inlineFragment)
  {
    return true;
  }
  public function endVisitInlineFragment(InlineFragment $inlineFragment)
  {
  }
  public function visitFragmentDefinition(FragmentDefinition $fragmentDefinition)
  {
    return true;
  }
  public function endVisitFragmentDefinition(FragmentDefinition $fragmentDefinition)
  {
  }
  public function visitVariable(Variable $variable)
  {
    return true;
  }
  public function endVisitVariable(Variable $variable)
  {
  }
  public function visitIntValue(IntValue $intValue)
  {
    return true;
  }
  public function endVisitIntValue(IntValue $intValue)
  {
  }
  public function visitFloatValue(FloatValue $floatValue)
  {
    return true;
  }
  public function endVisitFloatValue(FloatValue $floatValue)
  {
  }
  public function visitStringValue(StringValue $stringValue)
  {
    return true;
  }
  public function endVisitStringValue(StringValue $stringValue)
  {
  }
  public function visitBooleanValue(BooleanValue $booleanValue)
  {
    return true;
  }
  public function endVisitBooleanValue(BooleanValue $booleanValue)
  {
  }
  public function visitNullValue(NullValue $nullValue)
  {
    return true;
  }
  public function endVisitNullValue(NullValue $nullValue)
  {
  }
  public function visitEnumValue(EnumValue $enumValue)
  {
    return true;
  }
  public function endVisitEnumValue(EnumValue $enumValue)
  {
  }
  public function visitListValue(ListValue $listValue)
  {
    return true;
  }
  public function endVisitListValue(ListValue $listValue)
  {
  }
  public function visitObjectValue(ObjectValue $objectValue)
  {
    return true;
  }
  public function endVisitObjectValue(ObjectValue $objectValue)
  {
  }
  public function visitObjectField(ObjectField $objectField)
  {
    return true;
  }
  public function endVisitObjectField(ObjectField $objectField)
  {
  }
  public function visitDirective(Directive $directive)
  {
    return true;
  }
  public function endVisitDirective(Directive $directive)
  {
  }
  public function visitNamedType(NamedType $namedType)
  {
    return true;
  }
  public function endVisitNamedType(NamedType $namedType)
  {
  }
  public function visitListType(ListType $listType)
  {
    return true;
  }
  public function endVisitListType(ListType $listType)
  {
  }
  public function visitNonNullType(NonNullType $nonNullType)
  {
    return true;
  }
  public function endVisitNonNullType(NonNullType $nonNullType)
  {
  }
  public function visitName(Name $name)
  {
    return true;
  }
  public function endVisitName(Name $name)
  {
  }
  public function visitSchemaDefinition(SchemaDefinition $schemaDefinition)
  {
    return true;
  }
  public function endVisitSchemaDefinition(SchemaDefinition $schemaDefinition)
  {
  }
  public function visitOperationTypeDefinition(OperationTypeDefinition $operationTypeDefinition)
  {
    return true;
  }
  public function endVisitOperationTypeDefinition(OperationTypeDefinition $operationTypeDefinition)
  {
  }
  public function visitScalarTypeDefinition(ScalarTypeDefinition $scalarTypeDefinition)
  {
    return true;
  }
  public function endVisitScalarTypeDefinition(ScalarTypeDefinition $scalarTypeDefinition)
  {
  }
  public function visitObjectTypeDefinition(ObjectTypeDefinition $objectTypeDefinition)
  {
    return true;
  }
  public function endVisitObjectTypeDefinition(ObjectTypeDefinition $objectTypeDefinition)
  {
  }
  public function visitFieldDefinition(FieldDefinition $fieldDefinition)
  {
    return true;
  }
  public function endVisitFieldDefinition(FieldDefinition $fieldDefinition)
  {
  }
  public function visitInputValueDefinition(InputValueDefinition $inputValueDefinition)
  {
    return true;
  }
  public function endVisitInputValueDefinition(InputValueDefinition $inputValueDefinition)
  {
  }
  public function visitInterfaceTypeDefinition(InterfaceTypeDefinition $interfaceTypeDefinition)
  {
    return true;
  }
  public function endVisitInterfaceTypeDefinition(InterfaceTypeDefinition $interfaceTypeDefinition)
  {
  }
  public function visitUnionTypeDefinition(UnionTypeDefinition $unionTypeDefinition)
  {
    return true;
  }
  public function endVisitUnionTypeDefinition(UnionTypeDefinition $unionTypeDefinition)
  {
  }
  public function visitEnumTypeDefinition(EnumTypeDefinition $enumTypeDefinition)
  {
    return true;
  }
  public function endVisitEnumTypeDefinition(EnumTypeDefinition $enumTypeDefinition)
  {
  }
  public function visitEnumValueDefinition(EnumValueDefinition $enumValueDefinition)
  {
    return true;
  }
  public function endVisitEnumValueDefinition(EnumValueDefinition $enumValueDefinition)
  {
  }
  public function visitInputObjectTypeDefinition(InputObjectTypeDefinition $inputObjectTypeDefinition)
  {
    return true;
  }
  public function endVisitInputObjectTypeDefinition(InputObjectTypeDefinition $inputObjectTypeDefinition)
  {
  }
  public function visitTypeExtensionDefinition(TypeExtensionDefinition $typeExtensionDefinition)
  {
    return true;
  }
  public function endVisitTypeExtensionDefinition(TypeExtensionDefinition $typeExtensionDefinition)
  {
  }
  public function visitDirectiveDefinition(DirectiveDefinition $directiveDefinition)
  {
    return true;
  }
  public function endVisitDirectiveDefinition(DirectiveDefinition $directiveDefinition)
  {
  }
}