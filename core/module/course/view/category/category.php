<div class="row">
    <div class="col1">
        <?php echo template::button('courseCategoryModulesBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::button('courseCategoryModulesAdd', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'courseCategoryadd',
            'value' => template::ico('plus')
        ]); ?>
    </div>
</div>
<?php echo template::table([12], $module::$courseCategories, ['Titre']); ?>