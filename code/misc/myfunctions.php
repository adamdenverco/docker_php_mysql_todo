<?php 

/*
 * ---------------------------------------------------------------
 * SET PHP CLASS AUTOLOADER
 * ---------------------------------------------------------------
 */
if (!function_exists('isThisDev')) {
  function my_autoloader($class) {
    if ( strpos($class, '\\') ) {
      list($myNamespace,$class) = explode('\\', $class);
    }
    include_once __DIR__ . '/../models/' . strtolower($class) . '.php';
    return;
  }
}
spl_autoload_register('my_autoloader');
/*
 * ---------------------------------------------------------------
 * Environment Checks
 * ---------------------------------------------------------------
 */
if (!function_exists('isThisDev')) {
  function isThisDev() {
    return (MY_APP_ENVIRONMENT == 'development') ? true : false;
  }
}
if (!function_exists('getGitBranch')) {
  function getGitBranch() {
    // adapted from @author Kevin Ridgway
    // via https://stackoverflow.com/questions/7447472
    $branchName = "";
    // pull the .git HEAD file into an array
    if ($fileContentsArray = file(__DIR__.'/../../.git/HEAD', FILE_USE_INCLUDE_PATH) ) {
      // get the first line
      // explode by "/" into a 3 record array
      // set branch name as 3rd record
      $branchName = explode("/", $fileContentsArray[0], 3)[2];
    }
    return $branchName;
  }
}

/*
 * ---------------------------------------------------------------
 * CLEAN, CHECK, FORMAT DATA
 * ---------------------------------------------------------------
 */
if (!function_exists('isArrayAndNotNull')) {
  function isArrayAndNotNull($data) {
      return (is_array($data) && count($data) > 0) ? true:false;
  }
}
if (!function_exists('validIntegerOrZero')) {
  function validIntegerOrZero($var) {
      return ( strlen($var) == strlen((int)$var) && (int)$var > 0) ? (int)$var : 0;
  }
}
if (!function_exists('cleanAlphaNumericOnly')) {
  function cleanAlphaNumericOnly($data) {
      return preg_replace("/[^a-zA-Z0-9]+/", "", $data);
  }
}
if (!function_exists('cleanAlphaOnly')) {
  function cleanAlphaOnly($data) {
      return preg_replace("/[^a-zA-Z]+/", "", $data);
  }
}
if (!function_exists('dateForDatabase')) {
  function dateForDatabase() {
    return date('Y-m-d H:i:s');
  }
}
if (!function_exists('formatDateForDisplay')) {
  function formatDateForDisplay($inputDate = null) {
    $outputDate = '';
    if ( date('Y-m-d') == date('Y-m-d', strtotime($inputDate)) ) {
        $outputDate = 'Today at ' . date( 'g:i a', strtotime( $inputDate ) ); 
    } elseif ( date('Y') == date('Y', strtotime($inputDate)) ) { 
        $outputDate = date( 'M j \a\t g:i a', strtotime( $inputDate ) ); 
    } else {
        $outputDate = date( 'M j, Y \a\t g:i a', strtotime( $inputDate ) ); 
    }
    return $outputDate;
  }
}

/*
 * ---------------------------------------------------------------
 * DISPLAY OUTPUTS
 * ---------------------------------------------------------------
 */
if (!function_exists('echoDataTitleDie')) {
	function echoDataTitleDie( $data = NULL, $title = NULL, $should_we_die = NULL) {
		if ($data || $title) {
      echo $title;
			if (is_array($data) || is_object($data) ) {
				echo "<pre>";
				print_r($data);
				echo "</pre>\r\n";
			} else {
				echo $data . "<br/>\r\n";
			}
    }
    if (in_array(strtolower($should_we_die), ['yes', 'y', 'die', 1]) ) {
      echo "we died.<br/>\r\n";
      die();
      exit();
    }
		return;
	}
}

if (!function_exists('echoData')) {
  function echoData( $data = NULL, $title = NULL, $should_we_die = NULL) {
    echo_data_title_die( $data, $title, $should_we_die);
    return;
  }
}

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
