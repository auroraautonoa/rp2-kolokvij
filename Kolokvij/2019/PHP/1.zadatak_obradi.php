<?php 

session_start(); 

class Stol {

    protected $br_jela,$imena_jela,$cijene_jela;
    function __construct()
    {
        $this->br_jela=0;
        $this->imena_jela=array();
        $this->cijene_jela=array();
    }
    
    public function dodaj_jelo($ime,$cijena)
    {
        $this->imena_jela[$this->br_jela]=$ime;
        $this->cijene_jela[$this->br_jela]=$cijena;
        $this->br_jela++;
    }
    
    public function broj_stola(){
        return $this->br_jela;
    }
    
    public function ime_jela($k){
        return $this->imena_jela[$k];
    }
    
    public function cijena_jela($k){
        return $this->cijene_jela[$k];
    }
};

// STOLOVI

if ( !isset($_SESSION['broj_stolova'] ) ) {

    if ( isset($_POST['broj_stolova'])) {
        $_SESSION['broj_stolova'] = $_POST['broj_stolova'];
        $broj_stolova = $_SESSION['broj_stolova']; }
    else
        $_SESSION['broj_stolova'] = 0;
        
    for ( $i=0; $i < $broj_stolova; $i++ ) {
        $_SESSION['stol'][$i] =	new Stol();
        $stol[$i] = $_SESSION['stol'][$i];      
    }

}
$broj_stolova= $_SESSION['broj_stolova'];
for ( $i=0; $i < $broj_stolova; $i++){
  $stol[$i]=$_SESSION['stol'][$i];
}
$_SESSION['stol'][$i]=	new Stol();



// JELO
if( isset($_POST['dodaj_stolu']) && isset($_POST['jelo']) && isset($_POST['cijena'])){

    if (preg_match('/^[0-9]+$/', $_POST['cijena']) && preg_match('/^[a-zA-Z\s]+$/', $_POST['jelo'])) {
  
            if($_POST['jelo'] != 'PLATI') 
              $_SESSION['stol'][$_POST['dodaj_stolu']]->dodaj_jelo($_POST['jelo'],$_POST['cijena']);
            
            else {
              $_SESSION['stol'][$_POST['dodaj_stolu']] = new Stol();
            }
    }  
}

// ZARADA

if ( !isset($_SESSION['trenutna_zarada'] ) ) 
    $_SESSION['trenutna_zarada'] = 0;

if ( isset($_POST['cijena'] ) ) 
    $_SESSION['trenutna_zarada']  += $_POST['cijena'];
    $trenutna_zarada = $_SESSION['trenutna_zarada'];




// PONISTI SESIJU

if ( isset($_POST['ponisti'] ) ) {
    session_unset();
    session_destroy();
    header('Location: 1.zadatak.php');
	exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restoran</title>
    <style> 
        tr, td {
             border: 1px solid black; width: 90px; height: 30px; text-align: center;
        }
    </style>
</head>
<body>
    
</body>
</html>
    <form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">

        <h1>Restoran: ukupna zarada <?php echo $trenutna_zarada; ?> </h1>

        <table>
                <?php
                echo '<tr>'; 
                for ($i = 0; $i < $broj_stolova; $i++) {
                    $j = $i + 1;
                    echo '<th>';
                    echo 'Stol ' .$j;  
                    echo '</th>'; }
                echo '</tr>';

                echo '<tr>';
                for ($i = 0; $i < $broj_stolova; $i++) {
                    echo '<td>';
                    for( $k=0; $k < $stol[$i]->broj_stola(); $k++ ) {
                            echo $stol[$i]->ime_jela($k);
                            echo " -- ";
                            echo $stol[$i]->cijena_jela($k);
                            echo"<br>"; 
                        }
                    echo '</td>';
                }
                echo '</tr>';
                ?>
            
        </table>

        <br>

        Koji stol:
        <select style="width:50px;" name = "dodaj_stolu"> 
            <?php
                for ($i = 0; $i < $broj_stolova; $i++) {
                    $j = $i + 1;
                    echo "<option value='$i'>$j</option>'"; }
            ?>
        </select>

        <br> <br>
        Jelo (ili plati):
        <input type="text" name="jelo"> </input>

        Cijena:
        <input type="text" name="cijena"> </input>

        <br> <br>
        <button type="submit" name = "posalji">Pošalji</button>
        &nbsp
        <button type="submit" name = "ponisti">Poništi sesiju</button>

    </form>
<?php


/*if ( $_POST['ponisti']) {
    session_unset();
    session_destroy();
    header('Location: 1.zadatak.php'); 
}*/


?>