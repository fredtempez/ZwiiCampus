<?php echo template::formOpen('courseUsersAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/users/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset8">
        <?php echo template::button('courseUserAddSelectAll', [
            'value' => template::ico('square-check'),
            'help' => 'Tout sélectionner'
        ]); ?>
    </div>
    <div class="col1">
        <?php echo template::button('courseUserAddSelectNone', [
            'value' => template::ico('square-check-empty'),
            'help' => 'Tout désélectionner'
        ]); ?>
    </div>
    <div class="col1">
        <?php echo template::submit('courseUsersAddSubmit', [
            'value' => '',
            'ico' => 'plus',
        ]); ?>
    </div>
</div>
<div class="row" id="Bfrtip">
    <div class="col3">
        <?php echo template::select('courseFilterGroup', $module::$courseGroups, [
            'label' => 'Groupes / Profils',
            'selected' => isset($_POST['courseFilterGroup']) ? $_POST['courseFilterGroup'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('courseFilterFirstName', $module::$alphabet, [
            'label' => 'Prénom commence par',
            'selected' => isset($_POST['courseFilterFirstName']) ? $_POST['courseFilterFirstName'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('courseFilterLastName', $module::$alphabet, [
            'label' => 'Nom commence par',
            'selected' => isset($_POST['courseFilterLastName']) ? $_POST['courseFilterLastName'] : 'all',
        ]); ?>
    </div>
</div>
<?php if ($module::$courseUsers): ?>
    <?php echo template::table([1, 2, 3, 3, 3], $module::$courseUsers, ['', 'Id',  'Prénom', 'Nom', 'Étiquettes'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>