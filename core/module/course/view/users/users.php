<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset8">
        <?php echo template::button('userDeleteAll', [
            'href' => helper::baseUrl() . 'course/usersReportExport/' . $this->getUrl(2),
            'value' => template::ico('download'),
            'help' => 'Exporter',
        ]) ?>
    </div>
    <div class="col1">
        <?php echo template::button('userDeleteAll', [
            'class' => 'userDeleteAll buttonRed',
            'href' => helper::baseUrl() . 'course/usersDelete/' . $this->getUrl(2),
            'value' => template::ico('users'),
            'help' => 'Désinscrire en masse',
        ])?>
    </div>
    <div class="col1">
        <?php echo template::button('userDeleteAll', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'course/usersAdd/' . $this->getUrl(2),
            'value' => template::ico('users'),
            'help' => 'Inscription en masse',
        ]) ?>
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
    <?php echo template::table([3, 4, 1, 1, 1, 1, 1], $module::$courseUsers, ['Nom Prénom', 'Dernière page vue', 'Date' , 'Heure', 'Étiquettes', 'Progression', ''], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun participant'); ?>
<?php endif; ?>