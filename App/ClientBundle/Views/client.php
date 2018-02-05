<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title"><?php
        echo is_numeric($client->getId())
        ? "Édition"
        : "Création"
    ?> d'un client</h4>
</div>

<div class="modal-body">
    <form id="formClient" action="index.php?p=client&a=crud" method="post">
        <input type="hidden" name="action" value="<?php
            echo is_numeric($client->getId())
            ? "updateClient"
            : "addClient"
        ?>">
        <input type="hidden" name="id" value="<?php
            echo is_numeric($client->getId())
            ? $client->getId()
            : ""
        ?>">
        <div class="form-group">
            <label class="formIntitule">Nom & prénom *</label>
            <input required type="text" class="form-control userInput" name="nom" placeholder="Nom & prénom" value="<?php
                echo is_numeric($client->getId())
                ? $client->getNom()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Adresse *</label>
            <input required type="text" class="form-control userInput" name="adresse" placeholder="Adresse" value="<?php
                echo is_numeric($client->getId())
                ? $client->getAdresse()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Code postal *</label>
            <input required type="text" class="form-control userInput" name="cp" placeholder="Code postal" value="<?php
                echo is_numeric($client->getId())
                ? $client->getCp()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Ville *</label>
            <input required type="text" class="form-control userInput" name="ville" placeholder="Ville" value="<?php
                echo is_numeric($client->getId())
                ? $client->getVille()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Téléphone *</label>
            <input required type="text" class="form-control userInput" name="telephone" placeholder="Téléphone" value="<?php
                echo is_numeric($client->getId())
                ? $client->getTelephone()
                : ""
            ?>" />
        </div>
    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default"  data-dismiss="modal">Annuler</button>
    <button type="submit" form="formClient" class="btn btn-success">Valider</button>
</div>
