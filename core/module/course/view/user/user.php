<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::button('userDeleteAll', [
            'class' => 'userDeleteAll buttonRed',
            'href' => helper::baseUrl() . 'course/userDeleteAll/' . $this->getUrl(2),
            'value' => helper::translate('Réinitialiser'),
            'help' => 'Désinscrire tous les utilisateurs'
        ])
            ?>
    </div>
</div>
<?php echo template::formOpen('courseFilterUserForm'); ?>
<div class="row">
    <div class="col10 offset1">
        <div class="block">
            <h4>
                <?php echo helper::translate('Filtres'); ?>
            </h4>
            <div class="row">
                <div class="col2">
                    <?php echo template::select('courseFilterGroup', $module::$groups, [
                        'label' => 'Groupes / Profils',
                        'selected' => isset($_POST['courseFilterGroup']) ? $_POST['courseFilterGroup'] : self::GROUP_VISITOR,
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::select('courseFilterFirstName', $module::$alphabet, [
                        'label' => 'Prénom commence par',
                        'selected' => isset($_POST['courseFilterFirstName']) ? $_POST['courseFilterFirstName'] : 'A',
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::select('courseFilterLastName', $module::$alphabet, [
                        'label' => 'Nom commence par',
                        'selected' => isset($_POST['courseFilterLastName']) ? $_POST['courseFilterLastName'] : 'A',
                    ]); ?>
                </div>
                <div class="col2 offset4">
                    <?php echo template::submit('courseFilterSubmit', [
                        'uniqueSubmission' => true
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<?php if ($module::$courseUsers): ?>
    <?php echo template::table([2, 3, 3, 3, 1], $module::$courseUsers, ['Id', 'Nom Prénom', 'Id dernière page', 'Date - Heure', '']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>