<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title"><?php
        echo is_numeric($module->getId())
        ? "Édition"
        : "Création"
    ?> d'un module</h4>
</div>

<div class="modal-body">
    <form id="formModule" action="index.php?p=module&a=crud" method="post">
        <input type="hidden" name="action" value="<?php
            echo is_numeric($module->getId())
            ? "updateModule"
            : "addModule"
        ?>">
        <input type="hidden" name="id" value="<?php
            echo is_numeric($module->getId())
            ? $module->getId()
            : ""
        ?>">
        <div class="form-group">
            <label class="formIntitule">Nom</label>
            <input required type="text" class="form-control userInput" name="nom" placeholder="Nom" value="<?php
                echo is_numeric($module->getId())
                ? $module->getNom()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Dimensions *</label>
            <input required class="form-control userInput" name="dimensions" placeholder="Dimensions" value="<?php
                echo is_numeric($module->getId())
                ? $module->getDimensions()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Prix *</label>
            <input required type="number" step="0.01" class="form-control userInput" name="prix" placeholder="Prix" value="<?php
                echo is_numeric($module->getId())
                ? $module->getPrix()
                : ""
            ?>" />
        </div>
        <div class="form-group">
            <label class="formIntitule">Composant(s) *</label>
            <select class="form-control" name="composants[]" id="moduleComposants" multiple>
                <?php if (!empty($composants)): ?>
                <?php foreach ($composants as $composant): ?>
                    <option value="<?php echo $composant->getId(); ?>"<?php
                        echo is_numeric($module->getId())
                        && !empty($module->getComposants())
                        && isset($module->getComposants()[$composant->getId()])
                        ? " selected "
                        : ""
                        ?>><?php echo $composant->getNom() ?> | Prix : <?php echo $composant->getPrix() ?> €</option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default"  data-dismiss="modal">Annuler</button>
    <button type="submit" form="formModule" class="btn btn-success">Valider</button>
</div>
