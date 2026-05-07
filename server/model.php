<?php
define("HOST", "localhost");
define("DBNAME", "SAE203");
define("DBLOGIN", "root");
define("DBPWD", "a7fikti2Q9");

function getPDO() {
    return new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', DBLOGIN, DBPWD);
}

function getMovies($age) {
    $pdo = getPDO();
    $sql = "SELECT m.id, m.name, m.image, m.min_age, c.name as category_name FROM `SAE-Movie` m JOIN `SAE-Category` c ON m.id_category = c.id WHERE m.min_age <= ? ORDER BY c.name, m.name";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$age]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMovieDetail($id) {
    $pdo = getPDO();
    $sql = "SELECT m.*, c.name as category_name FROM `SAE-Movie` m JOIN `SAE-Category` c ON m.id_category = c.id WHERE m.id = ?";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age) {
    $pdo = getPDO();
    $sql = "INSERT INTO `SAE-Movie` (name, director, year, length, description, id_category, image, trailer, min_age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([$name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age]);
    
    if ($success) {
        return $pdo->lastInsertId();
    }
    return false;
}

function getProfiles() {
    $pdo = getPDO();
    $sql = "SELECT id, name, avatar, min_age FROM `SAE-Profile` ORDER BY name";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function saveProfile($id, $name, $avatar, $min_age) {
    $pdo = getPDO();
    
    if (empty($id)) {
        $sql = "INSERT INTO `SAE-Profile` (name, avatar, min_age) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$name, $avatar, $min_age]);
        
        if ($success) {
            return $pdo->lastInsertId();
        }
        return false;
    } 

    $sql = "UPDATE `SAE-Profile` SET name = ?, avatar = ?, min_age = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([$name, $avatar, $min_age, $id]);
    
    if ($success) {
        return $id;
    }
    return false;
}

function addFavorite($id_profile, $id_movie) {
    $pdo = getPDO();
    
    $sql_check = "SELECT * FROM `SAE-Favorite` WHERE id_profile = ? AND id_movie = ?";
    $check = $pdo->prepare($sql_check);
    $check->execute([$id_profile, $id_movie]);
    
    if ($check->rowCount() > 0) {
        return true;
    }

    $sql_insert = "INSERT INTO `SAE-Favorite` (id_profile, id_movie) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql_insert);
    return $stmt->execute([$id_profile, $id_movie]);
}

function removeFavorite($id_profile, $id_movie) {
    $pdo = getPDO();
    $sql = "DELETE FROM `SAE-Favorite` WHERE id_profile = ? AND id_movie = ?";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_profile, $id_movie]);
}

function getFavorites($id_profile) {
    $pdo = getPDO();
    $sql = "SELECT m.id, m.name, m.image, m.min_age, c.name as category_name FROM `SAE-Movie` m JOIN `SAE-Category` c ON m.id_category = c.id JOIN `SAE-Favorite` f ON m.id = f.id_movie WHERE f.id_profile = ? ORDER BY m.name";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_profile]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedMovies($age) {
    $pdo = getPDO();
    $sql = "SELECT * FROM `SAE-Movie` WHERE featured = 1 AND min_age <= ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$age]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAppStats() {
    $pdo = getPDO();
    $stats = [];

    $sql_profiles = "SELECT COUNT(*) as total FROM `SAE-Profile`";
    $stats['total_profiles'] = $pdo->query($sql_profiles)->fetch()['total'];
    
    $sql_movies = "SELECT COUNT(*) as total FROM `SAE-Movie`";
    $stats['total_movies'] = $pdo->query($sql_movies)->fetch()['total'];
    
    $sql_favs = "SELECT COUNT(*) as total FROM `SAE-Favorite`";
    $total_favs = $pdo->query($sql_favs)->fetch()['total'];
    
    $stats['avg_favorites'] = 0;
    if ($stats['total_profiles'] > 0) {
        $stats['avg_favorites'] = round($total_favs / $stats['total_profiles'], 1);
    }

    $sql_top_movie = "SELECT m.name, COUNT(f.id_movie) AS fav_count FROM `SAE-Favorite` f JOIN `SAE-Movie` m ON f.id_movie = m.id GROUP BY f.id_movie ORDER BY fav_count DESC LIMIT 1";
    $top_movie = $pdo->query($sql_top_movie)->fetch();
    
    $stats['top_movie'] = "Aucun";
    if ($top_movie) {
        $stats['top_movie'] = $top_movie['name'];
    }

    $sql_top_category = "SELECT c.name, COUNT(f.id_movie) AS fav_count FROM `SAE-Favorite` f JOIN `SAE-Movie` m ON f.id_movie = m.id JOIN `SAE-Category` c ON m.id_category = c.id GROUP BY c.id ORDER BY fav_count DESC LIMIT 1";
    $top_category = $pdo->query($sql_top_category)->fetch();
    
    $stats['top_category'] = "Aucune";
    if ($top_category) {
        $stats['top_category'] = $top_category['name'];
    }

    return $stats;
}

function searchMovies($age, $query) {
    $pdo = getPDO();
    
    $sql = "SELECT m.*, c.name as category_name FROM `SAE-Movie` m JOIN `SAE-Category` c ON m.id_category = c.id WHERE m.min_age <= ? AND m.name LIKE ?";
    
    $stmt = $pdo->prepare($sql);
    $search = '%' . $query . '%'; 
    $stmt->execute([$age, $search]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>