<?php

/**
 * This file is part of Zwii.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2023, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */

class workshop extends common
{
	const VERSION = '1.0';
	const REALNAME = 'Liste des cours';
	const DATADIRECTORY = ''; // Contenu localisé inclus par défaut (page.json et module.json)

	public static $actions = [
		'config' => self::GROUP_ADMIN,
		'index' => self::GROUP_VISITOR
	];

	public static $courseCategories = [
		'all' => 'Toutes les catégories'
	];

	public static $coursesLayout = [
		12 => 'Un cours par ligne',
		6 => 'Deux cours par ligne',
		4 => 'Trois cours par ligne',
		3 => 'Quatre cours par ligne',
		2 => 'Six cours par ligne',
	];


    public static $coursesAccess = [
        self::COURSE_ACCESS_OPEN => 'ouvert',
        self::COURSE_ACCESS_DATE => 'période d\'ouverture',
        self::COURSE_ACCESS_CLOSE => 'fermé',
    ];

    public static $coursesEnrolment = [
        self::COURSE_ENROLMENT_GUEST => 'anonyme, sans inscription',
        self::COURSE_ENROLMENT_SELF => 'inscription libre',
        self::COURSE_ENROLMENT_SELF_KEY => 'inscription avec clé',
        //self::COURSE_ENROLMENT_MANUAL => 'Manuelle'
    ];

	public static $coursesDetails = [];
	/**
	 * Configuration
	 */
	public function config()
	{
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
					'access' => $this->getInput('coursesConfigShowAccess', helper::FILTER_BOOLEAN),
					'openingdate' => $this->getInput('coursesConfigShowOpeningDate', helper::FILTER_BOOLEAN),
					'closingdate' => $this->getInput('coursesConfigShowClosingDate', helper::FILTER_BOOLEAN),
					'enrolment' => $this->getInput('coursesConfigShowEnrolment', helper::FILTER_BOOLEAN),
					'caption' => $this->getInput('coursesConfigCaption', helper::FILTER_STRING_SHORT),
					'layout' => $this->getInput('coursesConfigLayout', helper::FILTER_INT),
					'template' => $this->getInput('coursesConfigTemplate', helper::FILTER_BOOLEAN),
				]
			]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => helper::translate('Modifications enregistrées'),
				'state' => true
			]);
		}
		// Liste des catégories de cours
		self::$courseCategories = array_merge(self::$courseCategories, $this->getData(['category']));

		// Valeurs en sortie
		$this->addOutput([
			'title' => helper::translate('Configuration du module'),
			'view' => 'config'
		]);
	}
	public function index()
	{
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
}