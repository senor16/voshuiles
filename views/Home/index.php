<?php
ob_start();
require_once ROOT . 'views/layout/functions.php';
if (isset($flash) && $flash != '') {
    if ($flash['type'] != 'error') {
        ?>
        <div class="alert center success"><h3><?= $flash['message'] ?></h3></div>
        <?php
    } else {
        echo '
        <div class="alert center error"></h3>' . $flash['message'] . '</h3></div>';
    }
} ?>


    <h2>Nouveautés</h2>
<?php showProducts($products, 'rows'); ?>

    <h2>Promotion</h2>
<?php showProducts($products, 'rows'); ?>

    <h2>Blog</h2>
      <?php
showArticles($articles);

$content = ob_get_clean();
$scriptFile = 'home.js';