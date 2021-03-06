<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
    <title><?=$title?></title>
</head>
<body>
<?php
    require_once ROOT."views/layout/header.php";
?>
    <div class="container">
        <?=$content?>
    </div>
<?php
    require_once ROOT."views/layout/footer.php";
?>
<?=$script?? ''?>
<?php
if(isset($scriptFile)){
    ?>
<script src="<?=ROOT_URL?>js/<?=$scriptFile?>"></script>
<?php }?>
<script src="<?=ROOT_URL?>js/drop-down.js"></script>
</body>
</html>