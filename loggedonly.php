<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<header class="header">
        <div class="links">
<a href="logout.php">Выход</a>
<a href="/home">Главная</a>
        </div>
</header> 
<main class="main">
<div class="container pt-4">

<?php 

session_start();

if($_SESSION['auth'] == false) {
    header("location: login.php");
}


else {

    echo '<p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>';

}

if ($_SESSION['role'] == 'Vk') { 

    echo '<img src="images/4d0851a26cdfb7cb575b7e5e8ebd4040.webp">';

}
/// тут был else, но мне захотелось и тут роль спросить
if ($_SESSION['role'] == 'notVk') {
    echo '<p>Вы зашли не через ВК, поэтому картинка спрятана</p>';
}

?>
 
</div>
</main>
</body>
</html>