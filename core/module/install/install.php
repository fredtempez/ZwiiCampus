<?php

/**
 * This file is part of Zwii.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2025, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */
class install extends common
{
	public static $actions = [
		'index' => self::ROLE_VISITOR,
		'postinstall' => self::ROLE_VISITOR,
		'steps' => self::ROLE_ADMIN,
		'update' => self::ROLE_ADMIN
	];

	// Type de proxy
	public static $proxyType = [
		'tcp://' => 'TCP',
		'http://' => 'HTTP'
	];

	public static $newVersion;

	// Fichiers des Interface
	public static $i18nFiles = [];

	public static $updateButtonText = 'Réinstaller';

	/**
	 * Pré-installation - choix de la langue
	 */
	public function index()
	{
		// Accès refusé
		if ($this->getData(['user']) !== []) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}

		// Soumission du formulaire
		if (
			// $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
			$this->isPost()
		) {
			$lang = $this->getInput('installLanguage');
			$this->setData(['config', 'defaultLanguageUI', $lang]);

			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'install/postinstall'
			]);
		}

		// Liste des langues UI disponibles
		if (is_dir(self::I18N_DIR)) {
			foreach ($this->getData(['language']) as $lang => $value) {
				self::$i18nFiles[$lang] = self::$languages[$lang];
			}
		}

		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => helper::translate('ZwiiCampus installation'),
			'view' => 'index'
		]);
	}

	/**
	 * post Installation
	 */
	public function postInstall()
	{
		// Accès refusé
		if ($this->getData(['user']) !== []) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès autorisé
		else {
			// Soumission du formulaire
			if (
				// $this->getUser('permission', __CLASS__, __FUNCTION__) !== true &&
				$this->isPost()
			) {
				// Double vérification pour le mot de passe
				if ($this->getInput('installPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('installConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
					self::$inputNotices['installConfirmPassword'] = 'Incorrect';
				}
				// Utilisateur
				$userFirstname = $this->getInput('installFirstname', helper::FILTER_STRING_SHORT, true);
				$userLastname = $this->getInput('installLastname', helper::FILTER_STRING_SHORT, true);
				$userMail = $this->getInput('installMail', helper::FILTER_MAIL, true);
				$userId = $this->getInput('installId', helper::FILTER_ID, true);

				// Validation de la langue transmise
				self::$i18nUI = $this->getData(['config', 'defaultLanguageUI']);
				self::$i18nUI = array_key_exists(self::$i18nUI, self::$languages) ? self::$i18nUI : 'fr_FR';
				// Stockage de la langue par défaut afin d'afficher le site dans cette langue lors de l'affichage de la bannière de connexion.
				$this->setData(['config', 'defaultLanguageUI', self::$i18nUI], false);

				// Création du dossier de contenu avec le marqueur de langue par défaut
				if (!is_dir(self::DATA_DIR . $_SESSION['ZWII_SITE_CONTENT'])) {
					mkdir(self::DATA_DIR . $_SESSION['ZWII_SITE_CONTENT']);
					touch(self::DATA_DIR . $_SESSION['ZWII_SITE_CONTENT'] . '/.default');
				}
				// Création de l'utilisateur si les données sont complétées.
				// success retour de l'enregistrement des données
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'forgot' => 0,
						'role' => self::ROLE_ADMIN,
						'profil' => 0,
						'lastname' => $userLastname,
						'pseudo' => 'Admin',
						'signature' => 1,
						'mail' => $userMail,
						'password' => $this->getInput('installPassword', helper::FILTER_PASSWORD, true),
						'language' => $_SESSION['ZWII_SITE_CONTENT']
					]
				]);

				// Envoie le mail
				// Sent contient true si réussite sinon code erreur d'envoi en clair
				$this->sendMail(
					$userMail,
					'Installation de votre site',
					'Bonjour' . ' <strong>' . $userFirstname . ' ' . $userLastname . '</strong>,<br><br>'
						. 'Voici les détails de votre installation.<br><br>'
						. '<strong>URL du site :</strong> <a href="' . helper::baseUrl(false) . '" target="_blank">' . helper::baseUrl(false) . '</a><br>'
						. '<strong>Identifiant du compte :</strong> ' . $this->getInput('installId') . '<br>',
					null,
					'no-reply@localhost'
				);

				// Sauvegarder la configuration du Proxy
				$this->setData(['config', 'proxyType', $this->getInput('installProxyType')], false);
				$this->setData(['config', 'proxyUrl', $this->getInput('installProxyUrl')], false);
				$this->setData(['config', 'proxyPort', $this->getInput('installProxyPort', helper::FILTER_INT)], false);

				// Images exemples livrées dans tous les cas
				try {
					// Décompression dans le dossier de fichier temporaires
					if (file_exists(self::TEMP_DIR . 'files.tar.gz')) {
						unlink(self::TEMP_DIR . 'files.tar.gz');
					}
					if (file_exists(self::TEMP_DIR . 'files.tar')) {
						unlink(self::TEMP_DIR . 'files.tar');
					}
					copy('core/module/install/ressource/files.tar.gz', self::TEMP_DIR . 'files.tar.gz');
					$pharData = new PharData(self::TEMP_DIR . 'files.tar.gz');
					$pharData->decompress();
					// Installation
					$pharData->extractTo(__DIR__ . '/../../../site', null, true);
				} catch (Exception $e) {
					$success = $e->getMessage();
				}

				// Nettoyage
				unlink(self::TEMP_DIR . 'files.tar.gz');
				unlink(self::TEMP_DIR . 'files.tar');

				// Installer les données du site de test
				// Les groupes
				// Les espaces

				// Créer le dossier des fontes
				if (!is_dir(self::DATA_DIR . 'font')) {
					mkdir(self::DATA_DIR . 'font');
				}

				// Copie des langues de l'UI et génération de la base de données
				if (is_dir(self::I18N_DIR) === false) {
					mkdir(self::I18N_DIR);
				}

				// Créer le dossier de l'accueil dans les fichiers
				if (is_dir(self::FILE_DIR . 'source/home') === false) {
					mkdir(self::FILE_DIR . 'source/home');
				}

				// Créer la base de données des langues
				$this->copyDir('core/module/install/ressource/i18n', self::I18N_DIR);

				// Fixe l'adresse from pour les envois d'email
				$this->setData(['config', 'smtp', 'from', 'no-reply@' . str_replace('www.', '', $_SERVER['HTTP_HOST'])], false);

				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl(),
					'notification' => helper::translate('Installation terminée'),
					'state' => true
				]);

				// Force la sauvegarde
				$this->saveDB('config');
			}

			// Langue par défaut définie précédemment
			self::$i18nUI = $this->getData(['config', 'defaultLanguageUI']);

			// Affichage du formulaire
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => helper::translate('ZwiiCampus Installation'),
				'view' => 'postinstall'
			]);
		}
	}

	/**
	 * Étapes de mise à jour
	 */
	public function steps()
	{
		// Action interdite
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
			return;
		}

		// Installation par étapes
		switch ($this->getInput('step', helper::FILTER_INT)) {
			// Préparation
			case 1:
				$success = true;
				$message = '';
				// RAZ la mise à jour auto
				$this->setData(['core', 'updateAvailable', false]);
				// Backup du dossier Data
				helper::autoBackup(self::BACKUP_DIR, ['backup', 'tmp', 'file']);

				/**
				 * Le mode maintenance n'était pas activé
				 *  Son état est sauvegardé pour être restauré après la mise à jour
				 */
				if ($this->getData(['config', 'maintenance']) === true) {
					// Mode permanent pour éviter la désactivation
					touch(self::DATA_DIR . '.maintenance');
				}
				// Activer le mode maintenance et laisser les fichiers se fermer
				$this->setData(['config', 'maintenance', true]);
				usleep(500000);  // 500 milliseconds

				// Sauvegarde htaccess
				if ($this->getData(['config', 'autoUpdateHtaccess'])) {
					$success = copy('.htaccess', '.htaccess' . '.bak');
					$message = $success ? '' : 'Erreur de copie du fichier htaccess';
				}
				// Nettoyage des fichiers d'installation précédents
				if ($success && file_exists(self::TEMP_DIR . 'update.tar.gz')) {
					$success = unlink(self::TEMP_DIR . 'update.tar.gz');
					$message = $success ? '' : 'Impossible d&#39;effacer la mise à jour précédente';
				}
				if ($success && file_exists(self::TEMP_DIR . 'update.tar')) {
					$success = unlink(self::TEMP_DIR . 'update.tar');
					$message = $success ? '' : 'Impossible d&#39;effacer la mise &#224; jour pr&#233;c&#233;dente';
				}

				// Check la réécriture d'URL avant d'écraser les fichiers
				// Création du fichier de marqueur et l'effacer si présent
				if (helper::checkRewrite()) {
					touch(self::DATA_DIR . '.rewrite');
				} elseif (file_exists(self::DATA_DIR . '.rewrite')) {
					unlink(self::DATA_DIR . '.rewrite');
				}
				// Sauvegarde le message dans le journal
				if (!empty($message)) {
					$this->saveLog($message);
				}
				// Valeurs en sortie
				$this->addOutput([
					'display' => self::DISPLAY_JSON,
					'content' => [
						'success' => $success,
						'data' => json_encode($message, JSON_UNESCAPED_UNICODE)
					]
				]);
				break;
			// Téléchargement
			case 2:
				$success = true;
				$message = '';
				$this->secure_file_put_contents(self::TEMP_DIR . 'update.tar.gz', helper::getUrlContents(common::ZWII_UPDATE_URL . common::ZWII_UPDATE_CHANNEL . '/update.tar.gz'));
				$md5origin = helper::getUrlContents(common::ZWII_UPDATE_URL . common::ZWII_UPDATE_CHANNEL . '/update.md5');
				$md5origin = explode(' ', $md5origin);
				$md5target = md5_file(self::TEMP_DIR . 'update.tar.gz');
				// Vérifier si les checksums correspondent
				if ($md5origin[0] === $md5target) {
					$success = true;
					$message = '';
				} else {
					$success = false;
					$message = 'Erreur de téléchargement ou de somme de contrôle';
					if (file_exists(self::TEMP_DIR . 'update.tar.gz')) {
						unlink(self::TEMP_DIR . 'update.tar.gz');
						http_response_code(500);
					}
				}
				// Sauvegarde le message dans le journal
				if (!empty($message)) {
					$this->saveLog($message);
				}
				// Valeurs en sortie
				$this->addOutput([
					'display' => self::DISPLAY_JSON,
					'content' => [
						'success' => $success,
						'data' => json_encode($message, JSON_UNESCAPED_UNICODE)
					]
				]);
				break;
			// Installation
			case 3:
				$success = true;
				$message = '';

				// Décompression et installation
				try {
					// Décompression dans le dossier de fichier temporaires
					$pharData = new PharData(self::TEMP_DIR . 'update.tar.gz');
					$pharData->decompress();
					// Installation
					$pharData->extractTo(__DIR__ . '/../../../', null, true);
				} catch (Exception $e) {
					$message = $e->getMessage();
					$success = false;
					http_response_code(500);
				}

				// Nettoyage du dossier
				if (file_exists(self::TEMP_DIR . 'update.tar.gz')) {
					unlink(self::TEMP_DIR . 'update.tar.gz');
				}
				if (file_exists(self::TEMP_DIR . 'update.tar')) {
					unlink(self::TEMP_DIR . 'update.tar');
				}
				// Sauvegarde le message dans le journal
				if (!empty($message)) {
					$this->saveLog($message);
				}
				// Valeurs en sortie
				$this->addOutput([
					'display' => self::DISPLAY_JSON,
					'content' => [
						'success' => $success,
						'data' => json_encode($message, JSON_UNESCAPED_UNICODE)
					]
				]);
				break;
			// Configuration
			case 4:
				$success = true;
				$message = '';

				// Restaure le mode maintenance si permanent
				$this->setData(['config', 'maintenance', file_exists(self::DATA_DIR . '.maintenance')]);
				// Dans tous les cas supprimer le drapeau de maintenance
				if (file_exists(self::DATA_DIR . '.maintenance')) {
					unlink(self::DATA_DIR . '.maintenance');
				}

				/** Restaure le fichier htaccess */
				// Recopie htaccess
				if (
					$this->getData(['config', 'autoUpdateHtaccess']) === true
				) {
					// L'écraser avec le backup
					$success = copy('.htaccess.bak', '.htaccess');
					if ($success === false) {
						$message = helper::translate("La copie de sauvegarde du fichier htaccess n'a pas été restaurée !");
						http_response_code(500);
					}
					// Effacer le backup
					unlink('.htaccess.bak');
				} else {
					/** Restaure la réécriture d'URL */
					if (file_exists(self::DATA_DIR . '.rewrite')) {  // Ajout des lignes dans le .htaccess
						$fileContent = file_get_contents('.htaccess');
						$rewriteData = PHP_EOL
							. '# URL rewriting' . PHP_EOL
							. '<IfModule mod_rewrite.c>' . PHP_EOL
							. "\tRewriteEngine on" . PHP_EOL
							. "\tRewriteBase " . helper::baseUrl(false, false) . PHP_EOL
							. "\tRewriteCond %{REQUEST_FILENAME} !-f" . PHP_EOL
							. "\tRewriteCond %{REQUEST_FILENAME} !-d" . PHP_EOL
							. "\tRewriteRule ^(.*)\$ index.php?\$1 [L]" . PHP_EOL
							. '</IfModule>' . PHP_EOL
							. '# URL rewriting' . PHP_EOL;
						$fileContent = str_replace('# URL rewriting', $rewriteData, $fileContent);
						$success = $this->secure_file_put_contents(
							'.htaccess',
							$fileContent
						);
						unlink(self::DATA_DIR . '.rewrite');
					}
				}

				/** Met à jour les dictionnaires des langues depuis les nouveaux modèles installés */
				require_once ('core/module/install/ressource/defaultdata.php');
				$installedLanguages = $this->getData(['language']);
				$defaultLanguages = init::$defaultData['language'];
				foreach ($installedLanguages as $key => $value) {
					if (
						isset($defaultLanguages[$key]['date']) &&
						$defaultLanguages[$key]['date'] > $value['date'] &&
						isset($defaultLanguages[$key]['version']) &&
						$defaultLanguages[$key]['version'] >= $value['version']
					) {
						copy('core/module/install/ressource/i18n/' . $key . '.json', self::I18N_DIR . $key . '.json');
						$this->setData(['language', $key, $defaultLanguages[$key]]);
					}
				}
				// Sauvegarde le message dans le journal
				if (!empty($message)) {
					$this->saveLog($message);
				}

				// Valeurs en sortie
				$this->addOutput([
					'display' => self::DISPLAY_JSON,
					'content' => [
						'success' => $success,
						'data' => json_encode($message, JSON_UNESCAPED_UNICODE)
					]
				]);
		}
	}

	/**
	 * Mise à jour
	 */
	public function update()
	{
		// Action interdite
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Nouvelle version
			self::$newVersion = helper::getUrlContents(common::ZWII_UPDATE_URL . common::ZWII_UPDATE_CHANNEL . '/version');

			// Variable de version
			if (helper::checkNewVersion(common::ZWII_UPDATE_CHANNEL)) {
				self::$updateButtonText = helper::translate('Mise à jour');
			}

			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => helper::translate(self::$updateButtonText),
				'view' => 'update'
			]);
		}
	}
}
