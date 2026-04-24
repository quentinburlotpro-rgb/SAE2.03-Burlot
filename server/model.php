<?php
define("HOST", "mmi.unilim.fr");
define("DBNAME", "burlot4");
define("DBLOGIN", "burlot4");
define("DBPWD", "burlot4");


function getAllMovies(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select id, name, image from `SAE-Movie`";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
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