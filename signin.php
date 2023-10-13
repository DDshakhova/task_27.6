<?php
// Страница регистрации нового пользователя 
session_start();
require_once ('DBconnect.php');
require_once ('oauth.php');

// Не пускаем авторизованных пользователей
if(isset($_SESSION['auth'])) {
    header("location: index.php");
}

// Регистрация
pg_query($link, "SET NAMES 'utf8'");

if(isset($_POST['submit']))
{
    $err = [];
    // проверяем логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    } 
    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    } 
    // проверяем, не существует ли пользователя с таким именем
    $query = pg_query($link, "SELECT user_id FROM users1 WHERE login='".pg_escape_string ($link, $_POST['login'])."'");
    if(pg_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    } 
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $login = $_POST['login'];
        // хэш+соль
        $password = md5($_POST['password']."MEGASECRET"); 
        $role = 'notVk';
        pg_query($link,"INSERT INTO users1 (login, password, role) VALUES ('$login', '$password', '$role')");
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}

?>

<!-- Форма регистрации -->
<form method="POST">
Логин <input name="login" type="text" required><br>
Пароль <input name="password" type="password" required><br>
<input name="submit" type="submit" value="Зарегистрироваться">
</form>
<p>Уже зарегистрированы? <a href="/login.php">Войти</a></p>

<!-- Под формой -->
<!-- выводим на экран ссылку для открытия окна диалога авторизации через ВК -->
<?php
$params = array(
	'client_id'     => $clientId,
	'redirect_uri'  => $redirectUri,
	'response_type' => 'code',
	'v'             => '5.154', // версия API https://vk.com/dev/versions
 
	// Права доступа приложения https://vk.com/dev/permissions
	// Если указать "offline", полученный access_token будет "вечным" (токен умрёт, если пользователь сменит свой пароль или удалит приложение).
	// Если не указать "offline", то полученный токен будет жить 12 часов.
	'scope'         => 'photos,offline',
);

echo '<a href="https://oauth.vk.com/authorize?' . http_build_query( $params ) . '">Авторизация через ВКонтакте</a>';