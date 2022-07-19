<!DOCTYPE html>
<html lang="en">
<head>
<?php 
include 'models/mydomain.php';
include 'models/validation.php';
include 'models/myFieldTypes.php';

session_start();
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Domain(s)</title>
</head>
<body>
<div class="wrapper">
<div class="container text-center">
            <h1><?php echo("Register Domain(s)");?></h1>
        </div>
        <form method="post" action="registerdomain.php">
        <input name="token" value="39ba071cce1bfc9bc571653ecd0a3763092302f1" type="hidden">

        </form>
</div>
</body>
</html>