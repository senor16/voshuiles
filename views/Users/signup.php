<?php
ob_start();

echo '<h2 class="center">' . $title . '</h2>';
if (isset($result)) extract($result);
if (isset($message)) {
    if (!$error) {
        echo '<h3 class="form-success">' . $message['info'] . '</h3>';
        if (isset($link)) echo '<p>Un email vous a été envoyé pour confirmer votre adresse email</p>';
    } else {
        echo '<h3 class="form-error">' . $message['info'] . '</h3>';
    }
}
?>
    <form class="form" method="post">
        <p>
            Vous avez déja un compte ? <a href="<?=ROOT_URL?>/login">Connecter vous.</a>
        </p>
        <label for="first_name">Prénom <small>(20 caractères max)</small>:</label><br>
        <?= $message['first_name'] ?? '' ?>
        <input id="first_name" type="text" required name="first_name" value="<?= $fields['first_name'] ?? '' ?>"
               placeholder="Ex: Michée">
        <br>
        <label for="last_name">Nom <small>(30 caractères max)</label><br>
        <?= $message['last_name'] ?? '' ?>
        <input id="last_name" type="text" required name="last_name"
               value="<?= $fields['last_name'] ?? $auth->a_last_name ?>" placeholder="Ex: Sesso Kosga Bamokaï">
        <br>

        <label for="email">Email:</label><br>
        <?= $message['email'] ?? '' ?>
        <input id="email" type="email" required name="email" value="<?= $fields['email'] ?? '' ?>"
               placeholder="Ex: senor16@gmail.com">
        <br>

        <label for="tel">Tel:</label><br>
        <?= $message['tel'] ?? '' ?>
        <input id="tel" type="tel" required name="tel" value="<?= $fields['tel'] ?? '' ?>" placeholder="Ex: 698765435">
        <br>

        <label for="birth_date">Date de naissance :</label></br>
        <?= $message['birth_date'] ?? '' ?>
        <input id="birth_date" type="date" required name="birth_date"
               value="<?= $fields['birth_date'] ?? '1990-01-01' ?>">
        <br>


        <label for="gender">Genre</label>
        <select id="gender" class="gender" name="gender">
            <option value="M">Homme</option>
            <option value="F">Femme</option>
        </select>

        <label for="role">Vous souhaitez</label>
        <select id="role" class="role" name="role">
            <option value="CLIENT">Acheter</option>
            <option value="PRODUCTEUR">Vendre</option>
            <option value="PRODUCTEUR">Acheter et Vendre</option>
        </select>



        <label for="town">Votre ville:</label><br>
        <?= $message['town'] ?? '' ?>
        <input id="town" type="text" required name="town" value="<?= $fields['town'] ?? '' ?>" placeholder="Ex: Maroua"><br>



        <label for="password">Mot de passe <small>(4 caratères min)</small>:</label><br>
        <?= $message['password'] ?? '' ?>
        <input id="password" type="password" required name="password" placeholder="votremotdepasse">
        <br>
        <label for="password_confirm">Confirmer le mot de passr:</label><br>
        <?= $message['password_confirm'] ?? '' ?>
        <input type="password" id="password_confirm" required name="password_confirm" placeholder="votremotdepasse">
        <br>


        <input class="del-add" type="reset" value="Effacer">
        <input class="del-add" type="submit" required name="login" value="Inscription">

    </form>
<?php
$content = ob_get_clean();