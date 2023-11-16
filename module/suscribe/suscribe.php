<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author  Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2020, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.com/
 */

class suscribe extends common
{

	const VERSION = '1.4';
	const REALNAME = 'Auto-Inscription';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = ''; // Contenu localisé inclus par défaut (page.json et module.json)

	const STATUS_AWAITING = 0; // En attente de validation du mail par le client
	const STATUS_VALIDATED = 1; // Mail validé 
	public static $statusGroups = [
		self::STATUS_AWAITING => 'Email en attente de validation',
		self::STATUS_VALIDATED => 'Email validé',
	];

	public static $actions = [
		'index' => self::GROUP_VISITOR,
		'validate' => self::GROUP_VISITOR,
		'config' => self::GROUP_EDITOR,
		'user' => self::GROUP_EDITOR,
		'delete' => self::GROUP_EDITOR,
		'edit' => self::GROUP_EDITOR
	];



	public static $timeLimit = [
		2 => '2 minutes',
		5 => '5 minutes',
		10 => '10 minutes'
	];

	public static $users = [];



	/**
	 * Liste des utilisateurs en attente
	 */
	public function user()
	{
		$userIdsFirstnames = helper::arraycollumn($this->getData(['user']), 'firstname');
		ksort($userIdsFirstnames);
		foreach ($userIdsFirstnames as $userId => $userFirstname) {
			if (
				$this->getData(['user', $userId, 'group']) === self::STATUS_AWAITING ||
				$this->getData(['user', $userId, 'group']) === self::STATUS_VALIDATED
			) {
				self::$users[] = [
					$userId,
					$userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']),
					self::$statusGroups[$this->getData(['user', $userId, 'group'])],
					helper::dateUTF8(date('Y-m-d G:i'), $this->getData(['user', $userId, 'timer'])),
					template::button('registrationUserEdit' . $userId, [
						'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $userId,
						'value' => template::ico('pencil')
					]),
					template::button('registrationUserDelete' . $userId, [
						'class' => 'userDelete red',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $userId,
						'value' => template::ico('cancel')
					])
				];
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Demandes d\'inscription',
			'view' => 'user'
		]);
	}


