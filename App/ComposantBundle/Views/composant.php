<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title"><?php
        echo is_numeric($composant->getId())
        ? "Édition"
        : "Création"
    ?> d'un composant</h4>
</div>

<div class="modal-body">
    <form id="formComposant" action="index.php?p=composant&a=crud" method="post">
        <input type="hidden" name="action" value="<?php
            echo is_numeric($composant->getId())
            ? "updateComposant"
            : "addComposant"
        ?>">
        <input type="hidden" name="id" value="<?php
            echo is_numeric($composant->getId())
            ? $composant->getId()
            : ""
        ?>">
        <div class="form-group">
            <label class="formIntitule">Nom</label>
            <input required type="text" class="form-control userInput" name="nom" placeholder="Nom" value="<?php
                echo is_numeric($composant->getId())
                ? $composant->getNom()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Gamme *</label>
            <input required type="number" class="form-control userInput" name="gamme" placeholder="Gamme" value="<?php
                echo is_numeric($composant->getId())
                ? $composant->getGamme()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Dimensions *</label>
            <input required type="number" class="form-control userInput" name="dimensions" placeholder="Dimensions" value="<?php
                echo is_numeric($composant->getId())
                ? $composant->getDimensions()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Prix *</label>
            <input required type="number" step="0.01" class="form-control userInput" name="prix" placeholder="Prix" value="<?php
                echo is_numeric($composant->getId())
                ? $composant->getPrix()
                : ""
            ?>" />
        </div>
    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default"  data-dismiss="modal">Annuler</button>
    <button type="submit" form="formComposant" class="btn btn-success">Valider</button>
</div>
