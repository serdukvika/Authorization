<?php
include_once "action.php";
include "header.php";

if (isset($_POST['go'])) {
    $login = $_POST['login'];
    $password = $_POST['pass'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['pass'];
    if (add_user($login, $password)) {
        echo "Приветствуем, $login";

    } else {
        echo "Такой пользователь уже есть!";
    }
}
if (!isset($_SESSION['authorized'])) {
    $str_form = "<span id='massage'></span>
			<form  name='autoForm' action='" . $_SERVER['PHP_SELF'] . "' method='post' onSubmit='return overify_login(this);' >
 			 Логин: <input type='text' name='login'>
 			 Пароль: <input type='password' name='pass'>
 			 <input type='submit' name='go' value='Подтвердить'>
 		     </form>";
    echo $str_form;
} else {
    echo "Вы зарегистрированы как {$_SESSION['login']}";
    echo '<a href="logout.php">logout</a>';
}

include "footer.php";