<?php
require_once ROOT . 'views/layout/functions.php';
ob_start();
?>

<?php
if (!empty($products)) {
    if (count($products) > 1) {
        ?>
        <h2>"<?= $q ?>" : <?= count($products) ?> produits trouvés </h2>
        <?php
    } else {
        ?>
        <h2>"<?= $q ?>" : <?= count($products) ?> produit trouvé </h2>
        <?php
    }
    showProducts($products);
    ?>


    <?php
} else {
    ?>

    <h2>Aucun produit ne correspond à "<?= $q ?>"</h2>
    <?php

}

$content = ob_get_clean();