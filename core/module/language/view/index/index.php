<?php echo template::formOpen('translateForm'); ?>
<div class="row">
	<div class="col1">
		<?php echo template::button('translateFormBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col1">
		<?php /**echo template::button('translateHelp', [
		  'href' => 'https://doc.zwiicms.fr/prise-en-charge-des-langues-etrangeres',
		  'target' => '_blank',
		  'value' => template::ico('help'),
		  'class' => 'buttonHelp',
		  'help' => 'Consulter l\'aide en ligne'
		  ]);*/?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Langues installées'); ?>
			</h4>
			<?php if ($module::$languagesUiInstalled): ?>
				<?php echo template::table([2, 1, 1, 4, 1, 1, 1], $module::$languagesUiInstalled, ['Langues', 'Version', 'Date', '', '', '', '']); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Catalogue'); ?>
			</h4>
			<?php if ($module::$languagesStore): ?>
				<?php echo template::table([2, 1, 2, 6, 1], $module::$languagesStore, ['Langues', 'Version', 'Date', '', '']); ?>
			<?php endif; ?>
		</div>
	</div>
</div>


<?php echo template::formClose(); ?>