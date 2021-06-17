<?php

function showProducts(array $products = [], $class = "products", $editable = false)
{
    if ($class == 'row') {
        echo '
    <img src="' . ROOT_URL . 'svg/chevron-left.svg" alt="Précedent" class=" svg previous"> 
    <img src="' . ROOT_URL . 'svg/chevron-right.svg" alt="Suivant" class="svg next">';
    }
    echo '<div class="' . $class . '">';

    foreach ($products as $product) {
        echo '<!--<form method="post" action="' . ROOT_URL . 'panier/add/' . $product->id . '">-->' ?>
    <div class="product<?= ($class == 'row') ? '-row' : '' ?> <?=$editable?'editable':''?>">
        <?php
        echo '                    <img src="' . ROOT_URL . 'images/' . $product->image . '" class="image-responsive"
                         alt="product image">
                    <p class=product-name>' . $product->designation . ' ' .
            $product->qualite . '</p>
                    <p class="product-price">' . $product->prix . ' FCFA</p>
                   <!-- <input type="hidden" name="hidden-designation" value="' . $product->designation . '">
                    <input type="hidden" name="hidden-prix" value="' . $product->prix . '">
                    <input type="hidden" name="hidden-qualite" value="' . $product->qualite . '">-->
                    <!--<input type="submit" name="add" class="button add-to-card" value="Ajouter au panier">-->
                    ';
        if($editable){
            ?>
            <a href="<?=ROOT_URL?>products/modifier/<?=$product->id?>">Modifier</a>
            <a class="error" data-delete data-token="<?=sha1('deleteproduct'.$product->id)?>" href="<?=ROOT_URL?>products/delete/<?=$product->id?>">Supprimer</a>
        <?php
        }
        echo '
                </div>
            <!--</form>-->';
    }

    echo '</div>';
}

function showArticles(array $articles = [])
{
    echo '<div class="blog>';
    foreach ($articles as $article) {
        echo '<div class="article">
            <img src="' . ROOT_URL . 'images/' . $article->image . '" alt="Image">
            <h5>' . $article->titre . '</h5>';
    }
    echo '</div>';
}

