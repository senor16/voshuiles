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
                    <span class=product-name><a href="'.ROOT_URL.'details/'.$product->id.'">' . $product->designation . '</a><br> ' .
            $product->qualite . '</span>
                    <span class="product-price">' . $product->prix . ' FCFA</span>';
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
   <svg class="svg previous" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 320 512"><path d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"/></svg>
    <svg class="svg next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
';
    }
}

function showArticles(array $articles = [])
{
    echo '<div class="articles">';
    foreach ($articles as $article) {
        echo '<div class="article">
            <a href="'.ROOT_URL.'articles/'.$article->slug.'"><img src="' . ROOT_URL . 'images/uploads/' . $article->image . '" alt="Image"></a>
            <a href="'.ROOT_URL.'articles/'.$article->slug.'"><h4>' . $article->titre . '</h4></a>';
        echo '</div>';
    }
    echo '</div>';
}