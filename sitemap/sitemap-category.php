<?php

// okul url leri

require_once ('../php/Core.php');

$getCategories = $db->rawQuery("SELECT name, link FROM tag");

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

foreach ($getCategories as $categoryLink) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'. WEBURL . 'kategori/' . $categoryLink['link'] .'</loc>' . PHP_EOL;
    echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
    echo '<changefreq>weakly</changefreq>' . PHP_EOL;
    echo '<priority>'. '0.6' . '</priority>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}
echo '</urlset>' . PHP_EOL;