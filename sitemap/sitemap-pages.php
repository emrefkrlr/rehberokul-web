<?php
// anasayfa urlleri
require_once('../php/Core.php');

$pages = [
    'okul-tipi/anaokulu-kres',
    'okul-tipi/ilk-okul',
    'okul-tipi/orta-okul',
    'okul-tipi/lise',
    'talepler',
    'rehber-blog',
    'iletisim',
];
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
echo '<url>' . PHP_EOL;
echo '<loc>'. WEBURL . '</loc>' . PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

foreach ($pages as $page) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'. WEBURL . $page  . '</loc>' . PHP_EOL;
    echo '<changefreq>weakly</changefreq>' . PHP_EOL;
    echo '<priority>'. '0.8' . '</priority>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

echo '</urlset>' . PHP_EOL;

