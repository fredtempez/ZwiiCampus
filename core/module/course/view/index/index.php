<div class="row">
    <div class="col1">
        <?php echo template::button('courseModulesBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::button('courseModulesAdd', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'course/add',
            'value' => template::ico('plus')
        ]); ?>
    </div>
</div>
<?php echo template::table([3 , 3, 4, 1, 1], $module::$courses, ['Titre court', 'Auteur', 'Description', '', '']); ?>