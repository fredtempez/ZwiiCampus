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
                <div class="col8">
                    <?php echo template::text('courseAddTitle', [
                        'label' => 'Titre'
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('courseAddAccess', $module::$courseTeachers, [
                        'label' => 'Mentor'
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
                    <?php echo template::select('courseAddAccess', $module::$courseAccess, [
                        'label' => 'Accès'
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseOpeningDate', [
                        'type' => 'date',
                        'label' => 'Ouverture',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'date',
                        'label' => 'Fermeture',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('courseAddEnrolment', $module::$courseEnrolment, [
                        'label' => 'Inscription'
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('courseAddEnrolmentKey', [
                        'label' => 'Clé'
                    ]); ?>
                </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>