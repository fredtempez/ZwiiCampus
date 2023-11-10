<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset9">
        <?php echo template::button('userDeleteAll', [
            'href' => helper::baseUrl() . 'course/userHistoryExport/' . $this->getUrl(2),
            'value' => template::ico('download'),
            'help' => 'Exporter',
        ])
            ?>
    </div>
    <div class="col1">
        <?php echo template::button('userDeleteAll', [
            'class' => 'userDeleteAll buttonRed',
            'href' => helper::baseUrl() . 'course/userDeleteAll/' . $this->getUrl(2),
            'value' => template::ico('trash'),
            'help' => 'Désinscrire tous les utilisateurs',
        ])
            ?>
    </div>
</div>
<?php echo template::formOpen('courseFilterUserForm'); ?>
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
<?php echo template::formClose(); ?>
<?php if ($module::$courseUsers): ?>
    <?php echo template::table([2, 3, 3, 2, 1, 1], $module::$courseUsers, ['Id', 'Nom Prénom', 'Dernière page vue', 'Date - Heure', 'Progression', ''], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>