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
    <?php echo template::table([6, 6], $module::$userHistory, ['Page', 'Dernière consultation de cette page'], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun historique'); ?>
<?php endif; ?>