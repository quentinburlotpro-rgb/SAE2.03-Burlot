<?php
require_once 'model.php';

function readMoviesController() {
    if (!isset($_GET['age'])) return false;
    
    $rawMovies = getMovies($_GET['age']);
    if ($rawMovies === false) return false;
    
    $grouped = [];
    foreach ($rawMovies as $movie) {
        $catName = $movie['category_name'];
        if (!isset($grouped[$catName])) {
            $grouped[$catName] = [
                'category_name' => $catName, 
                'movies' => []
            ];
        }
        $grouped[$catName]['movies'][] = $movie;
    }
    return array_values($grouped);
}

function readMovieDetailController() {
    if (!isset($_GET['id'])) return false;
    return getMovieDetail($_GET['id']);
}

function addMovieController() {
    if (!isset($_POST['name']) || !isset($_POST['director']) || !isset($_POST['year']) || 
        !isset($_POST['length']) || !isset($_POST['description']) || !isset($_POST['id_category']) || 
        !isset($_POST['image']) || !isset($_POST['trailer']) || !isset($_POST['min_age'])) {
        return false;
    }
    return addMovie(
        $_POST['name'], $_POST['director'], $_POST['year'], 
        $_POST['length'], $_POST['description'], $_POST['id_category'], 
        $_POST['image'], $_POST['trailer'], $_POST['min_age']
    );
}

function readProfilesController() {
    return getProfiles();
}

function saveProfileController() {
    if (!isset($_POST['name']) || !isset($_POST['avatar']) || !isset($_POST['min_age'])) {
        return false;
    }
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    return saveProfile($id, $_POST['name'], $_POST['avatar'], $_POST['min_age']);
}

function addFavoriteController() {
    if (!isset($_GET['id_profile']) || !isset($_GET['id_movie'])) return false;
    return addFavorite($_GET['id_profile'], $_GET['id_movie']);
}

function removeFavoriteController() {
    if (!isset($_GET['id_profile']) || !isset($_GET['id_movie'])) return false;
    return removeFavorite($_GET['id_profile'], $_GET['id_movie']);
}

function readFavoritesController() {
    if (!isset($_GET['profile'])) return false;
    
    $rawMovies = getFavorites($_GET['profile']);
    if ($rawMovies) {
        return [['category_name' => 'Mes Favoris', 'movies' => $rawMovies]];
    }
    return [];
}

function readFeaturedMoviesController() {
    if (!isset($_GET['age'])) return false;
    return getFeaturedMovies($_GET['age']);
}

function readStatsController() {
    return getAppStats();
}

function searchMoviesController() {
    if (!isset($_GET['age']) || !isset($_GET['q'])) return false;
    return searchMovies($_GET['age'], $_GET['q']);
}