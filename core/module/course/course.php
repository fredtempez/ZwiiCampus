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

class course extends common
{

    public static $actions = [
        'swap' => self::GROUP_VISITOR,
        'suscribe' => self::GROUP_VISITOR,
        'unsuscribe' => self::GROUP_MEMBER,
        'index' => self::GROUP_EDITOR,
        'edit' => self::GROUP_EDITOR,
        'add' => self::GROUP_ADMIN,
        'delete' => self::GROUP_ADMIN,
        'category' => self::GROUP_ADMIN,
        'categoryAdd' => self::GROUP_ADMIN,
        'categoryEdit' => self::GROUP_ADMIN,
        'categoryDelete' => self::GROUP_ADMIN,
        'users' => self::GROUP_EDITOR,
        'usersAdd' => self::GROUP_EDITOR,
        'userDelete' => self::GROUP_EDITOR,
        'usersDelete' => self::GROUP_EDITOR,
        'userHistory' => self::GROUP_EDITOR,
        'usersHistoryExport' => self::GROUP_EDITOR,
        'userHistoryExport' => self::GROUP_EDITOR,
    ];

    public static $courseAccess = [
        self::COURSE_ACCESS_OPEN => 'Ouvert',
        self::COURSE_ACCESS_DATE => 'Période d\'ouverture',
        self::COURSE_ACCESS_CLOSE => 'Fermé',
    ];

    public static $courseEnrolment = [
        self::COURSE_ENROLMENT_GUEST => 'Anonyme',
        self::COURSE_ENROLMENT_SELF => 'Inscription libre',
        self::COURSE_ENROLMENT_SELF_KEY => 'Inscription avec clé',
        self::COURSE_ENROLMENT_MANDATORY => 'Imposée'
    ];

    public static $courseTeachers = [];

    public static $courseCategories = [];

    public static $courseUsers = [];


    public static $alphabet = [];

    public static $courseGroups = [
        'all' => 'Tout'
    ];

    public static $courses = [];

    public static $swapMessage = [];

    public static $pagesList = ['accueil' => 'Accueil'];


    public static $userHistory = [];

    public function index()
    {

        self::$courses = array();
        if (
            $this->getUser('id')
            && $this->getUser('group')
            && $this->getCoursesByUser($this->getUser('id'), $this->getUser('group'))
        ) {
            foreach ($this->getCoursesByUser($this->getUser('id'), $this->getUser('group')) as $courseId => $courseValue) {
                $categorieUrl = helper::baseUrl() . 'course/swap/' . $courseId;
                $authorId = $this->getData(['course', $courseId, 'author']);
                $author = isset($authorId)
                    ? sprintf('%s %s', $this->getData(['user', $authorId, 'firstname']), $this->getData(['user', $authorId, 'lastname']))
                    : '';
                $access = self::$courseAccess[$courseValue['access']];
                $enrolment = self::$courseEnrolment[$courseValue['enrolment']];
                $description = sprintf('%s<br />%s<br />%s<br />', $courseValue['description'], $access, $enrolment);
                self::$courses[] = [
                    $courseValue['title'],
                    $author,
                    $description,
                    '<a href="' . $categorieUrl . '" target="_blank">' . $categorieUrl . '</a>',
                    template::button('categoryUser' . $courseId, [
                        'href' => helper::baseUrl() . 'course/users/' . $courseId,
                        'value' => template::ico('users'),
                        'help' => 'Participants'
                    ]),
                    template::button('courseEdit' . $courseId, [
                        'href' => helper::baseUrl() . 'course/edit/' . $courseId,
                        'value' => template::ico('pencil'),
                        'help' => 'Éditer'
                    ]),
                    template::button('courseDelete' . $courseId, [
                        'class' => 'courseDelete buttonRed',
                        'href' => helper::baseUrl() . 'course/delete/' . $courseId,
                        'value' => template::ico('trash'),
                        'help' => 'Supprimer'
                    ])

                ];
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Espaces disponibles'),
            'view' => 'index'
        ]);
    }

