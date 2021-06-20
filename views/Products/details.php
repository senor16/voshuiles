<?php
ob_start();

?>
    <div class="product-details">
        <h2><?= $title ?></h2>

        <img class="image-responsive" src="<?= ROOT_URL ?>images/uploads/<?= $product->image ?>"
             alt="Image <?= $product->designation ?>">
        <p>
        <h3 class="center "> <?= $product->prix ?> FCFA</h3>
        <form method="post" action="<?= ROOT_URL ?>panier/add/<?= $product->id ?>">
            <input type="hidden" name="hidden-designation" value="<?= $product->designation ?>">
            <input type="hidden" name="hidden-prix" value="<?= $product->prix ?>">
            <input type="hidden" name="hidden-qualite" value="<?= $product->qualite ?>">
            <input type="submit" name="add" class="button add-to-card" value="Ajouter au panier">
        </form>
        <?php
        if (!empty($product->qualite)) {
            ?>
            <br><b>Qualité : </b><?= $product->qualite; ?>
            <?php
        }
        ?>
        </p>
        <p>
            <?php if (!empty($product->description)){
            ?>
        <h3> Description: </h3><?=  str_replace("\n","<br>",$product->description) ?>
    <?php
    }
    ?>
        </p>
    </div>
<?php

if (!empty($flash)) {
    echo '<script>alert("' . $flash . '");</script>';
}
$content = ob_get_clean();