<?php

require_once 'db.class.php';

function ispisi_parove(){
    $db = DB::getConnection();
    $st = $db->prepare('SELECT *  FROM tenis');
    $st->execute();


    $niz = [];
    $i = 0;
    $iznos = $_POST['iznos'];


    while ($row = $st->fetch() ) {
        //igrac1, igrac2, koef1, koef2
        $niz[$i] = [$row[1], $row[2], $row[3], $row[4]];
        $i++;
    }

    if (isset($_POST['chb'])) {
        $niz_koef = $_POST['chb'];
        for ( $j = 0; $j < count($niz); $j++){
            for ( $i = 0; $i < count($niz_koef); $i++){
                echo '<table>';
                if ( $niz_koef[$i] ==  $niz[$j][2] ){
                    $iznos *= $niz[$j][2];
                    echo '<tr><td>';
                    echo '('.$niz[$j][2].') ';
                    echo '<label>'.$niz[$j][0].'</label>';
                    echo '</td><td>';
                    echo '('.$niz[$j][3].') ';
                    echo $niz[$j][1];
                    echo '</td></tr>';
                }
                else if ( $niz_koef[$i] ==  $niz[$j][3] ) {
                    $iznos *= $niz[$j][3];
                    echo '<tr><td>';
                    echo '('.$niz[$j][2].') ';
                    echo $niz[$j][0];
                    echo '</td><td>';
                    echo '('.$niz[$j][3].') ';
                    echo '<label>'.$niz[$j][1].'</label>';
                    echo '</td></tr>';
                }
                echo '</table>';
            }
        }
    }

    echo '<br>';
    echo 'Moguće je osvojiti: '.$iznos.' kuna';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        label {color:red;}
        td {border:1px solid black; width: 150px;}
        th {border: hidden; border-bottom: 1px solid black;}
        table {border: 1px solid black; border-collapse: collapse; width: 300px; text-align: center;}
    </style>
</head>
<body>
    <?php ispisi_parove(); ?>
</body>
</html>

    



