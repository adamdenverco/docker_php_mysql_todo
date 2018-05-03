<?php 

/*
 * ---------------------------------------------------------------
 * AUTOLOAD CLASSES AS NECESSARY
 * ---------------------------------------------------------------
 */
function my_autoloader($class) {
    if ( strpos($class, '\\') ) {
        list($myNamespace,$class) = explode('\\', $class);
    }
    include_once __DIR__ . '/../models/' . strtolower($class) . '.php';
    return;
}
spl_autoload_register('my_autoloader');

/*
 * ---------------------------------------------------------------
 * CLEAN AND CHECK DATA
 * ---------------------------------------------------------------
 */
function isArrayAndNotNull($data) {
    return (is_array($data) && count($data) > 0) ? true:false;
}

function validIntegerOrZero($var) {
    return ( strlen($var) == strlen((int)$var) && (int)$var > 0) ? (int)$var : 0;
}
function cleanAlphaNumericOnly($data) {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $data);
}
function cleanAlphaOnly($data) {
    return preg_replace("/[^a-zA-Z]+/", "", $data);
}

/*
 * ---------------------------------------------------------------
 * MISC DISPLAY OUTPUTS
 * ---------------------------------------------------------------
 */
function br() {
    return "<br/>\r\n";
}

function hr() {
    return "<hr/>\r\n";
}

function strong($var) {
    return "<strong>". $var . "</strong>";
}

function echoWithBreak($var) {
    echo $var . br();
}

function echoArray($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>\r\n";
}

function dateForDatabase() {
    return date('Y-m-d H:i:s');
}