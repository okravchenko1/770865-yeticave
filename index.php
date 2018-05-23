<?php
require_once('functions.php');
require_once('templates' . DIRECTORY_SEPARATOR . 'common_data.php');
$pageContent = include_template('index', ['products' => $products]);
$layout_content = include_template('layout', [
    'pageContent' => $pageContent,
    'categories' => $categories,
    'title' => 'YetiCave - Главная']);
echo $layout_content;
?>