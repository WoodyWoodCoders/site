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

<button type="button" onClick="formModule();" class="btn btn-primary">
    <i class="fa fa-plus"></i> Ajouter un module
</button>
<table id="tableModules" class="table table-striped">
    <thead>
        <tr>
            <th>Nom du module</th>
            <th>Dimensions</th>
            <th>Prix</th>
            <th>Composants</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module): ?>
        <tr>
            <td><?php echo $module->getNom(); ?></td>
            <td><?php echo $module->getDimensions(); ?></td>
            <td><?php echo $module->getPrix(); ?></td>
            <td><?php //echo $module->getGamme(); ?></td>
            <td>
                <button type="button" class="btn btn-success"  onClick="formModule(<?php echo $module->getId() ?>);"> <i class="fa fa-pencil"></i> </button>
                <form id="formDeleteModule" action="index.php?p=module&a=crud" method="post">
                    <input type="hidden" name="action" value="deleteModule">
                    <input type="hidden" name="id" value="<?php echo $module->getId() ?>">
                </form>
                <button type="submit" form="formDeleteModule" class="btn btn-danger"><i class="fa fa-close"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
