<?php
declare(strict_types=1);
/* @generated */

/**
 * Copyright 2023-present, Lnear
 * All rights reserved.
 */

namespace Lnear\GraphQL\Language;

class OperationKind {
    const QUERY = 'query';
    const MUTATION = 'mutation';
    const SUBSCRIPTION = 'subscription';
}

class DirectiveLocation {
    const QUERY = 'QUERY';
    const MUTATION = 'MUTATION';
    const SUBSCRIPTION = 'SUBSCRIPTION';
    const FIELD = 'FIELD';
    const FRAGMENT_DEFINITION = 'FRAGMENT_DEFINITION';
    const FRAGMENT_SPREAD = 'FRAGMENT_SPREAD';
    const INLINE_FRAGMENT = 'INLINE_FRAGMENT';
    const SCHEMA = 'SCHEMA';
    const SCALAR = 'SCALAR';
    const OBJECT = 'OBJECT';
    const FIELD_DEFINITION = 'FIELD_DEFINITION';
    const ARGUMENT_DEFINITION = 'ARGUMENT_DEFINITION';
    const INTERFACE = 'INTERFACE';
    const UNION = 'UNION';
    const ENUM = 'ENUM';
    const ENUM_VALUE = 'ENUM_VALUE';
    const INPUT_OBJECT = 'INPUT_OBJECT';
    const INPUT_FIELD_DEFINITION = 'INPUT_FIELD_DEFINITION';
}

class TypeKind {
    const SCALAR = 'SCALAR';
    const OBJECT = 'OBJECT';
    const INTERFACE = 'INTERFACE';
    const UNION = 'UNION';
    const ENUM = 'ENUM';
    const INPUT_OBJECT = 'INPUT_OBJECT';
    const LIST = 'LIST';
    const NON_NULL = 'NON_NULL';
}

class ValueKind {
    const VARIABLE = 'VARIABLE';
    const INT = 'INT';
    const FLOAT = 'FLOAT';
    const STRING = 'STRING';
    const BOOLEAN = 'BOOLEAN';
    const NULL = 'NULL';
    const ENUM = 'ENUM';
    const LIST = 'LIST';
    const OBJECT = 'OBJECT';
}
abstract class Definition extends Node {
  public string $kind = 'Definition';
  public static function fromArray(array $data): Definition {
    match ($data['kind']) {
      'OperationDefinition' => OperationDefinition::fromArray($data),
      'FragmentDefinition' => FragmentDefinition::fromArray($data),
      'SchemaDefinition' => SchemaDefinition::fromArray($data),
      'ScalarTypeDefinition' => ScalarTypeDefinition::fromArray($data),
      'ObjectTypeDefinition' => ObjectTypeDefinition::fromArray($data),
      'InterfaceTypeDefinition' => InterfaceTypeDefinition::fromArray($data),
      'UnionTypeDefinition' => UnionTypeDefinition::fromArray($data),
      'EnumTypeDefinition' => EnumTypeDefinition::fromArray($data),
      'InputObjectTypeDefinition' => InputObjectTypeDefinition::fromArray($data),
      'TypeExtensionDefinition' => TypeExtensionDefinition::fromArray($data),
      'DirectiveDefinition' => DirectiveDefinition::fromArray($data),
      default => throw new \Exception('Unknown kind: ' . $data['kind']),
    };
  }
}

class Document extends Node {
  public string $kind = NodeKind::DOCUMENT;
  public array $definitions;
}

class OperationDefinition extends Node {
  public string $kind = NodeKind::OPERATION_DEFINITION;
  public OperationKind $operation;
  public ?Name $name;
  public ?array $variableDefinitions;
  public ?array $directives;
  public SelectionSet $selectionSet;
}

class VariableDefinition extends Node {
  public string $kind = NodeKind::VARIABLE_DEFINITION;
  public Variable $variable;
  public Type $type;
  public ?Value $defaultValue;
}

class SelectionSet extends Node {
  public string $kind = NodeKind::SELECTION_SET;
  public array $selections;
}
abstract class Selection extends Node {
  public string $kind = 'Selection';
  public static function fromArray(array $data): Selection {
    match ($data['kind']) {
      'Field' => Field::fromArray($data),
      'FragmentSpread' => FragmentSpread::fromArray($data),
      'InlineFragment' => InlineFragment::fromArray($data),
      default => throw new \Exception('Unknown kind: ' . $data['kind']),
    };
  }
}

class Field extends Node {
  public string $kind = NodeKind::FIELD;
  public ?Name $alias;
  public Name $name;
  public ?array $arguments;
  public ?array $directives;
  public ?SelectionSet $selectionSet;
}

