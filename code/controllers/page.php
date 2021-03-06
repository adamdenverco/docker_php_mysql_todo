<?php

/*
 * ---------------------------------------------------------------
 * COLLECT VARIABLES
 * ---------------------------------------------------------------
 */
$urlSegments = explode("/", $_SERVER[REQUEST_URI]);
$urlSegmentSection = ( trim($urlSegments[1]) != "" ) ? trim(strtolower($urlSegments[1])) : "todo";
$urlSegmentAction = isset($urlSegments[2]) ? $urlSegments[2] : '';
$urlSegmentActionId = isset($urlSegments[3]) ? validIntegerOrZero($urlSegments[3]) : 0;

/*
 * ---------------------------------------------------------------
 * START COLLECTING DATA FOR OUTPUT
 * (Gather data from models and load views)
 * ---------------------------------------------------------------
 */
ob_start();

// set CSS and JS version for development only
$setDevVersion = (isThisDev()) ? "?v=".date("i",time()) : "";
$devTopMessage = (isThisDev()) ? "You're in ".strong(MY_APP_ENVIRONMENT)." environment." : "";

if ($urlSegmentSection == "todo") {

  // default variables
  $editItemid = 0;

  // new iteration of the Todo class
  $todo = new Todo();

  // capture any posted variables
  $postedItemId = validIntegerOrZero($_POST['todo_id']);
  $postedItemAction = cleanAlphaOnly($_POST['action']);
  $postedItemContent = trim( htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8') );

  // prep any alert messages
  // future: convert all updates to AJAX and pass alerts back as JSON
  $alert = ($_GET['alert']) ? (array) json_decode($_GET['alert']) : [];
  if ( count($alert) > 0) {
    foreach ($alert as $key => $value) {
      $alert[cleanAlphaOnly($key)] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
  }

  // if section action is 'complete' and we have a valid integer id
  if ($urlSegmentAction == "complete" && $postedItemId > 0) {
    $result = $todo->changeComplete($postedItemId);
    header('Location: /todo/?alert=' . urlencode(json_encode($result)) );
    exit();

  // if section action is 'delete' and we have a valid integer id
  } elseif ($urlSegmentAction == "delete" && $postedItemId > 0) {
    $result = $todo->deleteItem($postedItemId);
    header('Location: /todo/?alert=' . json_encode($result) );
    exit();

  // if section action is 'new' and we have a valid integer id
  } elseif ($postedItemAction == "new" && $postedItemContent) {

    $result = $todo->newItem($_POST);
    header('Location: /todo/?alert=' . json_encode($result) );
    exit();
  
  } elseif ($urlSegmentAction == "edit") {

    // load the default data for this todo item
    if ( $editItem = $todo->returnValidItemOrFalse($urlSegmentActionId) ) {

      $editItemid = $editItem['todo_id'];
      $postedItemContent = ($postedItemContent) ? $postedItemContent : $editItem['content'];
  
      // if the id is a POST variable then we want to update the database
      if ($postedItemId > 0) {
        
        $result = $todo->editItem($_POST);
        header('Location: /todo/?alert=' . json_encode($result) );
        exit();
      
      // else the id is a GET variable we need to load the edit form
      } elseif ($urlSegmentActionId > 0) {
        // we're going to load the edit section for this todo id
      }

    } else {

      $alert = [
        'status' => 'error',
        'message' => 'we couldn\'t find that todo item to edit.'
      ];

    }

  }

  // get all active todo items associated with the user
  $todos = $todo->getUserActiveTodos();

  $output = $todos;
  include __DIR__.'/../views/todo.html.php';

} elseif ($urlSegmentSection == "todoinfo") {

  include __DIR__.'/../views/todoinfo.html.php';

}

/*
 * ---------------------------------------------------------------
 * ASSIGN COLLECTED OUTPUT TO VARIABLE
 * ---------------------------------------------------------------
 */
$output = ob_get_clean();

/*
 * ---------------------------------------------------------------
 * DISPLAY FINAL LAYOUT
 * ---------------------------------------------------------------
 */
include  __DIR__ . '/../views/layout.html.php';
