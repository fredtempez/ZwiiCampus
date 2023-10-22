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
	<div class="col8">
		<div class="block">
			<h4>
				<?php echo helper::translate('Elements à afficher'); ?>
			</h4>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowTitle', true, 'Titre', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'title']),
						'help' => 'Classe CSS de l\'élément en ligne : workshopTitle'
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowAuthor', true, 'Signature de l\'auteur', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'author']),
						'help' => 'Classe CSS de l\'élément en ligne : workshopTitle'
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowDescription', true, 'Description', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'description']),
						'help' => 'Classe CSS de l\'élément en ligne : workshopDescription'
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col4">
					<?php echo template::checkbox('coursesConfigShowAccess', true, 'Modalités d\'ouverture', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'access']),
						'help' => 'Classes CSS de la division workshopAccessContainer, élément en ligne workshopAccess'
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('coursesConfigShowEnrolment', true, 'Modalités d\'inscription', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'enrolment']),
						'help' => 'Classe CSS de l\'élément en ligne : workshopEnrolment'
					]); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col4">
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
					<?php echo template::checkbox('coursesConfigTemplate', true, 'Mise en évidence', [
						'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'template']),
						'help' => 'Template identique à TinyMCE avec une bordure et le titre en évidence. Classe de la division : workshopItemContainer'
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Étiquettes  : disponibilité du cours'); ?>
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
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'accessdate']),
						'help' => 'Insérer deux symboles %s pour placer les dates d\'ouverture et de fermeture',
						'placeholder' => 'Ouvre le %s et ferme le %s'
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
						<?php echo helper::translate('Étiquettes  : modalités d\'inscription'); ?>
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
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'url']),
						'help' => 'Classe CSS de la division : workshopSuscribe'
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::text('coursesCaptionUnsuscribe', [
						'label' => 'Désinscription',
						'value' => $this->getData(['module', $this->getUrl(0), 'caption', 'unsuscribe']),
						'help' => 'Classe CSS de la division : workshopUnsuscribe'
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo template::formClose(); ?>
<div class="moduleVersion">Version n°
	<?php echo $module::VERSION; ?>
</div>