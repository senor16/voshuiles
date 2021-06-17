<?php
ob_start();
require_once ROOT . 'views/layout/functions.php';
?>

<h2 class="center"><?=$title?></h2>
<?php showProducts($products,editable: true); ?>

<?php
$content = ob_get_clean();

$scriptFile="console.js";

