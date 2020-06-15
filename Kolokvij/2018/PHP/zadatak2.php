<?php session_start(); ?>

<!DOCTYPE html>

<?php
    if (!array_key_exists('stanica', $_SESSION))
        $_SESSION['stanica'] = 'Notting Hill Gate';

    // Otvaranje BP
    try 
    {
        $db = new PDO('mysql:host=rp2.studenti.math.hr;dbname=kolokvij;charset=utf8', '', '');
    } 
    catch(PDOException $e) 
    {
        echo "Greška pri otvaranju baze: " . $e->getMessage();
        exit();
    }

    if (array_key_exists('smjer', $_POST) && array_key_exists('broj', $_POST))
    {
        //FILTER_SANITIZE_NUMBER_INT -> mice sve nepotrebne znakove iz unosa broja, ostavlja npr + i -

        $n = (int)filter_var($_POST['broj'], FILTER_SANITIZE_NUMBER_INT);

        // Dedukcija smjera
        // explode pretvori string u array, 'delimiter'. prva rijec se dohvaca pomocu npr smjer_data[0]
        // strcmp je usporedba stringova
        
        $smjer_data = explode('_', $_POST['smjer']);
        if (!strcmp($smjer_data[1], '0'))
            $n = -$n;

        $st = $db->query("SELECT ime_stanice,broj_stanice WHERE linija LIKE '" . $smjer_data[0] . "'");

        // Trazenje stanice udaljene za n po odgovarajucoj liniji na dosta primitivan i spor nacin
        $r = -1;
        foreach ($st->fetchall() as $s)
        {
            if (!strcmp($s['ime_stanice'], $_SESSION['stanica']))
            {
                $r = (int)$s['broj_stanice'];
                break;
            }
        }
        $min = $r;
        $min_st = $_SESSION['stanica'];
        $max = $r;
        $max_st = $_SESSION['stanica'];
        $r = $r + $n;
        foreach ($st->fetchall() as $s)
        {
            if ((int)$s['broj_stanice'] === $r)
            {
                $_SESSION['stanica'] = $s['ime_stanice'];
                break;
            }
            if ((int)$s['broj_stanice'] < $min)
            {
                $min = (int)$s['broj_stanice'];
                $min_st = $s['ime_stanice'];
            }
            if ((int)$s['broj_stanice'] > $max)
            {
                $max = (int)$s['broj_stanice'];
                $max_st = $s['ime_stanice'];
            }
        }
        // Ako stanica trazenog indeksa na zadanoj liniji ne postoji, uzima se jedna od zavrsnih stanica linije
        if ($r < $min)
            $_SESSION['stanica'] = $min_st;
        if ($r > $max)
            $_SESSION['stanica'] = $max_st;
    }

    // Dohvacanje linija kroz stanicu
    $linije = $db->query("SELECT linija FROM metro WHERE ime_stanice LIKE '" . $_SESSION['stanica'] . "'");

?>

<html lang="hr">
    <head>
        <meta charset="utf-8" />

        <title>Zadatak 2</title>

        <meta name="description" content="Zadatak 2" />
        <meta name="developer" content="Davor Penzar" />
    </head>

    <body>
        <header>
            <h1 class="maintitle">Zadatak 2</h1>
        </header>

        <section>
            <h2>Mirko se nalazi na stanici <?php echo $_SESSION['stanica']; ?></h2>
            
            <p>
                Ovom stanicom prolaze linije:
                <?php
                    // Ispis svih linija
                    foreach($linije->fetchall() as $l)
                        echo $l['linija'] . "\n";

                ?>
            </p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <p>
                    Odaberi željeni smjer:<br>
                    <?php
                        // Prolaz po svim linijama
                        foreach ($linije->fetchall() as $l)
                        {
                            $stanice = $db->query("SELECT broj_stanice,ime_stanice FROM metro WHERE linija LIKE '" . $l['linija'] . "'");

                            $min = 10000;
                            $min_st = '';
                            $max = -1;
                            $max_st = '';

                            // Trazenje stanice s najmanjim i najvecim rednim brojem na trenutnoj liniji
                            foreach ($stanice->fetchall() as $s)
                            {
                                if ((int)$s['broj_stanice'] < $min)
                                {
                                    $min = (int)$s['broj_stanice'];
                                    $min_st = $s['ime_stanice'];
                                }
                                if ((int)$s['broj_stanice'] > $max)
                                {
                                    $max = (int)$s['broj_stanice'];
                                    $max_st = $s['ime_stanice'];
                                }
                            }

                            // na primjer za liniju value="YELLOW_0" oznacava smjer prema prvoj (najmanji r.b.) stanici linije YELLOW, a value="YELLOW_1" oznacava smjer prema zadnjoj (najveci r.b.) stanici linije YELLOW
                            if (strcmp($min_st, $_SESSION['stanica'])) // ako je ovo prva stanica linije, ne ispisujemo ju
                                echo "<input type=\"radio\" id=\"" . $l['linija'] . "_0\" name=\"smjer\" value=\"" . $l['linija'] . "_0\" /><label for=\"" . $l['linija'] . "_0\">" . $min_st . " (" . $l['linija'] . ")<label><br>\n";
                            if (strcmp($max_st, $_SESSION['stanica'])) // ako je ovo zadnja stanica linije, ne ispisujemo ju
                                echo "<input type=\"radio\" id=\"" . $l['linija'] . "_1\" name=\"smjer\" value=\"" . $l['linija'] . "_1\" /><label for=\"" . $l['linija'] . "_1\">" . $max_st . " (" . $l['linija'] . ")<label><br>\n";
                        }

                    ?>
                    <label for="broj">Koliko stanica treba Mirko putovati u odabranom smjeru?</label> <input type="text" id="broj" name="broj" />
                </p>
                <p>
                    <button type="submit">
                        Putuj!
                    </button>
                </p>
            </form>
        </section>

        <footer>
        </footer>
    </body>
</html>
