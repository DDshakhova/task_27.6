<?php  session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Галерея изображений</title>
</head>
<body>
<header class="header">
        <div class="links">
<?php 

if($_SESSION['auth'] == false){
    
    echo '
    <a href="/login.php">Вход</a>
    <a href="/signin.php"> Регистрация</a>'; 
 } else {
    echo '<a href="logout.php"> Выход</a>';
    echo '<a href="loggedonly.php"> Секрет</a>';
   
 }?>
        <a href="/home">Главная</a>
        </div>
</header> 
<main class="main">
<div class="container pt-4">

 
</div>
</main>
</body>
</html>



 