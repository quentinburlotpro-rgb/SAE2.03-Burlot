<?php
require_once 'model.php';

function readMoviesController() {
    $movies = getMovies();
    return $movies;
}


function addMovieController(){
    $requiredFields = ['name', 'director', 'year', 'length', 'description', 'id_category', 'image', 'min_age'];
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            return array('error' => "Le champ '$field' est obligatoire");
        }
    }
    $name = $_POST['name'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $length = $_POST['length'];
    $description = $_POST['description'];
    $id_category = $_POST['id_category'];
    $image = $_POST['image'];
    $trailer = isset($_POST['trailer']) ? $_POST['trailer'] : null;
    $min_age = $_POST['min_age'];
    
    if (!is_numeric($year) || $year < 1900 || $year > 2100) {
        return array('error' => "L'année de sortie doit être entre 1900 et 2100");
    }
    
    if (!is_numeric($length) || $length < 1) {
        return array('error' => "La durée doit être supérieure à 0");
    }
    
    if (!is_numeric($min_age) || $min_age < 0 || $min_age > 18) {
        return array('error' => "La restriction d'âge doit être entre 0 et 18");
    }
    
    $result = addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age);
    
    return $result;
}