<?php
require_once('functions.php');
$is_auth = (bool) rand(0, 1);
$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

if (!$connect) {
    exit('Ошибка подключения к БД');
}
    $products = getLotsSortedByDate($connect);
    $categories = getCategoryList($connect);
    $pageContent = include_template('index', ['categories' => $categories, 'products' => $products]);
    $layout_content = include_template('layout', [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'title' => 'YetiCave - Главная']);
    echo $layout_content;
?>