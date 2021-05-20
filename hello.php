<?php
ob_start();
include "header.php";
include_once "action.php";
$b = false;
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    if (check_admin($login)) {
        $b = true;
        echo "<h3>Привет,  $login!</h3>";
        echo "<p>Сводка погоды для всех стран на сегодня:<br/> холодно, снег</p>";
        echo "<a href='$home'>home</a>";
        include "footer.php";
    }

}
if (!$b) {
    header("Location: index.php");
    ob_end_flush();
}