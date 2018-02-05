<!-- BEGIN LOGIN FORM -->
<form class="login-form" action="index.php?p=user&a=login" method="post">
    <img src="public/logo.png" class="max-width-100" />
    <h3 class="form-title font-green">Connexion</h3>
    <small><a class="pull-right" href="index.php?p=user&a=register">S'inscrire</a></small>
    <?php if(isset($_GET["e"])) : ?>
    <?php $errorId = intval($_GET["e"]); ?>
    <div class="alert alert-<?php
        echo $this->getErrorSuccess($errorId) === true
        ? "success"
        : "danger"
    ?>">
        <button class="close" data-close="alert"></button>
        <span> <?php echo $this->getErrorMessage($errorId) ?> </span>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Adresse e-mail</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Adresse e-mail" name="login" /> </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Mot de passe</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Mot de passe" name="password" /> </div>
    <div class="form-group">
        <button type="submit" class="btn green uppercase pull-right">Se connecter</button>
    </div>
</form>
