<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<!--Même si on met du code pour "controller" les action de l'user, dans le front rien empêche l'user de le moddifier / supprimer donc on le fais dans le back là où l'user ne peux pas le moddifier-->
<p>Envoyez-moi votre rapport de stage, svp.</p>
<p>Attention, seuls les PDFs de moins de 3Mo sont acceptés.</p>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" /> <!--La valeur max du fichier mais c'est dans le front  il faut le mettre dans la back pour que ça ne soit pas moddifiable-->
    <input type="file" name="mon_fichier" accept="image/*" /> <br> <!-- On ne veux que des images mais on accepte tout les type d'image, png / jpg etc....-->
    <input type="submit" value="Envoyer">
</form>
</body>

</html>

<?php
var_dump($_FILES);


if (
    !empty($_FILES['mon_fichier'])
    && $_FILES['mon_fichier']['error'] === 0
    && $_FILES['mon_fichier']['size'] <= 3_000_000 // le fichier ne peux faire que 3 mo Maximum (3 000 000 d'octets)
    && str_starts_with($_FILES['mon_fichier']['type'], 'image/')
) {

    /**
     * On renomme le fichier par sécurité et on ne sauvegarde pas le nom entrée par l'user => pour empécher l'insertion de code dans le nom
     * (le nom vient de l'utilisateur, on ne lui fait jamais confiance)
     */
    $nouveau_nom = uniqid(); //on génère un id unique qui remplacera le nom actuel du fichier

    $extension = pathinfo($_FILES['mon_fichier']['name'], PATHINFO_EXTENSION); // on garde l'extension du fichier

    $nouveau_nom .= '.' . $extension; // on concatene le nouveau nom et l'extension actuel du fichier

    move_uploaded_file(
        $_FILES['mon_fichier']['tmp_name'],  // Point de départ
        __DIR__ . '/uploads/' . $nouveau_nom // Point d'arrivée => on envoie le fichier upload dans dossier "uploads" 

    );

} else {
    echo '<pre>';
    var_dump($_FILES); // on regarde ce qu'il y a dans le fichier 
    echo '</pre>';

    die("Bien essayer mais ça ne marchera pas");
}
