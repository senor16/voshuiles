<?php
ob_start();
require_once ROOT . 'views/layout/functions.php';
if (isset($flash) && $flash != '') {
    if ($flash['type'] != 'error') {
        ?>
        <div class="alert success"><h3><?= $flash['message'] ?></h3></div>
        <?php
    } else {
        echo '
        <div class="alert error"></h3>' . $flash['message'] . '</h3></div>';
    }
} ?>


    <h2>Nouveautés</h2>
<?php showProducts($products, 'rows'); ?>

    <h2>Promotion</h2>
<?php showProducts($products, 'rows'); ?>

    <h2>Blog</h2>
    <div class="articles">

        <div class="article">
            <img src="<?= ROOT_URL ?>images/huile-de-palme.jpg" alt="">
            <h4>Les bienfaits de l'huile de palme</h4>
        </div>
        <div class="article">
            <img src="<?= ROOT_URL ?>images/neem.jpeg" alt="">
            <h4>Les bienfaits de l'huile de neem</h4>
        </div>
        <div class="article">
            <img src="<?= ROOT_URL ?>images/karite.jpg" alt="">
            <h4>Les bienfaits du beurre de karité</h4>
        </div>
        <div class="article">
            <img src="<?= ROOT_URL ?>images/huile-de-sesame.jpg" alt="">
            <h4>Les bienfaits de l'huile de sésame</h4>
        </div>



    </div>
<?php
$content = ob_get_clean();
$scriptFile = 'home.js';