	/**
	 * Édition
	 */
	public function edit()
	{
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès refusé
		if (
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Droit d'édition
			and (
					// Impossible de s'auto-éditer
				(
					$this->getUser('id') === $this->getUrl(2)
					and $this->getUrl('group') <= self::GROUP_VISITOR
				)
				// Impossible d'éditer un autre utilisateur
				or ($this->getUrl('group') < self::GROUP_EDITOR)
			)
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès autorisé
		else {
			// Soumission du formulaire
			if (
				$this->getUser('permission', __CLASS__, __FUNCTION__) === true
				&& $this->isPost()
			) {
				// Modification du groupe
				$this->setData([
					'user',
					$this->getUrl(2),
					[
						'firstname' => $this->getData(['user', $this->getUrl(2), 'firstname']),
						'forgot' => 0,
						'group' => $this->getInput('registrationUserEditGroup', helper::FILTER_INT),
						'lastname' => $this->getData(['user', $this->getUrl(2), 'lastname']),
						'mail' => $this->getData(['user', $this->getUrl(2), 'mail']),
						'password' => $this->getData(['user', $this->getUrl(2), 'password']),
						'connectFail' => $this->getData(['user', $this->getUrl(2), 'connectFail']),
						'connectTimeout' => $this->getData(['user', $this->getUrl(2), 'connectTimeout']),
						'accessUrl' => $this->getData(['user', $this->getUrl(2), 'accessUrl']),
						'accessTimer' => $this->getData(['user', $this->getUrl(2), 'accessTimer']),
						'accessCsrf' => $this->getData(['user', $this->getUrl(2), 'accessCsrf'])
					]
				]);
				// Notifier le user uniquement si le groupe est membre au moins membre
				if ($this->getInput('registrationUserEditGroup') >= 1) {
					$this->sendMail(
						$this->getData(['user', $this->getUrl(2), 'mail']),
						'Approbation de l\'inscription',
						'<p>' . $this->getdata(['module', $this->getUrl(0), 'config', 'mailValidateContent']) . '</p>',
						null,
						$this->getData(['config', 'smtp', 'from'])
					);
				}
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/user',
					'notification' => 'Modifications enregistrées',
					'state' => true
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['user', $this->getUrl(2), 'firstname']) . ' ' . $this->getData(['user', $this->getUrl(2), 'lastname']),
				'view' => 'edit'
			]);
		}
	}


	/**
	 * Suppression
	 */
	public function delete()
	{
		// Accès refusé
		if (
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Groupe insuffisant
			and ($this->getUrl('group') < self::GROUP_EDITOR)
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Jeton incorrect
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Bloque la suppression de son propre compte
		elseif ($this->getUser('id') === $this->getUrl(2)) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/user',
				'notification' => 'Impossible de supprimer votre propre compte'
			]);
		}
		// Suppression
		else {
			$this->deleteData(['user', $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/user',
				'notification' => 'Utilisateur supprimé',
				'state' => true
			]);
		}
	}


	/**
	 * Ajout
	 */
	public function index()
	{
		// Soumission du formulaire
		if ($this->isPost()) {
			// Drapeau de contrôle des données saisies.
			$check = true;
			// L'identifiant d'utilisateur est indisponible
			$userId = $this->getInput('registrationAddId', helper::FILTER_ID, true);
			if ($this->getData(['module', $userId])) {
				self::$inputNotices['registrationAddId'] = 'Identifiant déjà enregistré';
				$check = false;
			}
			// Double vérification pour le mot de passe
			if ($this->getInput('registrationAddPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('registrationAddConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
				self::$inputNotices['registrationAddConfirmPassword'] = 'Les mots de passe ne sont pas identiques';
				$check = false;
			}
			// Le mail existe déjà
			foreach ($this->getData(['user']) as $usersId => $user) {
				if ($user['mail'] === $this->getInput('registrationAddMail', helper::FILTER_MAIL, true)) {
					self::$inputNotices['registrationAddMail'] = 'Adresse de courriel déjà enregistrée';
					$check = false;
					break;
				}
			}
			// Données de l'utilisateur
			$userFirstname = $this->getInput('registrationAddFirstname', helper::FILTER_STRING_SHORT, true);
			$userLastname = $this->getInput('registrationAddLastname', helper::FILTER_STRING_SHORT, true);
			$userMail = $this->getInput('registrationAddMail', helper::FILTER_MAIL, true);
			// Pas de nom saisi
			if (
				empty($userFirstname) ||
				empty($userLastname) ||
				empty($this->getInput('registrationAddPassword', helper::FILTER_STRING_SHORT, true)) ||
				empty($this->getInput('registrationAddConfirmPassword', helper::FILTER_STRING_SHORT, true))
			) {
				$check = false;
			}
			// Si tout est ok
			if ($check === true) {
				//  Enregistrement temporaire du compte 
				$this->setData([
					'module',
					$this->getUrl(0),
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'lastname' => $userLastname,
						'mail' => $userMail,
						'password' => $this->getInput('registrationAddPassword', helper::FILTER_PASSWORD, true),
						// pas de groupe afin de le différencier dans la liste des users
						'timer' => time(),
						'auth' => $_SESSION['csrf'],
						'status' => self::STATUS_AWAITING
					]
				]);
				// Mail d'avertissement aux administrateurs
				// Utilisateurs dans le groupe admin
				$to = [];
				foreach ($this->getData(['user']) as $userId => $user) {
					if ($user['group'] == self::GROUP_ADMIN) {
						$to[] = $user['mail'];
					}
				}
				// Envoi du mail
				if ($to) {
					$messageAdmin = $this->getdata(['module', $this->getUrl(0), 'config', 'state']) ? 'Une demande d\'inscription attend l`approbation d\'un administrateur.' : 'Un nouveau membre s\'est inscrit.';
					// Envoi le mail
					$this->sendMail(
						$to,
						'Auto-inscription sur le site ' . $this->getData(['config', 'title']),
						'<p>' . $messageAdmin . '</p>' .
						'<p><strong>Identifiant du compte :</strong> ' . $userId . ' (' . $userFirstname . ' ' . $userLastname . ')<br>' .
						'<strong>Email  :</strong> ' . $userMail . '</p>' .
						'<a href="' . helper::baseUrl() . 'user/login/' . strip_tags(str_replace('/', '_', $this->getUrl(0) . '/user')) . '">Validation de l\'inscription</a>',
						null,
						$this->getData(['config', 'smtp', 'from'])
					);
				}

				// Mail de confirmation à l'utilisateur
				// forger le lien de vérification
				$validateLink = helper::baseUrl(true) . $this->getUrl() . '/validate/' . $userId . '/' . $_SESSION['csrf'];
				// Envoi
				$sentMailtoUser = false;
				if ($check === true) {
					$sentMailtoUser = $this->sendMail(
						$userMail,
						'Confirmation de votre inscription',
						'<p>' . $this->getdata(['module', $this->getUrl(0), 'config', 'mailRegisterContent']) . '</p>' .
						'<a href="' . $validateLink . '">Activer votre compte<a/>',
						null,
						$this->getData(['config', 'smtp', 'from'])
					);
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl(),
				//'redirect' => $validateLink,
				'notification' => $sentMailtoUser ? "Un mail vous a été envoyé." : 'Quelque chose n\'a pas fonctionné !',
				'state' => $sentMailtoUser ? true : false
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Inscription',
			'view' => 'index',
			'showBarEditButton' => true,
			'showPageContent' => true
		]);
	}

	/**
	 * Vérification de l'email
	 */
	public function validate()
	{
		// Vérifie la session + l'id + le timer
		$check = true;
		$notification = 'Bienvenue sur le site' . $this->getData(['config', 'title']);
		$csrf = $this->getUrl(3);
		$userId = $this->getUrl(2);
		// Validité
		if (time() - $this->getData(['module', $this->getUrl(0), 'user', $userId, 'timer']) <= (60 * $this->getdata(['module', $this->getUrl(0), 'config', 'pageTimeOut']))) {
			$check = false;
			$notification = 'Le lien n\'est plus valide';
		}
		if (($csrf !== $_SESSION['csrf'])) {
			$check = false;
			$notification = 'Identifiant ou mot de passe inconnu';
		}

		if ($check) {
			$this->setData([
				'user',
				$userId,
				[
					'firstname' => $this->getData(['module', $this->getUrl(0), 'user', $userId, 'firstname']),
					'lastname' => $this->getData(['module', $this->getUrl(0), 'user', $userId, 'lastname']),
					'mail' => $this->getData(['module', $this->getUrl(0), 'user', $userId, 'mail']),
					'password' => $this->getData(['module', $this->getUrl(0), 'user', $userId, 'password']),
					'group' => self::GROUP_MEMBER,
					'profil' => 1,
					'forgot' => 0,
					'pseudo' => $userId,
					'signature' => 1,
					'language' => self::$siteContent,
				]
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'redirect' => $check ? helper::baseUrl() . $this->getdata(['module', $this->getUrl(0), 'config', 'pageSuccess']) : helper::baseUrl() . $this->getdata(['module', $this->getUrl(0), 'config', 'pageError']),
			'notificaton' => $notification,
			'state' => $check
		]);
	}

	/**
	 * Module de configuration
	 */
	public function config()
	{
		// Soumission du formulaire
		if (
			$this->getUser('permission', __CLASS__, __FUNCTION__) === true
			&& $this->isPost()
		) {
			// Lire les options et les enregistrer
			$this->setData([
				'module',
				$this->getUrl(0),
				'config',
				[
					'timeOut' => $this->getInput('registrationConfigTimeOut', helper::FILTER_INT),
					'pageSuccess' => $this->getInput('registrationConfigSuccess'),
					'pageError' => $this->getInput('registrationConfigError'),
					'state' => $this->getInput('registrationConfigState', helper::FILTER_BOOLEAN),
					'mailRegisterContent' => $this->getInput('registrationconfigMailRegisterContent', null, true),
					'mailValidateContent' => $this->getInput('registrationconfigMailValidateContent', null, true),
				]
			]);
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration',
			'view' => 'config',
			'vendor' => ['tinymce']
		]);
	}
}

