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
        <?php /*echo template::button('courseUserAdd', [
       'class' => 'buttonGreen',
       'href' => helper::baseUrl() . 'course/userAdd',
       'value' => template::ico('plus')
   ]); */?>
</div>

<?php if ($module::$courseUsers): ?>
    <?php echo template::table([2, 3, 3, 3, 1], $module::$courseUsers, ['Id', 'Nom Prénom', 'Id dernière page', 'Date - Heure', '']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>