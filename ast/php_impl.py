#PHP Implementation

class Printer(object):
  def __init__(self):
    pass

  def start_file(self):
    print('''<?php
/** generated */

namespace LNE\GraphQL\Ast;

use LNE\GraphQL\Ast\Visitor\AstVisitor;

use function LNE\GraphQL\print_ast;
''')
    
  def end_file(self):
    pass
  
  def start_type(self, name):
    print('''
class %s extends Node {
  public function accept(AstVisitor $visitor) {
    $visitor->visit%s($this);
''' % (name, name))
    
  def field(self, type, name, nullable, plural):
    if type in ['OperationKind', 'string', 'boolean']:
      return

    if plural:
      accept = '{ foreach ($this->%s as $x) { $x->accept($visitor); } }' % name
      if nullable:
        accept = 'if ($this->%s) %s' % (name, accept)
      print('    ' + accept)
    else:
      accept = '$this->%s->accept($visitor);' % name
      if nullable:
        accept = 'if ($this->%s) { %s }' % (name, accept)
      print('    ' + accept)
      
  def end_type(self, name):
    print('''
    $visitor->endVisit%s($this);
  }
}''' % name)
    
  def start_union(self, name):
    pass
  
  def union_option(self, option):
    pass
  
  def end_union(self, name):
    pass
  
  