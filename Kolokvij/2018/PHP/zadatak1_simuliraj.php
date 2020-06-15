<?php
    session_start();

?>

<!DOCTYPE html>

<?php
    // Apstraktna natklasa Container klasa Stack i Queue
    abstract class Container
    {
        protected $data;
        protected $type;

        public function __construct ()
        {
            $this->data = array();
            $this->type = 'container';
        }

        abstract public function push ($x);

        abstract public function pop ();

        public function __get ($var)
        {
            return $this->$var;
        }
    };

    // Stack
    class Stack extends Container
    {
        public function __construct ()
        {
            $this->data = array();
            $this->type = 'stack';
        }

        public function push ($x)
        {
            array_push($this->data, $x);
        }

        // Pop-anje s kraja
        public function pop ()
        {
            if (count($this->data) === 0)
                return Null;

            return array_pop($this->data);
        }
    };

    // Queue
    class Queue extends Container
    {
        public function __construct ()
        {
            $this->data = array();
            $this->type = 'queue';
        }

        public function push ($x)
        {
            array_push($this->data, $x);
        }

        // Pop-anje s pocetka
        public function pop ()
        {
            if (count($this->data) === 0)
                return Null;

            $x = $this->data[0];
            $aux = array();

            for ($i = 1; $i < count($this->data); ++$i)
                array_push($aux, $this->data[$i]);

            $this->data = $aux;

            return $x;
        }
    };

?>

<html lang="hr">
    <head>
        <meta charset="utf-8" />

        <title>Zadatak 1</title>

        <meta name="description" content="Zadatak 1" />
        <meta name="developer" content="Dora Parmać" />

        <link rel="stylesheet" href="style.css" />
    </head>
    
    <?php
        $errmsg = '';

        // Ako tip jos nije odabran, deducira se iz _POST-a
        if (!array_key_exists('tip', $_SESSION))
        {
            if (array_key_exists('tip', $_POST))
            {
                if (!strcmp($_POST['tip'], 'stack'))
                    $_SESSION['tip'] = new Stack();
                else if (!strcmp($_POST['tip'], 'queue'))
                    $_SESSION['tip'] = new Queue();
                else
                    $errmsg = $errmsg . '<p>Nije zadan tip.</p>';
            }
            else
                $errmsg = $errmsg . '<p>Nije zadan tip.</p>';
        }

        // Ako je tip dobro odabran...
        if (!strcmp($errmsg, ''))
        {
            // ... is _POST-a se deducira komanda
            if (array_key_exists('operacija', $_POST) &&
                array_key_exists('vrijednost', $_POST))
            {
                if (!(strcmp($_SESSION['tip']->type, 'stack') || strcmp($_POST['operacija'], 'PUSH')) ||  // ubacivanje u STACK
                    !(strcmp($_SESSION['tip']->type, 'queue') || strcmp($_POST['operacija'], 'ENQUEUE'))) // ubacivanje u QUEUE
                {
                    if (preg_match('/^-?[0-9]+$/', $_POST['vrijednost']) === 1)
                        $_SESSION['tip']->push((int)$_POST['vrijednost']);
                    else
                        $errmsg = $errmsg . '<p>Nije zadana valjana cjelobrojna vrijednost.</p>';
                }
                else if (!(strcmp($_SESSION['tip']->type, 'stack') || strcmp($_POST['operacija'], 'POP')) ||   // brisanje iz STACK-a
                         !(strcmp($_SESSION['tip']->type, 'queue') || strcmp($_POST['operacija'], 'DEQUEUE'))) // brisanje iz QUEUE-a
                    $_SESSION['tip']->pop();
                else
                    $errmsg = $errmsg . '<p>Nije zadana valjana operacija.</p>';
            }
        }

    ?>

    <body>
        <header>
            <?php
                // Ispis odgovarajućeg naslova
                if (strcmp($errmsg, ''))
                    echo "<h1 class=\"maintitle\">Greška</h1>\n";
                else if ($_SESSION['tip']->type === 'stack')
                    echo "<h1 class=\"maintitle\">Simulacija STACK-a</h1>\n";
                else if ($_SESSION['tip']->type === 'queue')
                    echo "<h1 class=\"maintitle\">Simulacija QUEUE-a</h1>\n";

            ?>
        </header>

        <section>
            <?php
                // Ispis greške ili sadžaja odabarnog tipa i forme za komandu nad odabranim tipom
                if (strcmp($errmsg, ''))
                    echo $errmsg;
                else
                {
                    // Sadržaj
                    if (count($_SESSION['tip']->data) === 0)
                    {
                        if (!strcmp($_SESSION['tip']->type, 'stack'))
                            echo "<p>STACK je trenutno prazan.</p>\n";
                        else if (!strcmp($_SESSION['tip']->type, 'queue'))
                            echo "<p>QUEUE je trenutno prazan.</p>\n";
                    }
                    else
                    {
                        echo "<table class=\"container\">\n<tbody>\n<tr>\n";
                        for ($i = 0; $i < count($_SESSION['tip']->data); ++$i)
                            echo "<td class=\"" . $_SESSION['tip']->type . "\">" . $_SESSION['tip']->data[$i] . "</td>\n";
                        echo "</tr>\n</tbody>\n</table>\n";
                    }

                    // Forma
                    echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
                    echo "<table class=\"menu\">\n<tbody>\n";
                    echo "<tr>\n";
                    echo "<td><label for=\"operacija\">Unesi ime operacije:</label></td>\n";
                    echo "<td><input type=\"text\" id=\"operacija\" name=\"operacija\" value=\"\" /></td>\n";
                    echo "<td colspan=\"2\"><button type=\"submit\">Izvrši!</button></td>\n";
                    echo "</tr>\n";
                    echo "<tr>\n";
                    echo "<td><label for=\"vrijednost\">Unesi broj koji se stavlja:</label></td>\n";
                    echo "<td><input type=\"text\" id=\"vrijednost\" name=\"vrijednost\" value=\"\" /></td>\n";
                    echo "</tr>\n";
                    echo "</tbody>\n</table>\n";
                    
                    echo "</form>\n";
                }
                    
            ?>
        </section>

        <footer>
        </footer>
    </body>
</html>
