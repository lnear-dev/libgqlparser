
#the above code is from libgraphqlparser/ast/c_impl.py and generates c bindings for the AST
#below is our implementation to generate PHP (Zend) bindings for the AST
from c import field_prototype, return_type, struct_name
from casing import title
from license import C_LICENSE_COMMENT
class Printer(object):
  '''Printer for the implementation of the php interface to the AST.
  '''

  def __init__(self):
    self._current_type = None

  def start_file(self):
    print(C_LICENSE_COMMENT + '''/** @generated */


#include "php.h"
#include "php_libgraphqlparser.h"
#include "GraphQLAst.h"
#include "../Ast.h"

using namespace facebook::graphql::ast;  // NOLINT
''')
    
  def end_file(self):
    pass
  
  def start_type(self, name):
    self._current_type = name
    
  def field(self, type, name, nullable, plural):
    print(field_prototype(self._current_type, type, name, nullable, plural) + ' {')
    print('  const auto *realNode = reinterpret_cast<const %s *>(node);' % self._current_type)
    title_name = title(name)
    call_get = 'realNode->get%s()' % title_name
    zend_name = name
    
    if plural:
      if nullable:
        print('  return %s ? %s->size() : 0;' % (call_get, call_get))
      else:
        print('  return %s.size();' % call_get)
    else:
      if type in ['string', 'OperationKind', 'boolean']:
        print('  return %s;' % call_get)
      else:
        fmt = '  return reinterpret_cast<const struct %s *>(%s%s);'
        print(fmt % (struct_name(type), '' if nullable else '&', call_get))
        
      # zval *zv = zend_read_property(Z_OBJCE_P(object), object, ZEND_STRL("name"), 0, &rv);

      # if (Z_TYPE_P(zv) == IS_STRING) {
        # RETURN_STR(Z_STR_P(zv));
      # }
      
    print('}')
    
  def end_type(self, name):
    pass

  def start_union(self, name):
    pass

  def union_option(self, option):
    pass

  def end_union(self, name):
    pass