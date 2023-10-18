<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserHistoryBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/user/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
</div>
<?php if ($module::$userHistory): ?>
    <div class="row textAlignCenter">
        <div class="col8">
            <?php echo template::table([6, 6], $module::$userHistory, ['Dernière consultation de cette page', 'Titre de la page'], ['id' => 'dataTables']); ?>
        </div>
    </div>
<?php else: ?>
    <?php echo template::speech('Aucun historique'); ?>
<?php endif; ?>