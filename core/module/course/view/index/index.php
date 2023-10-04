<div class="row">
    <div class="col1">
        <?php echo template::button('courseBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset8">
		<?php echo template::button('courseUser', [
			'href' => helper::baseUrl() . 'course/user',
			'value' => template::ico('users'),
			'help' => 'Etudiants inscrits'
		]); ?>
	</div>
    <div class="col1">
		<?php echo template::button('courseCategory', [
			'href' => helper::baseUrl() . 'course/category',
			'value' => template::ico('table'),
			'help' => 'Catégories de cours'
		]); ?>
	</div>
    <div class="col1 ">
        <?php echo template::button('courseAdd', [
            'class' => 'buttonGreen',
            'href' => helper::baseUrl() . 'course/add',
            'value' => template::ico('plus')
        ]); ?>
    </div>
</div>
<?php if($module::$courses): ?>
	<?php echo template::table([2, 1, 3, 4, 1, 1], $module::$courses, ['Titre court', 'Auteur', 'Description', 'Lien direct', '', '']); ?>
<?php else: ?>
	<?php echo template::speech('Aucun Cours'); ?>
<?php endif; ?>
