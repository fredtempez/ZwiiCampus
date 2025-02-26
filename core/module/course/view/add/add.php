<?php echo template::formOpen('courseAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('courseAddSubmit'); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Paramètres'); ?>
            </h4>
            <div class="row">
                <div class="col12">
                    <?php echo template::text('courseAddTitle', [
                        'label' => 'Titre',
                    ]); ?>
                </div>

            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::textarea('courseAddDescription', [
                        'label' => 'Description',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseAddAuthor', course::$courseTeachers, [
                        'label' => 'Auteur',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('courseAddCategorie', course::$courseCategories, [
                        'label' => 'Catégorie',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('courseAddTheme', course::$courses, [
                        'label' => 'Copier le thème depuis l\'espace',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('courseAddEnrolmentReport', true, 'Statistique des consultations', [
                        'checked' => true,
                        'help' => 'Enregistre une trace des consultations. Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Disponibilité'); ?>
            </h4>
            <div class="row">
                <div class="col3">
                    <?php echo template::select('courseAddAccess', course::$courseAccess, [
                        'label' => 'Modalité',
                    ]); ?>
                </div>
                <div class="col2 periodSetup">
                    <?php echo template::date('courseOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouvre le',
                        'value' => time()
                    ]); ?>
                </div>
                <div class="col2 periodSetup">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ferme le',
                        'value' => time()
                    ]); ?>
                </div>
                <div class="col3 periodSetup">
                    <?php echo template::checkbox('courseAddEnrolmentLimit', true, 'Date limite d\'inscription', [
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col2 periodSetup">
                    <?php echo template::date('courseAddEnrolmentLimitDate', [
                        'type' => 'datetime-local',
                        'label' => 'Jusqu\'au',
                        'value' => time()
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Inscription'); ?>
            </h4>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseAddEnrolment', course::$courseEnrolment, [
                        'label' => 'Méthode',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('courseAddEnrolmentKey', [
                        'label' => 'Clé',
                    ]); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Restriction de groupe'); ?>
            </h4>
            <div class="row">
                <div class="col12">
                    <?php echo template::label('courseManageGroups', 'Accès limité aux groupes cochés :', [
                        'help' => 'Pas de restriction si aucun groupe n\'est cochée, sinon accès limité à un ou aux groupes cochés.',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <?php foreach (course::$userGroups as $groupId): ?>
                    <div class="col2">
                        <?php echo ($groupId); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>