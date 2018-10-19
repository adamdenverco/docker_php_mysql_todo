<?php
/*
 * Database Connection Singleton
 * 
 * Singleton method adapted from... 
 * https://stackoverflow.com/questions/203336
 */
class Database {

    /**
     * Call this method to get singleton
     */
    public static function Instance()
    {
        // until $connection is null until it is set for the first time
        static $connection = null;

        // so if $connection is null, then lets set it
        if ($connection === null) {

            try {

                // we connect to the database via the constants loaded at the start
                $connection = new PDO(
                    'mysql:host='. MY_DATABASE_HOSTNAME .';dbname='. MY_DATABASE_DATABASE .';charset=utf8', 
                    MY_DATABASE_USERNAME, // username
                    MY_DATABASE_PASSWORD // password
                );
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            } catch (PDOException $e) {
                $dbOutput = [
                    'status' => 'error',
                    'message' => 'Unable to connect to the database server: ' . 
                        $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()
                ];
                Logging::writeToFile( json_encode($dbOutput) );
            }

        }

        // send the singleton version of the connection back
        return $connection;
    }

    /**
     * Private so nobody else can instantiate it
     */
    private function __construct() {
    }

}