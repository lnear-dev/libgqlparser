
  #PHP implementation of the AST Printer
  
import io as StringIO

from casing import title
class Printer(object):
    def __init__(self):
        self._type_name = None
        # Map concrete type to base class
        self._bases = {}
        # HACK: Defer everything we print so that forward declarations for
        # all classes come first. Avoids having to do 2 passes over the
        # input file.
        self._deferredOutput = StringIO.StringIO()

        self._fields = []

    def start_file(self):
        print('<?php', file=self._deferredOutput)
        print('namespace ast;', file=self._deferredOutput)
        print(file=self._deferredOutput)
        print('abstract class Node {', file=self._deferredOutput)
        print('  public ?Location $location = null;', file=self._deferredOutput)
        print('  public string $kind;', file=self._deferredOutput)
        
        print('  public function __construct( array $vars = []) {', file=self._deferredOutput)
        print('    foreach ($vars as $key => $value) {', file=self._deferredOutput)
        print('      if (! \property_exists($this, $key)) {', file=self._deferredOutput)
        print('        $cls = \get_class($this);', file=self._deferredOutput)
        print('        echo "Trying to set non-existing property \'{$key}\' on class \'{$cls}\'";', file=self._deferredOutput)
        print('      }', file=self._deferredOutput)
        print('      $this->{$key} = $value;', file=self._deferredOutput)
        print('    }', file=self._deferredOutput)
        print('  }', file=self._deferredOutput)
        
        print('  public abstract function accept(Vistor $visitor);', file=self._deferredOutput)
        
        print('  public function __toString() {', file=self._deferredOutput)
        print('    return print_ast($this);', file=self._deferredOutput)
        print('  }', file=self._deferredOutput)

        print('  public function getKind() {', file=self._deferredOutput)
        print('    return $this->kind;', file=self._deferredOutput)
        print('  }', file=self._deferredOutput)
        print('}', file=self._deferredOutput)
        print(file=self._deferredOutput)
        print('class Location {', file=self._deferredOutput)
        print('  public function __construct(', file=self._deferredOutput)
        print('      public int $beginLine,', file=self._deferredOutput)
        print('      public int $beginColumn,', file=self._deferredOutput)
        print('      public int $endLine,', file=self._deferredOutput)
        print('      public int $endColumn,', file=self._deferredOutput)
        print('      public string $source) { }', file=self._deferredOutput)
        print('}', file=self._deferredOutput)
        print(file=self._deferredOutput)
        
        print('enum OperationKind: string {', file=self._deferredOutput)
        print('  case QUERY = "query";', file=self._deferredOutput)
        print('  case MUTATION = "mutation";', file=self._deferredOutput)
        print('  case SUBSCRIPTION = "subscription";', file=self._deferredOutput)
        print('}', file=self._deferredOutput)
        
        
    def end_file(self):
        # print('}', file=self._deferredOutput)
        # print('?>', file=self._deferredOutput)
        print(self._deferredOutput.getvalue())
        
    def start_type(self, name):
        self._type_name = name
        self._fields = []
        # non-deferred!
        print('''
    class %s extends Node {
        public function accept(AstVisitor $visitor) {
            $visitor->visit%s($this);
    ''' % (name, name), file=self._deferredOutput)
            
        
    def field(self, type, name, nullable, plural):
        self._fields.append((type, name, nullable, plural))
        if type in ['OperationKind', 'string', 'boolean']:
            pass
        if plural:
            accept = 'foreach ($this->%s as $%s) { $%s->accept($visitor); }' % (name, name[:-1], name[:-1])
            if nullable:
                accept = 'if ($this->%s){ %s }' % (name, accept)
            print('    ' + accept, file=self._deferredOutput)
        else:
            accept = '$this->%s->accept($visitor);' % name
            if nullable:
                accept = 'if ($this->%s) { %s }' % (name, accept)
            print('    ' + accept, file=self._deferredOutput)
      
    def end_type(self, name):
        print('''
    $visitor->endVisit%s($this);
  }
''' % name, file=self._deferredOutput)
        self._print_fields()
        print('}', file=self._deferredOutput)
        

    def start_union(self, name):
        self._type_name = name
        # non-deferred!
        print('class %s extends Node {' % name, file=self._deferredOutput)
        print('  public function accept(AstVisitor $visitor) {', file=self._deferredOutput)
        print('    return $visitor->visit%s($this);' % name, file=self._deferredOutput)
        print('  }', file=self._deferredOutput)
        print(file=self._deferredOutput)
        
    def union_option(self, type):
        assert type not in self._bases, '%s cannot appear in more than one union!' % type
        self._bases[type] = self._type_name
        
    def end_union(self, name):
        print('}', file=self._deferredOutput)

    def start_visitor(self, name):
        self._type_name = name
        # non-deferred!
        print('interface Visitor {', file=self._deferredOutput)
        print(file=self._deferredOutput)
        print('  public function visit%s(%s $node);' % (name, name), file=self._deferredOutput)
        print(file=self._deferredOutput)
        
    def visitor_method(self, type):
        print('  public function visit%s(%s $node);' % (type, type), file=self._deferredOutput)
        print(file=self._deferredOutput)
        
    def end_visitor(self, name):
        print('}', file=self._deferredOutput)
        print(file=self._deferredOutput)
        
    def _print_fields(self):
        for (type, name, nullable, plural) in self._fields:
            if type == 'boolean':
                print('  public bool $%s;' % name, file=self._deferredOutput)
            else:
                print('  public %s $%s;' % (type, name), file=self._deferredOutput)
                print(file=self._deferredOutput)
    
    
      
    