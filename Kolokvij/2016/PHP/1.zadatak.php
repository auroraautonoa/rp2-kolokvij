<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nove boje</title>
</head>
<body>
            <?php

            session_start();

            if( !isset($_SESSION['rijeci'] ) ) {
                $_SESSION['rijeci'] = array();
                $_SESSION['boje'] = array();
            }

            if( isset( $_POST['nova_rijec'] ) ) {
                if ( isset( $_POST['boja'] ) )  {
                    if( ctype_alpha($_POST['nova_rijec'] ) ) {
                            array_push($_SESSION['rijeci'], $_POST['nova_rijec']);
                            array_push($_SESSION['boje'], $_POST['boja']);
                        }
                }
            

                if ( $_POST['nova_rijec'] === "KRAJ") {
                    echo '<span>Unesite naziv priče: </span>';
                    echo '<form method="post"><input type="text" name="naslov"></input>';
                    echo '<br>';
                    echo '<button type="submit">Unesi naslov</button>';
                    echo '</form>';
                }
            }
            if ( isset ($_POST['naslov'] ) ) {

                if (!preg_match("/^[A-Za-z\s]+$/",$_POST['naslov'])){
                    echo '<span>Niste unijeli dobar naziv. </span>';
                    echo '<br>';
                    echo '<span>Unesite naziv priče: </span>';
                    echo '<form method="post"><input type="text" name="naslov"></input>';
                    echo '<br>';
                    echo '<button type="submit">Unesi naslov</button>';
                    echo '</form>';
                    echo '<br>';
                }
                else  {
                    echo 'Naslov: ';
                    echo $_POST['naslov'];
                    echo '<br>';
                    echo '<br>';
                }

            }
            

            for( $i=0; $i < count($_SESSION['rijeci'] ); $i++) {

                if( strlen($_SESSION['boje'][$i]) === 1) {

                    if( ($_SESSION['boje'][$i] )==="R") 
                        $q="#FF0000";
                    elseif (($_SESSION['boje'][$i])==='G') 
                        $q="#008000";
                    elseif(($_SESSION['boje'][$i])==='B') 
                        $q="#176171";
                    elseif(($_SESSION['boje'][$i])==='Y') 
                        $q="#fffb53";
                    else 
                        $q='#FFFFFF';
                    echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i] . '</span>';
                    echo ' ';
                }

                else if ( strlen($_SESSION['boje'][$i]) === strlen($_SESSION['rijeci'][$i]) ){
                    
                    for ($j = 0; $j < strlen($_SESSION['boje'][$i]); $j++) { 
                        if ( $_SESSION['boje'][$i][$j] === 'R') {
                            $q="#FF0000";
                            echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][$j] . '</span>';
                        }
                        elseif (  $_SESSION['boje'][$i][$j] === 'G' ){
                            $q="#008000";
                            echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][$j] . '</span>';
                        }
                        elseif (  $_SESSION['boje'][$i][$j] === 'B' ){
                            $q="#176171";
                            echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][$j] . '</span>';
                        }
                        elseif (  $_SESSION['boje'][$i][$j] === 'Y' ){
                            $q="#fffb53";
                            echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][$j] . '</span>';   
                        }
                        else {
                            $q="#FF0000";
                            echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][$j] . '</span>';
                        }
                
                    }
                    echo ' ';
                }

                else {
                    $q='#FFFFFF';
                    echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i] . ' </span>';
                }

            }
           
            ?>
    <form action="1.zadatak.php" method="post">
<br>
        Unesi novu riječ: <input type="text" name="nova_rijec" id="">
        <br> <br>
        Unesi boju nove riječi: <input type="text" name="boja" id="">
        <br> <br>
        <button type="submit" name="dodaj"> Dodaj novu riječ! </button>
    </form>
</body>
</html>

<?php
//session_unset();
//session_destroy();

?>