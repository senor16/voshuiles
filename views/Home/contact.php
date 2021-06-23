<?php
ob_start();
?>

<h1 class="center">iHerb</h1>
<h2>
Découvrez tous les moyens de nous contacter</h2>

<p>Vous avez une question ? Nous vous répondons par téléphone, sur les réseaux sociaux et par tchat.</p>
<p>Les différents canaux</p>
<div>
<p><img class="image-responsive" src="<?=ROOT_URL?>images/tel.png" alt="Téléphone"></p>
<p>
  Par Télephone : +237 698142207
  </p>
</div>

<div>
<p><img class="image-responsive" src="<?=ROOT_URL?>images/reseaux.png" alt="Réseaux sociaux"></p>
<p>
  Sur les réseaux sociaux:</p>
  <ul>
    <li><a href="">Facebook</a></li>
    <li>Whatsapp : +237698142207</li>
    <li>Telegram : +237698142207</li>
  </ul>

</div>
<?php

$content =ob_get_clean();