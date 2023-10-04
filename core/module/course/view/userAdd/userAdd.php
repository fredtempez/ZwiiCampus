<?php echo template::formOpen('courseUserAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('courseUserAddSubmit'); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Utilisateurs'); ?>
            </h4>
        </div>
    </div>
</div>