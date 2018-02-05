<form action="index.php?p=user&a=register" method="POST">
    <img src="public/logo.png" class="max-width-100" />
    <h3 class="form-title font-green">Inscription</h3>
    <small><a class="pull-right" href="index.php?p=user&a=login">Se connecter</a></small>
    <div id="userInfos" class="col-md-12">
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
        <?php //$this->secureForm("register"); ?>
        <div class="form-group">
            <label class="formIntitule">Adresse e-mail *</label>
            <input required type="text" class="form-control userInput" name="login" placeholder="Adresse e-mail" value="" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Pr&eacute;nom *</label>
            <input required type="text" class="form-control userInput" id="userPrenom" name="firstName" placeholder="Pr&eacute;nom" value="" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Nom *</label>
            <input required type="text" class="form-control userInput" id="userNom" name="lastName" placeholder="Nom" value="" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Mot de passe *</label>
            <input required type="password" class="form-control userInput" id="userPassword1" name="password" placeholder="Mot de passe" value="" />
            </div>
        <div class="form-group">
            <label class="formIntitule">Confirmer le mot de passe *</label>
            <input required type="password" class="form-control userInput" id="userPassword2" name="password2" placeholder="Mot de passe (confirmation)" value="" />
            <span class="help-block"> </span>
        </div>
        <button type="submit" class="btn green pull-right">Valider</button>
    </div>
</form>
