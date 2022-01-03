<?php
// Ce fichier a une position un peu embêtante
// Faut-il le mettre en view? Non, il possède du code logique.
// Faut-il le mettre en classe? Non, ça serait inutile. En plus il est géré comme une page  par le site.
// Faut-il alors intégrer son code au fichier fonction? Bah c'est compliqué car il compare pas mal de choses avant d'executer ces fonctions...
// ----- / Il sert donc de passerelle entre fonctions.php et les pages.

if(isset($_GET["checkUsernameEmail"]) && !empty($_GET["checkUsernameEmail"])){
    // Cette fonction va vérifier si un username ou un email existe déjà dans la bdd
    if(checkUsernameEmail($_GET["checkUsernameEmail"])) echo "true";
    else echo "false";

}elseif(isset($_GET["handleLoginAndRegisterForm"])){
    // Celle-ci va permettre de gérer l'envoie des formulaires d'inscription et de connexion
    if(!empty($_POST)){
        // On va regarder de quel type de formulaire il s'agit
        if (isset($_POST['registerUsername'])) {
            // Il s'agit d'une inscription
            // Ici on va vérifier que l'on dispose bien de tous les champs nécessaires
            if(isset($_POST['recaptcha_response'])){
                // Build POST request:
                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_secret = '6LdzDpUaAAAAANjaM4-6fqzuCh6nkZO99tJXk4Iv';
                $recaptcha_response = $_POST['recaptcha_response'];

                // Make and decode POST request:
                $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);
                // Take action based on the score returned:
                if ($recaptcha->score >= 0.5){
                    if (!empty($_POST['registerUsername'])) {
                        if (isset($_POST['registerEmail'])) {
                            if (!empty($_POST['registerEmail'])) {
                                if (isset($_POST['registerPassword1'])) {
                                    if (!empty($_POST['registerPassword1'])) {
                                        if (isset($_POST['registerPassword2'])) {
                                            if (!empty($_POST['registerPassword2'])) {
                                                if ($_POST['registerPassword1']==$_POST['registerPassword2']) {
                                                    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/', $_POST['registerPassword1'])==1) {
                                                        $username = $_POST['registerUsername'];
                                                        $email = strtolower($_POST['registerEmail']); // ici on converti l'email donné en casse minuscule
                                                        $password = password_hash($_POST['registerPassword1'], PASSWORD_DEFAULT);
        
                                                        // Ici on récupère l'id du groupe des utilisateurs
                                                        $userGroupId = Connexion::pdo()->query("SELECT id FROM m_groupeUtilisateur WHERE name='utilisateur'")->fetchColumn();
        
                                                        // Là on va insérer l'utilisateur dans la table des utilisateurs
                                                        $query = Connexion::pdo()->prepare("INSERT INTO m_utilisateur (id, grouppId, username, password) VALUES (?, ?, ?)");
                                                        $query->execute([null, $userGroupId, $username]);
        
                                                        // Maintenant on va récuper son id
                                                        $userId = Connexion::pdo()->prepare("SELECT id FROM m_utilisateur WHERE username=?")->execute([$username])->fetchColumn();
                                                        
                                                        // On va insérer son adresse mail
                                                        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
                                                        $query->execute([$userId, 'email', $email]);
        
                                                        // Sa date d'inscription
                                                        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
                                                        $query->execute([$userId, 'joinedDate', date("Y-m-d H:i:s")]);
        
                                                        $return["success"] = "Inscription réussie, tu peux désormais te connecter! 🥳";
                                                    } else {
                                                        $return["error"] = 'Ton mot de passe doit être long d\'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.';
                                                    }
                                                    
                                                } else {
                                                    $return["error"] = 'Je sais pas comment  t\'as fais, <b>il faut que les deux mots de passe correspondent</b>';
                                                }
                                                
                                            } else {
                                                $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du second mdp</b>';
                                            }
                                        } else {
                                            $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 2nd mot de passe n\'est pas reconnu.';
                                        }
                                    } else {
                                        $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du premier mdp</b>';
                                    }
                                } else {
                                    $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 1er mot de passe n\'est pas reconnu.';
                                }
                            } else {
                                $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'adresse email</b>';
                            }
                        } else {
                            $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ de l\'adresse email n\'est pas reconnu.';
                        }
                        
                    } else {
                        $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'identifiant</b>';
                    }
                }else{
                    $return["error"] = "Le reCAPTCHA t'as identifié comme un robot. Re-essaie plus-tard.";
                }
            }
        }
    }else{
        // Ici on a pas reçu de données, nous ne sommes pas censsé arriver ici
        $return["error"] = "Vous n'avez pas rempli tous les champs";
    }
    echo json_encode($return);
}