<?php
ob_start();
//var_dump($_SESSION['flash']);
if (isset($flash) && $flash != '') {
    if ($flash['type'] != 'error') {
        ?>
        <div class="alert success"><h3><?= $flash['message'] ?></h3></div>
        <?php
    } else {
        echo '
        <div class="alert error"></h3>' . $flash['message'] . '</h3></div>';
    }
}
?>

    <div class="products">
        <?php
        foreach ($products as $product) {
            ?>
            <form method="post" action="<?= ROOT_URL ?>panier/add/<?= $product->id ?>">
                <div class="product">
                    <img src="<?= ROOT_URL ?>images/<?= $product->image ?>" class="image-responsive"
                         alt="product image">
                    <h5 class=product-name><?= $product->designation ?></h5>
                    <h5 class="product-price"><?= $product->prix ?> FCFA</h5>
                    <input type="hidden" name="hidden-designation" value="<?= $product->designation ?>">
                    <input type="hidden" name="hidden-prix" value="<?= $product->prix ?>">
                    <input type="hidden" name="hidden-qualite" value="<?= $product->qualite ?>">
                    <input type="submit" name="add" class="button add-to-card" value="Ajouter au panier">
                </div>
            </form>
            <?php
        }
        ?>
    </div>

<?php
$content = ob_get_clean();