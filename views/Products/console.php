<?php
ob_start();
require_once ROOT . 'views/layout/functions.php';
?>

<h2 class="center"><?=$title?></h2>
<a class="button" href="<?=ROOT_URL?>ajouter">Ajouter un produit</a>
<?php showProducts($products,'products', true); ?>

<?php

if(!empty($flash)){
  echo '<script>alert("'.$flash.'");</script>';
}
$content = ob_get_clean();

$scriptFile="console.js";