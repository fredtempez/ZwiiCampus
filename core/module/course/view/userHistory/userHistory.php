<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserHistoryBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/users/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::button('userDeleteAll', [
            'href' => helper::baseUrl() . 'course/userHistoryExport/'  . $this->getUrl(2) . '/' . $this->getUrl(3),
            'value' => template::ico('download'),
            'help' => 'Exporter',
        ]) ?>
    </div>
</div>
<?php if ($module::$userHistory): ?>
    <div class="row textAlignCenter">
        <div class="col8">
            <?php echo template::table([1, 6, 5], $module::$userHistory, ['Ordre', 'Page', 'Consultation'], ['id' => 'dataTables']); ?>
        </div>
    </div>
<?php else: ?>
    <?php echo template::speech('Aucun historique'); ?>
<?php endif; ?>