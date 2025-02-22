<?php echo template::formOpen('groupImportForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupImportBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset8">
        <?php echo template::button('groupImporTemplate', [
            'href' => helper::baseUrl() . 'group/template',
            'value' => template::ico('table'),
            'help' => 'Télécharger un modèle'
        ]); ?>
    </div>
    <div class="col2">
        <?php echo template::submit('groupImportSubmit', [
            'value' => 'Importer'
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Importation de fichier plat CSV'); ?>
            </h4>
            <div class="row">
                <div class="col10">
                    <?php echo template::file('groupImportCSVFile', [
                        'label' => 'Utilisateurs et groupes :'
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::select('groupImportSeparator', user::$separators, [
                        'label' => 'Séparateur'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<?php if (group::$groups): ?>
    <div class="row">
        <div class="col12 textAlignCenter">
            <?php echo template::table([1, 2, 2, 1, 1, 1, 2, 1, 1], group::$groups, ['Id', 'Nom', 'Prénom', 'Rôle', 'Profil', 'Pseudo', 'eMail', 'Étiquettes', '']); ?>
            <?php echo template::ico('check'); ?> Compte créé |
            <?php echo template::ico('mail'); ?> Compte créé et notifié |
            <?php echo template::ico('cancel'); ?> Erreur dans le fichier ou le compte existe.
        </div>
    </div>
<?php endif; ?>