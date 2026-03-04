<?php

$dir = __DIR__ . '/resources/views';
$keys = [];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        // Match __("...") or __('...')
        preg_match_all("/__\(\s*['\"](.*?)['\"]\s*\)/", $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $match) {
                // simple unescape
                $key = str_replace(["\\'", "\\\""], ["'", "\""], $match);
                $keys[$key] = $key;
            }
        }
    }
}

file_put_contents(__DIR__ . '/extracted_keys.json', json_encode(array_values($keys), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Extracted " . count($keys) . " keys.\n";
