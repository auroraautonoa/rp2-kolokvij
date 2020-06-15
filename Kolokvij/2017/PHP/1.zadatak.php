<?php
session_start();

if ( !isset($_SESSION['broj_redova'] ) ) {
    $_SESSION['broj_redova'] = 1; 
    $_SESSION['broj_kocki']=array();
    array_push($_SESSION['broj_kocki'],"10");
}


if ( isset ($_POST['napravi'] ) ) {
    if ( isset ($_POST['izbor'] ) ) {

        $izbor = $_POST['izbor'];

        if ($izbor === "dodaj_kocku") {
            $broj_kocaka = $_POST ['broj_kocaka_za_dodat'];
            $broj_reda = $_POST ['odabrani_red_za_dodat_kocku'];

                $_SESSION['broj_kocki'][$broj_reda] += $broj_kocaka;
        }


        else if ($izbor === "ukloni_kocku") {
            $broj_kocaka = $_POST ['broj_kocaka_za_uklonit'];
            $broj_reda = $_POST ['odabrani_red_za_brisat_kocku'];

            if( $_SESSION['broj_kocki'][$broj_reda] < $broj_kocaka ) {
                $_SESSION['broj_kocki'][$broj_reda] = 0;
            }
            else 
                $_SESSION['broj_kocki'][$broj_reda] -= $broj_kocaka;
        }

        else {
            ++$_SESSION['broj_redova'];
            array_push($_SESSION['broj_kocki'],10);

        }
    }

}




function crtaj_tablicu() {
    echo '<table>';
    for ($i = 0; $i < $_SESSION['broj_redova']; ++$i) {
        echo '<tr>';
            for ($j = 0; $j < $_SESSION['broj_kocki'][$i]; $j++){
                echo '<td>';
                echo 'X';
                echo '</td>';
            }
        echo '</tr>';
    }
    echo '</table>';
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kockice</title>
    <style>
        tr, td {
             border: 1px solid black; width: 60px; height: 30px; text-align: center;
        }
        </style>
</head>
<body>
    <form action="1.zadatak.php" method="post">
        <div name="tablica">
            <?php crtaj_tablicu(); ?>
        </div>
        
        <input type="radio" name="izbor" value="dodaj_kocku" id="dodaj">
        Dodaj 
        <input type="text" name="broj_kocaka_za_dodat" id="broj_kocaka">
        kocaka u red broj
        <select name = "odabrani_red_za_dodat_kocku">
            <?php
                for ($i = 0; $i < $_SESSION['broj_redova']; $i++)
                {
                    $j = $i + 1;
                    echo '<option value='.$i.'>'.$j.'</option>';
                }
            ?>
        </select>

        <br> <br>

        <input type="radio" name="izbor" value="ukloni_kocku">
        Ukloni 
        <input type="text" name="broj_kocaka_za_uklonit" id="broj_kocaka">
        kocaka iz reda broj
        <select name = "odabrani_red_za_brisat_kocku">
            <?php
                for ($i = 0; $i < $_SESSION['broj_redova']; $i++)
                {
                    $j = $i + 1;
                    echo '<option value='.$i.'>'.$j.'</option>';
                }
            ?>
        </select>

        <br> <br>

        <input type="radio" name="izbor" value="dodaj_novi_red" id="dodaj"> Dodaj novi red!
        <br>
        <button type="submit" name="napravi">Napravi!</button>
        <button type="submit" name = "kraj">Kraj igre!</button>
        <?php 
            if ( isset($_POST['kraj']))
            {
                session_unset();
                session_destroy();
            }
        ?>

    </form>
</body>
</html>

