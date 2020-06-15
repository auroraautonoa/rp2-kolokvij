<?php
class DB 
{
    // Interna statička varijabla koja čuva konekciju na bazu
    private static $db = null;

    // Zabranimo new DB() i kloniranje;
    final private function __construct() { }
    final private function __clone() { }

    // Statička funkcija za pristup bazi.
    public static function getConnection() 
    {
        // Spoji se samo ako već nisi nekad ranije.
        if( DB::$db === null ) 
        {
            // U glob. varijablama su parametri za spajanje
            global $db_base, $db_user, $db_pass;
            DB::$db = new PDO('mysql:host=rp2.studenti.math.hr;dbname=parmac;charset=utf8','student', 'pass.mysql' );
            //DB::$db = new PDO( "mysql: host=localhost; dbname=parmac; charset=utf8", 'root', ' ' );
            DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            DB::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //prijavljuje greske
        }

        //ako smo vec spojeni nekad
        return DB::$db;
    }
}


?>