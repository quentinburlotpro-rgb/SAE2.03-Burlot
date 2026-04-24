<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "mmi.unilim.fr");
define("DBNAME", "burlot4");
define("DBLOGIN", "burlot4");
define("DBPWD", "burlot4");


function getAllMovies(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer le menu avec des paramètres
    $sql = "select id, name, image from `SAE-Movie`";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

function addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age){
    try {
        // Connexion à la base de données
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
        
        // Requête SQL pour insérer un nouveau film
        $sql = "INSERT INTO `SAE-Movie` (name, director, year, length, description, id_category, image, trailer, min_age) 
                VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";
        
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        
        // Lie les paramètres
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':director', $director);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id_category', $id_category);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':trailer', $trailer);
        $stmt->bindParam(':min_age', $min_age);
        
        // Exécute la requête SQL
        $stmt->execute();
        
        // Récupère l'ID du film inséré
        $newMovieId = $cnx->lastInsertId();
        
        // Retourne un message de succès
        return array('success' => "Le film a été ajouté avec succès (ID: " . $newMovieId . ")");
    } catch (PDOException $e) {
        // Retourne un message d'erreur en cas d'exception
        return array('error' => "Erreur lors de l'ajout du film: " . $e->getMessage());
    }
}