    /**
     * Ajoute un nouveau contenu
     */
    public function add()
    {

        // Soumission du formulaire
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {
            $courseId = uniqid();
            // Créer la structure de données
            mkdir(self::DATA_DIR . $courseId);

            $this->initDB('page', $courseId);
            $this->initDB('module', $courseId);
            $this->initDB('theme', $courseId);
            $this->initData('page', $courseId);
            $this->initData('module', $courseId);
            $this->initData('theme', $courseId);

            // BDD des inscrits
            $this->setData([
                'enrolment',
                $courseId,
                []
            ]);


            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseAddTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseAddAuthor'),
                    'homePageId' => 'accueil',
                    'category' => $this->getInput('courseAddCategorie'),
                    'description' => $this->getInput('courseAddDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseAddAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseAddOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseAddClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseAddEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseAddEnrolmentKey'),
                    'limitEnrolment' => $this->getInput('courseAddEnrolmentLimit', helper::FILTER_BOOLEAN),
                    'limitEnrolmentDate' => $this->getInput('courseAddEnrolmentLimitDate', helper::FILTER_DATETIME),
                ]
            ]);

            // Copie du thème
            $sourceId = $this->getInput('courseAddTheme');
            copy(self::DATA_DIR . $sourceId . '/theme.json', self::DATA_DIR . $courseId . '/theme.json');
            copy(self::DATA_DIR . $sourceId . '/theme.css', self::DATA_DIR . $courseId . '/theme.css');

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Espace créé'),
                'state' => true
            ]);
        }

        // Liste des enseignants pour le sélecteur d'auteurs
        $teachers = $this->getData(['user']);
        foreach ($teachers as $teacherId => $teacherInfo) {
            if ($teacherInfo["group"] >= 2) {
                self::$courseTeachers[$teacherId] = $teacherInfo["firstname"] . ' ' . $teacherInfo["lastname"];
            }
        }

        // Liste des catégories de contenu
        self::$courseCategories = $this->getData(['category']);

        // Liste des contenus disponibles pour la copie du thème
        self::$courses = $this->getData(['course']);
        self::$courses = helper::arrayColumn(self::$courses, 'title', 'SORT_ASC');
        self::$courses = array_merge(['home' => 'Accueil de la plate-forme'], self::$courses);

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Ajouter un espace'),
            'view' => 'add'
        ]);
    }

    /**
     * Edite un contenu
     */
    public function edit()
    {

        // Soumission du formulaire
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {
            $courseId = $this->getUrl(2);
            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseEditShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseEditAuthor'),
                    'homePageId' => $this->getInput('courseEditHomePageId'),
                    'category' => $this->getInput('courseEditCategorie'),
                    'description' => $this->getInput('courseEditDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseEditAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseEditEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseEditEnrolmentKey'),
                    'limitEnrolment' => $this->getInput('courseEditEnrolmentLimit', helper::FILTER_BOOLEAN),
                    'limitEnrolmentDate' => $this->getInput('courseEditEnrolmentLimitDate', helper::FILTER_DATETIME),
                ]
            ]);

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Espace modifié'),
                'state' => true
            ]);
        }

        // Liste des enseignants pour le sélecteur d'auteurs
        $teachers = $this->getData(['user']);
        foreach ($teachers as $teacherId => $teacherInfo) {
            if ($teacherInfo["group"] >= 2) {
                self::$courseTeachers[$teacherId] = $teacherInfo["firstname"] . ' ' . $teacherInfo["lastname"];
            }
        }

        // Liste des catégories de contenu
        self::$courseCategories = $this->getData(['category']);

        // Liste des pages disponibles
        $this->initDB('page', $this->getUrl(2));
        self::$pagesList = $this->getData(['page']);
        foreach (self::$pagesList as $page => $pageId) {
            if (
                $this->getData(['page', $page, 'block']) === 'bar' ||
                $this->getData(['page', $page, 'disable']) === true
            ) {
                unset(self::$pagesList[$page]);
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Editer un espace'),
            'view' => 'edit'
        ]);
    }

    public function delete()
    {
        $courseId = $this->getUrl(2);
        if (
            ($this->getUser('permission', __CLASS__, __FUNCTION__) !== true
                // Le contenu n'existe pas
                || $this->getData(['course', $courseId]) === null)
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
            // Suppression
        } else {
            // Active l'accueil
            $_SESSION['ZWII_SITE_CONTENT'] = 'home';
            // ET efface la structure
            if (is_dir(self::DATA_DIR . $courseId)) {
                $success = $this->deleteDir(self::DATA_DIR . $courseId);
                $this->deleteData(['course', $courseId]);
                $this->deleteData(['enrolment', $courseId]);
            }

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => $success ? helper::translate('Espace supprimé') : helper::translate('Erreur de suppression'),
                'state' => $success
            ]);
        }

    }

    /**
     * Liste les catégories d'un contenu
     */
    public function category()
    {
        $categories = $this->getData(['category']);
        ksort($categories);
        foreach ($categories as $categoryId => $categoryTitle) {
            self::$courseCategories[] = [
                $categoryId,
                $categoryTitle,
                template::button('categoryEdit' . $categoryId, [
                    'href' => helper::baseUrl() . 'course/categoryEdit/' . $categoryId,
                    'value' => template::ico('pencil'),
                    'help' => 'Éditer'
                ]),
                template::button('courseDelete' . $categoryId, [
                    'class' => 'categoryDelete buttonRed',
                    'href' => helper::baseUrl() . 'course/categoryDelete/' . $categoryId,
                    'value' => template::ico('trash'),
                    'help' => 'Supprimer'
                ])
            ];
        }
        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Catégories'),
            'view' => 'category'
        ]);
    }

    public function categoryAdd()
    {

        // Soumission du formulaire
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {
            $categoryId = $this->getInput('categoryAddTitle', helper::FILTER_ID, true);
            $this->setData([
                'category',
                $categoryId,
                $this->getInput('categoryAddTitle', helper::FILTER_STRING_SHORT, true)
            ]);
            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/category',
                'notification' => helper::translate('Catégorie créée'),
                'state' => true
            ]);
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Ajouter une catégorie'),
            'view' => 'categoryAdd'
        ]);
    }

    public function categoryEdit()
    {

        // Soumission du formulaire
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {
            $categoryId = $this->getUrl(2);
            $this->setData([
                'category',
                $categoryId,
                $this->getInput('categoryEditTitle', helper::FILTER_STRING_SHORT, true)
            ]);
            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/category',
                'notification' => helper::translate('Catégorie éditée'),
                'state' => true
            ]);
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Éditer une catégorie'),
            'view' => 'categoryEdit'
        ]);
    }

    public function categoryDelete()
    {

        // Accès refusé
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) !== true
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        } else {
            $categories = helper::arrayColumn($this->getData(['course']), 'category', 'SORT_ASC');
            $courseId = $this->getUrl(2);
            $message = helper::translate('Une catégorie affectée ne peut pas être effacée');
            $state = false;
            if (in_array($courseId, $categories) === false) {
                $this->deleteData(['category', $this->getUrl(2)]);
                // Valeurs en sortie
                $message = helper::translate('Catégorie effacée');
                $state = true;
            }

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/category',
                'notification' => $message,
                'state' => $state
            ]);
        }

    }

    public function users()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Liste des groupes et des profils
        $courseGroups = $this->getData(['profil']);
        foreach ($courseGroups as $groupId => $groupValue) {
            switch ($groupId) {
                case "-1":
                case "0":
                    break;
                case "3":
                    self::$courseGroups['30'] = 'Administrateur';
                    $profils['30'] = 0;
                    break;
                case "1":
                case "2":
                    foreach ($groupValue as $profilId => $profilValue) {
                        if ($profilId) {
                            self::$courseGroups[$groupId . $profilId] = sprintf(helper::translate('Groupe %s - Profil %s'), self::$groupPublics[$groupId], $profilValue['name']);
                            $profils[$groupId . $profilId] = 0;
                        }
                    }
            }
        }

        // Liste alphabétique
        self::$alphabet = range('A', 'Z');
        $alphabet = range('A', 'Z');
        self::$alphabet = array_combine($alphabet, self::$alphabet);
        self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

        // Liste des pages contenues dans cet espace et exclure les barres et les pages masquées
        $sumPages = 0;
        $pages = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        $pages = $pages ['page'];
        foreach ($pages as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $sumPages++;
            }
        }

        // Liste des inscrits dans le contenu sélectionné.
        $users = $this->getData(['enrolment', $courseId]);

        // Tri du tableau par défaut par $userId
        ksort($users);

        foreach ($users as $userId => $userValue) {

            // Date et heure de la dernière page vue
            // Compatibilité anciennes versions
            if (
                $this->getData(['enrolment', $courseId, $userId, 'lastPageView']) === null
                or $this->getData(['enrolment', $courseId, $userId, 'datePageView']) === null
            ) {
                if (!empty($userValue['history'])) {
                    $maxTime = max($userValue['history']);
                    $lastPageId = array_search($maxTime, $userValue['history']);
                    $this->setData(['enrolment', $courseId, $userId, 'lastPageView', $lastPageId]);
                    $this->setData(['enrolment', $courseId, $userId, 'datePageView', $maxTime]);
                }
            }


            // Compte les rôles valides
            if (isset($profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])])) {
                $profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])]++;
            }

            // Filtres
            if ($this->isPost()) {
                // Groupe et profils
                $group = (string) $this->getData(['user', $userId, 'group']);
                $profil = (string) $this->getData(['user', $userId, 'profil']);
                $firstName = $this->getData(['user', $userId, 'firstname']);
                $lastName = $this->getData(['user', $userId, 'lastname']);
                if (
                    $this->getInput('courseFilterGroup', helper::FILTER_INT) > 0
                    && $this->getInput('courseFilterGroup', helper::FILTER_STRING_SHORT) !== $group . $profil
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

            // Taux de parcours
            $viewPages = $this->getData(['enrolment', $courseId, $userId, 'history']) !== null ?
                count(array_keys($this->getData(['enrolment', $courseId, $userId, 'history']))) :
                0;
            // Construction du tableau
            self::$courseUsers[] = [
                $userId,
                $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
                $pages[$this->getData(['enrolment', $courseId, $userId, 'lastPageView'])]['title'],
                helper::dateUTF8('%d %B %Y - %H:%M', $this->getData(['enrolment', $courseId, $userId, 'datePageView'])),
                $this->getData(['user', $userId, 'tags']),
                template::button('userHistory' . $userId, [
                    'href' => helper::baseUrl() . 'course/userHistory/' . $courseId . '/' . $userId,
                    'value' => !empty($userValue['history']) ? round(($viewPages * 100) / $sumPages, 1) . ' %' : '0%',
                    'disable' => empty($userValue['history'])
                ]),
                template::button('userDelete' . $userId, [
                    'class' => 'userDelete buttonRed',
                    'href' => helper::baseUrl() . 'course/userDelete/' . $courseId . '/' . $userId,
                    'value' => template::ico('user'),
                    'help' => 'Désinscrire'
                ])
            ];

        }

        // Ajoute les effectifs aux profils du sélecteur
        foreach (self::$courseGroups as $groupId => $groupValue) {
            if ($groupId === 'all') {
                self::$courseGroups['all'] = self::$courseGroups['all'] . ' (' . array_sum($profils) . ')';
            } else {
                self::$courseGroups[$groupId] = self::$courseGroups[$groupId] . ' (' . $profils[$groupId] . ')';
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => sprintf(helper::translate('Participants %s'), $this->getData(['course', $courseId, 'title'])),
            'view' => 'users',
        ]);
    }

    public function usersAdd()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Inscription des utilisateurs cochés
        if (
            isset($_POST['courseUsersAddSubmit'])
        ) {
            foreach ($_POST as $keyPost => $valuePost) {
                // Exclure les variables post qui ne sont pas des userId et ne traiter que les non inscrits
                if (
                    $this->getData(['user', $keyPost]) !== null
                    && $this->getData(['enrolment', $courseId, $keyPost]) === null
                ) {
                    $this->setData(['enrolment', $courseId, $keyPost, 'history', array()]);
                }
            }
        }

        // Liste des groupes et des profils
        $courseGroups = $this->getData(['profil']);
        foreach ($courseGroups as $groupId => $groupValue) {
            switch ($groupId) {
                case "-1":
                case "0":
                    break;
                case "3":
                    self::$courseGroups['30'] = 'Administrateur';
                    $profils['30'] = 0;
                    break;
                case "1":
                case "2":
                    foreach ($groupValue as $profilId => $profilValue) {
                        if ($profilId) {
                            self::$courseGroups[$groupId . $profilId] = sprintf(helper::translate('Groupe %s - Profil %s'), self::$groupPublics[$groupId], $profilValue['name']);
                            $profils[$groupId . $profilId] = 0;
                        }
                    }
            }
        }

        // Liste alphabétique
        self::$alphabet = range('A', 'Z');
        $alphabet = range('A', 'Z');
        self::$alphabet = array_combine($alphabet, self::$alphabet);
        self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

        // Liste des inscrits dans le contenu sélectionné.
        $suscribers = $this->getData(['enrolment', $courseId]);
        $suscribers = array_keys($suscribers);

        $users = array_diff_key($this->getData(['user']), array_flip($suscribers));

        // Tri du tableau par défaut par $userId
        ksort($users);

        foreach ($users as $userId => $userValue) {

            // Compte les rôles
            if (isset($profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])])) {
                $profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])]++;
            }

            // Filtres
            if (
                isset($_POST['courseFilterGroup'])
                || isset($_POST['courseFilterFirstName'])
                || isset($_POST['courseFilterLastName'])
            ) {

                // Groupe et profils
                $group = (string) $this->getData(['user', $userId, 'group']);
                $profil = (string) $this->getData(['user', $userId, 'profil']);
                $firstName = $this->getData(['user', $userId, 'firstname']);
                $lastName = $this->getData(['user', $userId, 'lastname']);
                if (
                    $this->getInput('courseFilterGroup', helper::FILTER_INT) > 0
                    && $this->getInput('courseFilterGroup', helper::FILTER_STRING_SHORT) !== $group . $profil
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
            self::$courseUsers[] = [
                template::checkbox($userId, true, '', ['class' => 'checkboxSelect']),
                $userId,
                $this->getData(['user', $userId, 'firstname']),
                $this->getData(['user', $userId, 'lastname']),
                $this->getData(['user', $userId, 'tags']),
            ];

        }

        // Ajoute les effectifs aux profils du sélecteur
        foreach (self::$courseGroups as $groupId => $groupValue) {
            if ($groupId === 'all') {
                self::$courseGroups['all'] = self::$courseGroups['all'] . ' (' . array_sum($profils) . ')';
            } else {
                self::$courseGroups[$groupId] = self::$courseGroups[$groupId] . ' (' . $profils[$groupId] . ')';
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Inscription en masse'),
            'view' => 'usersAdd'
        ]);
    }

    /**
     * Désinscription d'un utilisateur
     */
    public function userDelete()
    {
        // Accès refusé
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) !== true
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        } else {
            $this->deleteData(['enrolment', $this->getUrl(2), $this->getUrl(3)]);
            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/users/' . $this->getUrl(2),
                'notification' => sprintf(helper::translate('%s est désinscrit'), $this->getUrl(3)),
                'state' => true
            ]);
        }
    }

    /** 
     * Désinscription de tous les utilisateurs
     */
    public function usersDelete()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Inscription des utilisateurs cochés
        if (
            isset($_POST['courseUsersDeleteSubmit'])
        ) {
            foreach ($_POST as $keyPost => $valuePost) {
                // Exclure les variables post qui ne sont pas des userId et ne traiter que les non inscrits
                if (
                    $this->getData(['user', $keyPost]) !== null
                    && $this->getData(['enrolment', $courseId, $keyPost]) !== null
                ) {
                    $this->deleteData(['enrolment', $courseId, $keyPost]);
                }
            }
        }

        // Liste des groupes et des profils
        $courseGroups = $this->getData(['profil']);
        foreach ($courseGroups as $groupId => $groupValue) {
            switch ($groupId) {
                case "-1":
                case "0":
                    break;
                case "3":
                    self::$courseGroups['30'] = 'Administrateur';
                    $profils['30'] = 0;
                    break;
                case "1":
                case "2":
                    foreach ($groupValue as $profilId => $profilValue) {
                        if ($profilId) {
                            self::$courseGroups[$groupId . $profilId] = sprintf(helper::translate('Groupe %s - Profil %s'), self::$groupPublics[$groupId], $profilValue['name']);
                            $profils[$groupId . $profilId] = 0;
                        }
                    }
            }
        }

        // Liste alphabétique
        self::$alphabet = range('A', 'Z');
        $alphabet = range('A', 'Z');
        self::$alphabet = array_combine($alphabet, self::$alphabet);
        self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

        // Liste des inscrits dans le contenu sélectionné.
        $users = $this->getData(['enrolment', $courseId]);

        // Tri du tableau par défaut par $userId
        ksort($users);

        foreach ($users as $userId => $userValue) {

            // Compte les rôles
            if (isset($profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])])) {
                $profils[$this->getData(['user', $userId, 'group']) . $this->getData(['user', $userId, 'profil'])]++;
            }

            // Filtres
            if (
                isset($_POST['courseFilterGroup'])
                || isset($_POST['courseFilterFirstName'])
                || isset($_POST['courseFilterLastName'])
            ) {

                // Groupe et profils
                $group = (string) $this->getData(['user', $userId, 'group']);
                $profil = (string) $this->getData(['user', $userId, 'profil']);
                $firstName = $this->getData(['user', $userId, 'firstname']);
                $lastName = $this->getData(['user', $userId, 'lastname']);
                if (
                    $this->getInput('courseFilterGroup', helper::FILTER_INT) > 0
                    && $this->getInput('courseFilterGroup', helper::FILTER_STRING_SHORT) !== $group . $profil
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
            self::$courseUsers[] = [
                template::checkbox($userId, true, '', ['class' => 'checkboxSelect']),
                $userId,
                $this->getData(['user', $userId, 'firstname']),
                $this->getData(['user', $userId, 'lastname']),
                $this->getData(['user', $userId, 'tags']),
            ];

        }

        // Ajoute les effectifs aux profils du sélecteur
        foreach (self::$courseGroups as $groupId => $groupValue) {
            if ($groupId === 'all') {
                self::$courseGroups['all'] = self::$courseGroups['all'] . ' (' . array_sum($profils) . ')';
            } else {
                self::$courseGroups[$groupId] = self::$courseGroups[$groupId] . ' (' . $profils[$groupId] . ')';
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Désincription en masse'),
            'view' => 'usersDelete'
        ]);
    }

    /*
     * Traitement du changement de langue
     */
    public function swap()
    {
        $courseId = $this->getUrl(2);
        $userId = $this->getuser('id');
        $message = '';
        $redirect = helper::baseUrl();
        $state = true;

        if (
            // Sortir du contenu et afficher l'accueil
            $courseId === 'home'
        ) {
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }
        // l'étudiant est inscrit dans le contenu ET le contenu est ouvert
        // ou un admin  ou le prof du contenu sont connectés
        elseif (
            $this->courseIsUserEnroled($courseId)
            && $this->courseIsAvailable($courseId)
        ) {
            // Récupérer la dernière page visitée par cet utilisateur si elle existe
            $redirect = $this->getData(['enrolment', $courseId, $userId, 'lastPageView'])
                ? helper::baseUrl() . $this->getData(['enrolment', $courseId, $userId, 'lastPageView'])
                : helper::baseUrl() . $this->getData(['course', $courseId, 'homePageId']);
            /*
        $essage = $this->getData(['enrolment', $courseId, $userId, 'datePageView']) 
            ? $this->getData(['enrolment', $courseId, $userId, 'datePageView']) 
            : '';
            */
            if ($this->getData(['course', $courseId, 'access']) === self::COURSE_ACCESS_DATE) {
                $to = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI);
                $message .= sprintf(helper::translate('Ce contenu ferme le %s'), $to);
            } else {
                $message .= sprintf(helper::translate('Bienvenue dans l\'espace  %s'), $this->getData(['course', $courseId, 'title']));
            }
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }
        // Le contenu est fermé
        elseif ($this->courseIsAvailable($courseId) === false) {
            // Génération du message
            $message = helper::translate('Cet espace est fermé');
            $state = false;
            if ($this->getData(['course', $courseId, 'access']) === self::COURSE_ACCESS_DATE) {
                $from = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'openingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'openingDate']), self::$i18nUI);
                $to = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI);
                $message = sprintf(helper::translate('Cet espace ouvre le <br>%s <br> et ferme le %s'), $from, $to);
            }
        }
        // le contenu est ouvert, l'étudiant n'est pas inscrit, l'accès au contenu est anonyme
        elseif (
            $this->courseIsAvailable($courseId) &&
            $this->courseIsUserEnroled($courseId) === false
        ) {
            // Gérer les modalités d'inscription
            switch ($this->getData(['course', $courseId, 'enrolment'])) {
                // Anonyme
                case self::COURSE_ENROLMENT_GUEST:
                    $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
                    break;
                // Auto avec ou sans clé
                case self::COURSE_ENROLMENT_SELF:
                    //L'étudiant doit disposer d'un compte
                    if ($this->getUser('id')) {
                        $redirect = helper::baseUrl() . 'course/suscribe/' . $courseId;
                    } else {
                        $message = helper::translate('Vous devez disposer d\'un compte pour accéder à cet espace');
                        $state = false;
                    }
                    break;
                case self::COURSE_ENROLMENT_SELF_KEY:
                    //L'étudiant doit disposer d'un compte
                    if ($this->getUser('id')) {
                        $redirect = helper::baseUrl() . 'course/suscribe/' . $courseId;
                    } else {
                        $message = helper::translate('Vous devez disposer d\'un compte et d\'une clé pour accéder à cet espace');
                        $state = false;
                    }
                    break;
                // Par le prof
                case self::COURSE_ENROLMENT_MANDATORY:
                    $message = helper::translate('L\'enseignant doit vous inscrire');
                    $state = false;
                    break;
                default:
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => $redirect,
            'notification' => helper::translate($message),
            'state' => $state,
        ]);

    }

    /**
     * Liste les pages consultées par un utilisateur
     */
    public function userHistory()
    {

        $courseId = $this->getUrl(2);
        $userId = $this->getUrl(3);
        $history = $this->getData(['enrolment', $courseId, $userId, 'history']);

        // Liste des pages contenues dans cet espace et exclure les barres et les pages masquées
        $data = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        $data = $data['page'];
        $count = 0;
        foreach ($data as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $count++;
                $pages[$pageId] = [
                    'number' => $count,
                    'title' => $pageData['title'],
                ];
            }
        }

        foreach ($history as $pageId => $times) {
            // Dates de consultation de la page
            if (is_array($times)) {
                $d = array();
                foreach ($times as $time) {
                    $d[] = helper::dateUTF8('%d %B %Y - %H:%M:%S', $time);
                }
                $dates = implode('<br />', $d);
            } else {
                $dates = helper::dateUTF8('%d %B %Y - %H:%M:%S', $times);
            }

            self::$userHistory[$pageId] = [
                $pages[$pageId]['number'],
                $pages[$pageId]['title'],
                $dates,
            ];
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Historique ') . $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
            'view' => 'userHistory'
        ]);

    }

    public function usersHistoryExport()
    {

        $courseId = $this->getUrl(2);

        // Statistiques du contenu sélectionné calcul du nombre de pages
        $sumPages = 0;
        $data = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        // Exclure les barres et les pages masquées
        foreach ($data['page'] as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $sumPages++;
                $pages[$pageId] = $pageData['title'];
            }
        }

        // Liste des inscrits dans le contenu sélectionné.
        $users = $this->getData(['enrolment', $courseId]);

        // Tri du tableau par défaut par $userId
        ksort($users);

        // Dossier temporaire
        if (is_dir(self::FILE_DIR . 'source/export') === false) {
            mkdir(self::FILE_DIR . 'source/export');
        }
        if (is_dir(self::FILE_DIR . 'source/export/' . $courseId) === false) {
            mkdir(self::FILE_DIR . 'source/export/' . $courseId);
        }
        $path = self::FILE_DIR . 'source/export/';

        $filename = $path . $courseId . '/synthèse' . helper::dateUTF8('%Y%m%d', time()) . '.csv';

        foreach ($users as $userId => $userValue) {
            $history = $userValue['history'];

            $maxTime = max($history);
            $pageId = array_search($maxTime, $history);

            // Taux de parcours
            $viewPages = count($this->getData(['enrolment', $courseId, $userId, 'history']));

            // Construction du tableau
            self::$courseUsers[] = [
                $userId,
                $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
                $pages[$pageId],
                helper::dateUTF8('%d %B %Y - %H:%M', $maxTime),
                round(($viewPages * 100) / $sumPages, 1)
            ];

            // Synthèse des historiques
            // ------------------------
            // Ouverture du fichier en écriture
            $file = fopen($filename, 'w');

            foreach (self::$courseUsers as $user) {
                // Décode les entités HTML dans chaque élément du tableau
                $decodedUser = array_map('html_entity_decode', $user);

                // Écrire la ligne dans le fichier CSV
                fputcsv($file, $decodedUser, ';');
            }
            // Fermeture du fichier
            fclose($file);

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/users/' . $courseId,
                'notification' => 'Création ' . basename($filename) . ' dans le dossier "Export"',
                'state' => true,
            ]);

        }

    }

    public function userHistoryExport()
    {

        $courseId = $this->getUrl(2);
        $userId = $this->getUrl(3);
        $history = $this->getData(['enrolment', $courseId, $userId, 'history']);

        // Liste des pages contenues dans cet espace et exclure les barres et les pages masquées
        $data = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        $data = $data['page'];
        $count = 0;
        foreach ($data as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $count++;
                $pages[$pageId] = [
                    'number' => $count,
                    'title' => $pageData['title'],
                ];
            }
        }

        foreach ($history as $pageId => $times) {
            // Dates de consultation de la page
            if (is_array($times)) {
                $d = array();
                foreach ($times as $time) {
                    self::$userHistory[] = [
                        $pages[$pageId]['number'],
                        $pageId,
                        html_entity_decode($pages[$pageId]['title']),
                        helper::dateUTF8('%d %B %Y %H:%M:%S', $time)
                    ];
                }
            } else {
                self::$userHistory[] = [
                    $pages[$pageId]['number'],
                    $pageId,
                    html_entity_decode($pages[$pageId]['title']),
                    helper::dateUTF8('%d %B %Y %H:%M:%S', $times)
                ];
            }


        }

        // Dossier temporaire
        if (is_dir(self::FILE_DIR . 'source/export') === false) {
            mkdir(self::FILE_DIR . 'source/export');
        }
        if (is_dir(self::FILE_DIR . 'source/export/' . $courseId) === false) {
            mkdir(self::FILE_DIR . 'source/export/' . $courseId);
        }
        $path = self::FILE_DIR . 'source/export/';
        $filename = $path . $courseId . '/' . $userId . '.csv';
        $file = fopen($filename, 'w');
        
        foreach (self::$userHistory as $keys => $values) {
            $data = $values;
            // Écrire la ligne dans le fichier CSV
            fputcsv($file, $data, ';');
        }
        // Fermeture du fichier
        fclose($file);

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => helper::baseUrl() . 'course/userHistory/' . $courseId . '/' . $userId,
            'notification' => 'Création ' . basename($filename) . ' dans le dossier "Export"',
            'state' => true,
        ]);


    }

    // Génération du message d'inscription
    public function suscribe()
    {
        $courseId = $this->getUrl(2);
        $userId = $this->getUser('id');

        // Soumission du formulaire
        if (
            $this->isPost()
        ) {
            if (
                $this->courseIsAvailable($courseId)
            ) {
                // Inscrit l'étudiant
                switch ($this->getData(['course', $courseId, 'enrolment'])) {
                    case self::COURSE_ENROLMENT_SELF:
                        $this->courseEnrolUser($courseId, $userId);
                        // Stocker la sélection
                        $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
                        // Valeurs en sortie
                        $this->addOutput([
                            'redirect' => helper::baseUrl()
                        ]);
                        break;
                    case self::COURSE_ENROLMENT_SELF_KEY:
                        if ($this->getInput('courseSwapEnrolmentKey', helper::FILTER_PASSWORD, true) === $this->getData(['course', $courseId, 'enrolmentKey'])) {
                            $this->courseEnrolUser($courseId, $userId);
                            // Stocker la sélection
                            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
                            // Valeurs en sortie
                            $this->addOutput([
                                'redirect' => helper::baseUrl()
                            ]);
                        } else {
                            // Valeurs en sortie
                            $this->addOutput([
                                'redirect' => helper::baseUrl() . 'course/suscribe/' . $courseId,
                                'state' => false,
                                'notification' => 'La clé est incorrecte'
                            ]);
                        }
                        break;
                }
            }
        }
        // L'étudiant est-il  inscrit
        self::$swapMessage['submitLabel'] = helper::translate('M\'inscrire');
        self::$swapMessage['enrolmentMessage'] = '';
        self::$swapMessage['enrolmentKey'] = '';
        if ($this->courseIsUserEnroled($courseId) === false) {
            switch ($this->getData(['course', $courseId, 'enrolment'])) {
                case self::COURSE_ENROLMENT_SELF:
                    if ($userId == '') {
                        self::$swapMessage['enrolmentMessage'] = helper::translate('Connectez-vous pour accéder à ce espace.');
                        self::$swapMessage['submitLabel'] = helper::translate('Connexion');
                    }
                    break;
                case self::COURSE_ENROLMENT_SELF_KEY:
                    if ($userId == '') {
                        self::$swapMessage['enrolmentMessage'] = helper::translate('Connectez-vous pour accéder à cet espace.');
                        self::$swapMessage['submitLabel'] = helper::translate('Connexion');
                    } else {
                        self::$swapMessage['enrolmentKey'] = template::text('courseSwapEnrolmentKey', [
                            'label' => helper::translate('Clé d\'inscription'),
                        ]);
                    }
                    break;
                case self::COURSE_ENROLMENT_MANDATORY:
                    self::$swapMessage['enrolmentMessage'] = helper::translate('Vous ne pouvez pas vous inscrire par vous-même.');
                    break;
            }
            // Valeurs en sortie
            $this->addOutput([
                'title' => sprintf(helper::translate('Accéder à l\'espace %s'), $this->getData(['course', $this->getUrl(2), 'title'])),
                'view' => 'suscribe',
                'display' => self::DISPLAY_LAYOUT_LIGHT,
            ]);
        }
    }

    public function unsuscribe()
    {
        // Désincription du contenu ouvert ou du contenu sélectionné
        $courseId = $this->getUrl(2) ? $this->getUrl(2) : self::$siteContent;
        // home n'est pas un contenu dans lequel on peut se désincrire
        if (
            $courseId !== 'home'
            && array_key_exists($courseId, $this->getData(['course']))
        ) {
            $userId = $this->getUser('id');
            $this->deleteData(['enrolment', $courseId, $userId]);
            $_SESSION['ZWII_SITE_CONTENT'] = 'home';
            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl(),
                'notification' => helper::translate('Désinscription'),
                'state' => true,
            ]);

        }
    }


    /**
     * Autorise l'accès à un contenu
     * @param @return bool le user a le droit d'entrée dans le contenu
     * @param string $userId identifiant de l'utilisateur
     * @param string $courseId identifiant du contenu sollicité
     */
    private function courseIsUserEnroled($courseId)
    {
        $userId = $this->getUser('id');
        $group = $userId ? $this->getData(['user', $userId, 'group']) : null;
        switch ($group) {
            case self::GROUP_ADMIN:
                $r = true;
                break;
            case self::GROUP_EDITOR:
                $r = in_array($userId, array_keys($this->getData(['enrolment', $courseId])));
                break;
            case self::GROUP_MEMBER:
                $r = in_array($userId, array_keys($this->getData(['enrolment', $courseId])));
                break;
            // Visiteur non connecté
            case self::GROUP_VISITOR:
            case null:
                $r = $this->getData(['course', $courseId, 'enrolment']) === self::COURSE_ENROLMENT_GUEST;
                break;
            default:
                $r = false;
        }
        return $r;
    }

    /**
     * Autorise l'accès à un contenu
     * @param @return bool le user a le droit d'entrée dans le contenu
     * @param string $courseId identifiant du contenu sollicité
     */
    public function courseIsAvailable($courseId)
    {
        // L'accès à l'accueil est toujours autorisé
        if ($courseId === 'home') {
            return true;
        }
        // Si un utilisateur connecté est admin aou auteur, c'est autorisé
        if (
            $this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD') &&
            $this->getUser('group') === self::GROUP_ADMIN || $this->getUser('id') === $this->getData(['user', $courseId, 'author'])
        ) {
            return true;
        }
        // Retourne le statut du contenu dans les autres cas
        $access = $this->getData(['course', $courseId, 'access']);
        switch ($access) {
            case self::COURSE_ACCESS_OPEN:
                return true;
            case self::COURSE_ACCESS_DATE:
                return (
                    time() >= $this->getData(['course', $courseId, 'openingDate']) &&
                    time() <= $this->getData(['course', $courseId, 'closingDate'])
                );
            case self::COURSE_ACCESS_CLOSE:
                return false;
        }
    }

    private function countPages($array)
    {
        $count = 0;
        foreach ($array as $key => $value) {
            $count++; // Incrémente le compteur pour chaque clé associative trouvée
            if (is_array($value)) {
                $count += $this->countPages($value); // Appelle récursivement la fonction si la valeur est un tableau
            }
        }
        return $count;
    }

    private function courseEnrolUser($courseId, $userId)
    {
        $this->setData([
            'enrolment',
            $courseId,
            $userId,
            [
                'history' => [],
            ]
        ]);
    }

}