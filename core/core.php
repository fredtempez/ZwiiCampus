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



class common
{

	const DISPLAY_RAW = 0;
	const DISPLAY_JSON = 1;
	const DISPLAY_RSS = 2;
	const DISPLAY_LAYOUT_BLANK = 3;
	const DISPLAY_LAYOUT_MAIN = 4;
	const DISPLAY_LAYOUT_LIGHT = 5;
	const GROUP_BANNED = -1;
	const GROUP_VISITOR = 0;
	const GROUP_MEMBER = 1;
	const GROUP_EDITOR = 2;
	// Groupe MODERATOR, compatibilité avec les anciens modules :
	const GROUP_ADMIN = 3;
	const SIGNATURE_ID = 1;
	const SIGNATURE_PSEUDO = 2;
	const SIGNATURE_FIRSTLASTNAME = 3;
	const SIGNATURE_LASTFIRSTNAME = 4;
	// Dossier de travail
	const BACKUP_DIR = 'site/backup/';
	const DATA_DIR = 'site/data/';
	const FILE_DIR = 'site/file/';
	const TEMP_DIR = 'site/tmp/';
	const I18N_DIR = 'site/i18n/';
	const MODULE_DIR = 'module/';

	// Miniatures de la galerie
	const THUMBS_SEPARATOR = 'mini_';
	const THUMBS_WIDTH = 640;

	// Contrôle d'édition temps maxi en secondes avant déconnexion 30 minutes
	const ACCESS_TIMER = 1800;

	// Numéro de version
	const ZWII_VERSION = '1.0.11';

	// URL autoupdate
	const ZWII_UPDATE_URL = 'https://forge.chapril.org/ZwiiCMS-Team/update/raw/branch/master/lms/';
	const ZWII_UPDATE_CHANNEL = 'v1';

	// Valeurs possibles multiple de 10, 10 autorise 9 profils, 100 autorise 99 profils
	const MAX_PROFILS = 10;

	// Constantes pour les cours

	// Modalités d'ouverture
	const COURSE_ACCESS_OPEN = 0;
	const COURSE_ACCESS_DATE = 1;
	const COURSE_ACCESS_CLOSE = 2;
	// Modalités d'inscription
	const COURSE_ENROLMENT_GUEST = 0;
	const COURSE_ENROLMENT_SELF = 1; // Ouvert à tous les membres
	const COURSE_ENROLMENT_SELF_KEY = 2; // Ouvert à tous les membres disposant de la clé
	const COURSE_ENROLMENT_MANUAL = 3;


