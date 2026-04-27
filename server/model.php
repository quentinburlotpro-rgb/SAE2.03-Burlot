<?php
define("HOST", "mmi.unilim.fr");
define("DBNAME", "burlot4");
define("DBLOGIN", "burlot4");
define("DBPWD", "burlot4");
$pdo = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', DBLOGIN, DBPWD);


function getMovies() {
    $stmt = $pdo->query("SELECT name, image, affiche FROM `SAE-Movie`");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age){
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
        
        $sql = "INSERT INTO `SAE-Movie` (name, director, year, length, description, id_category, image, trailer, min_age) 
                VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";
        
        $stmt = $cnx->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':director', $director);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id_category', $id_category);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':trailer', $trailer);
        $stmt->bindParam(':min_age', $min_age);
        
        $stmt->execute();
        
        $newMovieId = $cnx->lastInsertId();
        
        return array('success' => "Le film a été ajouté avec succès (ID: " . $newMovieId . ")");
    } catch (PDOException $e) {
        return array('error' => "Erreur lors de l'ajout du film: " . $e->getMessage());
    }
}