<div class="row">
	<div class="col1">
		<?php echo template::button('groupBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'user',
			'value' => template::ico('address-book')
		]); ?>
	</div>
	<div class="col1 offset9">
		<?php echo template::button('groupImport', [
			'href' =>helper::baseUrl() . 'group/import',
			'value' => template::ico('download-cloud'),
			'help' => 'Créer et affecter des groupes par importation de fichier CSV'
		]); ?>
	</div>	
	<div class="col1">
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
	<div class="row">
		<div class="col12">
			<?php echo template::table([2, 6, 3, 1], group::$groups, ['Id', 'Nom', 'Inscription', ''], ['id' => 'dataTables'], ['id', 'group', 'suscribers', 'commandContainer']); ?>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Aucun groupe'); ?>
<?php endif; ?>