<header>
    <div class="desk-menu">
        <div class="top">
            <h1 class="logo"><a href="<?= ROOT_URL ?>">iHerb</a></h1>
            <form class="form-search" method="get" action="<?= ROOT_URL ?>products/search">
                <input class="q-search" name="q" type="search" required minlength="1" placeholder="Que voulez vous ?"
                       value="<?= $q ?? '' ?>">
                <button class="btn-search" type="submit"><img class="svg" src="<?= ROOT_URL ?>svg/search.svg" alt="Search">
                </button>
            </form>
            <div class="actions">
                <a class="user" href="<?=ROOT_URL?>login"> <img src="<?= ROOT_URL ?>svg/user.svg"></a>
                <a href="<?=ROOT_URL?>panier"> <img style="margin-left:10px" src="<?= ROOT_URL ?>svg/shopping-cart.svg"></a>
            </div>
            <ul class="drop-down" style="visibility: hidden">
                <?php if(!isset($_SESSION['auth'])){ ?>
                <li><a href="<?=ROOT_URL?>login">Connexion</a></li>
                <li><a href="<?=ROOT_URL?>signup">Inscription</a></li>
                <?php } else { ?>
                    <li><a href="<?=ROOT_URL?>logout">Déconnexion</a></li>
                <li><a href="<?=ROOT_URL?>console">Console</a></li>
                <li><a href="<?=ROOT_URL?>settings">Paramètres</a></li>
                <?php }?>
            </ul>
        </div>
        <nav class="menu">
            <ul>
                <li class="<?=($_SESSION['active']=='accueil') ? 'active' :''?>"><a href="<?= ROOT_URL ?>">Accueil</a></li>
                <li <?=($_SESSION['active']=='boutique') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>boutique">Boutique</a></li>
                <li <?=($_SESSION['active']=='blog') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>blog">Blog</a></li>
                <li <?=($_SESSION['active']=='contact') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>contact">Nous contacter</a></li>
            </ul>
        </nav>

    </div>
    <div class="mobile-menu">
        <div class="top">
            <h1 class="logo"><a href="<?= ROOT_URL ?>">iHerb</a></h1>
            <div class="actions">
                <a class="user" href="<?=ROOT_URL?>login"><img src="<?= ROOT_URL ?>svg/user.svg"></a>
                <a href="<?=ROOT_URL?>panier"><img style="margin-left:10px" src="<?= ROOT_URL ?>svg/shopping-cart.svg"></a>
            </div>
        </div>
        <form class="form-search" method="get" action="<?= ROOT_URL ?>products/search">
            <input class="q-search" name="q" type="search" required minlength="1" placeholder="Que voulez vous ?"
                   value="<?= $q ?? '' ?>">
            <button class="btn-search" type="submit"><img class="svg" src="<?= ROOT_URL ?>svg/search.svg" alt="Search">
            </button>
        </form>
        <nav class="menu">
            <ul>
                <li class="<?=($_SESSION['active']=='accueil') ? 'active' :''?> first"><a href="<?= ROOT_URL ?>">Accueil</a></li>
                <li <?=($_SESSION['active']=='boutique') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>boutique">Boutique</a></li>
                <li <?=($_SESSION['active']=='blog') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>blog">Blog</a></li>
                <li <?=($_SESSION['active']=='contact') ? 'class="active"' :''?>><a href="<?= ROOT_URL ?>contact">Nous contacter</a></li>
            </ul>
        </nav>
        <ul class="drop-down" style="visibility: hidden">
            <?php if(!isset($_SESSION['auth'])){ ?>
                <li><a href="<?=ROOT_URL?>login">Connexion</a></li>
                <li><a href="<?=ROOT_URL?>signup">Inscription</a></li>
            <?php } else { ?>
                <li><a href="<?=ROOT_URL?>logout">Déconnexion</a></li>
                <li><a href="<?=ROOT_URL?>console">Console</a></li>
                <li><a href="<?=ROOT_URL?>settings">Paramètres</a></li>
            <?php }?>
        </ul>



    </div>
    <?php /*
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
				<li><a href="<?=ROOT_URL.'login'?>"></a></li>
              <li>
			</ul>
		<?php
			endif;
		*/ ?>


</header>