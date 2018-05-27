<?php
declare(strict_types=1);

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
