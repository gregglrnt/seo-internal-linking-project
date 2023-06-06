<?php 
    if($_POST && isset($_POST['fake_url'])) {
        update_option('internal_linking_fake_url', $_POST['fake_url']);
    }
    if($_POST && isset($_POST['api_key'])) {
        update_option('internal_linking_api_key', $_POST['api_key']);
    }
?>

<h1> Maillage interne </h1>
<form method="post" action="">
    <label for="fake_url"> Fakez vos liens en modifiant ici l'url du site : </label>
    <input type="text" name="fake_url" value="<?php echo get_option('internal_linking_fake_url'); ?>" />
    <label for="api_key"> Pensez à bien mettre votre clef d'API ici ! :) </label>
    <input type="text" name="api_key" required value="<?php echo get_option('internal_linking_api_key'); ?>" />
    <button type="submit" class="wp-button"> Enregistrer </button>
</form>
