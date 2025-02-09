<div class="row">
	<div class="col1">
		<?php echo template::button('groupBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col1 offset10">
		<?php if ($this->getUser('permission', 'group', 'add') === true): ?>
			<?php echo template::button('groupAdd', [
				'class' => 'buttonGreen',
				'href' => helper::baseUrl() . 'group/add',
				'value' => template::ico('plus'),
				'help' => 'Ajouter un groupe'
			]); ?>
		<?php endif; ?>
	</div>
</div>
<?php if (group::$groups): ?>
	<?php echo template::table([6, 1, 1, 1, 1], group::$groups, ['Groupe', '', '', '', '',], ['id' => 'dataTables']); ?>
<?php else: ?>
	<?php echo template::speech('Aucun groupe'); ?>
<?php endif; ?>