<div class="row">
    <div class="col1">
        <?php echo template::button('categoryBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::button('categoryAdd', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'course/categoryAdd',
            'value' => template::ico('plus')
        ]); ?>
    </div>
</div>

<?php if($module::$courseCategories): ?>
	<?php echo template::table([5,5,1,1], $module::$courseCategories, ['Id', 'Titre', '','']); ?>
<?php else: ?>
	<?php echo template::speech('Aucune catégorie'); ?>
<?php endif; ?>