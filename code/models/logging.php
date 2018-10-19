<?php
/*
 * Logging Class
 * 
 * This will create a log-YYYY-MM.txt if none exists
 * And it will log any errors when called
 */
class Logging {

    /**
     * Call this static method to log
     */
    public static function writeToFile($text = null) {

        // if text isset then prep the text
        if ( $text = self::prepLogText($text) ) {

            // determine the log file name
            $logFileName = dirname(__FILE__).'/../logs/log-'. date('Y-m') .'.txt';

            // if file does not exist then...
            if (!file_exists($logFileName) ) {
                // create log file
                self::createLogFile($logFileName);
            }

            // append the $text to the end of the existing file
            try {
                // adapted from...
                // https://stackoverflow.com/questions/24972424
                file_put_contents($logFileName, $text, FILE_APPEND | LOCK_EX) or die("Can't add to file");
            } catch (Exception $e) {
                // report any log file trouble
                echo 'Caught exception: '.  $e->getMessage() .PHP_EOL;
            }
            
        }
        
        // return to what we were doing elsewhere
        return;
    }

    public static function createLogFile($fileName) {
        // return true or false
        $createdFileTrueFalse = false;
        // doublecheck that file does not exist
        if (!file_exists($fileName)) {
            try {
                // create file and close it
                $logfile = fopen($fileName, 'w');
                fclose($logfile);
            } catch (Exception $e) {
                // report any file creation trouble
                echo 'Caught exception: '.  $e->getMessage() .PHP_EOL;
            }
        }
        return;
    }

    public static function prepLogText($text = null) {
        // only prep text if it isset and not null
        if ( isset($text) && !is_null($text) ) {
            // if text is an array or object, convert it to a json string
            $text = ( is_array($text) || is_object($text) ) ? json_encode($text) : $text;

            // prepend $text variable with a date stamp and add new line at the end
            $text = date('Y-m-d H:i:s') . " : " . trim($text) . PHP_EOL;
        }
        return $text;
    }

    public function __construct() {
    }

}