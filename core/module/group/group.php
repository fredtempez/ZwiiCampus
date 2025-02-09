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
		'usersDelete' => self::ROLE_EDITOR,
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
			$group = $this->getData(['group']);
			ksort($group);
			foreach ($group as $groupId => $groupTitle) {
				self::$groups[] = [
					$groupTitle,
					template::button('groupEdit' . $groupId, [
						'href' => helper::baseUrl() . 'group/usersAdd/' . $groupId,
						'value' => template::ico('user-plus'),
						'help' => 'Inscrire'
					]),
					template::button('groupEdit' . $groupId, [
						'href' => helper::baseUrl() . 'group/usersdelete/' . $groupId,
						'value' => template::ico('user-times'),
						'help' => 'Désinscrire'
					]),
					template::button('groupEdit' . $groupId, [
						'href' => helper::baseUrl() . 'group/edit/' . $groupId,
						'value' => template::ico('pencil'),
						'help' => 'Éditer'
					]),
					template::button('groupDelete' . $groupId, [
						'class' => 'groupDelete buttonRed',
						'href' => helper::baseUrl() . 'group/delete/' . $groupId,
						'value' => template::ico('trash'),
						'help' => 'Supprimer'
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
			$groupId = $this->getInput('groupAddTitle', helper::FILTER_ID, true);
			$this->setData([
				'group',
				$groupId,
				$this->getInput('groupAddTitle', helper::FILTER_STRING_SHORT, true)
			]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'group',
				'notification' => helper::translate('groupe créé'),
				'state' => true
			]);        // Valeurs en sortie

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
		} else {
		}

		// Valeurs en sortie
		$this->addOutput([
			'title' => helper::translate('Utilisateurs'),
			'view' => 'index',
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
			$groups = helper::arrayColumn($this->getData(['course']), 'group', 'SORT_ASC');
			$users = $this->getUrl('user');
			$message = helper::translate('Un groupe affecté ne peut pas être effacé');
			$state = false;
			if (in_array($users, $groups) === false) {
				$this->deleteData(['group', $this->getUrl(2)]);
				// Valeurs en sortie
				$message = helper::translate('Groupe effacé');
				$state = true;
			}

			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'group',
				'notification' => $message,
				'state' => $state
			]);
		}
	}

	public function usersAdd()
    {

        // Contenu sélectionné
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
            isset($_POST['courseUsersAddSubmit'])
        ) {
            foreach ($_POST as $keyPost => $valuePost) {
                // Exclure les variables post qui ne sont pas des userId et ne traiter que les non inscrits
                if (
                    $this->getData(['user', $keyPost]) !== null
                    && $this->getData(['enrolment', $groupId, $keyPost]) === null
                ) {
                    $this->setData(['enrolment', $groupId, $keyPost, 'history', array()], false);
                }
            }
            // Sauvegarde la base manuellement
            $this->saveDB('enrolment');
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

            // Compte les rôles
            if (isset($profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])])) {
                $profils[$this->getData(['user', $userId, 'role']) . $this->getData(['user', $userId, 'profil'])]++;
            }

            // Filtres
            if (
                isset($_POST['courseFilterGroup'])
                || isset($_POST['courseFilterFirstName'])
                || isset($_POST['courseFilterLastName'])
            ) {

                // Groupe et profils
                $role = (string) $this->getData(['user', $userId, 'role']);
                $profil = (string) $this->getData(['user', $userId, 'profil']);
                $firstName = $this->getData(['user', $userId, 'firstname']);
                $lastName = $this->getData(['user', $userId, 'lastname']);
                if (
                    $this->getInput('courseFilterGroup', helper::FILTER_INT) > 0
                    && $this->getInput('courseFilterGroup', helper::FILTER_STRING_SHORT) !== $role . $profil
                )
                    continue;
                // Première lettre du prénom
                if (
                    $this->getInput('courseFilterFirstName', helper::FILTER_STRING_SHORT) !== 'all'
                    && $this->getInput('courseFilterFirstName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($firstName, 0, 1))
                )
                    continue;
                // Première lettre du nom
                if (
                    $this->getInput('courseFilterLastName', helper::FILTER_STRING_SHORT) !== 'all'
                    && $this->getInput('courseFilterLastName', helper::FILTER_STRING_SHORT) !== strtoupper(substr($lastName, 0, 1))
                )
                    continue;
            }

            // Construction du tableau
            self::$groupUsers[] = [
                template::checkbox($userId, true, '', ['class' => 'checkboxSelect']),
                $userId,
                $this->getData(['user', $userId, 'firstname']),
                $this->getData(['user', $userId, 'lastname']),
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
            'title' => helper::translate('Inscription en masse'),
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
