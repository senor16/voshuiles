<?php
ob_start();

?>
    <div class="article-details">
        <h2><?=$article->resume?></h2>

        <img src="<?= ROOT_URL ?>images/uploads/<?= $article->image ?>"
             alt="Image <?= $article->titre ?>">
      <p><?=$article->contenu?></p>

<?php
  $content = ob_get_clean();