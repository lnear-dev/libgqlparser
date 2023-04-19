<?php

require __DIR__ . '/bootstrap.php';

function printAst(LanguagePrinter $lang_module,  string $filename = "ast.ast"): void 
{
    $file = fopen($filename, 'r');
    if (!$file) {
        throw new Error('Could not open file: ' . $filename);
    }

    $lang_module->startFile();
    $line = fgets($file);
    while ($line) {
        $line = trim($line);
        if (strpos($line, '#') === 0 || !$line) {
            $line = fgets($file);
            continue;
        }

        [$code, $rest] = explode(' ', $line, 2);
        if ($code[0] === 'T') {
            $lang_module->startType($rest);
            $field_line = trim(fgets($file));
            while ($field_line) {
                if (strpos($field_line, '#') === 0) {
                    $field_line = trim(fgets($file));
                    continue;
                }
                [$field_kind, $field_type, $field_name] = explode(' ', $field_line, 3);
                $nullable = strlen($field_kind) > 1 && $field_kind[1] === '?';
                if ($field_kind[0] === 'S') {
                    $plural = false;
                } elseif ($field_kind[0] === 'P') {
                    $plural = true;
                } else {
                    throw new Error('Unknown field kind: ' . $field_kind);
                }
                $lang_module->field($field_type, $field_name, $nullable, $plural);
                $field_line = trim(fgets($file));
            }
            $lang_module->endType($rest);
        } elseif ($code[0] === 'U') {
            $lang_module->startUnion($rest);
            $field_line = trim(fgets($file));
            while ($field_line) {
                [$option_code, $option_type] = explode(' ', $field_line, 2);
                if ($option_code !== 'O') {
                    throw new Error('Unknown code in union: ' . $option_code);
                }
                $lang_module->unionOption($option_type);
                $field_line = trim(fgets($file));
            }
            $lang_module->endUnion($rest);
        }
        $line = fgets($file);
    }

    $lang_module->endFile();

    fclose($file);

} 

if (count($argv) !== 2) {
    echo "Usage: php ast.php <lang> ?<filename>\n";
    exit(1);
}

function loadLang(string $lang): LanguagePrinter {
    $lang = strtolower($lang);
    $langFile = __DIR__ . "/$lang.php";
    if (!file_exists($langFile)) {
        echo "Unknown language: $lang (file $langFile does not exist)\
";
        exit(1);
    }
    require_once $langFile;
    // $className = ucfirst($lang) . 'Printer';
    $className = 'Printer';
    return new $className();
}

$lang = $argv[1];

$printer = loadLang($lang);
printAst($printer);