class Argument extends Node {
  public string $kind = NodeKind::ARGUMENT;
  public Name $name;
  public Value $value;
}

class FragmentSpread extends Node {
  public string $kind = NodeKind::FRAGMENT_SPREAD;
  public Name $name;
  public ?array $directives;
}

class InlineFragment extends Node {
  public string $kind = NodeKind::INLINE_FRAGMENT;
  public ?NamedType $typeCondition;
  public ?array $directives;
  public SelectionSet $selectionSet;
}

class FragmentDefinition extends Node {
  public string $kind = NodeKind::FRAGMENT_DEFINITION;
  public Name $name;
  public NamedType $typeCondition;
  public ?array $directives;
  public SelectionSet $selectionSet;
}
abstract class Value extends Node {
  public string $kind = 'Value';
  public static function fromArray(array $data): Value {
    match ($data['kind']) {
      'Variable' => Variable::fromArray($data),
      'IntValue' => IntValue::fromArray($data),
      'FloatValue' => FloatValue::fromArray($data),
      'StringValue' => StringValue::fromArray($data),
      'BooleanValue' => BooleanValue::fromArray($data),
      'NullValue' => NullValue::fromArray($data),
      'EnumValue' => EnumValue::fromArray($data),
      'ListValue' => ListValue::fromArray($data),
      'ObjectValue' => ObjectValue::fromArray($data),
      default => throw new \Exception('Unknown kind: ' . $data['kind']),
    };
  }
}

class Variable extends Node {
  public string $kind = NodeKind::VARIABLE;
  public Name $name;
}

class IntValue extends Node {
  public string $kind = NodeKind::INT_VALUE;
  public string $value;
}

class FloatValue extends Node {
  public string $kind = NodeKind::FLOAT_VALUE;
  public string $value;
}

class StringValue extends Node {
  public string $kind = NodeKind::STRING_VALUE;
  public string $value;
}

class BooleanValue extends Node {
  public string $kind = NodeKind::BOOLEAN_VALUE;
  public boolean $value;
}

class NullValue extends Node {
  public string $kind = NodeKind::NULL_VALUE;
}

class EnumValue extends Node {
  public string $kind = NodeKind::ENUM_VALUE;
  public string $value;
}

class ListValue extends Node {
  public string $kind = NodeKind::LIST_VALUE;
  public array $values;
}

class ObjectValue extends Node {
  public string $kind = NodeKind::OBJECT_VALUE;
  public array $fields;
}

class ObjectField extends Node {
  public string $kind = NodeKind::OBJECT_FIELD;
  public Name $name;
  public Value $value;
}

class Directive extends Node {
  public string $kind = NodeKind::DIRECTIVE;
  public Name $name;
  public ?array $arguments;
}
abstract class Type extends Node {
  public string $kind = 'Type';
  public static function fromArray(array $data): Type {
    match ($data['kind']) {
      'NamedType' => NamedType::fromArray($data),
      'ListType' => ListType::fromArray($data),
      'NonNullType' => NonNullType::fromArray($data),
      default => throw new \Exception('Unknown kind: ' . $data['kind']),
    };
  }
}

class NamedType extends Node {
  public string $kind = NodeKind::NAMED_TYPE;
  public Name $name;
}

class ListType extends Node {
  public string $kind = NodeKind::LIST_TYPE;
  public Type $type;
}

class NonNullType extends Node {
  public string $kind = NodeKind::NON_NULL_TYPE;
  public Type $type;
}

class Name extends Node {
  public string $kind = NodeKind::NAME;
  public string $value;
}

class SchemaDefinition extends Node {
  public string $kind = NodeKind::SCHEMA_DEFINITION;
  public ?array $directives;
  public array $operationTypes;
}

class OperationTypeDefinition extends Node {
  public string $kind = NodeKind::OPERATION_TYPE_DEFINITION;
  public OperationKind $operation;
  public NamedType $type;
}

class ScalarTypeDefinition extends Node {
  public string $kind = NodeKind::SCALAR_TYPE_DEFINITION;
  public Name $name;
  public ?array $directives;
}

class ObjectTypeDefinition extends Node {
  public string $kind = NodeKind::OBJECT_TYPE_DEFINITION;
  public Name $name;
  public ?array $interfaces;
  public ?array $directives;
  public array $fields;
}

class FieldDefinition extends Node {
  public string $kind = NodeKind::FIELD_DEFINITION;
  public Name $name;
  public ?array $arguments;
  public Type $type;
  public ?array $directives;
}

class InputValueDefinition extends Node {
  public string $kind = NodeKind::INPUT_VALUE_DEFINITION;
  public Name $name;
  public Type $type;
  public ?Value $defaultValue;
  public ?array $directives;
}

