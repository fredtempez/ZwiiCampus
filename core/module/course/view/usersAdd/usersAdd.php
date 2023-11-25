<?php echo template::formOpen('courseUsersAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/users/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset7">
        <?php echo template::button('courseUserAddSelectAll', [
            'value' => 'Tout'
        ]); ?>
    </div>
    <div class="col1">
        <?php echo template::button('courseUserAddSelectNone', [
            'value' => 'Aucun'
        ]); ?>
    </div>
    <div class="col2">
        <?php echo template::submit('courseUsersAddSubmit', [
            'value' => 'Inscrire'
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
    <?php echo template::table([1, 4, 4, 3], $module::$courseUsers, ['', 'Id', 'Prénom', 'Nom'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>