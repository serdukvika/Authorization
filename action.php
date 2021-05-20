<?php
session_start();
include "db.php";
$home = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/";
function out_arr()
{
    global $countries;
    // делаем переменную $countries глобальной
    $arr_out = array();
    $arr_out[] = "<table class='out' border='1'>";
    $arr_out[] = "<tr><td>№</td><td>Страна</td><td>Столица</td><td>Площадь</td><td>Население за 2000 год</td><td>Население за 2010 год</td><td>Среднее население</td></tr>";
    foreach ($countries as $country) {
        static $i = 1;
        //статическая глобальная переменная-счетчик
        $str = "<tr>";
        $str .= "<td>" . $i . "</td>";
        foreach ($country as $key => $value) {
            if (!is_array($value)) {
                $str .= "<td>$value</td>";
            } else {
                foreach ($value as $k => $v) {
                    $str .= "<td>$v</td>";
                }

            }

        }
        $str .= "<td>" . (array_sum($country['population']) / count($country['population'])) . "</td>";
        $str .= "</tr>";
        $arr_out[] = $str;
        $i++;
    }
    $arr_out[] = "</table>";
    return $arr_out;
}

function check_autorize($log)
{
    //global $users;
    $users = get_users();
    return in_array($log, $users);
}

function check_admin($log)
{
    //global $users;
    // if (in_array($log, $users) && $pas == $users["admin"]) {
    //     return true;
    // } else {
    //     return false;
    // }
    return isset($_SESSION['authorized']) && $log == "admin";
}
function check_user($log, $pas)
{
    //global $users;
    $users = get_users();
    if (array_key_exists($log, $users) && $pas == $users[$log]) {
        $_SESSION['authorized'] = 1;
        return true;
    } else {
        return false;
    }

}

function add_user($log, $pas)
{
    //global $users;
    $users = get_users();
    if (!check_log($log)) {
        $users[$log] = $pas;
        $_SESSION['authorized'] = 1;
        update_users($users);
        return true;
    } else {
        return false;
    }

}

function check_log($log)
{
    //global $users;
    $users = get_users();
    return array_key_exists($log, $users);

}

function name($a, $b)
{ // функция, определяющая способ сортировки (по названию столицы)
    if ($a["capital"] < $b["capital"]) {
        return -1;
    } elseif ($a["capital"] == $b["capital"]) {
        return 0;
    } else {
        return 1;
    }

}

function area($a, $b)
{ // функция, определяющая способ сортировки (по населению)
    if ($a["area"] < $b["area"]) {
        return -1;
    } elseif ($a["area"] == $b["area"]) {
        return 0;
    } else {
        return 1;
    }

}

function population($a, $b)
{ // функция, определяющая способ сортировки (по сумме населения за 2000 и за 2010 годы)
    if ($a["population"]["2000"] + $a["population"]["2010"] < $b["population"]["2000"] + $b["population"]["2010"]) {
        return -1;
    } elseif ($a["population"]["2000"] + $a["population"]["2010"] == $b["population"]["2000"] + $b["population"]["2010"]) {
        return 0;
    } else {
        return 1;
    }

}
function sorting($p)
{
    global $countries;
    uasort($countries, $p);
}

//echo check_admin("user", "user");

function update_users($users)
{
    //global $users;
    //$users = get_users();
    $su = serialize($users);
    $file = fopen("db.txt", "w");
    if (fwrite($file, $su)) {
        return true;
    } else {
        return false;
    }
    fclose($file);
}

function get_users()
{
    $fname = "db.txt";
    $file = fopen($fname, "r");
    $users = fread($file, filesize($fname));
    fclose($file);
    return unserialize($users);
}

//update_users();

//print_r(get_users());