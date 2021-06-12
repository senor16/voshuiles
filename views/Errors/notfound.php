<?php
$title = "404 - Page introuvable";
ob_start();
?>

<h2 class="error">Erreur code 404 - Page introuvable</h2>
<h3>
    La page que vous avez demandé n'existe pas ou a été supprimée
</h3>

<?php
$content = ob_get_clean();
