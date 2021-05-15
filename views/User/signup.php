<?php
ob_start();
?>
<h2>Inscription</h2>

<?=isset($result)?$result:""?>
<?php
$content = ob_get_clean();