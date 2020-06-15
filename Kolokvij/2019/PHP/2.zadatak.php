<?php
  $user ='student';
  $pass='pass.mysql';

  try {
    $db=new PDO('mysql:host=rp2.studenti.math.hr;dbname=kolokvij;charset=utf8', $user, $pass);
  } 
  catch (PDOException $e) {
    echo "Greška: ".$e->getMessage(); exit();
  }

  $st = $db->query('SELECT id,utrka,trenutak,vozac FROM formula');
    $st1 = $db->query('SELECT id,utrka,trenutak,vozac FROM formula');
      $st2 = $db->query('SELECT id,utrka,trenutak,vozac FROM formula');
      $st3 = $db->query('SELECT id,utrka,trenutak,vozac FROM formula');

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Utrke</title>
  </head>
  <body>
    <form action="2.zadatak.php" method="post">
      Odaberi utrku koja te zanima i neke vozače koji su sudjelovali u toj utrci:
      <br>
      <?php
      $poljeUtrka=array();
      $poljeVozaca1=array();
            $poljeVozaca2=array();
                  $poljeVozaca3=array();
          foreach($st->fetchAll() as $row)
          {
            if (!(in_array($row['utrka'], $poljeUtrka)))
              {
                array_push($poljeUtrka, $row['utrka']);
                echo '<input type="radio" name="'.$row['id'].'" value="'.$row['utrka'].'"/>'. $row['utrka'];
                foreach($st1->fetchAll() as $row)
                {
                  if (!(in_array($row['vozac'], $poljeVozaca1)))
                  {
                    array_push($poljeVozaca1, $row['vozac']);
                    echo '<input type="checkbox" name="'.$row['vozac'].'" value="'.$row['vozac'].'" />'." ".$row['vozac'];
                  }
                }
                  $br=1;
                  if($br=2)
                  {
                    foreach($st2->fetchAll() as $row)
                  {
                    if (!(in_array($row['vozac'], $poljeVozaca2)))
                    {
                      array_push($poljeVozaca2, $row['vozac']);
                      echo '<input type="checkbox" name="'.$row['vozac'].'" value="'.$row['vozac'].'" />'." ".$row['vozac'];
                    }}}

                    $br=2;
                    if($br=3)
                    {
                      foreach($st3->fetchAll() as $row)
                    {
                      if (!(in_array($row['vozac'], $poljeVozaca2)))
                      {
                        array_push($poljeVozaca2, $row['vozac']);
                        echo '<input type="checkbox" name="'.$row['vozac'].'" value="'.$row['vozac'].'" />'." ".$row['vozac'];
                      }}
                      $br=3;

                   }
              echo '<br>';
          }
        }

        ?>
      <br />
      <button type="submit" name="odaberi">Odaberi utrku!</button>
    </form>
  </body>
</html>