	public static $actions = [];
	public static $coreModuleIds = [
		'config',
		'course',
		'dashboard',
		'install',
		'language',
		'maintenance',
		'page',
		'plugin',
		'sitemap',
		'theme',
		'user'
	];
	public static $concurrentAccess = [
		'config',
		'edit',
		'language',
		'plugin',
		'theme',
		'user'
	];
	private $data = [];
	private $hierarchy = [
		'all' => [],
		'visible' => [],
		'bar' => []
	];
	private $input = [
		'_COOKIE' => [],
		'_POST' => []
	];
	public static $inputBefore = [];
	public static $inputNotices = [];
	public static $importNotices = [];
	public static $coreNotices = [];
	public $output = [
		'access' => true,
		'content' => '',
		'contentLeft' => '',
		'contentRight' => '',
		'display' => self::DISPLAY_LAYOUT_MAIN,
		'metaDescription' => '',
		'metaTitle' => '',
		'notification' => '',
		'redirect' => '',
		'script' => '',
		'showBarEditButton' => false,
		'showPageContent' => false,
		'state' => false,
		'style' => '',
		'inlineStyle' => [],
		'inlineScript' => [],
		'title' => null,
		// Null car un titre peut être vide
		// Trié par ordre d'exécution
		'vendor' => [
			'jquery',
			'normalize',
			'lity',
			'filemanager',
			// 'tinycolorpicker', Désactivé par défaut
			// 'tinymce', Désactivé par défaut
			// 'codemirror', // Désactivé par défaut
			'tippy',
			'zwiico',
			'imagemap',
			'simplelightbox'
		],
		'view' => ''
	];
	public static $groups = [
		self::GROUP_BANNED => 'Banni',
		self::GROUP_VISITOR => 'Visiteur',
		self::GROUP_MEMBER => 'Etudiant',
		self::GROUP_EDITOR => 'Enseignant',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupEdits = [
		self::GROUP_BANNED => 'Banni',
		self::GROUP_MEMBER => 'Etudiant',
		self::GROUP_EDITOR => 'Enseignant',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupNews = [
		self::GROUP_MEMBER => 'Etudiant',
		self::GROUP_EDITOR => 'Enseignant',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupPublics = [
		self::GROUP_VISITOR => 'Visiteur',
		self::GROUP_MEMBER => 'Etudiant',
		self::GROUP_EDITOR => 'Enseignant',
		self::GROUP_ADMIN => 'Administrateur'
	];

	//Langues de l'UI
	// Langue de l'interface, tableau des dialogues
	public static $dialog;
	// Langue de l'interface sélectionnée
	public static $i18nUI = 'fr_FR';
	// Langues de contenu
	public static $siteContent = 'home';
	public static $languages = [
		'de' => 'Deutsch',
		'en_EN' => 'English',
		'es' => 'Español',
		'fr_FR' => 'Français',
		'gr_GR' => 'Ελληνικά',
		'it' => 'Italiano',
		'pt_PT' => 'Português',
		'tr_TR' => 'Türkçe',
		// source: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
	];


	// Zone de temps
	public static $timezone;
	private $url = '';
	// Données de site
	private $user = [];

	// Descripteur de données Entrées / Sorties
	// Liste ici tous les fichiers de données
	private $dataFiles = [
		'admin' => '',
		'blacklist' => '',
		'config' => '',
		'core' => '',
		'course' => '',
		'font' => '',
		'module' => '',
		'page' => '',
		'theme' => '',
		'user' => '',
		'language' => '',
		'profil' => '',
		'enrolment' => '',
		'category' => '',
	];

	private $configFiles = [
		'admin' => '',
		'blacklist' => '',
		'config' => '',
		'course' => '',
		'core' => '',
		'font' => '',
		'user' => '',
		'language' => '',
		'profil' => '',
		'enrolment' => '',
		'category' => '',
	];

	private $contentFiles = [
		'page' => '',
		'module' => '',
		'theme' => '',
	];

	public static $fontsWebSafe = [
		'arial' => [
			'name' => 'Arial',
			'font-family' => 'Arial, Helvetica, sans-serif',
			'resource' => 'websafe'
		],
		'arial-black' => [
			'name' => 'Arial Black',
			'font-family' => '\'Arial Black\', Gadget, sans-serif',
			'resource' => 'websafe'
		],
		'courrier' => [
			'name' => 'Courier',
			'font-family' => 'Courier, \'Liberation Mono\', monospace',
			'resource' => 'websafe'
		],
		'courrier-new' => [
			'name' => 'Courier New',
			'font-family' => '\'Courier New\', Courier, monospace',
			'resource' => 'websafe'
		],
		'garamond' => [
			'name' => 'Garamond',
			'font-family' => 'Garamond, serif',
			'resource' => 'websafe'
		],
		'georgia' => [
			'name' => 'Georgia',
			'font-family' => 'Georgia, serif',
			'resource' => 'websafe'
		],
		'impact' => [
			'name' => 'Impact',
			'font-family' => 'Impact, Charcoal, sans-serif',
			'resource' => 'websafe'
		],
		'lucida' => [
			'name' => 'Lucida',
			'font-family' => '\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif',
			'resource' => 'websafe'
		],
		'tahoma' => [
			'name' => 'Tahoma',
			'font-family' => 'Tahoma, Geneva, sans-serif',
			'resource' => 'websafe'
		],
		'times-new-roman' => [
			'name' => 'Times New Roman',
			'font-family' => '\'Times New Roman\', \'Liberation Serif\', serif',
			'resource' => 'websafe'
		],
		'trebuchet' => [
			'name' => 'Trebuchet',
			'font-family' => '\'Trebuchet MS\', Arial, Helvetica, sans-serif',
			'resource' => 'websafe'
		],
		'verdana' => [
			'name' => 'Verdana',
			'font-family' => 'Verdana, Geneva, sans-serif;',
			'resource' => 'websafe'
		]
	];

	// Boutons de navigation dans la page
	public static $navIconTemplate = [
		'open' => [
			'left' => 'left-open',
			'right' => 'right-open',
		],
		'dir' => [
			'left' => 'left',
			'right' => 'right-dir',
		],
		'big' => [
			'left' => 'left-big',
			'right' => 'right-big',
		],
	];

	/**
	 * Constructeur commun
	 */
	public function __construct()
	{

		// Extraction des données http
		if (isset($_POST)) {
			$this->input['_POST'] = $_POST;
		}
		if (isset($_COOKIE)) {
			$this->input['_COOKIE'] = $_COOKIE;
		}

		// Extraction de la sesion
		// $this->input['_SESSION'] = $_SESSION;

		// Déterminer le contenu du site
		if (isset($_SESSION['ZWII_SITE_CONTENT'])) {
			// Déterminé par la session présente
			self::$siteContent = $_SESSION['ZWII_SITE_CONTENT'];
		}
		// Instanciation de la classe des entrées / sorties
		// Les fichiers de configuration
		foreach ($this->configFiles as $module => $value) {
			$this->initDB($module);
		}
		// Les fichiers des cours
		foreach ($this->contentFiles as $module => $value) {
			$this->initDB($module, self::$siteContent);
		}


		// Installation fraîche, initialisation de la configuration inexistante
		// Nécessaire pour le constructeur
		if ($this->user === []) {
			// Charge la configuration
			foreach ($this->configFiles as $stageId => $item) {
				if (file_exists(self::DATA_DIR . $stageId . '.json') === false) {
					$this->saveConfig($stageId);
				}
			}
			// Charge le site d'accueil
			foreach ($this->contentFiles as $stageId => $item) {
				if (
					file_exists(self::DATA_DIR . self::$siteContent . '/' . $stageId . '.json') === false
				) {
					$this->initData($stageId, self::$siteContent);
				}
			}

		}

		// Récupère un utilisateur connecté
		if ($this->user === []) {
			$this->user = $this->getData(['user', $this->getInput('ZWII_USER_ID')]);
		}

		// Langue de l'administration si le user est connecté
		if ($this->getData(['user', $this->getUser('id'), 'language'])) {
			// Langue sélectionnée dans le compte, la langue du cookie sinon celle du compte ouvert
			self::$i18nUI = $this->getData(['user', $this->getUser('id'), 'language']);
			// Validation de la langue
			self::$i18nUI = isset(self::$i18nUI) && file_exists(self::I18N_DIR . self::$i18nUI . '.json')
				? self::$i18nUI
				: 'fr_FR';
		} else {
			if (isset($_SESSION['ZWII_UI'])) {
				self::$i18nUI = $_SESSION['ZWII_UI'];
			} elseif (isset($_COOKIE['ZWII_UI'])) {
				self::$i18nUI = $_COOKIE['ZWII_UI'];
			} else {
				self::$i18nUI = 'fr_FR';
			}
			$_SESSION['ZWII_UI'] = self::$i18nUI;
		}
		// Stocker le cookie de langue pour l'éditeur de texte ainsi que l'url du cours pour le theme
		setcookie('ZWII_UI', self::$i18nUI, time() + 3600, helper::baseUrl(false, false), '', false, false);
		setcookie('ZWII_SITE_CONTENT', self::$siteContent, time() + 3600, helper::baseUrl(false, false), '', false, false);
		setlocale(LC_ALL, self::$i18nUI);
		
		// Construit la liste des pages parents/enfants
		if ($this->hierarchy['all'] === []) {
			$this->buildHierarchy();
		}

		// Construit l'url
		if ($this->url === '') {
			if ($url = $_SERVER['QUERY_STRING']) {
				$this->url = $url;
			} else {
				$this->url = $this->homePageId();
			}
		}

		// Chargement des dialogues
		if (!file_exists(self::I18N_DIR . self::$i18nUI . '.json')) {
			// Copie des fichiers de langue par défaut fr_FR si pas initialisé
			$this->copyDir('core/module/install/ressource/i18n', self::I18N_DIR);
		}
		self::$dialog = json_decode(file_get_contents(self::I18N_DIR . self::$i18nUI . '.json'), true);

		// Dialogue du module
		if ($this->getData(['page', $this->getUrl(0), 'moduleId'])) {
			$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
			if (
				is_dir(self::MODULE_DIR . $moduleId . '/i18n')
				&& file_exists(self::MODULE_DIR . $moduleId . '/i18n/' . self::$i18nUI . '.json')
			) {
				$d = json_decode(file_get_contents(self::MODULE_DIR . $moduleId . '/i18n/' . self::$i18nUI . '.json'), true);
				self::$dialog = array_merge(self::$dialog, $d);
			}
		}

		// Données de proxy
		$proxy = $this->getData(['config', 'proxyType']) . $this->getData(['config', 'proxyUrl']) . ':' . $this->getData(['config', 'proxyPort']);
		if (
			!empty($this->getData(['config', 'proxyUrl'])) &&
			!empty($this->getData(['config', 'proxyPort']))
		) {
			$context = array(
				'http' => array(
					'proxy' => $proxy,
					'request_fulluri' => true,
					'verify_peer' => false,
					'verify_peer_name' => false,
				),
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false
				)
			);
			stream_context_set_default($context);
		}

		// Mise à jour des données core
		include('core/include/update.inc.php');

	}



	/**
	 * Ajoute les valeurs en sortie
	 * @param array $output Valeurs en sortie
	 */
	public function addOutput($output)
	{
		$this->output = array_merge($this->output, $output);
	}

	/**
	 * Ajoute une notice de champ obligatoire
	 * @param string $key Clef du champ
	 */
	public function addRequiredInputNotices($key)
	{
		// La clef est un tableau
		if (preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			if (empty($this->input['_POST'][$firstKey][$secondKey])) {
				common::$inputNotices[$firstKey . '_' . $secondKey] = helper::translate('Obligatoire');
			}
		}
		// La clef est une chaine
		elseif (empty($this->input['_POST'][$key])) {
			common::$inputNotices[$key] = helper::translate('Obligatoire');
		}
	}

	/**
	 * Check du token CSRF (true = bo
	 */
	public function checkCSRF()
	{
		return ((empty($_POST['csrf']) or hash_equals($_POST['csrf'], $_SESSION['csrf']) === false) === false);
	}

	/**
	 * Supprime des données
	 * @param array $keys Clé(s) des données
	 */
	public function deleteData($keys)
	{
		// Descripteur de la base
		$db = $this->dataFiles[$keys[0]];
		// Initialisation de la requête par le nom de la base
		$query = $keys[0];
		// Construire la requête
		for ($i = 1; $i <= count($keys) - 1; $i++) {
			$query .= '.' . $keys[$i];
		}
		// Effacer la donnée
		$success = $db->delete($query, true);
		return is_object($success);
	}

	/**
	 * Sauvegarde des données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys = [])
	{
		// Pas d'enregistrement lorsqu'une notice est présente ou tableau transmis vide
		if (
			!empty(self::$inputNotices)
			or empty($keys)
		) {
			return false;
		}

		// Empêcher la sauvegarde d'une donnée nulle.
		if (gettype($keys[count($keys) - 1]) === NULL) {
			return false;
		}

		// Initialisation du retour en cas d'erreur de descripteur
		$success = false;
		// Construire la requête dans la base inf à 1 retourner toute la base
		if (count($keys) >= 1) {
			// Descripteur de la base
			$db = $this->dataFiles[$keys[0]];
			$query = $keys[0];
			// Construire la requête
			// Ne pas tenir compte du dernier élément qui une une value donc <
			for ($i = 1; $i < count($keys) - 1; $i++) {
				$query .= '.' . $keys[$i];
			}
			// Appliquer la modification, le dernier élément étant la donnée à sauvegarder
			$success = is_object($db->set($query, $keys[count($keys) - 1], true));
		}
		return $success;
	}

	/**
	 * Accède aux données
	 * @param array $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = [])
	{
		// Eviter une requete vide
		if (count($keys) >= 1) {
			// descripteur de la base
			$db = $this->dataFiles[$keys[0]];
			$query = $keys[0];
			// Construire la requête
			for ($i = 1; $i < count($keys); $i++) {
				$query .= '.' . $keys[$i];
			}
			return $db->get($query);
		}
	}

	/**
	 * Lire les données de la page
	 * @param string pageId
	 * @param string langue
	 * @return string contenu de la page
	 */
	public function getPage($page, $course)
	{

		// Le nom de la ressource et le fichier de contenu sont définis :
		if (
			$this->getData(['page', $page, 'content']) !== ''
			&& file_exists(self::DATA_DIR . $course . '/content/' . $this->getData(['page', $page, 'content']))
		) {
			return file_get_contents(self::DATA_DIR . $course . '/content/' . $this->getData(['page', $page, 'content']));
		} else {
			return 'Aucun contenu trouvé.';
		}
	}

	/**
	 * Ecrire les données de la page
	 * @param string pageId
	 * @param string contenu de la page
	 * @return int nombre d'octets écrits ou erreur
	 */
	public function setPage($page, $value, $path)
	{

		return file_put_contents(self::DATA_DIR . $path . '/content/' . $page . '.html', $value);
	}



	/**
	 * Effacer les données de la page
	 * @param string pageId
	 * @return bool statut de l'effacement
	 */
	public function deletePage($page, $course)
	{
		return unlink(self::DATA_DIR . $course . '/content/' . $this->getData(['page', $page, 'content']));
	}


	public function initDB($module, $path = '')
	{
		// Instanciation de la classe des entrées / sorties
		// Constructeur  JsonDB;
		$this->dataFiles[$module] = new \Prowebcraft\JsonDb([
			'name' => $module . '.json',
			'dir' => self::DATA_DIR . $path . '/',
			'backup' => file_exists('site/data/.backup')
		]);
	}

	/**
	 * Initialisation des données sur un cours ou la page d'accueil
	 * @param string $course : id du module à générer
	 * @param string $path : le dossier à créer
	 * Données valides : page ou module
	 */

	public function initData($module, $path)
	{

		// Tableau avec les données vierges
		require_once('core/module/install/ressource/defaultdata.php');

		// L'arborescence
		if (!file_exists(self::DATA_DIR . $path)) {
			mkdir(self::DATA_DIR . $path, 0755);
		}
		if (!file_exists(self::DATA_DIR . $path . '/content')) {
			mkdir(self::DATA_DIR . $path . '/content', 0755);
		}

		/*
		 * Le site d'accueil, home ne dispose pas des mêmes modèles
		 */
		$template = $path === 'home' ? init::$siteTemplate : init::$courseDefault;
		// Création de page ou de module
		$this->setData([$module, $template[$module]]);
		// Création des pages 
		if ($module === 'page') {
			$content = $path === 'home' ? init::$siteContent : init::$courseContent;
			foreach ($content as $key => $value) {
				$this->setPage($key, $value, $path);
			}
		}

		common::$coreNotices[] = $module;

	}
	/**
	 * Initialisation des données
	 * @param string $module : if du module à générer
	 * choix valides :  core config user theme page module
	 */
	public function saveConfig($module)
	{
		// Tableau avec les données vierges
		require_once('core/module/install/ressource/defaultdata.php');
		// Installation des données des autres modules cad theme profil font config, admin et core
		$this->setData([$module, init::$defaultData[$module]]);
		common::$coreNotices[] = $module;
	}


	/**
	 * Accède à la liste des pages parents et de leurs enfants
	 * @param int $parentId Id de la page parent
	 * @param bool $onlyVisible Affiche seulement les pages visibles
	 * @param bool $onlyBlock Affiche seulement les pages de type barre
	 * @return array
	 */
	public function getHierarchy($parentId = null, $onlyVisible = true, $onlyBlock = false)
	{
		$hierarchy = $onlyVisible ? $this->hierarchy['visible'] : $this->hierarchy['all'];
		$hierarchy = $onlyBlock ? $this->hierarchy['bar'] : $hierarchy;
		// Enfants d'un parent
		if ($parentId) {
			if (array_key_exists($parentId, $hierarchy)) {
				return $hierarchy[$parentId];
			} else {
				return [];
			}
		}
		// Parents et leurs enfants
		else {
			return $hierarchy;
		}
	}

	/**
	 * Fonction pour construire le tableau des pages
	 * Appelée par le core uniquement
	 */

	private function buildHierarchy()
	{

		$pages = helper::arrayColumn($this->getData(['page']), 'position', 'SORT_ASC');
		// Parents
		foreach ($pages as $pageId => $pagePosition) {
			if (
				// Page parent
				$this->getData(['page', $pageId, 'parentPageId']) === ''
				// Ignore les pages dont l'utilisateur n'a pas accès
				and ($this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
					or ($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
						//and $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])
						// Modification qui tient compte du profil de la page
						and ($this->getUser('group') * self::MAX_PROFILS + $this->getUser('profil')) >= ($this->getData(['page', $pageId, 'group']) * self::MAX_PROFILS + $this->getData(['page', $pageId, 'profil']))

					)
				)
			) {
				if ($pagePosition !== 0) {
					$this->hierarchy['visible'][$pageId] = [];
				}
				if ($this->getData(['page', $pageId, 'block']) === 'bar') {
					$this->hierarchy['bar'][$pageId] = [];
				}
				$this->hierarchy['all'][$pageId] = [];
			}
		}
		// Enfants
		foreach ($pages as $pageId => $pagePosition) {
			if (
				// Page parent
				$parentId = $this->getData(['page', $pageId, 'parentPageId'])
				// Ignore les pages dont l'utilisateur n'a pas accès
				and (
					($this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
						and $this->getData(['page', $parentId, 'group']) === self::GROUP_VISITOR
					)
					or ($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
						//and $this->getUser('group') >= $this->getData(['page', $parentId, 'group'])
						//and $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])

						// Modification qui tient compte du profil de la page
						and ($this->getUser('group') * self::MAX_PROFILS + $this->getUser('profil')) >= ($this->getData(['page', $this->$parentId, 'group']) * self::MAX_PROFILS + $this->getData(['page', $this->$parentId, 'profil']))
						and ($this->getUser('group') * self::MAX_PROFILS + $this->getUser('profil')) >= ($this->getData(['page', $this->$pageId, 'group']) * self::MAX_PROFILS + $this->getData(['page', $pageId, 'profil']))

					)
				)
			) {
				if ($pagePosition !== 0) {
					$this->hierarchy['visible'][$parentId][] = $pageId;
				}
				if ($this->getData(['page', $pageId, 'block']) === 'bar') {
					$this->hierarchy['bar'][$pageId] = [];
				}
				$this->hierarchy['all'][$parentId][] = $pageId;
			}
		}
	}

	/**
	 * Génère un fichier json avec la liste des pages
	 *
	 */
	private function tinyMcePages()
	{
		// Sauve la liste des pages pour TinyMCE
		$parents = [];
		$rewrite = (helper::checkRewrite()) ? '' : '?';
		// Boucle de recherche des pages actives
		foreach ($this->getHierarchy(null, false, false) as $parentId => $childIds) {
			$children = [];
			// Exclure les barres
			if ($this->getData(['page', $parentId, 'block']) !== 'bar') {
				// Boucler sur les enfants et récupérer le tableau children avec la liste des enfants
				foreach ($childIds as $childId) {
					$children[] = [
						'title' => '↳' . html_entity_decode($this->getData(['page', $childId, 'shortTitle']), ENT_QUOTES),
						'value' => $rewrite . $childId
					];
				}
				// Traitement
				if (empty($childIds)) {
					// Pas d'enfant, uniquement l'entrée du parent
					$parents[] = [
						'title' => html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES),
						'value' => $rewrite . $parentId
					];
				} else {
					// Des enfants, on ajoute la page parent en premier
					array_unshift($children, [
						'title' => html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES),
						'value' => $rewrite . $parentId
					]);
					// puis on ajoute les enfants au parent
					$parents[] = [
						'title' => html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES),
						'value' => $rewrite . $parentId,
						'menu' => $children
					];
				}
			}
		}
		// Sitemap et Search
		$children = [];
		$children[] = [
			'title' => 'Rechercher dans le site',
			'value' => $rewrite . 'search'
		];
		$children[] = [
			'title' => 'Plan du site',
			'value' => $rewrite . 'sitemap'
		];
		$parents[] = [
			'title' => 'Pages spéciales',
			'value' => '#',
			'menu' => $children
		];

