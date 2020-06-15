<?php 
$linije = array( "petica", "dvanajstica", "trojka", "devetka", "sedamnajstica" );

$stanice = array( 
	"petica" => array( "Prečko", "Jarun", "Stud.dom", "Zagrepčanka", "Vukovarska", "Kvatrić" ),
	"dvanajstica" => array( "Remiza", "Cibona", "Frankopanska", "Trg", "Vlaška", "Kvatrić", "Dubrava" ),
	"trojka" => array( "Remiza", "Cibona", "Zagrepčanka", "Vukovarska" ),
	"devetka" => array( "Remiza", "Cibona", "Vodnikova", "Kolodvor", "Zvonimirova", "Borongaj" ),
	"sedamnajstica" => array( "Prečko", "Jarun", "Stud.dom", "Zagrepčanka", "Cibona", "Frankopanska", "Trg", "Zvonimirova", "Borongaj" )
);

$pozicije = array(
	"Prečko" => array( 30, 550 ),
	"Jarun" => array( 100, 550 ),
	"Stud.dom" => array( 160, 550 ),
	"Zagrepčanka" => array( 160, 400 ),
	"Vukovarska" => array( 450, 400 ),
	"Kvatrić" => array( 450, 70 ),
	"Remiza" => array( 80, 320 ),
	"Cibona" => array( 160, 320 ),
	"Frankopanska" => array( 160, 70 ),
	"Trg" => array( 250, 70 ),
	"Vlaška" => array( 350, 70 ),
	"Dubrava" => array( 550, 70 ),
	"Vodnikova" => array( 160, 150 ),
	"Kolodvor" => array( 250, 150 ),
	"Zvonimirova" => array( 300, 150 ),
	"Borongaj" => array( 500, 150 )
);

// ----------------------------------
// Dodajte svoj kod ispod.
// ----------------------------------

if (count($_GET) === 0)
    echo json_encode($linije);
else if (count($_GET) === 1)
{
    if (array_key_exists("L", $_GET))
        if (in_array($_GET["L"], $linije, TRUE))
        {
            $out = array();

            foreach ($stanice[$_GET["L"]] as $s)
                $out[$s] = $pozicije[$s];


			//vraca json interpretaciju niza
			
            echo json_encode($out);
        }
}

?>

