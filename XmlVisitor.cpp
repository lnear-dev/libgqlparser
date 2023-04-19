/**
 * Copyright 2019-present, GraphQL Foundation
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

#include "position.hh"
#include "XmlVisitor.h"

#include <cassert>
#include <iterator>

namespace lnear
{
    namespace graphql
    {
        namespace ast
        {
            namespace visitor
            {

                static std::string escape(const char *s)
                {
                    static char hex[16] = {'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'};
                    std::string result;
                    while (unsigned char ch = *s++)
                    {
                        if (ch >= '\0' && ch <= '\x1f')
                        {
                            result.push_back('\\');
                            result.push_back('u');
                            result.push_back('0');
                            result.push_back('0');
                            result.push_back(ch >= 16 ? '1' : '0');
                            result.push_back(hex[ch % 16]);
                        }
                        else if (ch == '"')
                        {
                            result.push_back('\\');
                            result.push_back('"');
                        }
                        else if (ch == '\\')
                        {
                            result.push_back('\\');
                            result.push_back('\\');
                        }
                        else
                        {
                            result.push_back(ch);
                        }
                    }
                    return result;
                }

                XmlVisitor::NodeFieldPrinter::NodeFieldPrinter(
                    XmlVisitor &visitor,
                    const char *nodeKind,
                    const Node &node)
                    : visitor_(visitor)
                {
                    if (!visitor_.printed_.empty())
                    {
                        nextChild_ = visitor_.printed_.back().begin();
                    }
                    out_ << R"(<)" << nodeKind << R"( loc=")";
                    printLocation(out_, node.getLocation());
                }

                std::string XmlVisitor::NodeFieldPrinter::finishPrinting()
                {
                    assert(!out_.str().empty());

                    out_ << R"(>)";
                    auto result(out_.str());
#ifndef NDEBUG
                    out_.str("");
#endif
                    return result;
                }

                void XmlVisitor::NodeFieldPrinter::printFieldSeparator()
                {

                    out_ << R"( )";
                }

                void XmlVisitor::NodeFieldPrinter::printSingularPrimitiveField(
                    const char *fieldName,
                    const char *value)
                {
                    printFieldSeparator();

                    out_ << '"' << fieldName << R"("=)";

                    out_ << '"' << value << '"';
                }

                void XmlVisitor::NodeFieldPrinter::printSingularBooleanField(
                    const char *fieldName,
                    bool value)
                {
                    printFieldSeparator();

                    out_ << '"' << fieldName << R"("=)";

                    out_ << (value ? "1" : "0");
                }

                void XmlVisitor::NodeFieldPrinter::printSingularObjectField(const char *fieldName)
                {
                    printFieldSeparator();

                    out_ << '"' << fieldName << R"("=)";
                    assert(!visitor_.printed_.empty());

                    out_ << *nextChild_++ << R"(</)" << fieldName << R"(>)";
                }

                void XmlVisitor::NodeFieldPrinter::printNullableSingularObjectField(
                    const char *fieldName,
                    const void *value)
                {
                    printFieldSeparator();

                    out_ << '"' << fieldName << R"("=)";
                    if (value != nullptr)
                    {
                        assert(!visitor_.printed_.empty());

                        out_ << *nextChild_++ << R"(</)" << fieldName << R"(>)";
                    }
                    else
                    {

                        out_ << R"(<)" << fieldName << R"(>)";
                    }
                }

                // Method invariant: printed_ contains strings for this node's children.
                void XmlVisitor::NodeFieldPrinter::printLocation(
                    std::ostringstream &out,
                    const yy::location &location)
                {
                    out << R"(<location )"
                        << R"(start_line=")" << location.begin.line << R"(" )"
                        << R"(start_column=")" << location.begin.column << R"(" )"
                        << R"(end_line=")" << location.end.line << R"(" )"
                        << R"(end_column=")" << location.end.column << R"(" />)";
                }

                void XmlVisitor::NodeFieldPrinter::printChildList(
                    std::ostringstream &out,
                    const std::vector<std::string>::const_iterator &childIterator,
                    size_t numChildren)
                {

                    out << R"(<children>)";

                    for (size_t ii = 0; ii < numChildren; ++ii)
                    {
                        if (ii != 0)
                        {

                            out << R"(<child>)";
                        }

                        out << *(childIterator + ii) << R"(</child>)";
                    }

                    out << R"(</children>)";
                }

                void XmlVisitor::endVisitValueRepresentedAsString(const char *valueKind, const ValueNode &value)
                {
                    std::ostringstream out;

                    out << R"(<)" << valueKind << R"( loc=")";
                    printLocation(out, value.getLocation());

                    out << R"(>)" << escape(value.getValue()) << R"(</)" << valueKind << R"(>)";
                    endVisitNode(out.str());
                }

XmlVisitor::XmlVisitor() {
  currentNode_ = xmlNewNode(nullptr, BAD_CAST "root");
}

void XmlVisitor::visitNode() {
  // printed_.emplace_back();
}

void XmlVisitor::endVisitNode(std::string &&str) {
  // printed_.pop_back();
  // printed_.back().emplace_back(std::move(str));
}

template <typename ValueNode>
void XmlVisitor::endVisitValueRepresentedAsString(const char *valueKind, const ValueNode &value) {
  std::ostringstream out;

  out << R"(<)" << valueKind << R"( loc=")";
  printLocation(out, value.getLocation());

  out << R"(>)" << escape(value.getValue()) << R"(</)" << valueKind << R"(>)";
  endVisitNode(out.str());
}

std::string XmlVisitor::getResult() const {
  xmlDocPtr doc = xmlNewDoc(BAD_CAST "1.0");
  xmlDocSetRootElement(doc, currentNode_);
  xmlChar *xmlbuff;
  int buffersize;
  xmlDocDumpFormatMemoryEnc(doc, &xmlbuff, &buffersize, "UTF-8", 1);
  std::string result((char *)xmlbuff);
  xmlFree(xmlbuff);
  xmlFreeDoc(doc);
  return result;
}

XmlVisitor::NodeFieldPrinter::NodeFieldPrinter(XmlVisitor &visitor, const char *nodeKind, const Node &node)
    : visitor_(visitor), node_(xmlNewNode(nullptr, BAD_CAST nodeKind)) {
  printLocation(node.getLocation());
}

void XmlVisitor::NodeFieldPrinter::printFieldSeparator() {
  if (node_->children != nullptr) {
    xmlNodePtr separator = xmlNewText(BAD_CAST ", ");
    xmlAddSibling(node_->children, separator);
  }
}

void XmlVisitor::NodeFieldPrinter::printLocation(const yy::location &location) {
  std::ostringstream out;
  out << R"( loc=")";
  printLocation(out, location);
  out << R"(")";
  xmlNewProp(node_, BAD_CAST "loc", BAD_CAST out.str().c_str());
}

#include "XmlVisitor.cpp.inc"

                // libxml2 refactoring

            } // namespace visitor
        }     // namespace ast
    }         // namespace graphql
} // namespace lnear
