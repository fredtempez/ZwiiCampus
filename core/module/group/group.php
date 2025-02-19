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

class group extends common
{

	public static $actions = [
		'add' => self::ROLE_EDITOR,
		'delete' => self::ROLE_EDITOR,
		'index' => self::ROLE_EDITOR,
		'edit' => self::ROLE_EDITOR,
		'usersAdd' => self::ROLE_EDITOR,
		'users' => self::ROLE_EDITOR,
	];

	public static $groups = [];

	public static $groupId = '';

	public static $alphabet = [];

	public static $groupRoles = [];

	public static $groupUsers = [];


	/**
	 * Liste les catégories d'un contenu
	 */
	public function index()
	{

		if (
			// Accès limité aux admins
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Les groupes déclarés
			$usersGroups = array_column($this->getData(['user']), 'group');

			// Fusionner les sous-tableaux
			$usersGroups = array_merge(...$usersGroups);

			// URéindexer les clés
			$usersGroups = array_values($usersGroups);

			// Les groupes triés
			$groups = $this->getData(['group']);
			ksort($groups);

			// Construire le tableau
			foreach ($groups as $groupId => $groupTitle) {
				$suscribers = 0;
				if (empty($usersGroups) === false) {
					foreach ($usersGroups as $itemKey => $item) {
						if ($item === $groupId) {
							$suscribers++;
						}
					}
				}
				$message = $suscribers === 0 ? helper::translate('Inscrire des participants') : sprintf(helper::translate('%s inscrits'), $suscribers);
				self::$groups[] = [
					$groupTitle,
					$suscribers === 0 ? '<a href="' . helper::baseUrl() . 'group/usersAdd/' . $groupId . '">' . $message . '</a>'
						: '<a href="' . helper::baseUrl() . 'group/users/' . $groupId . '">' . $message . '</a>',
					template::ico('pencil',  [
						'id' => 'groupEdit' . $groupId,
						'href' => helper::baseUrl() . 'group/edit/' . $groupId,
						'value' => template::ico('pencil'),
						'margin' => 'right',
						'help' => 'Éditer',
						'fontSize' => '1.2em',
					])
					. template::ico('trash', [
						'id' => 'groupDelete' . $groupId,
						'class' => 'groupDelete icoTextRed',
						'href' => helper::baseUrl() . 'group/delete/' . $groupId,
						'margin' => 'left',
						'help' => 'Supprimer',
						'fontSize' => '1.2em',
					])
				];
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => helper::translate('Groupes'),
				'view' => 'index'
			]);
		}
	}


	/**
	 * Ajout
	 */
	public function add()
	{

		if (
			// Accès limité aux admins
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]); // Soumission du formulaire
		} elseif ($this->isPost()) {
			$groupId = uniqid();
			$groupTitle = $this->getInput('groupAddTitle', helper::FILTER_STRING_SHORT, true);
			if (in_array($groupTitle, $this->getData(['group'])) === false) {
				$this->setData([
					'group',
					$groupId,
					$groupTitle
				]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'group',
					'notification' => helper::translate('Groupe créé'),
					'state' => true
				]);        // Valeurs en sortie
			} else {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'group/add',
					'notification' => helper::translate('Ce nom du groupe existe déjà'),
					'state' => false
				]);
			}
		}
		$this->addOutput([
			'title' => helper::translate('Ajouter un groupe'),
			'view' => 'add'
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
		} elseif ($this->isPost()) {
			$groupTitle = $this->getInput('groupEditTitle', helper::FILTER_STRING_SHORT, true);
			if (in_array($groupTitle, $this->getData(['group'])) === false) {
				$this->setData([
					'group',
					$this->getUrl(2),
					$groupTitle
				]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'group',
					'notification' => helper::translate('Groupe modifié'),
					'state' => true
				]);
			} else {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'group/edit/' . $this->getUrl(2),
					'notification' => helper::translate('Ce nom du groupe existe déjà'),
					'state' => false
				]);
			}
		}

		// Valeurs en sortie
		$this->addOutput([
			'title' => helper::translate('Utilisateurs'),
			'view' => 'edit',
			'vendor' => [
				'datatables'
			]
		]);
	}

	public function delete()
	{

		if (
			// Accès limité aux admins
			$this->getUser('permission', __CLASS__, __FUNCTION__) !== true
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {

			// Id et titre d'un groupe
			$groupId = $this->getUrl(2);
			$groupTitle = $this->getData(['group', $groupId]);

			$message = $message = sprintf(helper::translate('Groupe %s effacé'), $groupTitle);
			$state = true;

			// Recherche des inscriptions dans ce groupe
			// Les groupes déclarés
			$usersGroups = array_column($this->getData(['user']), 'group');
			// Fusionner les sous-tableaux
			$usersGroups = array_merge(...$usersGroups);
			// URéindexer les clés
			$usersGroups = array_values($usersGroups);

			// Parcourir les groupes affectés
			if (empty($usersGroups) === false) {
				foreach ($usersGroups as $itemKey => $item) {
					if ($item === $groupId) {
						// Pas du suppression, le groupe est affecté
						$message = helper::translate('Un groupe affecté ne peut pas être supprimé !');
						$state = false;
						break;
					}
				}
			}

			// Supprime le groupe orphelin
			if ($state === true) {
				$this->deleteData(['group', $groupId]);
			}

			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'group',
				'notification' => $message,
				'state' => $state
			]);
		}
	}

	public function users()
	{
		// Groupe sélectionné
		$groupId = $this->getUrl(2);

		// Accès limité au propriétaire ou éditeurs inscrits ou admin
		if (
			$this->getUser('role') <= self::$actions[__FUNCTION__]
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}

		// Inscription des utilisateurs cochés
		if (
			$this->isPost()
		) {

			// Drapeau pour forcer la sauvegarde finale
			$flag = false;

			// Groupe à traiter 
			$groupId = $this->getUrl(2);

			// Parcourir les posts
			foreach ($_POST as $key => $values) {

				// On passe les posts qui ne sont pas des utilisateurs
				if ($this->getData(['user', $key, 'group']) === NULL) {
					continue;
				}

				// Lire les groupes de l'utilisateur
				$groups = $this->getData(['user', $key, 'group']);
				// Désinscrit du groupe
				$groups = array_diff($groups, [$groupId]);

				// Enregistrer sans sauvegarder
				$this->setData(['user', $key, 'group', $groups], false);

				// Drapeau d'enregistrement
				$flag = true;
			}
			// Sauvegarder la base si un modification a été faite
			if ($flag) {
				$this->saveDB('user');
			}
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'group',
				'notification' => helper::translate('Inscriptions modifiées'),
				'state' => true
			]);
		}

		// Liste des rôles et des profils
		$groupGroups = $this->getData(['profil']);
		foreach ($groupGroups as $roleId => $roleValue) {
			switch ($roleId) {
				case "-1":
				case "0":
					break;
				case "3":
					self::$groupRoles['30'] = 'Administrateur';
					$profils['30'] = 0;
					break;
				case "1":
				case "2":
					foreach ($roleValue as $profilId => $profilValue) {
						if ($profilId) {
							self::$groupRoles[$roleId . $profilId] = sprintf(helper::translate('Rôle %s - Profil %s'), self::$rolePublics[$roleId], $profilValue['name']);
							$profils[$roleId . $profilId] = 0;
						}
					}
			}
		}

		// Liste alphabétique
		self::$alphabet = range('A', 'Z');
		$alphabet = range('A', 'Z');
		self::$alphabet = array_combine($alphabet, self::$alphabet);
		self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

		// Liste des inscrits dans l'espace sélectionné afin de les supprimer de la liste des candidats
		$users = $this->getData(['user']);

		// Filtrer les utilisateurs qui appartiennent au groupe recherché
		$users = array_filter($users, function ($user) use ($groupId) {
			return isset($user['group']) && in_array($groupId, $user['group']);
		});


		// Tri du tableau par défaut par $userId
		ksort($users);

		foreach ($users as $userId => $userValue) {

			// Compte les rôles
			if (isset($profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])])) {
				$profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])]++;
			}

			// Filtres
			if (
				isset($_POST['groupFilterGroup'])
				|| isset($_POST['groupFilterFirstName'])
				|| isset($_POST['groupFilterLastName'])
			) {

				// Groupe et profils
				$role = (string) $this->getData(['user', $userId, 'role']);
				$profil = (string) $this->getData(['user', $userId, 'profil']);
				$firstName = $this->getData(['user', $userId, 'firstname']);
				$lastName = $this->getData(['user', $userId, 'lastname']);
				if (
					$this->getInput('groupFilterGroup', helper::FILTER_INT) > 0
					&& $this->getInput('groupFilterGroup', helper::FILTER_STRING_SHORT) !== $role . $profil
				)
					continue;
				// Première lettre du prénom
				if (
					$this->getInput('groupFilterFirstName', helper::FILTER_STRING_SHORT) !== 'all'
					&& $this->getInput('groupFilterFirstName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($firstName, 0, 1))
				)
					continue;
				// Première lettre du nom
				if (
					$this->getInput('groupFilterLastName', helper::FILTER_STRING_SHORT) !== 'all'
					&& $this->getInput('groupFilterLastName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($lastName, 0, 1))
				)
					continue;
			}

			// Construction du tableau
			// Les groupes sous forme de chaine
			$group = $this->getData(['user', $userId, 'group']);
			$group = is_null($group) === false ? implode('', array_map(fn($valeur) => sprintf('<span class="groupTitleLabel">%s</span>', $this->getData(['group', htmlspecialchars($valeur)])), $group)) : '';
			self::$groupUsers[] = [
				template::checkbox($userId, true, '', [
					'class' => 'checkboxSelect',
					'checked' => false,
				]),
				$this->getData(['user', $userId, 'firstname']),
				$this->getData(['user', $userId, 'lastname']),
				$group,
				$this->getData(['user', $userId, 'tags']),
			];
		}

		// Ajoute les effectifs aux profils du sélecteur
		foreach (self::$groupRoles as $roleId => $roleValue) {
			if ($roleId === 'all') {
				self::$groupRoles['all'] = self::$groupRoles['all'] . ' (' . array_sum($profils) . ')';
			} else {
				self::$groupRoles[$roleId] = self::$groupRoles[$roleId] . ' (' . $profils[$roleId] . ')';
			}
		}

		// Valeurs en sortie
		$this->addOutput([
			'title' => sprintf(helper::translate('Inscriptions dans le groupe %s'), $this->getData(['group', $groupId])),
			'view' => 'users',
			'vendor' => [
				'datatables'
			]
		]);
	}


	public function usersAdd()
	{

		// Grouope sélectionné
		$groupId = $this->getUrl(2);
		// Accès limité au propriétaire ou éditeurs inscrits ou admin
		if (
			$this->getUser('role') <= self::$actions[__FUNCTION__]
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}

		// Inscription des utilisateurs cochés
		if (
			$this->isPost()
		) {
			// Drapeau pour forcer la sauvegarde finale
			$flag = false;

			// Parcourir les posts
			foreach ($_POST as $key => $values) {

				// On passe les posts qui ne sont pas des utilisateurs
				if ($this->getData(['user', $key]) === NULL) {
					continue;
				}

				// Lire les inscriptions existantes
				$groups = $this->getData(['user', $key, 'group']) !== NULL ? $this->getData(['user', $key, 'group']) : [];
				// N'est pas déjà inscrit
				if (in_array($groupId, $groups) === false) {
					// Ajoute le groupe
					$groups = array_merge($groups, array($groupId));
					// Enregistre les inscriptions
					$this->setData(['user', $key, 'group', $groups], false);
					$flag = true;
				}
			}
			// Sauvegarde la base manuellement
			if ($flag) {
				$this->saveDB('user');

				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'group',
					'notification' => helper::translate('Inscriptions ajoutées'),
					'state' => true
				]);
			}
		}

		// Liste des rôles et des profils
		$groupGroups = $this->getData(['profil']);
		foreach ($groupGroups as $roleId => $roleValue) {
			switch ($roleId) {
				case "-1":
				case "0":
					break;
				case "3":
					self::$groupRoles['30'] = 'Administrateur';
					$profils['30'] = 0;
					break;
				case "1":
				case "2":
					foreach ($roleValue as $profilId => $profilValue) {
						if ($profilId) {
							self::$groupRoles[$roleId . $profilId] = sprintf(helper::translate('Rôle %s - Profil %s'), self::$rolePublics[$roleId], $profilValue['name']);
							$profils[$roleId . $profilId] = 0;
						}
					}
			}
		}

		// Liste alphabétique
		self::$alphabet = range('A', 'Z');
		$alphabet = range('A', 'Z');
		self::$alphabet = array_combine($alphabet, self::$alphabet);
		self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

		// Liste des inscrits dans l'espace sélectionné afin de les supprimer de la liste des candidats
		$users = $this->getData(['user']);
		$suscribers = $this->getData(['enrolment', $groupId]);
		if (is_array($suscribers)) {
			$suscribers = array_keys($suscribers);
			$users = array_diff_key($users, array_flip($suscribers));
		}

		// Tri du tableau par défaut par $userId
		ksort($users);

		foreach ($users as $userId => $userValue) {

			// Supprime les inscrits
			if (
				is_array($this->getData(['user', $userId, 'group']))
				&& in_array($groupId, $this->getData(['user', $userId, 'group']))
			) {
				continue;
			}


			// Compte les rôles
			if (isset($profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])])) {
				$profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])]++;
			}

			// Filtres
			if (
				isset($_POST['groupFilterGroup'])
				|| isset($_POST['groupFilterFirstName'])
				|| isset($_POST['groupFilterLastName'])
			) {

				// Groupe et profils
				$role = (string) $this->getData(['user', $userId, 'role']);
				$profil = (string) $this->getData(['user', $userId, 'profil']);
				$firstName = $this->getData(['user', $userId, 'firstname']);
				$lastName = $this->getData(['user', $userId, 'lastname']);
				if (
					$this->getInput('groupFilterGroup', helper::FILTER_INT) > 0
					&& $this->getInput('groupFilterGroup', helper::FILTER_STRING_SHORT) !== $role . $profil
				)
					continue;
				// Première lettre du prénom
				if (
					$this->getInput('groupFilterFirstName', helper::FILTER_STRING_SHORT) !== 'all'
					&& $this->getInput('groupFilterFirstName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($firstName, 0, 1))
				)
					continue;
				// Première lettre du nom
				if (
					$this->getInput('groupFilterLastName', helper::FILTER_STRING_SHORT) !== 'all'
					&& $this->getInput('groupFilterLastName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($lastName, 0, 1))
				)
					continue;
			}

			// Les groupes sous forme de chaine
			$group = $this->getData(['user', $userId, 'group']);
			$group = is_null($group) === false ? implode('', array_map(fn($valeur) => sprintf('<span class="groupTitleLabel">%s</span>', $this->getData(['group', htmlspecialchars($valeur)])), $group)) : '';
			// Construction du tableau
			self::$groupUsers[] = [
				template::checkbox($userId, true, '', [
					'class' => 'checkboxSelect',
					'checked' => false,
				]),
				$this->getData(['user', $userId, 'firstname']),
				$this->getData(['user', $userId, 'lastname']),
				$group,
				$this->getData(['user', $userId, 'tags']),
			];
		}

		// Ajoute les effectifs aux profils du sélecteur
		foreach (self::$groupRoles as $roleId => $roleValue) {
			if ($roleId === 'all') {
				self::$groupRoles['all'] = self::$groupRoles['all'] . ' (' . array_sum($profils) . ')';
			} else {
				self::$groupRoles[$roleId] = self::$groupRoles[$roleId] . ' (' . $profils[$roleId] . ')';
			}
		}

		// Valeurs en sortie
		$this->addOutput([
			'title' => sprintf(helper::translate('Inscrire dans le groupe %s'), $this->getData(['group', $groupId])),
			'view' => 'usersAdd',
			'vendor' => [
				'datatables'
			]
		]);
	}

	/**
	 * Liste les dossier contenus dans RFM
	 */
	private function getSubdirectories($dir, $basePath = '')
	{
		$subdirs = array();
		// Ouvrez le répertoire spécifié
		$dh = opendir($dir);
		// Parcourez tous les fichiers et répertoires dans le répertoire
		while (($file = readdir($dh)) !== false) {
			// Ignorer les entrées de répertoire parent et actuel
			if ($file == '.' || $file == '..') {
				continue;
			}
			// Construisez le chemin complet du fichier ou du répertoire
			$path = $dir . '/' . $file;
			// Vérifiez si c'est un répertoire
			if (is_dir($path)) {
				// Construisez la clé et la valeur pour le tableau associatif
				$key = $basePath === '' ? ucfirst($file) : $basePath . '/' . $file;
				$value = $path . '/';
				// Ajouter la clé et la valeur au tableau associatif
				$subdirs[$key] = $value;
				// Appeler la fonction récursivement pour ajouter les sous-répertoires
				$subdirs = array_merge($subdirs, $this->getSubdirectories($path, $key));
			}
		}
		// Fermez le gestionnaire de dossier
		closedir($dh);
		return $subdirs;
	}
}
