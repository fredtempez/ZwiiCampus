<?php echo template::formOpen('sliderThemeForm'); ?>
<div class="row">
	<div class="col1">
		<?php echo template::button('sliderThemeBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'value' => template::ico('left')
		]); ?>
	</div>
	<div class="col2 offset9">
		<?php echo template::submit('sliderThemeSubmit'); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>Paramètres</h4>
			<div class="row">
				<div class="col3">
					<?php echo template::select('sliderThememaxWidth', slider::$screenWidth, [
						'label' => 'Largeur',
						'selected' => slider::$selectedMaxwidth,
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemeAuto', slider::$auto, [
						'label' => 'Automatisation',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'auto']),
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemeDiapoTime', slider::$timeout, [
						'label' => 'Image fixe',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'timeout'])
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemespeed', slider::$speed, [
						'label' => 'Transition ',
						'help' => 'Cette durée doit être inférieure au temps fixe',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'speed'])
					]); ?>
				</div>
			</div>
			<div class="row">

			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>Navigation</h4>
			<div class="row">
				<div class="col3">
					<?php echo template::select('sliderThemeSort', slider::$sort, [
						'label' => 'Tri des images',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'sort'])
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemePager', slider::$pager, [
						'label' => 'Puces horizontales',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'pager']),
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemeNameSpace', slider::$namespace, [
						'label' => 'Boutons latéraux',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'namespace'])
					]); ?>
				</div>
				<div class="col3">
					<?php echo template::select('sliderThemeCaption', slider::$caption, [
						'label' => 'Légendes',
						'selected' => $this->getData(['module', $this->getUrl(0), 'theme', 'caption'])
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php echo template::formClose(); ?>