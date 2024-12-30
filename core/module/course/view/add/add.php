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
                        'label' => 'Titre'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col7">
                    <?php echo template::text('courseAddShortTitle', [
                        'label' => 'Titre court'
                    ]); ?>
                </div>
                <div class="col5">
                    <?php echo template::select('courseAddAuthor', course::$courseTeachers, [
                        'label' => 'Auteur'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('courseAddTheme', course::$courses, [
                        'label' => 'Copier le thème depuis',
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('courseAddCategorie', course::$courseCategories, [
                        'label' => 'Catégorie',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::textarea('courseAddDescription', [
                        'label' => 'Description'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseAddAccess', course::$courseAccess, [
                        'label' => 'Accès'
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseAddOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouverture',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseAddClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fermeture',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('courseAddEnrolment', course::$courseEnrolment, [
                        'label' => 'Participation'
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('courseAddEnrolmentKey', [
                        'label' => 'Clé'
                    ]); ?>
                </div>
            </div>
            <div class="row">
            <div class="col4">
                    <?php echo template::checkbox('courseAddEnrolmentReport', true, 'Rapport des consultations', [
                        'help' => 'Enregistre une trace des consultations. Ne s\'applique pas à l\'inscription anonyme',
                        'checked' => true
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::checkbox('courseAddEnrolmentLimit', true, 'Date de fin d\'inscription', [
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseAddEnrolmentLimitDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fermeture',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo template::formClose(); ?>