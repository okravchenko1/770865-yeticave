<?php
require_once('functions.php');
if (!$connect) {
    exit('Ошибка подключения к БД');
}
$product = getLotsSortedByDate($connect);
$categories = getCategoryList($connect);
$bets = getBetsList($connect);
$yourBet = NULL;
/*Проверяем наличие параметра запроса с id лота и проверяем существует ли лот*/
if (isset($_GET['id']) && in_array(intval($_GET['id']), array_column($product, 'id'))) {
    $product = getLotById($connect, $_GET['id'], $product);
    $bet = getBetsById($connect, $_GET['id'], $bets);
    $bet_counter = count($bet);
    $userbet = userBet($connect, $_GET['id'], $product);
    $pageContent = include_template('lot', ['categories' => $categories, 'product' => $product, 'bet' => $bet, 'userBet' => $userbet, 'bet_counter' => $bet_counter]);
    $layout_content = include_template('layout', [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'title' => $product['name']]);
    echo $layout_content;
} else {
    http_response_code(404);
}
?>
