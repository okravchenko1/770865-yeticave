<?php
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
    extract($param);
    ob_start();
    require('templates' . DIRECTORY_SEPARATOR . $filename . '.php');
    return ob_get_clean();
}
?>