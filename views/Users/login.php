<?php
ob_start();


echo '<h2 class="center">' . $title . '</h2>';
if (isset($result)) extract($result);

if (isset($message)) {
    if ($error) {
        echo '<h3 class="form-error">' . $message . '</h3>';
    }
} else {
    if (isset($flash) && $flash != '') {
        if ($flash['type'] != 'error') {
            ?>
            <div class="alert success"><h3><?= $flash['message'] ?></h3></div>
            <?php
        } else {
            echo '
        <div class="alert error"></h3>' . $flash['message'] . '</h3></div>';
        }
    }
}
?>

    <form class="form" action="<?= ROOT_URL . "login" ?>" method="post">
        <label for="tel">Email ou Tel:</label><br>
        <input type="text" required name="tel" placeholder="" value="<?= $tel ?? '' ?>">
        <br>
        <label for="password">Mot de passe <small>(<a href="<?= ROOT_URL ?>restore">Mot de passe
                    oublié</a>)</small>:</label>
        <input type="password" required name="password" placeholder="motdepasse">
        <br>
        <label for="remember">
            <input type="checkbox" name="remember" id="remember" value="1">Se souvenir de moi</label><br>

        <p>
            Pas encore de compte ? <a href="<?= ROOT_URL ?>signup">Inscrivez-vous.</a>
        </p>
        <input class="del-add" type="reset" value="Effacer">
        <input class="del-add" type="submit" required name="login" value="Connexion">
    </form>
<?php
$content = ob_get_clean();