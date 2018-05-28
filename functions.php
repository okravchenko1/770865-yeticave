<?php
declare(strict_types=1);

$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, "utf8");

/**
 * Функция принимает целое число и
 * возвращает отформатированную сумму со знаком рубля.
 *
 * @param int $price_value
 * @return string
 *
 */
function format_price(int $price_value): string
{
    $price_value = ceil($price_value);
    $num = number_format($price_value, 0, '', ' ');
    $num .= " <b class=\"rub\">&#8381;</b>";
    return $num;
}

/**
 * Функция-шаблонизатор
 *
 * @param string $filename
 * @param array $param
 * @return string
 */
function include_template(string $filename, array $param = []): string
{
    if (!file_exists('templates' . DIRECTORY_SEPARATOR . $filename . '.php')) {
        return print('');
    }
    extract($param, EXTR_OVERWRITE);
    ob_start();
    require('templates' . DIRECTORY_SEPARATOR . $filename . '.php');
    return ob_get_clean();
}

/**
 *  Функция для вывода окончания ставок на лот
 *
 * @return string
 */
function lot_expire():string {
    date_default_timezone_set('Europe/Moscow');
    $ts_midnight = strtotime('tomorrow');
    $time_till_midnight = $ts_midnight - time();
    $hour = floor($time_till_midnight / 3600);
    $minute = floor(($time_till_midnight % 3600)/ 60);
    $expire = $hour . ':' . $minute;
    return strftime('%R', strtotime($expire));
}

/**
 * * Получение списка лотов, отсортированных по дате создания
 * (самые новые)
 *
 * @param mysqli $connect
 * @return array
 */
function getLotsSortedByDate(mysqli $connect):array {
    $sql = 'SELECT id, name, creation_date,  description, image, start_price, category_id FROM lots WHERE end_date>NOW() ORDER BY creation_date DESC';
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
};

/**
 *  * Получение списка категорий
 *
 * @param mysqli $connect
 * @return array
 */
function getCategoryList(mysqli $connect):array {
    $sql =  'SELECT id, category_name FROM categories ORDER BY id ASC;';
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
};

/**
 * @param array $required
 * @param array $errors
 * @return array
 */
function validateIfEmpty($required=[], $errors=[]) {
    foreach ($required as $key => $value) {
        if (empty($value)) {
            $errors[$key] = 'Обязательное поле';
        }
    }
    return $errors;
}

/*Валидация полей на целое положительное число*/
function validateIfInt($required=[], $errors=[]) {
    foreach ($required as $key => $value) {
        if (!empty($value)) {
            if (!filter_var($value, FILTER_VALIDATE_INT) OR $value<0) {
                $errors[$key] = 'Неверный формат';
            }
        }
    }
    return $errors;
}

/*Валидация даты*/
function dateValidation(array $required=[], $errors=[]) {
    foreach ($required as $key => $value) {
        if (!empty($value)) {
            $dif = strtotime($value) - time() - 86400;
            if ($dif<0) {
                $errors[$key] = 'Некорректная дата истечения лота';
            }
        }
    };
    return $errors;
}

function fileValidation($required=[], $format, $errors=[]) {
    if (!empty($required)) {
        $file_type = mime_content_type($required);
        $errors['file'] = 'Загрузите файл в нужном формате';
        foreach ($format as $form) {
            if ($file_type == $form) {
                unset($errors['file']);
            };
        };
    }
    return $errors;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}