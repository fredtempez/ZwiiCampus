<div class="row">
    <div class="col1">
        <?php echo template::button('courseBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl(),
            'value' => template::ico('home')
        ]); ?>
    </div>
    <div class="col1 offset8">
        <?php if ($this->getUser('permission', 'course', 'category') === true): ?>
            <?php echo template::button('courseCategory', [
                'href' => helper::baseUrl() . 'course/category',
                'value' => template::ico('table'),
                'help' => 'Catégories des espaces'
            ]); ?>
        <?php endif; ?>
    </div>
    <div class="col1">
        <?php if ($this->getUser('permission', 'course', 'restore') === true): ?>
            <?php echo template::button('courseUpload', [
                'href' => helper::baseUrl() . 'course/restore/',
                'value' => template::ico('upload-cloud'),
                'help' => 'Restaurer un espace'
            ]); ?>
        <?php endif; ?>
    </div>
    <div class="col1">
        <?php if ($this->getUser('permission', 'course', 'add') === true): ?>
            <?php echo template::button('courseAdd', [
                'class' => 'buttonGreen',
                'href' => helper::baseUrl() . 'course/add',
                'value' => template::ico('plus'),
                'help' => 'Ajouter un espace'
            ]); ?>
        <?php endif; ?>
    </div>
</div>
<?php if (course::$courses): ?>
    <?php echo template::table([4, 4, 3, 1], course::$courses, ['Titre court', 'Description', 'Inscription', ''], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun espace'); ?>
<?php endif; ?>