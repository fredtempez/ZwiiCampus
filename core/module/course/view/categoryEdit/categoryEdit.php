<?php echo template::formOpen('categoryEditForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('categoryEditBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/category',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('categoryEditSubmit'); ?>
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
                    <?php 
                    echo template::text('categoryEditTitle', [
                        'label' => 'Nom de la catégorie',
                        'value' => $this->getData(['category',$this->getUrl(2)])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>