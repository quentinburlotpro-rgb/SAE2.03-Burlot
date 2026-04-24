<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");


function readMoviesController(){
    $movies = getAllMovies();
    return $movies;
}

function addMovieController(){
    // Vérifie que tous les champs obligatoires sont présents
    $requiredFields = ['name', 'director', 'year', 'length', 'description', 'id_category', 'image', 'min_age'];
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            return array('error' => "Le champ '$field' est obligatoire");
        }
    }
    
    // Récupère les données du formulaire
    $name = $_POST['name'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $length = $_POST['length'];
    $description = $_POST['description'];
    $id_category = $_POST['id_category'];
    $image = $_POST['image'];
    $trailer = isset($_POST['trailer']) ? $_POST['trailer'] : null;
    $min_age = $_POST['min_age'];
    
    // Valide les données
    if (!is_numeric($year) || $year < 1900 || $year > 2100) {
        return array('error' => "L'année de sortie doit être entre 1900 et 2100");
    }
    
    if (!is_numeric($length) || $length < 1) {
        return array('error' => "La durée doit être supérieure à 0");
    }
    
    if (!is_numeric($min_age) || $min_age < 0 || $min_age > 18) {
        return array('error' => "La restriction d'âge doit être entre 0 et 18");
    }
    
    // Appelle la fonction du modèle pour ajouter le film
    $result = addMovie($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age);
    
    return $result;
}