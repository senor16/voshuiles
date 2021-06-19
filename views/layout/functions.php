<?php

function showProducts(array $products = [], $class = "products", $editable = false)
{
    if ($class == 'rows') {
        echo '
    <img src="' . ROOT_URL . 'svg/chevron-left.svg" alt="Précedent" class=" svg previous">
    <img src="' . ROOT_URL . 'svg/chevron-right.svg" alt="Suivant" class="svg next">';
    }
    echo '<div class="' . $class . '">';

    foreach ($products as $product) {
       ?>
    <div class="product<?= ($class == 'rows') ? '-row' : '' ?> <?=$editable?'editable':''?>">
        <?php
        echo '<a href="'.ROOT_URL.'details/'.$product->id.'"> <img src="' . ROOT_URL . 'images/' . $product->image . '" class="image-responsive"
                         alt="product image"></a>
                    <p class=product-name><a href="'.ROOT_URL.'details/'.$product->id.'">' . $product->designation . '</a><br> ' .
            $product->qualite . '</p>
                    <p class="product-price">' . $product->prix . ' FCFA</p>';
        if($editable){
            ?>
            <a href="<?=ROOT_URL?>products/modifier/<?=$product->id?>">Modifier</a>
            <a class="error" data-delete data-token="<?=sha1('deleteproduct'.$product->id)?>" href="<?=ROOT_URL?>products/delete/<?=$product->id?>">Supprimer</a>
        <?php
        }
        echo '
                </div>';
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