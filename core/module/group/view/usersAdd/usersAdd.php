<?php echo template::formOpen('groupUsersAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupUserAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group/',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::submit('groupUsersAddSubmit', [
            'value' => '',
            'ico' => 'user-plus',
        ]); ?>
    </div>
</div>
<div class="row" id="Bfrtip">
    <div class="col3">
        <?php echo template::select('groupFilterGroup', group::$groupRoles, [
            'label' => 'Rôles/ Profils',
            'selected' => isset($_POST['groupFilterGroup']) ? $_POST['groupFilterGroup'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('groupFilterFirstName', group::$alphabet, [
            'label' => 'Prénom commence par',
            'selected' => isset($_POST['groupFilterFirstName']) ? $_POST['groupFilterFirstName'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('groupFilterLastName', group::$alphabet, [
            'label' => 'Nom commence par',
            'selected' => isset($_POST['groupFilterLastName']) ? $_POST['groupFilterLastName'] : 'all',
        ]); ?>
    </div>
    <div class="col1 offset1 verticalAlignBottom">
        <?php echo template::button('groupUserAddSelectAll', [
            'value' => template::ico('square-check'),
            'help' => 'Tout sélectionner'
        ]); ?>
    </div>
    <div class="col1 verticalAlignBottom">
        <?php echo template::button('groupUserAddSelectNone', [
            'value' => template::ico('square-check-empty'),
            'help' => 'Tout désélectionner'
        ]); ?>
    </div>
</div>
<?php if (group::$groupUsers): ?>
    <?php echo template::table([1, 4 , 4, 3], group::$groupUsers, ['', 'Nom/Prénom', 'Groupes', 'Étiquette'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>