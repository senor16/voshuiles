<?php
ob_start();
if (empty($_SESSION['cart'])) {
    ?>
    <h3>Il n'y a aucun produit dans le panier</h3>
    <?php

} else {

    ?>
    <h2><?= $title ?></h2>
    <table>
    <tr>
        <th style="width:50px;">N<sup>o</sup></sup></th>
        <th style="width:300px;">Désignation</th>
        <th style="width:100px;">Qualité</th>
        <th style="width:150px;">Quantitté</th>
        <th style="width:100px;">Prix unitaire</th>
        <th style="width:250px;">Total</th>
        <th style="width:150px;">Action</th>
    </tr>
    <?php
    $i = 0;
    $totlal = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $product) {
            $totlal += $product['prix'] * $product['quantite'];
            $i++;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $product['designation'] ?></td>
                <td><?= $product['qualite'] ?></td>
                <td><a href="<?= ROOT_URL ?>panier/modifyquantity/<?= $product['id'] ?>/down" class="button">-</a>
                    <?= $product['quantite'] ?>
                    <a href="<?= ROOT_URL ?>panier/modifyquantity/<?= $product['id'] ?>/up" class="button">+</a></td>
                <td style="text-align: right;"><?= $product['prix'] ?> </td>
                <td style="text-align: right;"><?= $product['prix'] * $product['quantite'] ?> </td>
                <td><a href="<?= ROOT_URL ?>panier/delete/<?= $product['id'] ?>" class=" danger">Supprimer</a></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="4"><b>Total</b></td>
            <td colspan="3"><b><?= $totlal ?> FCFA</b></td>
        </tr>
        </table>
        <p>
            <a class="button" href="<?=ROOT_URL?>panier/confirmer">Confirmer l'achat</a>
        </p>
        <?php
    }
}

$content = ob_get_clean();