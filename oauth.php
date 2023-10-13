<?php

session_start();

require_once ('DBconnect.php');

// Параметры приложения
$clientId     = '51764652'; // ID приложения
$clientSecret = 'cHJhSWqWEKZ6CgZQzTQt'; // Защищённый ключ
$redirectUri  = 'http://localhost:3000/oauth.php'; // Адрес, на который будет переадресован пользователь после прохождения авторизации

// Получаем токен
if (isset($_GET['code'])) {
   $params = array(
       'client_id'     => $clientId,
       'client_secret' => $clientSecret,
       'code'          => $_GET['code'],
       'redirect_uri'  => $redirectUri
   );


   if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
       $error = error_get_last();
       throw new Exception('HTTP request failed. Error: ' . $error['message']);
   }

   $response = json_decode($content);

   // Если при получении токена произошла ошибка
   if (isset($response->error)) {
       throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
   }

   //А вот здесь выполняем код, если все прошло хорошо
   $tokenVk = $response->access_token; // Токен
   $expiresIn = $response->expires_in; // Время жизни токена
   $userId = $response->user_id; // ID авторизовавшегося пользователя

   // Сохраняем токен в сессии
   $_SESSION['token'] = $tokenVk;

   
   // Получаем информацию о пользователе ВК
   $params = [
       'uids' => $userId,
       'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
       'access_token' => $tokenVk,
       'v' => '5.154'];

   $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
   if (isset($userInfo['response'][0]['id'])) {
       $userInfo = $userInfo['response'][0];
   // Готовим запись для БД
       $login = $userInfo['screen_name'];
       $password = 'vkauth'; 
       $role = 'Vk';
   //  Вытаскиваем из БД запись, у которой логин равняется vk id    
   $check= pg_query($link, "SELECT * FROM users1 WHERE login='".pg_escape_string ($link, $userInfo['screen_name'])."'");
if(pg_num_rows($check) == 0) // если такой пользователь ещё не заходил, добавляем в БД
{
   pg_query($link,"INSERT INTO users1 (login, password, role) VALUES ('$login', '$password', '$role')");
} 

///////////////////// ПРИКОЛ можно вывести данные профиля ВК на экран ///////////////////////


//    echo "ID пользователя: " . $userInfo['id'] . '<br />';
//   echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
//    echo "Ссылка на профиль: " . $userInfo['screen_name'] . '<br />';
//    echo "День Рождения: " . $userInfo['bdate'] . '<br />';
//    echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
   }
//    else {
//        echo 'no info received';
//   }
 
   
   // Пишем роль и факт входа в сессию
   $_SESSION['auth'] = true; 
   $_SESSION['role'] = 'Vk'; 

   // Переадресовываем браузер 
  header("Location: index.php"); exit();
}