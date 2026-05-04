<?php
define("HOST", "mmi.unilim.fr");
define("DBNAME", "burlot4");
define("DBLOGIN", "burlot4");
define("DBPWD", "burlot4");

function getPDO() {
    return new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', DBLOGIN, DBPWD);
}

function getMovies($age = 18) {
    $pdo = getPDO();
    $sql = "SELECT m.id, m.name, m.image, m.min_age, c.name as category_name 
            FROM `SAE-Movie` m 
            JOIN `SAE-Category` c ON m.id_category = c.id 
            WHERE m.min_age <= :age
            ORDER BY c.name, m.name";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':age' => $age]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMovieDetail($id) {
    $pdo = getPDO();
    $sql = "SELECT m.*, c.name as category_name 
                FROM `SAE-Movie` m 
                JOIN `SAE-Category` c ON m.id_category = c.id 
                WHERE m.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age) {
    $pdo = getPDO();
    $sql = "INSERT INTO `SAE-Movie` (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':name' => $name, ':director' => $director, ':year' => $year, 
        ':length' => $length, ':description' => $description, 
        ':id_category' => $id_category, ':image' => $image, 
        ':trailer' => $trailer, ':min_age' => $min_age
    ]);
    return $success ? $pdo->lastInsertId() : false;
}

function getProfiles() {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT id, name, avatar, min_age FROM `SAE-Profile` ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function saveProfile($id, $name, $avatar, $min_age) {
    $pdo = getPDO();
    
    if (empty($id)) {
        $sql = "INSERT INTO `SAE-Profile` (name, avatar, min_age) VALUES (:name, :avatar, :min_age)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':name' => $name, 
            ':avatar' => $avatar, 
            ':min_age' => $min_age
        ]);
        return $success ? $pdo->lastInsertId() : false;
    } 

    else {
        $sql = "UPDATE `SAE-Profile` SET name = :name, avatar = :avatar, min_age = :min_age WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':id' => $id,
            ':name' => $name, 
            ':avatar' => $avatar, 
            ':min_age' => $min_age
        ]);
        return $success ? $id : false;
    }
}

function addFavorite($id_profile, $id_movie) {
    $pdo = getPDO();
    $check = $pdo->prepare("SELECT * FROM `SAE-Favorite` WHERE id_profile = ? AND id_movie = ?");
    $check->execute([$id_profile, $id_movie]);
    if ($check->rowCount() > 0) return true;

    $stmt = $pdo->prepare("INSERT INTO `SAE-Favorite` (id_profile, id_movie) VALUES (?, ?)");
    return $stmt->execute([$id_profile, $id_movie]);
}

function removeFavorite($id_profile, $id_movie) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM `SAE-Favorite` WHERE id_profile = ? AND id_movie = ?");
    return $stmt->execute([$id_profile, $id_movie]);
}

function getFavorites($id_profile) {
    $pdo = getPDO();
    $sql = "SELECT m.id, m.name, m.image, m.min_age, c.name as category_name FROM `SAE-Movie` m JOIN `SAE-Category` c ON m.id_category = c.id 
    JOIN `SAE-Favorite` f ON m.id = f.id_movie WHERE f.id_profile = :profile ORDER BY m.name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':profile' => $id_profile]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedMovies($age) {
    $pdo = getPDO();
    $sql = "SELECT * FROM `SAE-Movie` WHERE featured = 1 AND min_age <= :age";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':age' => $age]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAppStats() {
    $pdo = getPDO();
    $stats = [];

    $stats['total_profiles'] = $pdo->query("SELECT COUNT(*) as total FROM `SAE-Profile`")->fetch()['total'];

    $stats['total_movies'] = $pdo->query("SELECT COUNT(*) as total FROM `SAE-Movie`")->fetch()['total'];

    $total_favs = $pdo->query("SELECT COUNT(*) as total FROM `SAE-Favorite`")->fetch()['total'];
    $stats['avg_favorites'] = $stats['total_profiles'] > 0 ? round($total_favs / $stats['total_profiles'], 1) : 0;

    $top_movie = $pdo->query("SELECT m.name, COUNT(f.id_movie) AS fav_count FROM `SAE-Favorite` f JOIN `SAE-Movie` m ON f.id_movie = m.id GROUP BY f.id_movie ORDER BY fav_count DESC LIMIT 1")->fetch();
    $stats['top_movie'] = $top_movie ? $top_movie['name'] : "Aucun";

    $top_category = $pdo->query("SELECT c.name, COUNT(f.id_movie) AS fav_count FROM `SAE-Favorite` f JOIN `SAE-Movie` m ON f.id_movie = m.id JOIN `SAE-Category` c ON m.id_category = c.id GROUP BY c.id ORDER BY fav_count DESC LIMIT 1")->fetch();
    $stats['top_category'] = $top_category ? $top_category['name'] : "Aucune";

    return $stats;
}

function searchMovies($age, $query) {
    $pdo = getPDO();
    $sql = "SELECT * FROM `SAE-Movie` WHERE min_age <= :age AND name LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':age' => $age, 
        ':query' => '%' . $query . '%'
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}