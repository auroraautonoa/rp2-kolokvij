<?php

require_once 'db.class.php';


function svi_letovi()
{
    $db = DB::getConnection();
    $st = $db->prepare('SELECT DISTINCT start_mjesto FROM avioni');
    $st->execute();

    $st1 = $db->prepare('SELECT DISTINCT cilj_mjesto FROM avioni');
    $st1->execute();

    $niz = array();
    $niz1 = array();


    while ($row = $st->fetch() ) 
        $niz[] = $row['start_mjesto'];

    while ($row1 = $st1->fetch() ) 
        $niz1[] = $row1['cilj_mjesto'];

    for ($i = 0; $i < count($niz); $i++){
        echo $niz[$i];
        echo ', ';
    }

    $result = array_diff($niz1, $niz);

    for ($j = 0; $j < count($result); $j++){
        echo $result[$j];
        echo ', ';
    }

    echo "<pre>";
print_r($niz);
echo "</pre>";
echo "<pre>";
print_r($niz1);
echo "</pre>";
echo "<pre>";
print_r($result);
echo "</pre>";
    

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    Dostupni su letovi u sljedeće gradove:
    <?php svi_letovi(); ?>

    <form action="2.zadatak_trazi.php" method="post">
    <br>
    Polazni grad: <input type="text" name="polazni_grad" id="polazni_grad">
    <br>
    Ciljni grad: <input type="text" name="ciljni_grad" id="ciljni_grad">
    <br>
    <button type="submit">Nađi putovanja!</button>
    </form>

    
</body>
</html>