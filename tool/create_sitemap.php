<?php
/**
 * Created by PhpStorm.
 * User: vankhoadesign
 * Date: 1/4/18
 * Time: 10:17 AM
 */
$row = 0;
if (($handle = fopen("URLsWithDomains.csv", "r")) !== FALSE) {
    $fp = fopen('../sitemap.xml', 'w');

    fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>
        <urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row++;
        if($row<=1) continue;

        $url = '<url>
  <loc>'.$data[0].'</loc>
  <lastmod>'. date('c',time()).'</lastmod>
  <priority>0.80</priority>
</url>
';
        fwrite($fp, $url);

    }
    fwrite($fp, "</urlset>");
    fclose($fp);
    fclose($handle);
}
