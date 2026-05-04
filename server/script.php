<?php
require("controller.php");
if ( isset($_REQUEST['todo']) ){
  header('Content-Type: application/json');
  $todo = $_REQUEST['todo'];
  switch($todo){

    case 'readMovies':
      $data = readMoviesController();
      break;

    case 'readMovieDetail':
      $data = readMovieDetailController();
      break;

    case 'addMovie':
      $data = addMovieController();
      break;
    
    case 'readProfiles':
      $data = readProfilesController();
      break;

    case 'saveProfile':
      $data = saveProfileController();
      break;

    case 'addFavorite':
      $data = addFavoriteController();
      break;

    case 'readFavorites':
      $data = readFavoritesController();
      break;

    case 'removeFavorite':
      $data = removeFavoriteController();
      break;

    case 'readFeaturedMovies':
      $data = readFeaturedMoviesController();
      break;

    case 'readStats':
      $data = readStatsController();
      break;

    case 'searchMovies':
      $data = searchMoviesController();
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