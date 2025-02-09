<?php echo template::formOpen('groupEditForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupEditBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('groupEditSubmit'); ?>
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
                    echo template::text('groupEditTitle', [
                        'label' => 'Nom du groupe',
                        'value' => $this->getData(['group',$this->getUrl(2)])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>