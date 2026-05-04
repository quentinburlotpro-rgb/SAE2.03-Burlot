<?php
require_once 'model.php';

function readMoviesController() {
    $age = isset($_GET['age']) ? intval($_GET['age']) : 0;
    $rawMovies = getMovies($age);
    
    if (!$rawMovies) return [];
    
    $grouped = [];
    foreach ($rawMovies as $movie) {
        $catName = $movie['category_name'];
        if (!isset($grouped[$catName])) {
            $grouped[$catName] = ['category_name' => $catName, 'movies' => []];
        }
        $grouped[$catName]['movies'][] = [
            'id' => $movie['id'],
            'name' => $movie['name'],
            'image' => $movie['image']
        ];
    }
    return array_values($grouped);
}

function readMovieDetailController() {
    if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) return false;
    return getMovieDetail($_REQUEST['id']);
}

function addMovieController() {
    $fields = ['name', 'director', 'year', 'length', 'description', 'id_category', 'image', 'min_age'];
    foreach ($fields as $f) {
        if (!isset($_POST[$f]) || empty($_POST[$f])) return false;
    }

    return addMovie(
        $_POST['name'], $_POST['director'], $_POST['year'], 
        $_POST['length'], $_POST['description'], $_POST['id_category'], 
        $_POST['image'], $_POST['trailer'] ?? null, $_POST['min_age']
    );
}

function addProfileController() {
    if (!isset($_POST['name']) || empty($_POST['name'])) return false;
    if (!isset($_POST['min_age'])) return false;

    $name = $_POST['name'];
    $avatar = $_POST['avatar'] ?? null;
    $min_age = $_POST['min_age'];

    return addProfile($name, $avatar, $min_age);
}

function readProfilesController() {
    return getProfiles();
}

function saveProfileController() {
    if (!isset($_POST['name']) || empty($_POST['name'])) return false;
    if (!isset($_POST['min_age'])) return false;

    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $avatar = $_POST['avatar'] ?? null;
    $min_age = $_POST['min_age'];

    return saveProfile($id, $name, $avatar, $min_age);
}

function addFavoriteController() {
    if (!isset($_POST['id_profile']) || !isset($_POST['id_movie'])) return false;
    return addFavorite($_POST['id_profile'], $_POST['id_movie']);
}

function removeFavoriteController() {
    if (!isset($_POST['id_profile']) || !isset($_POST['id_movie'])) return false;
    return removeFavorite($_POST['id_profile'], $_POST['id_movie']);
}

function readFavoritesController() {
    $profile = isset($_GET['profile']) ? intval($_GET['profile']) : 0;
    if ($profile === 0) return [];
    
    $rawMovies = getFavorites($profile);
    if (!$rawMovies) return [];
    
    return [['category_name' => 'Mes Favoris', 'movies' => $rawMovies]];
}

function readFeaturedMoviesController() {
    $age = isset($_GET['age']) ? intval($_GET['age']) : 18;
    return getFeaturedMovies($age);
}

function readStatsController() {
    return getAppStats();
}

function searchMoviesController() {
    $age = isset($_GET['age']) ? intval($_GET['age']) : 18;
    $query = isset($_GET['q']) ? $_GET['q'] : '';
    return searchMovies($age, $query);
}