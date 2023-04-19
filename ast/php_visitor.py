
#PHP Implementation
from casing import camel, title

class Printer(object):
  def __init__(self):
    pass

  def start_file(self):
    print('''
/** @generated */

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
''')
    
  def end_file(self):
    print('}')
    
  def start_type(self, name):
    titleName = title(name)
    camelName = camel(titleName)
    print('  public function visit%s(%s $%s) {' % (
      titleName,
      titleName,
      camelName))
    print('    return true;')
    print('  }')
    
    print('  public function endVisit%s(%s $%s) {' % (
      titleName,
      titleName,
      camelName))
    print('  }')
    
  def end_type(self, name):
    pass

  def field(self, type, name, nullable, plural):
    pass

  def start_union(self, name):
    pass

  def union_option(self, option):
    pass

  def end_union(self, name):
    pass
  
      