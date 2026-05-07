# Documentation Base de Données - SAE 2.03 (Quentin Burlot)

## 1. Justification des choix d'architecture

**Organisation des tables et associations :**
La base de données est structurée autour de 3 entités principales (`SAE-Movie`, `SAE-Category`, `SAE-Profile`) et d'une table de liaison (`SAE-Favorite`).
Le choix de séparer les catégories dans une table dédiée (`SAE-Category`) permet d'éviter la redondance de données et facilite le filtrage ou l'ajout futur de nouvelles catégories, en respectant la 3ème forme normale. 
La table `SAE-Favorite` est indispensable pour résoudre la relation Plusieurs-à-Plusieurs (N:M) entre les Profils et les Films.

**Clefs primaires (PK) et Clefs étrangères (FK) :**
* Toutes les tables principales utilisent un champ `id` de type `INT(11)` en `AUTO_INCREMENT` comme clef primaire. C'est le format le plus optimisé pour les index et les jointures.
* La table `SAE-Favorite` utilise une clef primaire composite (`id_profile`, `id_movie`) qui sert également de clefs étrangères pointant vers leurs tables respectives. Cela empêche naturellement les doublons (un profil ne peut pas avoir deux fois le même film en favori).

**Types de données et longueurs :**
* **VARCHAR(255) :** Utilisé pour les textes courts (nom des films, réalisateur, URLs des images et trailers). 255 caractères offrent une marge suffisante.
* **TEXT :** Utilisé pour le champ `description` des films, car un synopsis dépasse très souvent la limite d'un simple VARCHAR.
* **INT(11) :** Utilisé pour les identifiants, les années (`year`), les durées (`length`) et les restrictions d'âge (`min_age`).
* **TINYINT(1) :** Utilisé pour le champ `featured` (booléen) afin de stocker l'état "mis en avant" (0 = non, 1 = oui) en occupant un minimum d'espace mémoire.

---

## 2. Explication des cardinalités (Modèle Conceptuel)

Le modèle conceptuel de données (MCD) repose sur deux associations principales :

1.  **Relation "Appartenir" (Film - Catégorie) :**
    * **Film (1,1) :** Un film possède obligatoirement une catégorie au minimum, et une seule au maximum.
    * **Catégorie (0,n) :** Une catégorie peut ne contenir aucun film, ou en contenir plusieurs. Cela se traduit physiquement par l'ajout d'une clef étrangère `id_category` dans la table Film.
2.  **Relation "Aimer / Favoris" (Profil - Film) :**
    * **Profil (0,n) :** Un profil peut n'avoir aucun film en favori, ou en accumuler plusieurs.
    * **Film (0,n) :** Un film peut n'être le favori de personne, ou être le favori de multiples profils. Cette relation (0,n) - (0,n) engendre la création de la table de liaison `SAE-Favorite`.

*(Voir la capture d'écran `capture_looping.png` pour le schéma visuel).*

---

## 3. Requêtes SQL utilisées par itération

*Note : Toutes les requêtes communiquant avec l'extérieur utilisent PDO avec des requêtes préparées (`?`) pour prévenir les injections SQL.*

### Itération 1, 4 & 7 : Lister, Grouper par Catégories et Filtrer par Âge
* **Requête :** `SELECT m.id, m.name, m.image, m.min_age, c.name as category_name FROM SAE-Movie m JOIN SAE-Category c ON m.id_category = c.id WHERE m.min_age <= ? ORDER BY c.name, m.name`
* **Explication :** On récupère les films via une jointure pour obtenir le nom de la catégorie (Itération 1). Le regroupement (Itération 4) est géré en PHP, mais facilité par le `ORDER BY c.name`. Le `WHERE` assure le filtrage selon l'âge du profil actif (Itération 7).

### Itération 2 : Ajouter des films (Admin)
* **Requête :** `INSERT INTO SAE-Movie (name, director, year, length, description, id_category, image, trailer, min_age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`

### Itération 3 : Consulter les détails d'un film
* **Requête :** `SELECT m.*, c.name as category_name FROM SAE-Movie m JOIN SAE-Category c ON m.id_category = c.id WHERE m.id = ?`

### Itération 5 & 8 : Ajouter et Modifier un Profil (Admin)
* **Ajout :** `INSERT INTO SAE-Profile (name, avatar, min_age) VALUES (?, ?, ?)`
* **Modification :** `UPDATE SAE-Profile SET name = ?, avatar = ?, min_age = ? WHERE id = ?`

### Itération 6 : Lister les Profils
* **Requête :** `SELECT id, name, avatar, min_age FROM SAE-Profile ORDER BY name`

### Itération 9 & 10 : Ajouter, Retirer et Lister les Favoris
* **Vérification doublon :** `SELECT * FROM SAE-Favorite WHERE id_profile = ? AND id_movie = ?`
* **Ajout (Itération 9) :** `INSERT INTO SAE-Favorite (id_profile, id_movie) VALUES (?, ?)`
* **Retrait (Itération 10) :** `DELETE FROM SAE-Favorite WHERE id_profile = ? AND id_movie = ?`
* **Lister les favoris d'un profil :** `SELECT m.id, m.name, m.image, m.min_age, c.name as category_name FROM SAE-Movie m JOIN SAE-Category c ON m.id_category = c.id JOIN SAE-Favorite f ON m.id = f.id_movie WHERE f.id_profile = ? ORDER BY m.name`

### Itération 11 : Films mis en avant
* **Requête :** `SELECT * FROM SAE-Movie WHERE featured = 1 AND min_age <= ?`

### Itération 12 : Consulter les Statistiques
* **Total profils :** `SELECT COUNT(*) as total FROM SAE-Profile`
* **Total films :** `SELECT COUNT(*) as total FROM SAE-Movie`
* **Total favoris :** `SELECT COUNT(*) as total FROM SAE-Favorite`
* **Film Top 1 :** `SELECT m.name, COUNT(f.id_movie) AS fav_count FROM SAE-Favorite f JOIN SAE-Movie m ON f.id_movie = m.id GROUP BY f.id_movie ORDER BY fav_count DESC LIMIT 1`
* **Catégorie Top 1 :** `SELECT c.name, COUNT(f.id_movie) AS fav_count FROM SAE-Favorite f JOIN SAE-Movie m ON f.id_movie = m.id JOIN SAE-Category c ON m.id_category = c.id GROUP BY c.id ORDER BY fav_count DESC LIMIT 1`

### Itération 13 : Recherche
* **Requête :** `SELECT m.*, c.name as category_name FROM SAE-Movie m JOIN SAE-Category c ON m.id_category = c.id WHERE m.min_age <= ? AND m.name LIKE ?`
* **Explication :** L'opérateur `LIKE` est combiné en PHP avec des `%` pour trouver le terme de recherche n'importe où dans le titre.