		// Enregistrement : 3 tentatives
		for ($i = 0; $i < 3; $i++) {
			if (file_put_contents('core/vendor/tinymce/link_list.json', json_encode($parents, JSON_UNESCAPED_UNICODE), LOCK_EX) !== false) {
				break;
			}
			// Pause de 10 millisecondes
			usleep(10000);
		}
	}

	/**
	 * Accède à une valeur des variables http (ordre de recherche en l'absence de type : _COOKIE, _POST)
	 * @param string $key Clé de la valeur
	 * @param int $filter Filtre à appliquer à la valeur
	 * @param bool $required Champ requis
	 * @return mixed
	 */
	public function getInput($key, $filter = helper::FILTER_STRING_SHORT, $required = false)
	{
		// La clef est un tableau
		if (preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			foreach ($this->input as $type => $values) {
				// Champ obligatoire
				if ($required) {
					$this->addRequiredInputNotices($key);
				}
				// Check de l'existence
				// Également utile pour les checkbox qui ne retournent rien lorsqu'elles ne sont pas cochées
				if (
					array_key_exists($firstKey, $values)
					and array_key_exists($secondKey, $values[$firstKey])
				) {
					// Retourne la valeur filtrée
					if ($filter) {
						return helper::filter($this->input[$type][$firstKey][$secondKey], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$firstKey][$secondKey];
					}
				}
			}
		}
		// La clef est une chaîne
		else {
			foreach ($this->input as $type => $values) {
				// Champ obligatoire
				if ($required) {
					$this->addRequiredInputNotices($key);
				}
				// Check de l'existence
				// Également utile pour les checkbox qui ne retournent rien lorsqu'elles ne sont pas cochées
				if (array_key_exists($key, $values)) {
					// Retourne la valeur filtrée
					if ($filter) {
						return helper::filter($this->input[$type][$key], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$key];
					}
				}
			}
		}
		// Sinon retourne null
		return helper::filter(null, $filter);
	}

	/**
	 * Accède à une partie l'url ou à l'url complète
	 * @param int $key Clé de l'url
	 * @return string|null
	 */
	public function getUrl($key = null)
	{
		// Url complète
		if ($key === null) {
			return $this->url;
		}
		// Une partie de l'url
		else {
			$url = explode('/', $this->url);
			return array_key_exists($key, $url) ? $url[$key] : null;
		}
	}

	/**
	 * Accède à l'utilisateur connecté
	 * @param int $key Clé de la valeur
	 * @return string|null
	 */
	public function getUser($key, $perm1 = null, $perm2 = null)
	{
		if (is_array($this->user) === false) {
			return false;
		} elseif ($key === 'id') {
			return $this->getInput('ZWII_USER_ID');
		} elseif ($key === 'permission') {
			return $this->getPermission($perm1, $perm2);
		} elseif (array_key_exists($key, $this->user)) {
			return $this->user[$key];
		} else {
			return false;
		}
	}

	/**
	 * Retourne les permission de l'utilisateur connecté
	 * @param int $key Clé de la valeur du groupe
	 * @return string|null
	 */
	public function getPermission($key1, $key2 = null)
	{
		// User n'existe pas
		// if (is_array($this->user) === false) {
		//	return false;
		// Administrateur, toutes les permissions
		if ($this->getUser('group') === self::GROUP_ADMIN) {
			return true;
		} elseif ($this->getUser('group') < 1) { // Groupe sans autorisation
			return false;
		} elseif (
			// Groupe avec profil, consultation des autorisations sur deux clés
			$key1
			&& $key2
			&& $this->user
			&& $this->getData(['profil', $this->user['group'], $this->user['profil'], $key1])
			&& array_key_exists($key2, $this->getData(['profil', $this->user['group'], $this->user['profil'], $key1]))
		) {
			return $this->getData(['profil', $this->user['group'], $this->user['profil'], $key1, $key2]);
			// Groupe avec profil, consultation des autorisations sur une seule clé
		} elseif (
			$key1
			&& $this->user
			&& $this->getData(['profil', $this->user['group'], $this->user['profil']])
			&& array_key_exists($key1, $this->getData(['profil', $this->user['group'], $this->user['profil']]))
		) {
			return $this->getData(['profil', $this->user['group'], $this->user['profil'], $key1]);
		} else {
			// Une permission non spécifiée dans le profil est autorisée par défaut pour le fonctionnement de $action
			return true;
		}

	}

	/**
	 * Check qu'une valeur est transmise par la méthode _POST
	 * @return bool
	 */
	public function isPost()
	{
		return ($this->checkCSRF() and $this->input['_POST'] !== []);
	}


	/**
	 * Retourne une chemin localisé pour l'enregistrement des données
	 * @param $stageId nom du module
	 * @param $course langue des pages
	 * @return string du dossier à créer
	 */
	public function dataPath($id, $course)
	{
		// Sauf pour les pages et les modules
		if (
			$id === 'page' ||
			$id === 'module'
		) {
			$folder = self::DATA_DIR . $course . '/';
		} else {
			$folder = self::DATA_DIR;
		}
		return ($folder);
	}


	/**
	 * Génère un fichier un fichier sitemap.xml
	 * https://github.com/icamys/php-sitemap-generator
	 * all : génère un site map complet
	 * Sinon contient id de la page à créer
	 * @param string Valeurs possibles
	 */

	public function updateSitemap()
	{

		// Rafraîchit la liste des pages après une modification de pageId notamment 
		$this->buildHierarchy();

		// Actualise la liste des pages pour TinyMCE
		$this->tinyMcePages();

		//require_once 'core/vendor/sitemap/SitemapGenerator.php';	

		$timezone = $this->getData(['config', 'timezone']);
		$outputDir = getcwd();
		$sitemap = new \Icamys\SitemapGenerator\SitemapGenerator(helper::baseurl(false), $outputDir);

		// will create also compressed (gzipped) sitemap : option buguée
		// $sitemap->enableCompression();

		// determine how many urls should be put into one file
		// according to standard protocol 50000 is maximum value (see http://www.sitemaps.org/protocol.html)
		$sitemap->setMaxUrlsPerSitemap(50000);

		// sitemap file name
		$sitemap->setSitemapFileName('sitemap.xml');


		// Set the sitemap index file name
		$sitemap->setSitemapIndexFileName('sitemap-index.xml');

		$datetime = new DateTime(date('c'));
		$datetime->format(DateTime::ATOM); // Updated ISO8601

		foreach ($this->getHierarchy() as $parentPageId => $childrenPageIds) {
			// Exclure les barres et les pages non publiques et les pages masquées
			if (
				$this->getData(['page', $parentPageId, 'group']) !== 0 ||
				$this->getData(['page', $parentPageId, 'block']) === 'bar'
			) {
				continue;
			}
			// Page désactivée, traiter les sous-pages sans prendre en compte la page parente.
			if ($this->getData(['page', $parentPageId, 'disable']) !== true) {
				// Cas de la page d'accueil ne pas dupliquer l'URL
				$pageId = ($parentPageId !== $this->homePageId()) ? $parentPageId : '';
				$sitemap->addUrl('/' . $pageId, $datetime);
			}
			// Articles du blog
			if (
				$this->getData(['page', $parentPageId, 'moduleId']) === 'blog' &&
				!empty($this->getData(['module', $parentPageId]))
			) {
				foreach ($this->getData(['module', $parentPageId, 'posts']) as $articleId => $article) {
					if ($this->getData(['module', $parentPageId, 'posts', $articleId, 'state']) === true) {
						$date = $this->getData(['module', $parentPageId, 'posts', $articleId, 'publishedOn']);
						$sitemap->addUrl('/' . $parentPageId . '/' . $articleId, new DateTime('@{$date}', new DateTimeZone($timezone)));
					}
				}
			}
			// Sous-pages
			foreach ($childrenPageIds as $childKey) {
				if ($this->getData(['page', $childKey, 'group']) !== 0 || $this->getData(['page', $childKey, 'disable']) === true) {
					continue;
				}
				// Cas de la page d'accueil ne pas dupliquer l'URL
				$pageId = ($childKey !== $this->homePageId()) ? $childKey : '';
				$sitemap->addUrl('/' . $childKey, $datetime);

				// La sous-page est un blog
				if (
					$this->getData(['page', $childKey, 'moduleId']) === 'blog' &&
					!empty($this->getData(['module', $childKey]))
				) {
					foreach ($this->getData(['module', $childKey, 'posts']) as $articleId => $article) {
						if ($this->getData(['module', $childKey, 'posts', $articleId, 'state']) === true) {
							$date = $this->getData(['module', $childKey, 'posts', $articleId, 'publishedOn']);
							$sitemap->addUrl('/' . $childKey . '/' . $articleId, new DateTime('@{$date}', new DateTimeZone($timezone)));
						}
					}
				}
			}
		}

		// Flush all stored urls from memory to the disk and close all necessary tags.
		$sitemap->flush();

		// Move flushed files to their final location. Compress if the option is enabled.
		$sitemap->finalize();

		// Update robots.txt file in output directory

		if ($this->getData(['config', 'seo', 'robots']) === true) {
			if (file_exists('robots.txt')) {
				unlink('robots.txt');
			}
			$sitemap->updateRobots();
		} else {
			file_put_contents('robots.txt', 'User-agent: *' . PHP_EOL . 'Disallow: /');
		}

		// Submit your sitemaps to Google, Yahoo, Bing and Ask.com
		if (empty($this->getData(['config', 'proxyType']) . $this->getData(['config', 'proxyUrl']) . ':' . $this->getData(['config', 'proxyPort']))) {
			$sitemap->submitSitemap();
		}

		return (file_exists('sitemap.xml') && file_exists('robots.txt'));


	}

	/*
	 * Création d'une miniature
	 * Fonction utilisée lors de la mise à jour d'une version 9 à une version 10
	 * @param string $src image source
	 * @param string $dets image destination
	 * @param integer $desired_width largeur demandée
	 */
	function makeThumb($src, $dest, $desired_width)
	{
		// Vérifier l'existence du dossier de destination.
		$fileInfo = pathinfo($dest);
		if (!is_dir($fileInfo['dirname'])) {
			mkdir($fileInfo['dirname'], 0755, true);
		}
		$source_image = '';
		// Type d'image
		switch ($fileInfo['extension']) {
			case 'jpeg':
			case 'jpg':
				$source_image = imagecreatefromjpeg($src);
				break;
			case 'png':
				$source_image = imagecreatefrompng($src);
				break;
			case 'gif':
				$source_image = imagecreatefromgif($src);
				break;
			case 'webp':
				$source_image = imagecreatefromwebp($src);
				break;
			case 'avif':
				$source_image = function_exists('imagecreatefromavif') ? imagecreatefromavif($src) : null;
				break;
		}
		// Image valide
		if ($source_image) {
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));
			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			switch (mime_content_type($src)) {
				case 'image/jpeg':
				case 'image/jpg':
					return (imagejpeg($virtual_image, $dest));
				case 'image/png':
					return (imagepng($virtual_image, $dest));
				case 'image/gif':
					return (imagegif($virtual_image, $dest));
				case 'webp':
					return (imagewebp($virtual_image, $dest));
				case 'avif':
					return (imageavif($virtual_image, $dest));
			}
		} else {
			return (false);
		}
	}


	/**
	 * Envoi un mail
	 * @param string|array $to Destinataire
	 * @param string $subject Sujet
	 * @param string $content Contenu
	 * @return bool
	 */
	public function sendMail($to, $subject, $content, $replyTo = null, $from = '')
	{
		// Layout
		ob_start();
		include 'core/layout/mail.php';
		$layout = ob_get_clean();
		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->setLanguage(substr(self::$i18nUI, 0, 2), 'core/class/phpmailer/i18n/');
		$mail->CharSet = 'UTF-8';
		$mail->Encoding = 'base64';
		// Mail
		try {
			// Paramètres SMTP perso
			if ($this->getdata(['config', 'smtp', 'enable'])) {
				//$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_CLIENT;
				$mail->isSMTP();
				$mail->SMTPAutoTLS = false;
				$mail->SMTPSecure = false;
				$mail->SMTPAuth = false;
				$mail->Host = $this->getdata(['config', 'smtp', 'host']);
				$mail->Port = (int) $this->getdata(['config', 'smtp', 'port']);
				if ($this->getData(['config', 'smtp', 'auth'])) {
					$mail->SMTPSecure = true;
					$mail->SMTPAuth = true;
					$mail->Username = $this->getData(['config', 'smtp', 'username']);
					$mail->Password = helper::decrypt($this->getData(['config', 'smtp', 'password']), $this->getData(['config', 'smtp', 'host']));
					switch ($this->getData(['config', 'smtp', 'secure'])) {
						case 'ssl':
							$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
							break;
						case 'tls':
							$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
							break;
						default:
							break;
					}
				}
			}

			// Expéditeur
			$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
			$from = $from ? $from : 'no-reply@' . $host;
			$mail->setFrom($from, html_entity_decode($this->getData(['config', 'title'])));

			// répondre à
			if (is_null($replyTo)) {
				$mail->addReplyTo($from, html_entity_decode($this->getData(['config', 'title'])));
			} else {
				$mail->addReplyTo($replyTo);
			}

			// Destinataires
			if (is_array($to)) {
				foreach ($to as $userMail) {
					$mail->addAddress($userMail);
				}
			} else {
				$mail->addAddress($to);
			}
			$mail->isHTML(true);
			$mail->Subject = html_entity_decode($subject);
			$mail->Body = $layout;
			$mail->AltBody = strip_tags($content);
			if ($mail->send()) {
				return true;
			} else {
				return $mail->ErrorInfo;
			}
		} catch (Exception $e) {
			return $mail->ErrorInfo;
		}
	}



	/**
	 * Effacer un dossier non vide.
	 * @param string URL du dossier à supprimer
	 */
	public function deleteDir($path)
	{
		foreach (new DirectoryIterator($path) as $item) {
			if ($item->isFile())
				@unlink($item->getRealPath());
			if (!$item->isDot() && $item->isDir())
				$this->deleteDir($item->getRealPath());
		}
		return (rmdir($path));
	}


	/*
	 * Copie récursive de dossiers
	 * @param string $src dossier source
	 * @param string $dst dossier destination
	 * @return bool
	 */
	public function copyDir($src, $dst)
	{
		// Ouvrir le dossier source
		$dir = opendir($src);
		// Créer le dossier de destination
		if (!is_dir($dst))
			$success = mkdir($dst, 0755, true);
		else
			$success = true;

		// Boucler dans le dossier source en l'absence d'échec de lecture écriture
		while (
			$success
			and $file = readdir($dir)
		) {

			if (($file != '.') && ($file != '..')) {
				if (is_dir($src . '/' . $file)) {
					// Appel récursif des sous-dossiers
					$s = $this->copyDir($src . '/' . $file, $dst . '/' . $file);
					$success = $s || $success;
				} else {
					$s = copy($src . '/' . $file, $dst . '/' . $file);
					$success = $s || $success;
				}
			}
		}
		return $success;
	}


	/**
	 * Fonction de parcours des données de module
	 * @param string $find donnée à rechercher
	 * @param string $replace donnée à remplacer
	 * @param array tableau à analyser
	 * @param int count nombres d'occurrences
	 * @return array avec les valeurs remplacées.
	 */
	public function recursive_array_replace($find, $replace, $array, &$count)
	{
		if (!is_array($array)) {
			return str_replace($find, $replace, $array, $count);
		}

		$newArray = [];
		foreach ($array as $key => $value) {
			$newArray[$key] = $this->recursive_array_replace($find, $replace, $value, $c);
			$count += $c;
		}
		return $newArray;
	}

	/**
	 * Génère une archive d'un dossier et des sous-dossiers
	 * @param string fileName path et nom de l'archive
	 * @param string folder path à zipper
	 * @param array filter dossiers à exclure
	 */
	public function makeZip($fileName, $folder, $filter = [])
	{
		$zip = new ZipArchive();
		$zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		//$directory = 'site/';
		$files = new RecursiveIteratorIterator(
			new RecursiveCallbackFilterIterator(
				new RecursiveDirectoryIterator(
					$folder,
					RecursiveDirectoryIterator::SKIP_DOTS
				),
				function ($fileInfo, $key, $iterator) use ($filter) {
					return $fileInfo->isFile() || !in_array($fileInfo->getBaseName(), $filter);
				}
			)
		);
		foreach ($files as $name => $file) {
			if (!$file->isDir()) {
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen(realpath($folder)) + 1);
				$zip->addFile($filePath, str_replace('\\', '/', $relativePath));
			}
		}
		$zip->close();
	}

	/**
	 * Retourne l'id de la page d'accueil
	 * @return string pageId
	 */
	public function homePageId()
	{
		switch (self::$siteContent) {
			case 'home':
				return ($this->getData(['config', 'homePageId']));
			default:

				return ($this->getData(['course', self::$siteContent, 'homePageId']));
		}

	}

	/**
	 * Journalisation
	 */
	public function saveLog($message = '')
	{
		// Journalisation
		$dataLog = helper::dateUTF8('%Y %m %d', time(),  self::$i18nUI) . ' - ' . helper::dateUTF8('%H:%M', time(), self::$i18nUI);
		$dataLog .= helper::getIp($this->getData(['config', 'connect', 'anonymousIp'])) . ';';
		$dataLog .= empty($this->getUser('id')) ? 'visitor;' : $this->getUser('id') . ';';
		$dataLog .= $message ? $this->getUrl() . ';' . $message : $this->getUrl();
		$dataLog .= PHP_EOL;
		if ($this->getData(['config', 'connect', 'log'])) {
			file_put_contents(self::DATA_DIR . 'journal.log', $dataLog, FILE_APPEND);
		}
	}

	// Fonctions pour la gestion des cours


	/**
	 * Retourne un tableau de tous les cours selon les autorisations
	 * @param string $access
	 *      - 0 le cours est ouvert
	 *      - 1 le cours est ouvert entre les dates
	 *      - 2 le cours est fermé
	 * @param string $enrolment 
	 *     - 0 accès est anonyme
	 *     - 1 accès libre
	 *     - 2 accès avec clé
	 *     - 3 manuel, le prof inscrits
	 */
	public function getCourses($access = null, $enrolment = null)
	{
		$courses = $this->getData(['course']);
		$response = [];
		foreach ($courses as $courseId => $courseValues) {
			$response[] = ($access === $courseValues['access'] || $access === null)
				? $courseId : '';
			$response[] = ($enrolment === $courseValues['enrolment'] || $enrolment === null)
				? $courseId : '';
		}
		$response = array_unique($response);
		$response = array_filter($response, function ($value) {
			// Supprime les éléments vides (null, "", 0, false, etc.)
			return !empty($value);
		});
		return $response;
	}

	/**
	 * Retourne les cours d'un utilisateur
	 * @param string $userId identifiant
	 * @param string $serStatus teacher ou student ou admin
	 */
	public function getCoursesByUser($userId, $userStatus)
	{
		$c = $this->getData([('course')]);
		switch ($userStatus) {
			case self::GROUP_ADMIN:
				return $c;
			case self::GROUP_EDITOR:
				foreach ($c as $courseId => $value) {
					if ($this->getData(['enrolment', $courseId]) !== $userId) {
						unset($c[$courseId]);
					}
				}
				return $c;
			case self::GROUP_MEMBER:
			case self::GROUP_VISITOR:
				foreach ($c as $courseId => $value) {
					$students = $this->getData(['enrolment', $courseId, 'students']);
					if (in_array($userId, $students) === false) {
						unset($c[$courseId]);
					}
				}
				return $c;
			default:
				return null;
		}
	}

}