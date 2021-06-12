<?php
ob_start();
?>
    <h2><?= $title ?></h2>
    <h3>Informations de paiement :</h3>
<?php
extract($result);
if (isset($message)) {
    if (!$error) {
        echo '<h3 class="form-success">' . $message['info'] . '</h3>';
    } else {
        echo '<h3 class="form-error">' . $message['info'] . '</h3>';
    }
}
if (!(isset($message) && isset($error) && !$error)) {
    ?>


    <form method="post">
        <p>
            <?php
            if ($fields['mode-paiement'] == 'om' || !isset($message)) {
                ?>
                <input type="radio" checked="checked" name="mode-paiement" id="om" value="om">
                <label for="om">Orange Money</label>
                <?php
            } else {
                ?>
                <input type="radio" name="mode-paiement" id="om" value="om">
                <label for="om">Orange Money</label>
            <?php }
            if ($fields['mode-paiement'] == 'mm') {
                ?>

                <input type="radio" checked="checked" name="mode-paiement" id="mm" value="mm">
                <label for="mm">Mobile Money</label>
            <?php } else {
                ?>
                <input type="radio" name="mode-paiement" id="mm" value="mm">
                <label for="mm">Mobile Money</label>

                <?php
            }
            if ($fields['mode-paiement'] == 'visa') {
                ?>
                <input type="radio" checked="checked" name="mode-paiement" id="visa" value="visa">
                <label for="visa">Carte bancaire</label><br>
                <?php
            } else {
                ?>

                <input type="radio" name="mode-paiement" id="visa" value="visa">
                <label for="visa">Carte bancaire</label><br>
            <?php } ?>
        </p>

            <div id="div-mm-om" <?php
            if ($fields['mode-paiement'] == 'visa') {
                echo "hidden";
            }?>>
                <label for="tel">Tel:</label><br>
                <?= $message['tel'] ?? '' ?>
                <input id="tel" type="tel" name="tel" value="<?= $fields['tel'] ?? '' ?>"
                       placeholder="Ex: 698765435">
            </div>

            <div id="div-visa" <?php
            if ($fields['mode-paiement'] != 'visa') {
                echo "hidden";
            }?>>
                <label for="numero">Num'ero de la carte</label>
                <input type="tel" name="numero" id="numero" placeholder="1234 1234 1234 1234 "><br>
                <label for="date">Date d'expiration</label>
                <input type="date" name="date" id="date" value="2021-06-12"><br>
                <label for="cvc">CVC</label><br>
                <input type="tel" name="cvc" placeholder="CVC" id="cvc">
            </div>


        <input class="del-add" type="submit" required name="payer" value="Confirmer">

    </form>

    <?php
}
$content = ob_get_clean();
