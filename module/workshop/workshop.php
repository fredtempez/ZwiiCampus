<?php

/**
 * This file is part of Zwii.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2024, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */

class workshop extends common
{
	const VERSION = '1.01';
	const REALNAME = 'Liste des espaces';
	const DATADIRECTORY = ''; // Contenu localisé inclus par défaut (page.json et module.json)

	public static $actions = [
		'config' => self::GROUP_ADMIN,
		'index' => self::GROUP_VISITOR
	];

	public static $courseCategories = [
		'all' => 'Toutes les catégories'
	];

	public static $coursesLayout = [
		12 => 'Un contenu par ligne',
		6 => 'Deux contenu par ligne',
		4 => 'Trois contenu par ligne',
		3 => 'Quatre contenu par ligne',
		2 => 'Six contenu par ligne',
	];

	public static $coursesAccess = [];

	public static $coursesEnrolment = [];

	public static $default = [
		'config' => array(
			'category' => 'general',
			'title' => true,
			'author' => true,
			'description' => true,
			'access' => true,
			'enrolment' => true,
			'layout' => 6,
			'template' => true,
			'unsuscribe' => false,
		),
		'caption' => array(
			'accessopen' => 'Ouvert',
			'accessdate' => 'P&eacute;riode d&#039;ouverture du %s au %s',
			'accessclose' => 'Ferm&eacute;',
			'enrolguest' => 'Anonyme',
			'enrolself' => 'Membres',
			'enrolselfkey' => 'Membres avec cl&eacute;',
			'enrolMandatory' => 'Inscription par l\'enseignant',
			'url' => 'Acc&eacute;der au contenu',
			'unsuscribe' => 'Me d&eacute;sinscrire',
			'enrolmentLimit' => 'Date limite des inscriptions',
		)
	];

	/**
	 * Configuration
	 */
	public function config()
	{

		// Contrôle de la configuration par défaut
		$this->update();

		// Soumission du formulaire
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
			$this->isPost()
		) {
			$this->setData([
				'module',
				$this->getUrl(0),
				'config',
				[
					'category' => $this->getInput('coursesConfigCategories'),
					'title' => $this->getInput('coursesConfigShowTitle', helper::FILTER_BOOLEAN),
					'author' => $this->getInput('coursesConfigShowAuthor', helper::FILTER_BOOLEAN),
					'description' => $this->getInput('coursesConfigShowDescription', helper::FILTER_BOOLEAN),
					'unsuscribe'=> $this->getInput('coursesConfigShowUnsuscribe', helper::FILTER_BOOLEAN),
					'access' => $this->getInput('coursesConfigShowAccess', helper::FILTER_BOOLEAN),
					'openingdate' => $this->getInput('coursesConfigShowOpeningDate', helper::FILTER_BOOLEAN),
					'closingdate' => $this->getInput('coursesConfigShowClosingDate', helper::FILTER_BOOLEAN),
					'enrolment' => $this->getInput('coursesConfigShowEnrolment', helper::FILTER_BOOLEAN),
					'caption' => $this->getInput('coursesConfigCaption', helper::FILTER_STRING_SHORT),
					'layout' => $this->getInput('coursesConfigLayout', helper::FILTER_INT),
					'template' => $this->getInput('coursesConfigTemplate', helper::FILTER_BOOLEAN),
				]
			]);
			$this->setData([
				'module',
				$this->getUrl(0),
				'caption',
				[
					'accessopen' => $this->getInput('coursesCaptionAccessOpen', helper::FILTER_STRING_SHORT),
					'accessdate' => $this->getInput('coursesCaptionAccessDate', helper::FILTER_STRING_SHORT),
					'accessclose' => $this->getInput('coursesCaptionAccessClose', helper::FILTER_STRING_SHORT),
					'enrolguest' => $this->getInput('coursesCaptionGuest', helper::FILTER_STRING_SHORT),
					'enrolself' => $this->getInput('coursesCaptionSelf', helper::FILTER_STRING_SHORT),
					'enrolselfkey' => $this->getInput('coursesCaptionSelfKey', helper::FILTER_STRING_SHORT),
					'enrolMandatory' => $this->getInput('coursesCaptionMandatory', helper::FILTER_STRING_SHORT),
					'url' => $this->getInput('coursesCaptionUrl', helper::FILTER_STRING_SHORT),
					'unsuscribe' => $this->getInput('coursesCaptionUnsuscribe', helper::FILTER_STRING_SHORT),
					'enrolmentLimit' => $this->getInput('coursesCaptionEnrolmentLimit', helper::FILTER_STRING_SHORT),
				]
			]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => helper::translate('Modifications enregistrées'),
				'state' => true
			]);
		}
		// Liste des catégories de contenu
		self::$courseCategories = array_merge(self::$courseCategories, $this->getData(['category']));

		// Valeurs en sortie
		$this->addOutput([
			'title' => helper::translate('Configuration du module'),
			'view' => 'config'
		]);
	}
	public function index()
	{
		// Contrôle de la configuration par défaut
		$this->update();

		// Mise à jour des étiquettes
		self::$coursesAccess[self::COURSE_ACCESS_OPEN] = $this->getData(['module', $this->getUrl(0), 'caption', 'accessopen']);
		self::$coursesAccess[self::COURSE_ACCESS_DATE] = $this->getData(['module', $this->getUrl(0), 'caption', 'accessdate']);
		self::$coursesAccess[self::COURSE_ACCESS_CLOSE] = $this->getData(['module', $this->getUrl(0), 'caption', 'accessclose']);
		self::$coursesEnrolment[self::COURSE_ENROLMENT_GUEST] = $this->getData(['module', $this->getUrl(0), 'caption', 'enrolguest']);
		self::$coursesEnrolment[self::COURSE_ENROLMENT_SELF] = $this->getData(['module', $this->getUrl(0), 'caption', 'enrolself']);
		self::$coursesEnrolment[self::COURSE_ENROLMENT_SELF_KEY] = $this->getData(['module', $this->getUrl(0), 'caption', 'enrolselfkey']);
		self::$coursesEnrolment[self::COURSE_ENROLMENT_MANDATORY] = $this->getData(['module', $this->getUrl(0), 'caption', 'enrolMandatory']);

		// Valeurs en sortie
		$this->addOutput([
			'showBarEditButton' => true,
			'showPageContent' => true,
			'view' => 'index'
		]);


		// Valeurs en sortie
		$this->addOutput([
			'showBarEditButton' => true,
			'showPageContent' => true,
			'view' => 'index',
		]);
	}

	// Initialise avec des valeurs par défaut
	private function update()
	{
		$check = false;
		foreach (self::$default['config'] as $key => $value) {
			if (is_null($this->getData(['module', $this->getUrl(0), 'config', $key]))) {
				$this->setData(['module', $this->getUrl(0), 'config', $key, $value]);
				$check = true;
			}
		}
		foreach (self::$default['caption'] as $key => $value) {
			if (is_null($this->getData(['module', $this->getUrl(0), 'caption', $key]))) {
				$this->setData(['module', $this->getUrl(0), 'caption', $key, $value]);
				$check = true;
			}
		}
		if ($check) {
			header('refresh:0');
		}
	}
}