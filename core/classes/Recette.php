<?php
class Recette{
    // Recettes
    public static function getRecettes($search=""){
        // C'est gitcopilot qui écrit 75% de cette fonction

        // On va récupérer les recettes selon la recherche
        // Si $search est une liste, on va chercher selon son contenu
        // $search["categoryId"], $search["name"], ["ingredientId"], ["difficulte"], ["time"], ["auteurId"]
        if(is_array($search) && !empty($search)){
            // https://stackoverflow.com/a/18603279
            $categoryId = $search["categoryId"] ?? "";
            $name = $search["name"] ?? "";
            $ingredients = $search["ingredients"] ?? "";
            $difficulte = $search["difficulte"] ?? "";
            $tempsPreparation = $search["tempsPreparation"] ?? "";
            $auteurId = $search["auteurId"] ?? "";

            // On construit la requête
            $queryString = "SELECT * FROM m_recette INNER JOIN m_recetteIngredient ON m_recette.id=m_recetteIngredient.recetteId  WHERE 1=1";
            if(!empty($categoryId)){
                $queryString .= " AND categoryId=:categoryId";
            }
            if(!empty($name)){
                $queryString .= " AND nom LIKE :name";
            }
            if(!empty($ingredients)){
                $ingredientsIn = implode(',', $ingredients);
                $queryString .= " AND ingredientId IN (:ingredients)";
            }
            if(!empty($difficulte)){
                $queryString .= " AND difficulte=:difficulte";
            }
            if(!empty($tempsPreparation)){
                $queryString .= " AND tempsPreparation=:tempsPreparation";
            }
            if(!empty($auteurId)){
                $queryString .= " AND auteurId=:auteurId";
            }
            // On la prépare
            $query = Connexion::pdo()->prepare($queryString." ORDER BY nom");

            // On rempli les paramètres
            if(!empty($categoryId)){
                $query->bindParam(':categoryId', $categoryId);
            }
            if(!empty($name)){
                $name = "%".$name."%";
                $query->bindParam(':name', $name);
            }
            if(!empty($ingredientId)){
                $query->bindParam(':ingredients', $ingredientsIn);
            }
            if(!empty($difficulte)){
                $query->bindParam(':difficulte', $difficulte);
            }
            if(!empty($tempsPreparation)){
                $query->bindParam(':tempsPreparation', $tempsPreparation);
            }
            if(!empty($auteurId)){
                $query->bindParam(':auteurId', $auteurId);
            }

            // On exécute
            $query->execute();
            // Et on retourne le résultat
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            // Si $search n'est pas un array, on va chercher toutes les recettes
            $query = Connexion::pdo()->prepare("SELECT * FROM m_recette ORDER BY nom");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public static function getRecette($recetteId){
        $query = Connexion::pdo()->prepare("SELECT * FROM m_recette WHERE id=?");
        $query->execute([$recetteId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    // Récupréation diverses infos relatives aux recettes
    public static function getCategories(){
        $query = Connexion::pdo()->prepare("SELECT * FROM m_categorie ORDER BY nom");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getUstensiles(){
        $query = Connexion::pdo()->prepare("SELECT * FROM m_ustensile ORDER BY nom");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getIngredients($recetteId=""){
        if(empty($recetteId)){
            $query = Connexion::pdo()->prepare("SELECT * FROM m_ingredient ORDER BY nom");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $query = Connexion::pdo()->prepare("SELECT * FROM m_ingredient WHERE id IN (SELECT ingredientId FROM m_recetteIngredient WHERE recetteId=:recetteId) ORDER BY nom");
            $query->bindParam(':recetteId', $recetteId);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

    // Envoyer une recette
    public static function sendRecette($recetteTitle, $recetteContent, $recetteDescription, $recetteCategory, $recetteIngredients, $recettePreparation, $recetteUstensiles, $recetteHeaderPic, $recetteDifficulte){
        $recetteTitle = utf8_encode(htmlspecialchars($recetteTitle));
        $recetteContent = utf8_encode($recetteContent);
        $recetteDescription = utf8_encode(htmlspecialchars($recetteDescription));
        $quantite = 1; // Je suis un boulet j'ai oublié ça xD

        // On insert la recette
        $query = Connexion::pdo()->prepare("INSERT INTO m_recette (id, categoryId, auteurId, nom, description, contenu, image, tempsPreparation, difficulte, datePost, dateModif) VALUES (NULL, :categoryId, :auteurId, :nom, :description, :contenu, :image, :tempsPreparation, :difficulte, NOW(), NOW())");
        $query->bindParam(':categoryId', $recetteCategory);
        $query->bindParam(':auteurId', $_SESSION["userId"]);
        $query->bindParam(':nom', $recetteTitle);
        $query->bindParam(':description', $recetteDescription);
        $query->bindParam(':contenu', $recetteContent);
        $query->bindParam(':image', $recetteHeaderPic);
        $query->bindParam(':tempsPreparation', $recettePreparation);
        $query->bindParam(':difficulte', $recetteDifficulte);
        $query->execute();

        // Puis on répertorie les ingrédients
        $recetteId = Connexion::pdo()->lastInsertId();
        foreach($recetteIngredients as $ingredient){
            $query = Connexion::pdo()->prepare("INSERT INTO m_recetteIngredient (recetteId, ingredientId, quantite) VALUES (:recetteId, :ingredientId, :quantite)");
            $query->bindParam(':recetteId', $recetteId);
            $query->bindParam(':ingredientId', $ingredient);
            $query->bindParam(':quantite', $quantite); 
            $query->execute();
        }
        // Et on termine par les ustensiles
        foreach($recetteUstensiles as $ustensile){
            $query = Connexion::pdo()->prepare("INSERT INTO m_recetteUstensile (recetteId, ustensileId) VALUES (:recetteId, :ustensileId)");
            $query->bindParam(':recetteId', $recetteId);
            $query->bindParam(':ustensileId', $ustensile);
            $query->execute();
        }
        // On retourne l'id de la recette
        return $recetteId;
    }
}