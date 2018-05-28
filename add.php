<?php
require_once('functions.php');

$categories = [];
$sql_categories = 'SELECT * FROM categories';
$result_categories = mysqli_query($connect, $sql_categories);
if ($result_categories) {
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
}
$product = [
    'name' => null,
    'category_id' => null,
    'description' => null,
    'start_price' => null,
    'lot_step' => null,
    'end_date' => null,
    'img_source' => null
];
$errors = [
];
if ($_SERVER['REQUEST_METHOD'] = 'POST') {
    if (isset($_POST['product'])) {
        $product = $_POST['product'];
        $required = ['name', 'category_id', 'description', 'start_price', 'lot_step', 'end_date'];
        foreach ($required as $value) {
            if (empty($product[$value])) {
                $errors[$value] = 'Обязательное поле';
            }
        }

        //Категории
        if (is_numeric($product['category_id'])) {
            $product['category_id'] = intval($product['category_id']);
            if ($product['category_id'] > 6 || $product['category_id'] < 1) {
                $errors['category_id'] = 'Выберите категорию';
            }
        }
        //Начальная цена
        if (is_numeric($product['start_price'])) {
            if ($product['start_price'] < 0) {
                $errors['start_price'] = 'Цена должна быть целым положительным числом';
            }
        } else {
            $errors['start_price'] = 'Введите начальную цену';
        }
        //Шаг ставки
        if (!is_numeric($product['lot_step']) && ($product['lot_step'] < 1)) {
            $errors['lot_step'] = 'Шаг ставки должен быть целым числом больше 0';
        }
        //Дата
        if (strtotime($product['end_date'])) {
            $product_ts = strtotime($product['end_date']);
            $diff = $product_ts - time();
            if ($diff < 86400) {
                $errors['end_date'] = 'Укажите время не ранее одних суток';
            }
        } else {
            $errors['end_date'] = 'Введите дату окончания приема ставок';
        }
        $temp_name = null;
        //Работа с файлом
        if (is_uploaded_file($_FILES['lot_img']['tmp_name'])) {
            $temp_name = $_FILES['lot_img']['tmp_name'];
            $file_type = mime_content_type($temp_name);
            if ($file_type == "image/png") {
                $path = uniqid() . '.png';
                $product['img_source'] = 'img/' . $path;
            } elseif ($file_type == "image/jpeg") {
                $path = uniqid() . '.jpeg';
                $product['img_source'] = 'img/' . $path;
            } else {
                $errors['file'] = 'Загрузите картинку в формате jpeg/png';
            }
        } else {
            $errors['file'] = 'Вы не загрузили файл';
        }
        if (count($errors)) {
            $errors['file'] = 'Повторите отправку файла';
            $pageContent = include_template('add', ['product' => $product, 'categories' => $categories,
                'errors' => $errors]);
        } else {
            $sql_lot = "INSERT INTO lots (creation_date, name, description, image, start_price, end_date, lot_step, category_id)
        VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?)";
            $stmt = db_get_prepare_stmt($connect, $sql_lot, [$product['name'], $product['description'], $product['img_source'],
                $product['start_price'], $product['end_date'], $product['lot_step'], $product['category_id']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                move_uploaded_file($temp_name, $product['img_source']);
                $lot_id = mysqli_insert_id($connect);
                header("Location: lot.php?id=" . $lot_id);
            }
        }
    } else {
        $pageContent = include_template('add', [
            'categories' => $categories,
            'product' => $product,
            'errors' => $errors
        ]);
    }
}
$layout_content = include_template('layout', [
    'pageContent' => $pageContent,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'title' => 'YetiCave - Главная']);
echo $layout_content;