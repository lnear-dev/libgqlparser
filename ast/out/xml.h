/**
 * Copyright 2019-present GraphQL Foundation
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
/** @generated */
bool XMLVisitor::visitDocument(const Document &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitDocument(const Document &node) {
  NodeFieldPrinter fields(*this, "Document", node);
  fields.printPluralField("definitions", node.getDefinitions());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitOperationDefinition(const OperationDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitOperationDefinition(const OperationDefinition &node) {
  NodeFieldPrinter fields(*this, "OperationDefinition", node);
  fields.printSingularPrimitiveField("operation", node.getOperation());
  fields.printNullableSingularObjectField("name", node.getName());
  fields.printNullablePluralField("variableDefinitions", node.getVariableDefinitions());
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printSingularObjectField("selectionSet");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitVariableDefinition(const VariableDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitVariableDefinition(const VariableDefinition &node) {
  NodeFieldPrinter fields(*this, "VariableDefinition", node);
  fields.printSingularObjectField("variable");
  fields.printSingularObjectField("type");
  fields.printNullableSingularObjectField("defaultValue", node.getDefaultValue());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitSelectionSet(const SelectionSet &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitSelectionSet(const SelectionSet &node) {
  NodeFieldPrinter fields(*this, "SelectionSet", node);
  fields.printPluralField("selections", node.getSelections());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitField(const Field &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitField(const Field &node) {
  NodeFieldPrinter fields(*this, "Field", node);
  fields.printNullableSingularObjectField("alias", node.getAlias());
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("arguments", node.getArguments());
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printNullableSingularObjectField("selectionSet", node.getSelectionSet());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitArgument(const Argument &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitArgument(const Argument &node) {
  NodeFieldPrinter fields(*this, "Argument", node);
  fields.printSingularObjectField("name");
  fields.printSingularObjectField("value");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitFragmentSpread(const FragmentSpread &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitFragmentSpread(const FragmentSpread &node) {
  NodeFieldPrinter fields(*this, "FragmentSpread", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitInlineFragment(const InlineFragment &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitInlineFragment(const InlineFragment &node) {
  NodeFieldPrinter fields(*this, "InlineFragment", node);
  fields.printNullableSingularObjectField("typeCondition", node.getTypeCondition());
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printSingularObjectField("selectionSet");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitFragmentDefinition(const FragmentDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitFragmentDefinition(const FragmentDefinition &node) {
  NodeFieldPrinter fields(*this, "FragmentDefinition", node);
  fields.printSingularObjectField("name");
  fields.printSingularObjectField("typeCondition");
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printSingularObjectField("selectionSet");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitVariable(const Variable &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitVariable(const Variable &node) {
  NodeFieldPrinter fields(*this, "Variable", node);
  fields.printSingularObjectField("name");

  endVisitNode(fields.finishPrinting());
}

void XMLVisitor::endVisitIntValue(const IntValue &node) {
  NodeFieldPrinter fields(*this, "IntValue", node);
  fields.printSingularPrimitiveField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

void XMLVisitor::endVisitFloatValue(const FloatValue &node) {
  NodeFieldPrinter fields(*this, "FloatValue", node);
  fields.printSingularPrimitiveField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

void XMLVisitor::endVisitStringValue(const StringValue &node) {
  NodeFieldPrinter fields(*this, "StringValue", node);
  fields.printSingularPrimitiveField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

void XMLVisitor::endVisitBooleanValue(const BooleanValue &node) {
  NodeFieldPrinter fields(*this, "BooleanValue", node);
  fields.printSingularBooleanField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

void XMLVisitor::endVisitNullValue(const NullValue &node) {
  NodeFieldPrinter fields(*this, "NullValue", node);

  printed_.back().emplace_back(fields.finishPrinting());
}

void XMLVisitor::endVisitEnumValue(const EnumValue &node) {
  NodeFieldPrinter fields(*this, "EnumValue", node);
  fields.printSingularPrimitiveField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

bool XMLVisitor::visitListValue(const ListValue &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitListValue(const ListValue &node) {
  NodeFieldPrinter fields(*this, "ListValue", node);
  fields.printPluralField("values", node.getValues());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitObjectValue(const ObjectValue &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitObjectValue(const ObjectValue &node) {
  NodeFieldPrinter fields(*this, "ObjectValue", node);
  fields.printPluralField("fields", node.getFields());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitObjectField(const ObjectField &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitObjectField(const ObjectField &node) {
  NodeFieldPrinter fields(*this, "ObjectField", node);
  fields.printSingularObjectField("name");
  fields.printSingularObjectField("value");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitDirective(const Directive &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitDirective(const Directive &node) {
  NodeFieldPrinter fields(*this, "Directive", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("arguments", node.getArguments());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitNamedType(const NamedType &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitNamedType(const NamedType &node) {
  NodeFieldPrinter fields(*this, "NamedType", node);
  fields.printSingularObjectField("name");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitListType(const ListType &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitListType(const ListType &node) {
  NodeFieldPrinter fields(*this, "ListType", node);
  fields.printSingularObjectField("type");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitNonNullType(const NonNullType &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitNonNullType(const NonNullType &node) {
  NodeFieldPrinter fields(*this, "NonNullType", node);
  fields.printSingularObjectField("type");

  endVisitNode(fields.finishPrinting());
}

void XMLVisitor::endVisitName(const Name &node) {
  NodeFieldPrinter fields(*this, "Name", node);
  fields.printSingularPrimitiveField("value", node.getValue());

  printed_.back().emplace_back(fields.finishPrinting());
}

bool XMLVisitor::visitSchemaDefinition(const SchemaDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitSchemaDefinition(const SchemaDefinition &node) {
  NodeFieldPrinter fields(*this, "SchemaDefinition", node);
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("operationTypes", node.getOperationTypes());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitOperationTypeDefinition(const OperationTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitOperationTypeDefinition(const OperationTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "OperationTypeDefinition", node);
  fields.printSingularPrimitiveField("operation", node.getOperation());
  fields.printSingularObjectField("type");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitScalarTypeDefinition(const ScalarTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitScalarTypeDefinition(const ScalarTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "ScalarTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitObjectTypeDefinition(const ObjectTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitObjectTypeDefinition(const ObjectTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "ObjectTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("interfaces", node.getInterfaces());
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("fields", node.getFields());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitFieldDefinition(const FieldDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitFieldDefinition(const FieldDefinition &node) {
  NodeFieldPrinter fields(*this, "FieldDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("arguments", node.getArguments());
  fields.printSingularObjectField("type");
  fields.printNullablePluralField("directives", node.getDirectives());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitInputValueDefinition(const InputValueDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitInputValueDefinition(const InputValueDefinition &node) {
  NodeFieldPrinter fields(*this, "InputValueDefinition", node);
  fields.printSingularObjectField("name");
  fields.printSingularObjectField("type");
  fields.printNullableSingularObjectField("defaultValue", node.getDefaultValue());
  fields.printNullablePluralField("directives", node.getDirectives());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitInterfaceTypeDefinition(const InterfaceTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitInterfaceTypeDefinition(const InterfaceTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "InterfaceTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("fields", node.getFields());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitUnionTypeDefinition(const UnionTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitUnionTypeDefinition(const UnionTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "UnionTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("types", node.getTypes());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitEnumTypeDefinition(const EnumTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitEnumTypeDefinition(const EnumTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "EnumTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("values", node.getValues());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitEnumValueDefinition(const EnumValueDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitEnumValueDefinition(const EnumValueDefinition &node) {
  NodeFieldPrinter fields(*this, "EnumValueDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitInputObjectTypeDefinition(const InputObjectTypeDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitInputObjectTypeDefinition(const InputObjectTypeDefinition &node) {
  NodeFieldPrinter fields(*this, "InputObjectTypeDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("directives", node.getDirectives());
  fields.printPluralField("fields", node.getFields());

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitTypeExtensionDefinition(const TypeExtensionDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitTypeExtensionDefinition(const TypeExtensionDefinition &node) {
  NodeFieldPrinter fields(*this, "TypeExtensionDefinition", node);
  fields.printSingularObjectField("definition");

  endVisitNode(fields.finishPrinting());
}

bool XMLVisitor::visitDirectiveDefinition(const DirectiveDefinition &node) {
  visitNode();
  return true;
}

void XMLVisitor::endVisitDirectiveDefinition(const DirectiveDefinition &node) {
  NodeFieldPrinter fields(*this, "DirectiveDefinition", node);
  fields.printSingularObjectField("name");
  fields.printNullablePluralField("arguments", node.getArguments());
  fields.printPluralField("locations", node.getLocations());

  endVisitNode(fields.finishPrinting());
}

