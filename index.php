<?php
include_once "action.php";
include "header.php";

if (isset($_POST['go'])) {
    $login = $_POST['login'];
    $password = $_POST['pass'];
    $_SESSION['login'] = $_POST['login'];

    if (check_user($login, $password)) {
        echo "Приветствуем, $login";
        if (check_admin($login)) {
            echo "<a href='hello.php'>Просмотр отчета</a>";
        }
    } else {
        echo "Вы не зарегистрированы!";
    }
}
if (!isset($_SESSION['authorized'])) {
    $str_form = "<span id='massage'></span>
			<form  name='autoForm' action='index.php' method='post' onSubmit='return overify_login(this);' >
 			 Логин: <input type='text' name='login'>
 			 Пароль: <input type='password' name='pass'>
 			 <input type='submit' name='go' value='Подтвердить'>
 		     </form>";
    echo $str_form;
} else {
    echo '<a href="logout.php">logout</a>';
}
$str_form_s = '<h3>Сортировать по:</h3>
<form action="index.php" name="myform" method="post">
 <select name="sort" size="1">
   <option value="name">Названию</option>
   <option value="area">Площади</option>
   <option value="population">Среднему населению</option>
 </select>
 <input name="Submit" type=submit value="Подтвердить">
</form>';
echo $str_form_s;
if (isset($_POST["sort"])) {
    sorting($_POST["sort"]);
}
$out = out_arr();
if (count($out) > 0) {
    foreach ($out as $row) {
        echo $row;
    }
}

include "footer.php";