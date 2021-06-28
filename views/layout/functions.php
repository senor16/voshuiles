<?php

function showProducts(array $products = [], $class = "products", $editable = false)
{
    echo '<div class="' . $class . '">';

    foreach ($products as $product) {
       ?>
    <div class="product<?= ($class == 'rows') ? '-row' : '' ?> <?=$editable?'editable':''?>">
        <?php
        echo '<a href="'.ROOT_URL.'details/'.$product->id.'"> <img src="' . ROOT_URL . 'images/uploads/' . $product->image . '"
                         alt="product image"></a><p></p>
                    <span class="product-price">' . $product->prix . ' <small>FCFA</small></span>
                    <span class=product-name><a href="'.ROOT_URL.'details/'.$product->id.'">' . $product->designation . '</a><br> ' .
            $product->qualite . '</span><br>';
        if($editable){
            ?>
            <a href="<?=ROOT_URL?>products/modifier/<?=$product->id?>">Modifier</a>
            <a class="danger" data-delete data-token="<?=sha1('deleteproduct'.$product->id)?>" href="<?=ROOT_URL?>products/delete/<?=$product->id?>">Supprimer</a>
        <?php
        }
        echo '
                </div>';
    }

    echo '</div>';
    if ($class == 'rows') {
        echo '
   <div class="previous"><img src="'.ROOT_URL.'images/fleche_gauche.png" alt="Précédent"></div>
    <div class="next"><img src="'.ROOT_URL.'images/fleche_droite.png" alt="Précédent"></div>
';
    }
}

function showArticles(array $articles = [],$class="articles")
{
    echo '<div class="'.$class.'">';
    foreach ($articles as $article) {
        echo '<div class="article">
            <a href="'.ROOT_URL.'articles/'.$article->slug.'"><img src="' . ROOT_URL . 'images/uploads/' . $article->image . '" alt="Image"></a>
            <a href="'.ROOT_URL.'articles/'.$article->slug.'"><h4>' . $article->titre . '</h4></a>';
        echo '</div>';
    }
    echo '</div>';
}