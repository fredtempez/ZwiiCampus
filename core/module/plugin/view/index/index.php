<div class="row">
	<div class="col1">
		<?php echo template::button('configModulesBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col1">
		<?php /**echo template::button('pluginHelp', [
			 'href' => 'https://doc.zwiicms.fr/gestion-des-modules',
			 'target' => '_blank',
			 'value' => template::ico('help'),
			 'class' => 'buttonHelp',
			 'help' => 'Consulter l\'aide en ligne'
		 ]);*/?>
	</div>
	<div class="col1 offset8">
		<?php echo template::button('pluginModulesStore', [
			'href' => helper::baseUrl() . 'plugin/store',
			'value' => template::ico('shopping-basket'),
			'help' => 'Installer depuis le catalogue en ligne'
		]); ?>
	</div>
	<div class="col1">
		<?php echo template::button('pluginStoreUpload', [
			'href' => helper::baseUrl() . 'plugin/upload',
			'value' => template::ico('file-archive'),
			'help' => 'Installer depuis une archive'
		]); ?>
	</div>
</div>
<?php if (plugin::$modulesInstalled): ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>
					<?php echo helper::translate('Sauvegarde'); ?>
				</h4>
				<?php echo template::table([4, 4, 3, 1], plugin::$modulesInstalled, ['Module', 'Identifiant', 'Version',  '']); ?>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Aucun module installé.'); ?>
<?php endif; ?>
<?php if (plugin::$modulesOrphan): ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>
					<?php echo helper::translate('Modules orphelins'); ?>
				</h4>
				<?php echo template::table([4, 4, 3, 1], plugin::$modulesOrphan, ['Module', 'Identifiant', 'Version', '']); ?>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Aucun module orphelin.'); ?>
<?php endif; ?>