<?php
require_once('functions.php');
//require_once('templates' . DIRECTORY_SEPARATOR . 'common_data.php');
$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, "utf8");


if (!$connect) {
    print('Ошибка подключения: ' .mysqli_connect_error());
}
else {
    $products = getLotsSortedByDate($connect);
    $categories = getCategoryList($connect);
    if (!empty($errors)) {
        foreach ($errors as $error) {
            Print('Ошибка подключения: '.$error);
        }
    }
    $pageContent = include_template('index', ['products' => $products]);
    $layout_content = include_template('layout', [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'title' => 'YetiCave - Главная']);
    echo $layout_content;

}
?>