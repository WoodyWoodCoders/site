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

<button type="button" onClick="formComposant();" class="btn btn-primary">
    <i class="fa fa-plus"></i> Ajouter un composant
</button>
<table id="tableComposants" class="table table-striped">
    <thead>
        <tr>
            <th>Nom du composant</th>
            <th>Gamme</th>
            <th>Dimensions</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($composants as $composant): ?>
        <tr>
            <td><?php echo $composant->getNom(); ?></td>
            <td><?php echo $composant->getGamme(); ?></td>
            <td><?php echo $composant->getDimensions(); ?></td>
            <td><?php echo $composant->getPrix(); ?></td>
            <td>
                <form action="index.php?p=composant&a=crud" method="post">
                    <input type="hidden" name="action" value="deleteComposant">
                    <input type="hidden" name="id" value="<?php echo $composant->getId() ?>">

                    <button type="button" class="btn btn-success"  onClick="formComposant(<?php echo $composant->getId() ?>);"> <i class="fa fa-pencil"></i> </button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
