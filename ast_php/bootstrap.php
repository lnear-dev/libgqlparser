<?php
function structName($type)
{
    return 'GraphQLAst' . $type;
}

function returnType($type)
{
    if ($type == 'OperationKind' || $type == 'string') {
        return 'const char *';
    }
    if ($type == 'boolean') {
        return 'int';
    }
    return 'const struct ' . structName($type) . ' *';
}


function title($name)
{
    return ucfirst($name);
}
function fieldPrototype($owningType, $type, $name, $nullable, $plural)
{
    $stName = structName($owningType);
    if ($plural) {
        return 'int ' . $stName . '_get_' . snake($name) . '_size(const struct ' . $stName . ' *node)';
    } else {
        $retType = returnType($type);
        return $retType . ' ' . $stName . '_get_' . snake($name) . '(const struct ' . $stName . ' *node)';
    }
}
function snake($str)
{
    $str = preg_replace('/\s+/u', '', ucwords($str));
    $str = lcfirst($str);
    return $str;
}


function camel($str)
{
    $str = preg_replace('/[^a-zA-Z0-9]/', ' ', $str);
    $str = ucwords($str);
    $str = str_replace(' ', '', $str);
    $str = lcfirst($str);
    return $str;
}
interface LanguagePrinter {
    public function startFile(): void;
    public function startType(string $name): void;
    public function field(string $type, string $name, bool $nullable, bool $plural): void;
    public function endType(string $name): void;
    public function startUnion(string $name): void;
    public function unionOption(string $optionType): void;
    public function endUnion(string $name): void;
    public function endFile(): void;
}