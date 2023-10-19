<?php echo template::formOpen('coursesConfig'); ?>
<div class="row">
	<div class="col1">
		<?php echo template::button('coursesConfigBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
			'value' => template::ico('left')
		]); ?>
	</div>
	<div class="col2 offset9">
		<?php echo template::submit('coursesConfigSubmit'); ?>
	</div>
</div>
<div class="row">
	<div class="col6">
		<?php echo template::select('coursesConfigCategories', $module::$courseCategories, [
			'label' => 'Catégorie à afficher',
			'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'category'])
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Disponibilité du cours'); ?>
			</h4>
			<div class="row">
				<div class="col4">
					<?php echo template::text('coursesCaptionAccessOpen', [
						'label' => 'Ouvert',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'accessopen'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::text('coursesCaptionAccessDate', [
						'label' => 'Période',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'accessdate'])
					]); ?>
				</div>

				<div class="col4">
					<?php echo template::text('coursesCaptionAccessClose', [
						'label' => 'Fermé',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'accessclose'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<h4>
						<?php echo helper::translate('Modalité d\'accès'); ?>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col4">
					<?php echo template::text('coursesCaptionGuest', [
						'label' => 'Anonyme',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'enrolguest'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::text('coursesCaptionSelf', [
						'label' => 'Membre',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'enrolself'])
					]); ?>
				</div>

				<div class="col4">
					<?php echo template::text('coursesCaptionSelfKey', [
						'label' => 'Membre avec clé',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'enrolselfkey'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col4">
					<?php echo template::text('coursesCaptionUrl', [
						'label' => 'Lien vers le cours',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'url'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::text('coursesCaptionUnsuscribe', [
						'label' => 'Désinscription',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'unsuscribe'])
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Elements à afficher'); ?>
			</h4>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowTitle', true, 'Titre', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'title'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowAuthor', true, 'Signature de l\'auteur', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'author'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowDescription', true, 'Description', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'description'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col4">
					<?php echo template::checkbox('coursesConfigShowAccess', true, 'Modalités d\'ouverture', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'access'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::checkbox('coursesConfigShowOpeningDate', true, 'Date d\'ouverture', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'openingdate']),
						'help' => 'Affiché si l\'accès est limité dans le temps',
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::checkbox('coursesConfigShowClosingDate', true, 'Date de fermeture', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'closingdate']),
						'help' => 'Affiché si l\'accès est limité dans le temps',
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowEnrolment', true, 'Modalités d\'inscription', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'enrolment'])
					]); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Thème'); ?>
			</h4>

			<div class="row">
				<div class="col12">
					<?php echo template::select('coursesConfigLayout', $module::$coursesLayout, [
						'label' => 'Présentation en colonnes',
						'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'layout']),
						'help' => 'Chaque cours est présenté dans une colonne'
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigTemplate', true, 'Bordure', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'template']),
						'help' => 'Template bordure de TinyMCE, le titre en évidence'
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion">Version n°
	<?php echo $module::VERSION; ?>
</div>