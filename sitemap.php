<?php
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>https://www.rehberokul.com/sitemap/sitemap-category.xml</loc>' . PHP_EOL;
echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>https://www.rehberokul.com/sitemap/sitemap-landing.xml</loc>' . PHP_EOL;
echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>https://www.rehberokul.com/sitemap/sitemap-blog.xml</loc>' . PHP_EOL;
echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>https://www.rehberokul.com/sitemap/sitemap-school.xml</loc>' . PHP_EOL;
echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '<url>' . PHP_EOL;
echo '<loc>https://www.rehberokul.com/sitemap/sitemap-pages.xml</loc>' . PHP_EOL;
echo '<lastmod>' . date('Y-m-dTH:i:sP', time()) . '</lastmod>'. PHP_EOL;
echo '<changefreq>daily</changefreq>' . PHP_EOL;
echo '<priority>'. '1.0' . '</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;

echo '</urlset>' . PHP_EOL;


