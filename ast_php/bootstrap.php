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

function snake($str)
{
    if (strlen($str) < 2) {
        return strtolower($str);
    }
    $out = strtolower($str[0]);
    for ($i = 1; $i < strlen($str); $i++) {
        $c = $str[$i];
        if (ctype_upper($c)) {
            $out .= '_';
            $c = strtolower($c);
        }
        $out .= $c;
    }
    return $out;
}
function fieldPrototype($owningType, $type, $name, $nullable, $plural)
{
    $stName = structName($owningType);
    if ($plural) {
        return sprintf('int %s_get_%s_size(const struct %s *node)', $stName, snake($name), $stName);
    } else {
        $retType = returnType($type);
        return sprintf('%s %s_get_%s(const struct %s *node)', $retType, $stName, snake($name), $stName);
    }
}

define("LICENSE", <<<EOT
/**
 * **This whole file is generated. Do not edit.**
 * Copyright 2023-present Lnear
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
EOT
);


function title($name)
{
    return ucfirst($name);
}

function camel($str)
{
    return lcfirst($str);
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