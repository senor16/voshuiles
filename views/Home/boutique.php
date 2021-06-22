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
}

 showProducts($products);

$content = ob_get_clean();