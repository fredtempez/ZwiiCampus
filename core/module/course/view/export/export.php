<?php echo template::formOpen('courseExportForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseExportBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/manage/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('courseExportSubmit', [
            'value' => 'Valider'
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4><?php echo helper::translate('Sélection des pages de l\'espace') ?></h4>
            <div class='row'>
                <div class='col10 offset2'>
                    <?php foreach ($module::$pagesList as $key => $value) {
                        echo $value;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>