<?php
session_start();



?>

<!DOCTYPE html>
<?php session_destroy();?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restoran</title>
</head>
<body>
    <form action="1.zadatak_obradi.php" method="post">
        Unesite broj stolova u restoranu:
        <input type="text" name="broj_stolova"> </input>
        <button type="submit">Pošalji!</button>    
    </form>
</body>
</html>