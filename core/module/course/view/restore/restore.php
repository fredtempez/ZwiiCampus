<?php echo template::formOpen('courseRestoreForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseRestoreBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('courseRestoreSubmit', [
            'value' => 'Valider'
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo sprintf('%s : %s', helper::translate('Restaurer depuis le dossier de l\'espace id'), self::$siteContent ); ?>
            </h4>
            <div class="row">
                <div class="col10 offset1">
                    <?php echo template::file('courseRestoreFile', [
                        'language' => $this->getData(['course', $this->getUser('id'), 'language']),
                        //'label' => 'Fichier de sauvegarde :'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>