class InterfaceTypeDefinition extends Node {
  public string $kind = NodeKind::INTERFACE_TYPE_DEFINITION;
  public Name $name;
  public ?array $directives;
  public array $fields;
}

class UnionTypeDefinition extends Node {
  public string $kind = NodeKind::UNION_TYPE_DEFINITION;
  public Name $name;
  public ?array $directives;
  public array $types;
}

class EnumTypeDefinition extends Node {
  public string $kind = NodeKind::ENUM_TYPE_DEFINITION;
  public Name $name;
  public ?array $directives;
  public array $values;
}

class EnumValueDefinition extends Node {
  public string $kind = NodeKind::ENUM_VALUE_DEFINITION;
  public Name $name;
  public ?array $directives;
}

class InputObjectTypeDefinition extends Node {
  public string $kind = NodeKind::INPUT_OBJECT_TYPE_DEFINITION;
  public Name $name;
  public ?array $directives;
  public array $fields;
}

class TypeExtensionDefinition extends Node {
  public string $kind = NodeKind::TYPE_EXTENSION_DEFINITION;
  public ObjectTypeDefinition $definition;
}

class DirectiveDefinition extends Node {
  public string $kind = NodeKind::DIRECTIVE_DEFINITION;
  public Name $name;
  public ?array $arguments;
  public array $locations;
}
enum NodeKind: string {
    case DOCUMENT = Document::class;
    case OPERATION_DEFINITION = OperationDefinition::class;
    case VARIABLE_DEFINITION = VariableDefinition::class;
    case SELECTION_SET = SelectionSet::class;
    case FIELD = Field::class;
    case ARGUMENT = Argument::class;
    case FRAGMENT_SPREAD = FragmentSpread::class;
    case INLINE_FRAGMENT = InlineFragment::class;
    case FRAGMENT_DEFINITION = FragmentDefinition::class;
    case VARIABLE = Variable::class;
    case INT_VALUE = IntValue::class;
    case FLOAT_VALUE = FloatValue::class;
    case STRING_VALUE = StringValue::class;
    case BOOLEAN_VALUE = BooleanValue::class;
    case NULL_VALUE = NullValue::class;
    case ENUM_VALUE = EnumValue::class;
    case LIST_VALUE = ListValue::class;
    case OBJECT_VALUE = ObjectValue::class;
    case OBJECT_FIELD = ObjectField::class;
    case DIRECTIVE = Directive::class;
    case NAMED_TYPE = NamedType::class;
    case LIST_TYPE = ListType::class;
    case NON_NULL_TYPE = NonNullType::class;
    case NAME = Name::class;
    case SCHEMA_DEFINITION = SchemaDefinition::class;
    case OPERATION_TYPE_DEFINITION = OperationTypeDefinition::class;
    case SCALAR_TYPE_DEFINITION = ScalarTypeDefinition::class;
    case OBJECT_TYPE_DEFINITION = ObjectTypeDefinition::class;
    case FIELD_DEFINITION = FieldDefinition::class;
    case INPUT_VALUE_DEFINITION = InputValueDefinition::class;
    case INTERFACE_TYPE_DEFINITION = InterfaceTypeDefinition::class;
    case UNION_TYPE_DEFINITION = UnionTypeDefinition::class;
    case ENUM_TYPE_DEFINITION = EnumTypeDefinition::class;
    case ENUM_VALUE_DEFINITION = EnumValueDefinition::class;
    case INPUT_OBJECT_TYPE_DEFINITION = InputObjectTypeDefinition::class;
    case TYPE_EXTENSION_DEFINITION = TypeExtensionDefinition::class;
    case DIRECTIVE_DEFINITION = DirectiveDefinition::class;

}

abstract class Node implements \Ds\Hashable{
    public string $kind;
    public array $loc;


    public static function fromArray(array $data): Node {
        return self::fromArrayInternal($data);
      }
  
    private static function fromArrayInternal(array $data): Node {
        $kind = $data['kind'];
        $class = NodeKind::${$kind};
        $node = new $class();
        foreach ($data as $key => $value) {
            if ($key === 'kind') {
            continue;
            }
            if ($key === 'loc') {
            $node->loc = $value;
            continue;
            }
            if (is_array($value)) {
            $node->{$key} = array_map(fn($v) => self::fromArrayInternal($v), $value);
            continue;
            }
            $node->{$key} = $value;
        }
        return $node;
    }

    public function __toString(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    public function hash(): string {
        return md5($this->__toString());
    }

    public function equals($other): bool {
        return $this->__toString() === $other->__toString();
    }
}


