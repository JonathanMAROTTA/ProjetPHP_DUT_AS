<?php
    session_start();
    require('../controleur/login_verification.php');
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SuperAnimes - Anime Details</title>
        <link rel="stylesheet" href="style4.css?v=<?php echo time(); ?>" type="text/css" >
    </head>

    <body>

        <?php include_once('header.php'); ?>

        <div class="title-details-anime">
            <h1>Details Anime</h1>
        </div>

            <?php
                require_once('../controleur/detailsAnime.php');

                include_once('footer.php');
            ?>
    </body>
</html>