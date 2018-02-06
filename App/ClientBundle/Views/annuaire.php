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

<button type="button" onClick="formClient();" class="btn btn-primary">
    <i class="fa fa-plus"></i> Ajouter un client
</button>
<table id="tableClients" class="table table-striped">
    <thead>
        <tr>
            <th>Nom du client</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?php echo $client->getNom(); ?></td>
            <td><?php echo $client->getAdresseComplete(); ?></td>
            <td>
                <form action="index.php?p=client&a=crud" method="post">
                    <input type="hidden" name="action" value="deleteClient">
                    <input type="hidden" name="id" value="<?php echo $client->getId() ?>">
                    
                    <button type="button" class="btn btn-success"  onClick="formClient(<?php echo $client->getId() ?>);"> <i class="fa fa-pencil"></i> </button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
