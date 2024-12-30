<?php echo template::formOpen('usersTagForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('userDeleteBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'user/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>Étiquette de remplacement</h4>
            <div class="row">
                <div class="col8">
                    <?php echo template::text('usersTagLabel', [
                        'placeholder' => 'Les étiquettes saisis remplaceront celles existantes. Les étiquettes sont séparées par des espaces'
                    ]); ?>
                </div>
                <div class="col2 offset2 verticalAlignBottom">
                    <?php echo template::submit('usersTagSubmit'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="Bfrtip">
    <div class="col3">
        <?php echo template::select('usersFilterGroup', user::$usersGroups, [
            'label' => 'Groupes / Profils',
            'selected' => isset($_POST['usersFilterGroup']) ? $_POST['usersFilterGroup'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('usersFilterFirstName', user::$alphabet, [
            'label' => 'Prénom commence par',
            'selected' => isset($_POST['usersFilterFirstName']) ? $_POST['usersFilterFirstName'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('usersFilterLastName', user::$alphabet, [
            'label' => 'Nom commence par',
            'selected' => isset($_POST['usersFilterLastName']) ? $_POST['usersFilterLastName'] : 'all',
        ]); ?>
    </div>
    <div class="col1 offset1 verticalAlignBottom">
        <?php echo template::button('usersTagSelectAll', [
            'value' => template::ico('square-check'),
            'help' => 'Tout sélectionner'
        ]); ?>
    </div>
    <div class="col1 verticalAlignBottom">
        <?php echo template::button('usersTagSelectNone', [
            'value' => template::ico('square-check-empty'),
            'help' => 'Tout désélectionner'
        ]); ?>
    </div>
</div>
<?php if (user::$users): ?>
    <?php echo template::table([1, 2, 3, 3, 3], user::$users, ['', 'Id', 'Prénom', 'Nom', 'Étiquettes'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>