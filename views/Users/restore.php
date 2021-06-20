<?php
ob_start();

echo '<h2 class="center">' . $title . '</h2>';

extract($result);


if (isset($message)) {
    if (!$error) {
        echo '<h3 class="form-success center">' . $message['info'] . '</h3>';
    } else {
        echo '<h3 class="form-error center">' . $message['info'] . '</h3>';
    }
}else{
?>

    <form class="form" action="" method="post">
        <label for="tel">Email ou Tel:</label><br>
        <?= $message['tel'] ?? '' ?>
        <input id="tel" type="tel" required name="tel" value="<?= $fields['tel'] ?? '' ?>">
        <input class="del-add" type="submit" required name="login" value="Restaurer">
    </form>
<?php
}
$content = ob_get_clean();