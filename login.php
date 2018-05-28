<?php

require_once("functions.php");
$pageContent = null;
$cur_category = "";
$categories = [];
$sql_categories = 'SELECT * FROM categories';
$result_categories = mysqli_query($connect, $sql_categories);
if ($result_categories) {
$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
};
if (isset($_SESSION['user'])) {
header('Location: /');
};
$login = [
'email' => null,
'password' => null
];
$user = null;
// Проверяем отправку формы
if (isset($_POST['login'])) {
$login = $_POST['login'];
$required = ['email', 'password'];
$errors = [];
// Проверяем заполненность полей
foreach ($required as $field) {
if (empty($login[$field])) {
$errors[$field] = 'Это поле надо заполнить';
}
};
// Ищем пользователя в базе
$email = mysqli_real_escape_string($link, $login['email']);
$sql = "SELECT * FROM users WHERE email LIKE '$email'";
$res = mysqli_query($link, $sql);
$user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
if (!count($errors) and $user) {
if (password_verify($login['password'], $user['password'])) {
$_SESSION['user'] = $user;
header('Location: /');
}
else {
$errors['password'] = 'Вы ввели неверный email/пароль';
}
}
else {
$errors['email'] = 'Вы ввели неверный email/пароль';
}
if (count($errors)) {
$page_content = include_template('templates/login.php',
['categories' => $categories, 'errors' => $errors, 'login' => $login]);
}
}
else {
$pageContent = include_template('login', ['categories' => $categories, 'login' => $login]);
}
$layout_content = include_template('layout', [
'title' => 'Вход | YetiCave',
'page_content' => $pageContent,
'categories' => $categories,
'cur_category' => $cur_category
]
);
print ($layout_content);