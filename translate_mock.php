<?php

$locales = ['es', 'fr', 'de', 'zh', 'ar', 'hi', 'pt', 'ru', 'ja'];
$keys_json = file_get_contents(__DIR__ . '/extracted_keys.json');
$keys = json_decode($keys_json, true);

// Create EN language fully
$en_file = __DIR__ . '/lang/en.json';
$en_data = file_exists($en_file) ? json_decode(file_get_contents($en_file), true) : [];
foreach ($keys as $k) {
    if (!isset($en_data[$k]))
        $en_data[$k] = $k;
}
file_put_contents($en_file, json_encode($en_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

foreach ($locales as $loc) {
    $file = __DIR__ . "/lang/{$loc}.json";
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    foreach ($keys as $k) {
        if (!isset($data[$k])) {
            $prefix = strtoupper($loc);
            $data[$k] = "[{$prefix}] {$k}";
        }
    }
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Generated " . count($data) . " keys for {$loc}\n";
}
echo "Done.\n";
