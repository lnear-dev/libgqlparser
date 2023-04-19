#pragma once

#include "AstNode.h"
#include "AstVisitor.h"
#include "libxml/parser.h"
#include <libxml/tree.h>

namespace lnear {
namespace graphql {
namespace ast {
namespace visitor {

class XmlVisitor : public AstVisitor {
private:
  xmlNodePtr currentNode_;

  class NodeFieldPrinter {
  private:
    XmlVisitor& visitor_;
    xmlNodePtr node_;

    void printFieldSeparator();

    void printLocation(const yy::location& location);

  public:
    NodeFieldPrinter(XmlVisitor& visitor, const char* nodeKind, const Node& node);

    void printSingularPrimitiveField(const char* fieldName, const char* value);

    void printSingularBooleanField(const char* fieldName, bool value);

    void printSingularObjectField(const char* fieldName);

    void printNullableSingularObjectField(const char* fieldName, const void* value);

    template <typename T>
    void printPluralField(const char* fieldName, const std::vector<std::unique_ptr<T>>& value) {
      printFieldSeparator();
      xmlNodePtr childNode = xmlNewChild(node_, nullptr, BAD_CAST fieldName, nullptr);
      for (const auto& child : value) {
        NodeFieldPrinter printer(visitor_, "", *child);
        xmlAddChild(childNode, printer.node_);
      }
    }

    template <typename T>
    void printNullablePluralField(const char* fieldName, const std::vector<std::unique_ptr<T>>* value) {
      if (value != nullptr) {
        printFieldSeparator();
        xmlNodePtr childNode = xmlNewChild(node_, nullptr, BAD_CAST fieldName, nullptr);
        for (const auto& child : *value) {
          NodeFieldPrinter printer(visitor_, "", *child);
            xmlAddChild(childNode, printer.node_);
        }
        }
    }
    };
 // Must be called at the start of all visit methods for node types
  // that have children. Maintains printed_.
  void visitNode();

  // Must be called at the end of all visit methods for node types
  // that have children, passing the text for this node. Maintains
  // printed_.
  void endVisitNode(std::string &&str);

  // Prints one of the many FooValue types that is prepresented with a
  // single string.
  template <typename ValueNode>
  void endVisitValueRepresentedAsString(const char *valueKind, const ValueNode &value);

public:
    XmlVisitor();
    ~XmlVisitor() {}
    
    std::string getResult() const;
    
    #include "XmlVisitor.h.inc"



};
} // namespace visitor
} // namespace ast
} // namespace graphql
} // namespace lnear
