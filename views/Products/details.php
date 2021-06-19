<?php
ob_start();

?>

<h2><?=$title?></h2>

<img src="<?=ROOT_URL?>images/<?=$product->image?>"
     alt="Image <?=$product->image?>">
<p>
 <h3 class="center "> <?=$product->prix?> FCFA</h3>
<form method="post" action="<?=ROOT_URL?>panier/add/<?=$product->id?>">
 <input type="hidden" name="hidden-designation" value="<?=$product->designation?>">
                    <input type="hidden" name="hidden-prix" value="<?=$product->prix?>">
                    <input type="hidden" name="hidden-qualite" value="<?=$product->qualite?>">
  <input type="submit" name="add" class="button add-to-card" value="Ajouter au panier">
  </form>
  <?php
  if(!empty($product->qualite)){
    ?>
  	  <h3>Qualité : </h3><?=$product->qualite;?>
  <?php
  }
  ?>
 </p>
<p>
  <?php if(!empty($product->description)){
  ?>
 <h3> Description: </h3><?=$product->description?>
  <?php
}
  ?>
</p>

<?php

if(!empty($flash)){
  echo '<script>alert("'.$flash.'");</script>';
}
$content = ob_get_clean();