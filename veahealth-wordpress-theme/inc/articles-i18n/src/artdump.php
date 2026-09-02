<?php
define('ABSPATH',1); function add_filter(){} function __($s,$d=""){return $s;}
require '/home/user/vea-health-final/veahealth-wordpress-theme/inc/blog-data.php';
$slug = $argv[1] ?? null;
foreach (veahealth_blog_articles() as $a) {
    if ($slug && $a['slug'] !== $slug) continue;
    echo "===== ", $a['slug'], "  [", $a['cat'], "]  read=", $a['read'], "\n";
    echo "TITLE: ", $a['title'], "\n";
    echo "EXCERPT: ", $a['excerpt'], "\n";
    echo "DEK: ", $a['dek'], "\n";
    foreach ($a['keys'] as $i=>$k) echo "KEY$i: ", $k, "\n";
    echo "CONTENT:\n", str_replace('><', ">\n<", $a['content']), "\n\n";
}
