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

            if( isset( $_POST['nova_rijec'] ) && isset( $_POST['boja'] ) ) {
                if( ctype_alpha($_POST['nova_rijec'] ) )
                    {
                        array_push($_SESSION['rijeci'], $_POST['nova_rijec']);
                        array_push($_SESSION['boje'], $_POST['boja']);
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
                    echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i] . ' </span>';
                }

                else if ( strlen($_SESSION['boje'][$i]) === strlen($_SESSION['rijeci'][$i]) ){
                    $q='#c0c0c0';
                    
                    for ($j = 0; $j < strlen($_SESSION['rijeci'][$i]); $j++) { 
                        echo'<span style="background-color:' . $q . '">' . $_SESSION['rijeci'][$i][1] . ' </span>';
                    }
                }
            }
           
            ?>
    <form action="1.zadatak.php" method="post">

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