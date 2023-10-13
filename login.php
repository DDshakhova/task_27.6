<?php

include ('vendor/autoload.php');
include_once ('logger.php');
require_once ('DBconnect.php');
require_once ('oauth.php');

session_start();

// Не пускаем авторизованных пользователей
if(isset($_SESSION['auth'])) {
    header("location: index.php");
}

// Авторизация
    if((isset($_POST["login"]))&& (isset($_POST["password"])))
{
    //echo $_POST["token"] . "</br>";
    //echo $_SESSION["CSRF"] . "</br>"; проверка
    if($_POST["token"] == $_SESSION["CSRF"]) 
{
    // Вытаскиваем из БД запись, у которой логин равняется введенному
    $query = pg_query($link,"SELECT user_id, password FROM users1 WHERE login='".pg_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = pg_fetch_assoc($query); 
    // Сравниваем пароли
    if($data['password'] === md5($_POST['password']."MEGASECRET"))
    { 
        $_SESSION['auth'] = true; 
        $_SESSION['role'] = 'notVk'; 
        
        // Переадресовываем 
        header("Location: index.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
        //Логируем неудачную попытку авторизации
        $log->info('Неудачная попытка входа пользователем, который представился как' . ' ' . $_POST['login']);
    }
}
else {
    //////Проблема с токеном
    print 'Are u trying to hack me?';
  
}
$token = hash('gost-crypto', random_int(0,999999));
$_SESSION["CSRF"] = $token;
}

$token = $_SESSION["CSRF"];
?>

<!-- Форма авторизации -->
<form method="post" action="">
<input type="text" name="login" placeholder="Логин"><br/>
<input type="password" name="password"> <br/>
<input type="hidden" name="token" value="<?=$token?>"> <br/>
<input type="submit" value="Войти">
</form>
<p>Ещё нет аккаунта? <a href="/signin.php">Зарегистрироваться</a></p>

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







   
