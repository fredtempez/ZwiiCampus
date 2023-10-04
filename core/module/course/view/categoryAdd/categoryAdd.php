<?php echo template::formOpen('categoryAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('categoryAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/category',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('categoryAddSubmit'); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Paramètres'); ?>
            </h4>
            <div class="row">
                <div class="col12">
                    <?php echo template::text('categoryAddTitle', [
                        'label' => 'Nom de la catégorie'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>