<?php
ob_start();
echo '<h2 class="center">'.$title.'</h2>';
if (isset($result))extract($result);
if(isset($message)){
	if(!$error){
		echo '<h3 class="form-success">'.$message['info'].'</h3>';
		if (isset($link)) echo '<p>Un email vous a été envoyé pour confirmer votre adresse email</p>';
	}else{
		echo '<h3 class="form-error">'.$message['info'].'</h3>';
	}
}
?>
<form class="form"  method="post">
	<label for="first_name">Prénom <small>(20 caractères max)</small>:</label><br>
	<?=isset($message['first_name'])?$message['first_name']:''?>
	<input type="text" required name="first_name" value="<?=isset($fields['first_name'])?$fields['first_name']:''?>" placeholder="Ex: Michée">
	<br>
       <label for="last_name">Nom <small>(30 caractères max)</label><br>
		<?=isset($message['last_name'])?$message['last_name']:''?>
      <input type="text" required name="last_name" value="<?= isset($fields['last_name']) ? $fields['last_name'] : $auth->a_last_name?>" placeholder="Ex: Sesso Kosga Bamokaï">
  <br>

	<label for="email">Email:</label><br>
	<?=isset($message['email'])?$message['email']:''?>
	<input type="email" required name="email" value="<?=isset($fields['email'])?$fields['email']:''?>" placeholder="Ex: senor16@gmail.com">
	<br>

    <label for="tel">Tel:</label><br>
	<?=isset($message['tel'])?$message['tel']:''?>
	<input type="tel" required name="tel" value="<?=isset($fields['tel'])?$fields['tel']:''?>" placeholder="Ex: 698765435">
	<br>

         <label for="birth_date">Date de naissance :</label></br>
	<?=isset($message['birth_date'])?$message['birth_date']:''?>
	<input type="date" required name="birth_date" value="<?=isset($fields['birth_date'])?$fields['birth_date']:'1990-01-01'?>">
	<br>

     <label for="town">Ville:</label><br>
	<?=isset($message['town'])?$message['town']:''?>
	<input type="text" required name="town" value="<?=isset($fields['town'])?$fields['town']:''?>" placeholder="Ex: Maroua">

    <p>Genre</p>
    <select class="gender" name="gender">
      <option value="M">Homme</option>
      <option value="F">Femme</option>
    </select>
<br>

	<label for="password">Mot de passe <small>(4 caratères min)</small>:</label><br>
	<?=$message['password'] ?? ''?>
	<input type="password" required name="password" placeholder="votremotdepasse">
	<br>
	<label for="password_confirm">Confirmer le mot de passr:</label><br>
	<?=isset($message['password_confirm'])?$message['password_confirm']:''?>
	<input type="password" required name="password_confirm" placeholder="votremotdepasse">
	<br>


	<input class="del-add" type="reset" value="Effacer">
	<input class="del-add" type="submit" required name="login" value="Inscription">

</form>
<?php
$content=ob_get_clean();