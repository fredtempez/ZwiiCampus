<?php echo template::formOpen('groupAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('groupAddSubmit'); ?>
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
                    <?php echo template::text('groupAddTitle', [
                        'label' => 'Nom du groupe',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>