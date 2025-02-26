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
                <?php echo helper::translate('Fichier CSV'); ?>
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
            <div>Format CSV en UTF8, les clés sont mail_user et id_group ou id_user et id_group.</div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<?php if (group::$groups): ?>
    <div class="row">
        <div class="col12 textAlignCenter">
            <?php echo template::table([4, 4, 4], group::$groups, ['Utilisateur','Groupe', 'Message']); ?>
        </div>
    </div>
<?php endif; ?>