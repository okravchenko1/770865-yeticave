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
}

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
}

function getBetsList(mysqli $connect):array {
    $sql =  'SELECT id, date,  bet_sum, user_id, lot_id FROM bets ORDER BY id ASC;';
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
}
/**
 * Получение лота по его id
 *
 * @param mysqli $connect
 * @param int $id
 * @return array
 */
function getLotById(mysqli $connect, int $id, array $array = []):array {
    $id = intval($id);
    $sql = "SELECT name, image, description, start_price, lot_step, category_id FROM lots WHERE id='$id'";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
    }
    return $array;
}

/**
 * @param mysqli $connect
 * @param int $id
 * @param array $array
 * @return array|null
 */
function getBetsById(mysqli $connect, int $id, array $array=[]):array {
    $id = intval($id);
    $sql = "SELECT b.date, b.bet_sum, u.username as user_name FROM bets b
                LEFT JOIN users u
                ON b.user_id = u.id
                WHERE lot_id='$id' ORDER BY date DESC";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
}

/**
 * Рассчитываем placeholder для поля "Ваша ставка"
 *
 * @param mysqli $connect
 * @param int $id
 * @param array $lot
 * @return int
 */
function userBet(mysqli $connect, int $id, array $lot=[]):int {
    $id = intval($id);
    $sql = "SELECT l.start_price as start_price, l.lot_step as lot_step, COUNT(b.id) as bet_count, MAX(b.bet_sum) as current_max_price FROM bets b
                LEFT JOIN lots l
                ON b.lot_id = l.id
                WHERE end_date IS NULL AND l.id = '$id' GROUP BY l.id";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
        if (empty($array['current_max_price'])) {
            $userBet = (int)$lot['start_price'] + (int)$lot['lot_step'];
        }
        else {
            $userBet = (int)$array['current_max_price'] + (int)$lot['lot_step'];
        }
    }
    return $userBet;
}

