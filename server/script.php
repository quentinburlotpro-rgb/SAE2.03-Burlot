<?php
require("controller.php");
if ( isset($_REQUEST['todo']) ){
  header('Content-Type: application/json');
  $todo = $_REQUEST['todo'];
  switch($todo){

    case 'readmovies':
      $data = readMoviesController();
      break;

    case 'addmovie':
      $data = addMovieController();
      break;

    default:
      echo json_encode('[error] Unknown todo value');
      http_response_code(400);
      exit();
  }
  if ($data===false){
    http_response_code(500);
    echo json_encode('[error] Controller returns false');
    exit();
  }

  echo json_encode($data);
  http_response_code(200);
  exit();

   
}

http_response_code(404);
?>