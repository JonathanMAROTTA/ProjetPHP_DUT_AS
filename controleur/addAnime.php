<?php
    session_start();
    require '../controleur/connexion.php';
    require '../modele/animeManager.php';
    require '../modele/userManager.php';
    $animeManager = new AnimeManager($bdd);
    $userManager = new UserManager($bdd);
    $users = $userManager->getAll();
    $animes = $animeManager->getAll();
    
    if(isset($_POST['new_anime'])) {
        $idUser;
        $animeEstDejaPresent = false;

        foreach ($animes as $_anime){
            if ($_anime->getTitre_native() == $_POST['titre_native'] || $_anime->getTitre_romaji() == $_POST['titre_romaji'] || $_anime->getTitre_fr() == $_POST['titre_fr']) {
                $animeEstDejaPresent = true;
            }
        }

        foreach ($users as $user){
            if ($_SESSION['pseudo'] == $user->getPseudo()) {
                $idUser = $user->getIdUser();
            }
        }

        if ($animeEstDejaPresent) {
            $_SESSION['error_addAnime'] = 'Erreur : Anime déjà présente------ !';
            header('location:../vue/ajouter.php?id=<php echo $idUser?>');
            die();
        }
        
        else {
            $ret        = false;
            $img_blob   = '';
            $img_taille = 0;
            $taille_max = 10000000; // FILE_MAX_SIZE = 10Mo
            $ret        = is_uploaded_file($_FILES['userImage']['tmp_name']);
            
            if (!$ret) {
                echo "Problème de transfert";
            }
            else {
                // Le fichier a bien été reçu
                $img_taille = $_FILES['userImage']['size'];
                
                if ($img_taille > $taille_max) {
                    echo "Fichier Trop volumineux (10Mo MAX) !";
                }
            }
            
            $img_blob = base64_encode( file_get_contents(  $_FILES['userImage']['tmp_name']    )    );
            
            $data = [
                'titre_native' => $_POST['titre_native'],
                'titre_romaji' => $_POST['titre_romaji'],
                'titre_fr' => $_POST['titre_fr'],
                'status' => $_POST['status_anime'],
                'studio' => $_POST['studio'],
                'genre' => $_POST['genre'],
                'synopsis' => $_POST['synopsis'],
                'nb_episodes' => $_POST['nb_episodes'],
                'jaquette' => $img_blob,
                'createur' => $idUser
            ];
            
            $anime = new Anime();
            $anime->hydrate($data);
            $animeManager->add($anime);

            header("Location: ../vue/animes.php");
            die();
        }     
    }
?>