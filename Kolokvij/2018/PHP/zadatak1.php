<?php session_start(); ?>

<!DOCTYPE html>
<?php session_unset(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zadatak 1</title>
</head>
<body>
    <h1> Zadatak 1 </h1>

    <form action="zadatak1_simuliraj.php" method="post">
    <label for="cars">Odaberi strukturu koju ćemo simulirati: </label>
    <select name="tip" id="tip">
        <option value="stack">STACK</option>
        <option value="queque">QUEQUE</option>
    </select>
    <button> Simuliraj! </button>
    </form>
</body>
</html>