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
            'help' => 'Exporter rapports',
        ]) ?>
    </div>
    <div class="col1">
        <?php echo template::button('userDeleteAll', [
            'class' => 'userDeleteAll buttonRed',
            'href' => helper::baseUrl() . 'course/usersDelete/' . $this->getUrl(2),
            'value' => template::ico('user-times'),
            'help' => 'Désinscrire en masse',
        ])?>
    </div>
    <div class="col1">
        <?php echo template::button('userDeleteAll', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'course/usersAdd/' . $this->getUrl(2),
            'value' => template::ico('user-plus'),
            'help' => 'Inscription en masse',
        ]) ?>
    </div>
</div>
<?php echo template::formOpen('courseFilterUserForm'); ?>
<div class="row" id="Bfrtip">
    <div class="col3">
        <?php echo template::select('courseFilterGroup', course::$courseGroups, [
            'label' => 'Rôles/ Profils',
            'selected' => isset($_POST['courseFilterGroup']) ? $_POST['courseFilterGroup'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('courseFilterFirstName', course::$alphabet, [
            'label' => 'Prénom commence par',
            'selected' => isset($_POST['courseFilterFirstName']) ? $_POST['courseFilterFirstName'] : 'all',
        ]); ?>
    </div>
    <div class="col3">
        <?php echo template::select('courseFilterLastName', course::$alphabet, [
            'label' => 'Nom commence par',
            'selected' => isset($_POST['courseFilterLastName']) ? $_POST['courseFilterLastName'] : 'all',
        ]); ?>
    </div>
</div>
<?php echo template::formClose(); ?>
<?php if (course::$courseUsers): ?>
    <?php echo template::table([2, 2, 1, 2, 2, 1, 1], course::$courseUsers, ['Nom Prénom', 'Groupes', 'Étiquettes', 'Dernière page vue', 'Date' , 'Progression', ''], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun participant'); ?>
<?php endif; ?>