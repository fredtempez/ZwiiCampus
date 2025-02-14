<?php echo template::formOpen('groupUsersForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupUsersBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset8">
        <?php echo template::button('groupUsersBack', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'group/usersAdd/' . $this->getUrl(2),
            'value' => template::ico('user-plus'),
            'help' => 'Inscrire dans le groupe',
        ]); ?>
    </div>
    <div class="col2">
        <?php echo template::submit('groupUsersSubmit',[
            'value' => 'Désinscrire',

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
        <?php echo template::button('groupUsersSelectAll', [
            'value' => template::ico('square-check'),
            'help' => 'Tout sélectionner'
        ]); ?>
    </div>
    <div class="col1 verticalAlignBottom">
        <?php echo template::button('groupUsersSelectNone', [
            'value' => template::ico('square-check-empty'),
            'help' => 'Tout désélectionner'
        ]); ?>
    </div>
</div>
<?php if (group::$groupUsers): ?>
    <?php echo template::table([1, 3, 3, 3, 2], group::$groupUsers, ['', 'Prénom', 'Nom', 'Groupes', 'Étiquettes'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>