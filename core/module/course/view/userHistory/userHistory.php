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
            <?php echo template::table([1, 6, 5], $module::$userHistory, ['Ordre', 'Titre de la page', 'Dernière consultation de cette page'], ['id' => 'dataTables']); ?>
        </div>
    </div>
<?php else: ?>
    <?php echo template::speech('Aucun historique'); ?>
<?php endif; ?>