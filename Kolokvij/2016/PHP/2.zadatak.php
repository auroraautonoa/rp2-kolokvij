<?php

require_once 'db.class.php';

function ispisi_igrace(){
        
    $db = DB::getConnection();
    $st = $db->prepare('SELECT *  FROM tenis');
    $st->execute();


    $niz = [];
    $i = 0;

    while ($row = $st->fetch() ) {
        $niz[$i] = [$row[1], $row[2], $row[3], $row[4]];
        $i++;
    }

    echo '<table><tr><th>Prvi igrač</th><th>Drugi igrač</th></tr>';
    for ($i = 0; $i < count($niz); $i++){
        echo '<tr><td>';
        echo '('.$niz[$i][2].') ';
        echo $niz[$i][0];
        echo '<input type="checkbox" name="chb[]" value="'.$niz[$i][2].'"></input>';
        echo '</td>';

        echo '<td>';
        echo '('.$niz[$i][3].') ';
        echo $niz[$i][1];
        echo '<input type="checkbox"  name="chb[]" value="'.$niz[$i][3].'"></input>';
        echo '</td></tr>';
    }
    echo '</table>';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenis</title>
    <style>
        tr, td {border: 1px solid black; width: 100px;}

        th {border: hidden; border-bottom: 1px solid black;}

        table {border-collapse: collapse; width: 300px; text-align: center;}
    </style>
</head>
<body>
    <form action="2.zadatak_izracunaj.php" method="post">
        <?php ispisi_igrace(); ?>
        <br><br>
        
        Unesi uloženi iznos:
        <input type="text" name="iznos"> </input> &nbsp &nbsp
        <button type="submit">Izračunaj!</button>
    </form>    
</body>
</html>