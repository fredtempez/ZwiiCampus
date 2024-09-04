<?php echo template::formOpen('usersTagForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('userDeleteBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'user/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset7">
        <?php echo template::button('usersTagSelectAll', [
            'value' => template::ico('square-check'),
            'help' => 'Tout sélectionner'
        ]); ?>
    </div>
    <div class="col1">
        <?php echo template::button('usersTagSelectNone', [
            'value' => template::ico('square-check-empty'),
            'help' => 'Tout désélectionner'
        ]); ?>
    </div>
    <div class="col2">
        <?php echo template::submit('usersTagSubmit'); ?>
    </div>
</div>
<div class="row" id="Bfrtip">
    <div class="col3">
        <?php echo template::select('usersFilterGroup', $module::$usersGroups, [
            'label' => 'Groupes / Profils',
            'selected' => isset($_POST['usersFilterGroup']) ? $_POST['usersFilterGroup'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('usersFilterFirstName', $module::$alphabet, [
            'label' => 'Prénom commence par',
            'selected' => isset($_POST['usersFilterFirstName']) ? $_POST['usersFilterFirstName'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('usersFilterLastName', $module::$alphabet, [
            'label' => 'Nom commence par',
            'selected' => isset($_POST['usersFilterLastName']) ? $_POST['usersFilterLastName'] : 'all',
        ]); ?>
    </div>
</div>
<?php if ($module::$users): ?>
    <?php echo template::table([1, 2, 3, 3, 3], $module::$users, ['', 'Id', 'Prénom', 'Nom', 'Étiquettes'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>