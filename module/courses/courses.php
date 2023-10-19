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

class courses extends common
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
		1 => 'Une colonne',
		2 => 'Deux colonnes',
		3 => 'Trois colonnes',
		4 => 'Quatre colonnes',
		5 => 'Cinq colonnes',
		6 => 'Six colonnes',
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
					'shortTitle' => $this->getInput('coursesConfigShowShortTitle', helper::FILTER_BOOLEAN),
					'author' => $this->getInput('coursesConfigShowAuthor', helper::FILTER_BOOLEAN),
					'description' => $this->getInput('coursesConfigShowDescription', helper::FILTER_BOOLEAN),
					'access' => $this->getInput('coursesConfigShowAccess', helper::FILTER_BOOLEAN),
					'opening' => $this->getInput('coursesConfigShowOpening', helper::FILTER_BOOLEAN),
					'closing' => $this->getInput('coursesConfigShowClosing', helper::FILTER_BOOLEAN),
					'enrolment' => $this->getInput('coursesConfigShowEnrolment', helper::FILTER_BOOLEAN),
					'urlText' => $this->getInput('coursesConfigUrlText', helper::FILTER_STRING_SHORT),
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