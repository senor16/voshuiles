<?php
ob_start();

if ($action != "") {
    switch ($action) {
        case "main":
            ?>
            <ul class="settings">
                <li><a href="<?=ROOT_URL?>settings/profil"> Profil</a></li>
                <li><a href="<?=ROOT_URL?>settings/password"> Changer de mot de passe</a></li>
                <li><a href="<?=ROOT_URL?>settings/delete"> Supprimer mon compte</a></li>
            </ul>
            <?php
            break;
        case "profil":
            ?>
            <form action="" method="post">
            <label for="first_name">Prénom <small>(20 caractères max)</small>:</label><br>
            <?= $message['first_name'] ?? '' ?>
            <input id="first_name" type="text" required name="first_name" value="<?= $fields['first_name'] ?? $auth->prenom ?>"
                   placeholder="Ex: Michée"
                   class="<?=isset($message['firts_name']) ? 'field-error' : '' ?>">
            <br>
            <label for="last_name">Nom <small>(30 caractères max)</label><br>
            <?= $message['last_name'] ?? '' ?>
            <input id="last_name" type="text" required name="last_name"
                   value="<?= $fields['last_name'] ?? $auth->nom ?>" placeholder="Ex: Sesso Kosga Bamokaï"
                   class="<?=isset($message['last_name']) ? 'field-error' : '' ?>">
            <br>

            <label for="email">Email:</label><br>
            <?= $message['email'] ?? '' ?>
            <input id="email" type="email" required name="email" value="<?= $fields['email'] ?? $auth->email ?>"
                   placeholder="Ex: senor16@gmail.com"
                   class="<?=isset($message['email']) ? 'field-error' : '' ?>">
            <br>

            <label for="tel">Tel:</label><br>
            <?= $message['tel'] ?? '' ?>
            <input id="tel" type="tel" required name="tel" value="<?= $fields['tel'] ?? $auth->tel ?>" placeholder="Ex: 698765435"
                   class="<?=isset($message['tel']) ? 'field-error' : '' ?>">
            <br>

            <label for="birth_date">Date de naissance :</label></br>
            <?= $message['birth_date'] ?? '' ?>
            <input id="birth_date" type="date" required name="birth_date"
                   value="<?= $fields['birth_date'] ?? $auth->date_naiss ?>"
                   class="<?=isset($message['tel']) ? 'field-error' : '' ?>">
            <br>


            <label for="gender">Genre</label>
            <select id="gender" class="gender" name="gender">
                <?php
                if($auth->genre=="M"){
                    ?>
                    <option selected value="M">Homme</option>
                    <option value="F">Femme</option>
                        <?php
                }else{
                    ?>
                    <option value="M">Homme</option>
                <option selected value="F">Femme</option>

                    <?php
                }
                ?>
            </select>

            <label for="role">Vous souhaitez</label>
            <select id="role" class="role" name="role">
                <option value="CLIENT">Acheter</option>
                <option value="PRODUCTEUR">Vendre</option>
                <option value="PRODUCTEUR">Acheter et Vendre</option>
            </select>



            <label for="town">Votre ville:</label><br>
            <?= $message['town'] ?? '' ?>
            <input id="town" type="text" required name="town" value="<?= $fields['town'] ?? $auth->ville ?>" placeholder="Ex: Maroua"
                  class="<?=isset($message['town']) ? 'field-error' : '' ?>" ><br>
            <input class="del-add" type="submit" required name="submit" value="Enregistrer">

            </form>
            <?php
            break;

        case "delete":
            ?>
<form method="post">
   <label for="password">Mot de passe </label><br>
        <input id="password" type="password" required name="password" placeholder="votremotdepasse">
        <br>
  <input type="submit" class="del-add" value="Supprimer" name="submit">
</form>

            <?php
            break;

        case "password":
            ?>
<form method="post">
   <label for="password">Mot de passe actuel<small>(4 caratères min)</small>:</label><br>
        <?= $message['password'] ?? '' ?>
        <input id="password" type="password" required name="password" placeholder="votremotdepasse"
               class="<?=isset($message['password']) ? 'field-error' : '' ?>">
        <br>
  <label for="new_password">Nouveau mot de passe <small>(4 caratères min)</small>:</label><br>
        <?= $message['new_password'] ?? '' ?>
        <input id="new_password" type="password" required name="new_password" placeholder="votrenouveaumotdepasse"
               class="<?=isset($message['new_password']) ? 'field-error' : '' ?>">
        <br>
        <label for="password_confirm">Confirmer le mot de passr:</label><br>
        <?= $message['password_confirm'] ?? '' ?>
        <input type="password" id="password_confirm" required name="password_confirm" placeholder="votrenouveaumotdepasse"
               class="<?=isset($message['password_confirm']) ? 'field-error' : '' ?>">
        <br>
  <input type="submit" class="del-add" value="Enregistrer" name="submit">
</form>
            <?php
            break;

    }
}

$content = ob_get_clean();