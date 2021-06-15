<header>
    <h1><a href="<?=ROOT_URL?>">Manyanga</a></h1>
<?php
			if(isset($_SESSION['auth'])):
		?>
			<ul class="menu">
				<li><a href="<?=ROOT_URL.'logout'?>">Se deconnecter</a></li>
				<li><a href="<?=ROOT_URL.'settings'?>">Paramètres</a></li>
			</ul>
		<?php
			else:
		?>
			<ul class="menu">
				<li><a href="<?=ROOT_URL.'login'?>">Se connecter</a></li>
			</ul>
		<?php
			endif;
		?>

<form class="form-search" method="get" action="<?=ROOT_URL?>products/search">
			<input class="q-search" name="q" type="search" required minlength="1" placeholder="Que voulez vous ?" value="<?=$q ?? '' ?>">
			<button class="btn-search" type="submit"><img class="svg" src="<?=ROOT_URL?>svg/search.svg" alt="Search"></button>
		</form>

</header>