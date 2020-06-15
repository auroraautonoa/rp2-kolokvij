<?php

require_once 'db.class.php';

if ( isset( $_POST['polazni_grad']) && isset( $_POST['ciljni_grad']) )
{
    $polazni = $_POST['polazni_grad'];
    $ciljni = $_POST['ciljni_grad'];
}

function prikazi($polazni, $ciljni){
try
{
    $db = DB::getConnection();    
    $st = $db->prepare( 'SELECT * FROM avioni WHERE start_mjesto=:start_mjesto AND cilj_mjesto=:cilj_mjesto ORDER BY cijena ASC' );
    $st->execute( array('start_mjesto' => $polazni,
    'cilj_mjesto' => $ciljni ));
}
catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }


//------------------------------------------------------
$niz1 = array();
$niz2 = array();
try
{
    $db = DB::getConnection();    
    $st1 = $db->prepare( 'SELECT cilj_mjesto FROM avioni WHERE start_mjesto=:start_mjesto' );
    $st1->execute( ['start_mjesto' => $polazni]);
}
catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

while ($row = $st1->fetch() ) 
    $niz1[] = $row['cilj_mjesto'];

try
{
        $db = DB::getConnection();    
        $st2 = $db->prepare( 'SELECT start_mjesto FROM avioni WHERE cilj_mjesto=:cilj_mjesto' );
        $st2->execute( ['cilj_mjesto' => $ciljni]);
}
catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
while ($row = $st2->fetch() ) 
    $niz2[] = $row['start_mjesto'];

$result = array_intersect($niz1, $niz2);

echo "<pre>";
print_r($niz1);
echo "</pre>";
echo "<pre>";
print_r($niz2);
echo "</pre>";
echo "<pre>";
print_r($result);
echo "</pre>";



echo 'Između ' .$polazni. ' i ' .$ciljni. ' dostupni su sljedeći letovi: ';
echo '<br>';
echo '<br>';

echo '<table style="border-collapse:collapse">';
    while ($row=$st->fetch())
    {
        echo '<tr>';
        echo '<td>';
        echo $row['start_mjesto'];
        echo ' polazak u ';
        echo  $row['start_vrijeme'];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo $row['cilj_mjesto'];
        echo ' polazak u ';
        echo  $row['cilj_vrijeme'];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo ' Cijena  ';
        echo  $row['cijena'];
        echo '</td>';
        echo '</tr>';
    }
echo '</table>';
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        tr:nth-child(3) {
            border-bottom:1pt solid black;
        }
        </style>
</head>
<body>
    <?php 
    prikazi($polazni, $ciljni);
    ?>
</body>
</html>