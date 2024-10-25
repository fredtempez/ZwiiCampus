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

class course extends common
{

    public static $actions = [
        'swap' => self::GROUP_VISITOR,
        'suscribe' => self::GROUP_VISITOR,
        'unsuscribe' => self::GROUP_MEMBER,
        'index' => self::GROUP_EDITOR, // Fait
        'edit' => self::GROUP_EDITOR, // Fait
        'manage' => self::GROUP_EDITOR, // Fait
        'users' => self::GROUP_EDITOR, // fait
        'usersAdd' => self::GROUP_EDITOR, //Fait
        'usersDelete' => self::GROUP_EDITOR, //Fait
        'usersReportExport' => self::GROUP_EDITOR, //fait
        'userDelete' => self::GROUP_EDITOR, //Fait
        'userReport' => self::GROUP_EDITOR, //Fait
        'userReportExport' => self::GROUP_EDITOR, //Fait
        'backup' => self::GROUP_EDITOR, // Fait
        'restore' => self::GROUP_EDITOR, //Fait
        'reset' => self::GROUP_EDITOR,
        'clone' => self::GROUP_ADMIN,
        'add' => self::GROUP_ADMIN,
        'delete' => self::GROUP_ADMIN,
        'category' => self::GROUP_ADMIN,
        'categoryAdd' => self::GROUP_ADMIN,
        'categoryEdit' => self::GROUP_ADMIN,
        'categoryDelete' => self::GROUP_ADMIN,
        'export' => self::GROUP_ADMIN,
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


    public static $userReport = [];

    public static $userGraph = [];

    public static $userStat = [];

    public function index()
    {
        // Tableau à transmettre à la fvue
        self::$courses = array();

        // Pointer RFM sur le dossier de l'espace
        self::$siteContent = 'home';

        if (
            $this->getUser('id')
            && $this->getUser('group')
        ) {
            foreach ($this->getData(['course']) as $courseId => $courseValue) {
                /**
                 * Filtres :
                 * Groupes acceptés :
                 * admin : tous les espaces
                 * editor : gère son espace son espace dans lequel il est inscrit
                 */
                if (
                    $this->permissionControl(__FUNCTION__, $courseId)
                ) {

                    $author = $this->getData(['course', $courseId, 'author'])
                        ? sprintf('%s %s', $this->getData(['user', $this->getData(['course', $courseId, 'author']), 'firstname']), $this->getData(['user', $this->getData(['course', $courseId, 'author']), 'lastname']))
                        : '';
                    $categorieUrl = helper::baseUrl() . 'course/swap/' . $courseId;
                    $info = sprintf(' <a href="%s">%s</a><br />Auteur : %s<br />Id : %s<br />', $categorieUrl, $this->getData(['course', $courseId, 'title']), $author, $courseId, );
                    $enrolment = sprintf(
                        'Accès : %s<br />Inscription : %s<br />',
                        self::$courseAccess[$this->getData(['course', $courseId, 'access'])],
                        self::$courseEnrolment[$this->getData(['course', $courseId, 'enrolment'])]
                    );
                    if ($this->getUser('permission', 'course', 'users') === true) {
                        $users = template::button('categoryUser' . $this->getUrl(2), [
                            'href' => helper::baseUrl() . 'course/users/' . $courseId,
                            'value' => template::ico('users'),
                        ]);
                    }
                    self::$courses[] = [
                        $info,
                        $this->getData(['course', $courseId, 'description']),
                        $enrolment,
                        $users,
                        template::button('categoryUser' . $courseId, [
                            'href' => helper::baseUrl() . 'course/manage/' . $courseId,
                            'value' => template::ico('sliders'),
                            'help' => 'Gérer'
                        ])
                    ];
                }
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Gestionnaire d\'espaces'),
            'view' => 'index',
            'vendor' => [
                'datatables'
            ]
        ]);
    }

    /**
     * Ajoute un nouveau contenu
     */
    public function add()
    {

        // Accès limité aux admins
        if (
            $this->getUser('group') !== self::GROUP_ADMIN
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        // Soumission du formulaire
        if (
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

            // Pointer RFM sur le dossier de l'espace
            self::$siteContent = $courseId;
            // Ordonne les pages par position
            $this->buildHierarchy();

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

            // Dossier du gestionnaire de fichier
            mkdir(self::FILE_DIR . 'source/' . $courseId);

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
     * Edite un espace
     */
    public function edit()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        // Soumission du formulaire
        if (
            //$this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {

            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseEditShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseEditAuthor'),
                    'homePageId' => $this->getInput('courseEditHomePageId'),
                    'category' => $this->getInput('courseEditCategorie'),
                    'description' => $this->getInput('courseEditDescription', helper::FILTER_STRING_LONG, true),
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
                'redirect' => helper::baseUrl() . 'course/manage/' . $this->getUrl(2),
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
        $this->initDB('page', $courseId);

        // Pointer RFM sur le dossier de l'espace
        self::$siteContent = $courseId;

        // Ordonne les pages par position
        $this->buildHierarchy();

        // Données pour le formulaire
        self::$pagesList = $this->getData(['page']);

        // Exclure les barres et les pages désactivées
        foreach (self::$pagesList as $pageId => $page) {
            if (
                $page['block'] === 'bar' ||
                $page['disable'] === true
            ) {
                unset(self::$pagesList[$pageId]);
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => sprintf('%s id : %s', helper::translate('Éditer l\'espace'), $this->getUrl(2)),
            'view' => 'edit'
        ]);
    }

    /**
     * Affiche un contenu et pointe vers les utilitaires
     */
    public function manage()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
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
        $this->initDB('page', $courseId);

        // Pointer RFM sur le dossier de l'espace
        self::$siteContent = $courseId;

        // Ordonne les pages par position
        $this->buildHierarchy();

        // Données pour le formulaire
        self::$pagesList = $this->getData(['page']);

        // Exclure les barres et les pages désactivées
        foreach (self::$pagesList as $pageId => $page) {
            if (
                $page['block'] === 'bar' ||
                $page['disable'] === true
            ) {
                unset(self::$pagesList[$pageId]);
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => sprintf('%s id : %s', helper::translate('Gérer l\'espace'), $this->getUrl(2)),
            'view' => 'manage'
        ]);
    }

    /**
     * Duplique un cours et l'affiche dans l'éditeur
     */
    public function clone()
    {

        // Cours à dupliquer
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->getUser('group') !== self::$actions[__FUNCTION__]
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        } else {
            // Id du nouveau cours
            $target = uniqid();

            // Créer la structure de données
            mkdir(self::DATA_DIR . $target);

            $this->copyDir(self::DATA_DIR . $courseId, self::DATA_DIR . $target);

            $this->setData(['course', $target, $this->getData(['course', $courseId])]);

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Espace dupliqué'),
                'state' => true
            ]);
        }
    }

    public function delete()
    {
        // Espace sélectionné
        $courseId = $this->getUrl(2);

        if (
            // Accès limité aux admins
            $this->getUser('group') !== self::$actions[__FUNCTION__]
            // Le contenu n'existe pas
            || $this->getData(['course', $courseId]) === null
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
            // Dossier du gestionnaire de fichier
            if (is_dir(self::FILE_DIR . 'source/' . $courseId)) {
                $this->deleteDir(self::FILE_DIR . 'source/' . $courseId);
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

        if (
            // Accès limité aux admins
            $this->getUser('group') !== self::$actions[__FUNCTION__]
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        } else {
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
    }

    public function categoryAdd()
    {

        if (
            // Accès limité aux admins
            $this->getUser('group') !== self::$actions[__FUNCTION__]
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]); // Soumission du formulaire
        } elseif ($this->isPost()) {
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
            ]);        // Valeurs en sortie

        }
        $this->addOutput([
            'title' => helper::translate('Ajouter une catégorie'),
            'view' => 'categoryAdd'
        ]);

    }

    public function categoryEdit()
    {
        if (
            // Accès limité aux admins
            $this->getUser('group') !== self::$actions[__FUNCTION__]
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]); // Soumission du formulaire
        } elseif (
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

        if (
            // Accès limité aux admins
            $this->getUser('group') !== self::$actions[__FUNCTION__]
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

        $courseId = $this->getUrl(2);

        // Accès limité au propriétaire, admin ou éditeurs isncrits

        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

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
        $sumPages = $this->countPages($pages['page']);

        // Liste des inscrits dans le contenu sélectionné.
        $users = $this->getData(['enrolment', $courseId]);

        // Obtient les statistiques de l'ensemble de la cohorte
        $reports = $this->getReport($courseId);

        if (is_array($users)) {
            // Tri du tableau par défaut par $userId
            ksort($users);
            foreach ($users as $userId => $userValue) {

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

                // Progression
                $viewPages = array_key_exists($userId, $reports) ?
                    count($reports[$userId]) :
                    0;

                // Construction du tableau
                self::$courseUsers[] = [
                    //$userId,
                    $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
                    array_key_exists('lastPageView', $userValue) && isset($pages[$userValue['lastPageView']]['title'])
                    ? $pages[$userValue['lastPageView']]['title']
                    : '',
                    array_key_exists('lastPageView', $userValue)
                    ? helper::dateUTF8('%d/%m/%Y', $userValue['datePageView'])
                    : '',
                    array_key_exists('datePageView', $userValue)
                    ? helper::dateUTF8('%H:%M', $userValue['datePageView'])
                    : '',
                    $this->getData(['user', $userId, 'tags']),
                    template::button('userReport' . $userId, [
                        'href' => helper::baseUrl() . 'course/userReport/' . $courseId . '/' . $userId,
                        /** La lecture de la progression s'effectue selon la nouvelle méthode (progression dans la base des enrolements)
                         *  Soit avec l'ancienne méthode qui consiste à recalculer la progression.  
                         *  TRANSITOIRE A SUPPRIMER EN FIN D'ANNEE
                         **/
                        'value' => array_key_exists('progress', $userValue)
                            ? $userValue['progress']
                            : ($viewPages ? min(round(($viewPages * 100) / $sumPages, 1), 100) . ' %' : '0%'),
                        'disable' => empty($userValue['datePageView']),
                        //'value' => $viewPages ? min(round(($viewPages * 100) / $sumPages, 1), 100) . ' %' : '0%',
                        //'disable' => empty($viewPages)
                    ]),
                    template::button('userDelete' . $userId, [
                        'class' => 'userDelete buttonRed',
                        'href' => helper::baseUrl() . 'course/userDelete/' . $courseId . '/' . $userId,
                        'value' => template::ico('user'),
                        'help' => 'Désinscrire'
                    ])
                ];

            }
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
            'vendor' => [
                'datatables'
            ]
        ]);
    }

    public function usersAdd()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité au propriétaire ou éditeurs inscrits ou admin
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
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
                    && $this->getData(['enrolment', $courseId, $keyPost]) === null
                ) {
                    $this->setData(['enrolment', $courseId, $keyPost, 'history', array()], false);
                }
            }
            // Sauvegarde la base manuellement
            $this->saveDB('enrolment');
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

        // Liste des inscrits dans l'espace sélectionné afin de les supprimer de la liste des candidats
        $users = $this->getData(['user']);
        $suscribers = $this->getData(['enrolment', $courseId]);
        if (is_array($suscribers)) {
            $suscribers = array_keys($suscribers);
            $users = array_diff_key($users, array_flip($suscribers));

        }

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
            'view' => 'usersAdd',
            'vendor' => [
                'datatables'
            ]
        ]);
    }

    /**
     * Désinscription d'un utilisateur
     */
    public function userDelete()
    {
        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité au propriétaire ou admin ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
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
     * Les désinscriptions ne suppriment pas les historiques
     */
    public function usersDelete()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

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

        if (is_array($users)) {
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
            'view' => 'usersDelete',
            'vendor' => [
                'datatables'
            ]
        ]);
    }

    /**
     * Désincription de tous les utilisateurs hors les éditeurs
     * Effacement des historiques
     */
    public function reset()
    {

        // Contenu sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }


        // Active l'accueil
        $_SESSION['ZWII_SITE_CONTENT'] = 'home';

        // Efface les inscriptions
        $success = $this->setData(['enrolment', $courseId, []]);

        // Efface les rapports
        if (file_exists(self::DATA_DIR . $courseId . '/report.csv')) {
            unlink(self::DATA_DIR . $courseId . '/report.csv');
        }

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => helper::baseUrl() . 'course',
            'notification' => helper::translate('Espace réinitialisé'),
            'state' => true
        ]);

    }

    /*
     * Traitement du changement de langue
     */
    public function swap()
    {
        $courseId = $this->getUrl(2);
        // pageIfd est transmis lors de l'appel de la page depuis un lien direct alors que l'espace n'est pas sélectionné.
        $pageId = $this->getUrl(3);
        $userId = $this->getuser('id');
        $message = '';
        $redirect = helper::baseUrl();
        $state = true;

        // Récupérer les pages pour contrôler la dernière page vue
        $p = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        $pages = $p['page'];

        // Routage
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
            $redirect = ($this->getData(['enrolment', $courseId, $userId, 'lastPageView']) !== null
                && array_key_exists($this->getData(['enrolment', $courseId, $userId, 'lastPageView']), $pages)
            )
                ? helper::baseUrl() . $this->getData(['enrolment', $courseId, $userId, 'lastPageView'])
                : helper::baseUrl();

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
                    // Accès direct à la page
                    $redirect = helper::baseUrl() . $pageId;
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
    public function userReport()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité au propriétaire ou éditeurs inscrits ou admin
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        $userId = $this->getUrl(3);
        $h = $this->getReport($courseId, $userId);
        $h = $h[$userId];

        // Inversion des clés et des valeurs
        $report = array();
        foreach ($h as $key => $values) {
            foreach ($values as $value) {
                $report[$value] = $key;
            }
        }

        ksort($report);

        // Liste des pages contenues dans cet espace et exclure les barres et les pages masquées
        $p = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        foreach ($p['page'] as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $pages[$pageId] = [
                    'title' => $pageData['title'],
                ];
            }
        }

        $floorTime = 99999999999;
        $topTime = 0;
        $lastView = 0;

        foreach ($report as $time => $pageId) {
            if (isset($pages[$pageId]['title'])) {
                $lastView = ($lastView === 0) ? $time : $lastView;
                $diff = $time - $lastView;
                self::$userReport[] = [
                    html_entity_decode($pages[$pageId]['title']),
                    $time,
                    ($diff < 1800) ? sprintf("%d' %d''", floor($diff / 60), $diff % 60) : "Non significatif",
                ];
                if ($diff < 1800) {
                    self::$userGraph[] = [
                        helper::dateUTF8('%Y-%m-%d %H:%M:%S', $time),
                        $diff,
                        html_entity_decode($pages[$pageId]['title']) . ' (' . helper::dateUTF8('%M\'%S"', $diff) . ')'
                    ];
                }
                $lastView = $time;
                $floorTime = isset($floorTime) && $floorTime < $time ? $floorTime : $time;
                $topTime = isset($topTime) && $topTime > $time ? $topTime : $time;
            }
        }

        // Décale les temps de consultation
        for ($i = 0; $i < count(self::$userReport) - 1; $i++) {
            self::$userReport[$i][2] = self::$userReport[$i + 1][2];
        }
        // Décale les temps de consultation
        for ($i = 0; $i < count(self::$userGraph) - 1; $i++) {
            self::$userReport[$i][1] = self::$userReport[$i + 1][1];
        }

        // Formate le timestamp
        array_walk(self::$userReport, function (&$item) {
            $item[1] = helper::dateUTF8('%d/%m/%Y %H:%M:%S', $item[1]);
        });

        self::$userStat['floor'] = helper::dateUTF8('%d %B %Y %H:%M', $floorTime);
        self::$userStat['top'] = helper::dateUTF8('%d %B %Y %H:%M', $topTime);
        $d = $topTime - $floorTime;
        // Conversion de la différence en jours, heures et minutes
        $d_days = floor($d / 86400);  // 1 jour = 86400 secondes (24 heures * 60 minutes * 60 secondes)
        $d_hours = floor(($d % 86400) / 3600);
        $d_minutes = floor(($d % 3600) / 60);

        // Affichage du résultat
        self::$userStat['time'] = $d_days . ' jours, ' . $d_hours . ' heures, ' . $d_minutes . ' minutes ';

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Historique ') . $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
            'view' => 'userReport',
            'vendor' => [
                "plotly"
            ]
        ]);

    }

    public function usersReportExport()
    {

        $courseId = $this->getUrl(2);

        // Accès limité au propriétaire ou éditeurs inscrits ou admin
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        self::$courseUsers = [
            0 => ['UserId', 'Prénom', 'Nom', 'Page Titre', 'Consultation Date', 'Consultation Heure', 'Progression']
        ];

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

        // Obtient les statistiques de l'ensemble de la cohorte
        $reports = $this->getReport($courseId);

        if (is_array($users)) {
            // Tri du tableau par défaut par $userId
            ksort($users);

            // Dossier d'export
            if (is_dir(self::FILE_DIR . 'source/' . $courseId) === false) {
                mkdir(self::FILE_DIR . 'source/' . $courseId);
            }
            if (is_dir(self::FILE_DIR . 'source/' . $courseId . '/export/') === false) {
                mkdir(self::FILE_DIR . 'source/' . $courseId . '/export/');
            }
            $filename = self::FILE_DIR . 'source/' . $courseId . '/export/' . '/synthèse' . helper::dateUTF8('%Y%m%d', time()) . '.csv';

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
                        $this->setData(['enrolment', $courseId, $userId, 'lastPageView', $lastPageId], false);
                        $this->setData(['enrolment', $courseId, $userId, 'datePageView', $maxTime]);
                    }
                }

                // Progression
                $viewPages = array_key_exists($userId, $reports) ?
                    count($reports[$userId]) :
                    0;

                // Construction du tableau
                self::$courseUsers[] = [
                    $userId,
                    $this->getData(['user', $userId, 'firstname']),
                    $this->getData(['user', $userId, 'lastname']),
                    isset($pages[$this->getData(['enrolment', $courseId, $userId, 'lastPageView'])])
                    ? $pages[$this->getData(['enrolment', $courseId, $userId, 'lastPageView'])]
                    : $this->getData(['enrolment', $courseId, $userId, 'lastPageView']) . ' (supprimée)',
                    helper::dateUTF8('%d/%d/%Y', $this->getData(['enrolment', $courseId, $userId, 'datePageView'])),
                    helper::dateUTF8('%H:%M', $this->getData(['enrolment', $courseId, $userId, 'datePageView'])),
                    /** La lecture de la progression s'effectue selon la nouvelle méthode (progression dans la base des enrolements)
                     *  Soit avec l'ancienne méthode qui consiste à recalculer la progression.  
                     *  TRANSITOIRE A SUPPRIMER EN FIN D'ANNEE
                     **/
                    array_key_exists('progress', $userValue)
                    ? $userValue['progress']
                    : ($viewPages ? min(round(($viewPages * 100) / $sumPages, 1), 100) . ' %' : '0%'),
                    //number_format(min(round(($viewPages * 100) / $sumPages, 1) / 100, 1), 2, ','),
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
    }

    public function userReportExport()
    {

        $courseId = $this->getUrl(2);
        $userId = $this->getUrl(3);

        // Accès limité au propriétaire ou éditeur inscrit ou admin
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        // Traitement de l'historique
        $h = $this->getReport($courseId);
        $h = $h[$userId];

        // Inversion des clés et des valeurs
        $report = array();
        foreach ($h as $key => $values) {
            foreach ($values as $value) {
                $report[$value] = $key;
            }
        }

        ksort($report);

        // Liste des pages contenues dans cet espace et exclure les barres et les pages masquées
        $p = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/page.json'), true);
        foreach ($p['page'] as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $pages[$pageId] = [
                    'title' => $pageData['title'],
                ];
            }
        }

        $lastView = 0;

        foreach ($report as $time => $pageId) {
            if (isset($pages[$pageId]['title'])) {
                $lastView = ($lastView === 0) ? $time : $lastView;
                $diff = $time - $lastView;
                self::$userReport[] = [
                    $pageId,
                    html_entity_decode($pages[$pageId]['title']),
                    $time,
                    ($diff < 1800) ? sprintf("%d' %d''", floor($diff / 60), $diff % 60) : "Non significatif",
                ];
                $lastView = $time;
                $floorTime = isset($floorTime) && $floorTime < $time ? $floorTime : $time;
                $topTime = isset($topTime) && $topTime > $time ? $topTime : $time;
            }
        }

        // Décale les temps de consultation
        for ($i = 0; $i < count(self::$userReport) - 1; $i++) {
            self::$userReport[$i][3] = self::$userReport[$i + 1][3];
        }
        // Formate le timestamp
        array_walk(self::$userReport, function (&$item) {
            $item[2] = helper::dateUTF8('%d/%m/%Y %H:%M:%S', $item[2]);
        });

        // Ajoute les entêtes
        self::$userReport = array_merge([0 => ['PageId', 'Page Titre', 'Consultation Date', 'Temps Consultation']], self::$userReport);

        // Dossier d'export
        if (is_dir(self::FILE_DIR . 'source/' . $courseId) === false) {
            mkdir(self::FILE_DIR . 'source/' . $courseId);
        }
        if (is_dir(self::FILE_DIR . 'source/' . $courseId . '/export/') === false) {
            mkdir(self::FILE_DIR . 'source/' . $courseId . '/export/');
        }
        $filename = self::FILE_DIR . 'source/' . $courseId . '/export/' . $userId . '.csv';

        $file = fopen($filename, 'w');

        foreach (self::$userReport as $keys => $values) {
            $data = $values;
            // Écrire la ligne dans le fichier CSV
            fputcsv($file, $data, ';');
        }
        // Fermeture du fichier
        fclose($file);

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => helper::baseUrl() . 'course/userReport/' . $courseId . '/' . $userId,
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
                        if ($this->getInput('courseSwapEnrolmentKey', helper::FILTER_STRING_SHORT, true) === $this->getData(['course', $courseId, 'enrolmentKey'])) {
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

    /**
     * Désinscription d'un participant
     * La désinscription ne supprime pas les historiques, 
     */
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
     * Sauvegarde d'un cours sans option
     */

    public function backup()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->permissionControl(__FUNCTION__, $courseId) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        } else {

            // Participants avec historiques
            $enrolment = $this->getData(['enrolment', $courseId]);
            // Générer un fichier dans le dossier de l'espace
            $this->secure_file_put_contents(self::DATA_DIR . $courseId . '/enrolment.json', json_encode([$courseId => $enrolment], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            // Idem pour les données du cours
            $course = $this->getData(['course', $courseId]);
            // Générer un fichier dans le dossier de l'espace
            $this->secure_file_put_contents(self::DATA_DIR . $courseId . '/course.json', json_encode([$courseId => $course], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            // Idem pour la catégorie
            $category = $this->getData(['category', $this->getData(['course', $courseId, 'category'])]);
            // Générer un fichier dans le dossier de l'espace
            $this->secure_file_put_contents(self::DATA_DIR . $courseId . '/category.json', json_encode([$this->getData(['course', $courseId, 'category']) => $category], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));


            // Génère une archive ZIP
            $this->makeZip(self::TEMP_DIR . $courseId . '-' . date('Y-m-d-H-i-s', time()) . '.zip', self::DATA_DIR . $courseId);

            $success = false;
            $message = helper::translate('Erreur : sauvegarde non générée !');
            // Transférer dans RFM
            if (file_exists(self::TEMP_DIR . $courseId . '-' . date('Y-m-d-H-i-s', time()) . '.zip')) {
                if (!is_dir(self::FILE_DIR . 'source/' . $courseId)) {
                    mkdir(self::FILE_DIR . 'source/' . $courseId);
                }
                if (!is_dir(self::FILE_DIR . 'source/' . $courseId . '/backup/')) {
                    mkdir(self::FILE_DIR . 'source/' . $courseId . '/backup/');
                }
                copy(self::TEMP_DIR . $courseId . '-' . date('Y-m-d-H-i-s', time()) . '.zip', self::FILE_DIR . 'source/' . $courseId . '/backup/' . $courseId . '-' . date('Y-m-d-H-i-s', time()) . '.zip');
                unlink(self::TEMP_DIR . $courseId . '-' . date('Y-m-d-H-i-s', time()) . '.zip');
                $success = true;
                $message = helper::translate('Sauvegarde générée avec succès');
            }

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/manage/' . $this->getUrl(2),
                'state' => $success,
                'notification' => $message,
            ]);
        }

    }

    // Générer un fichier externe contenant le contenu des pages
    public function export()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        // Liste des pages disponibles
        $this->initDB('page', $courseId);

        // Pointer RFM sur le dossier de l'espace
        self::$siteContent = $courseId;

        // Ordonne les pages par position
        $this->buildHierarchy();

        // Tableau de retour
        self::$pagesList = [];

        // Exclure les barres et les pages désactivées
        foreach ($this->getData(['page']) as $pageId => $page) {
            if (
                $this->getData(['page', $pageId, 'block']) !== 'bar' &&
                $this->getData(['page', $pageId, 'disable']) !== true
            ) {
                self::$pagesList[] = template::checkbox('courseManageExport' . $pageId, true, $page['title'], [
                    'class' => 'courseManageCheckbox'
                ]);
            }
        }

        // Soumission du formulaire
        if ($this->isPost()) {
            $datas = '<h1>' . $this->getData(['course', $courseId, 'title']) . '</h1>';
            $resources = [];

            foreach ($this->getData(['page']) as $pageId => $page) {
                if ($this->getInput('courseManageExport' . $pageId, helper::FILTER_BOOLEAN) === true) {
                    $pageContent = $this->getPage($pageId, $courseId);

                    // Extraction des URLs des ressources (images, vidéos, fichiers, etc.)
                    preg_match_all('/<img[^>]+src=["\'](.*?)["\']/i', $pageContent, $imgMatches); // Images
                    preg_match_all('/<a[^>]+href=["\'](.*?)["\']/i', $pageContent, $linkMatches); // Liens
                    preg_match_all('/<video[^>]+src=["\'](.*?)["\']/i', $pageContent, $videoMatches); // Vidéos directes
                    preg_match_all('/<source[^>]+src=["\'](.*?)["\']/i', $pageContent, $sourceMatches); // Vidéos dans balises <source>

                    // Traitement des images
                    $this->processResources($pageContent, '/<img[^>]+src=["\'](.*?)["\']/i', $resources);

                    // Traitement des vidéos directes via <video>
                    $this->processResources($pageContent, '/<video[^>]+src=["\'](.*?)["\']/i', $resources);

                    // Traitement des sources dans les balises <source> (utilisées dans <video> ou <audio>)
                    $this->processResources($pageContent, '/<source[^>]+src=["\'](.*?)["\']/i', $resources);

                    // Traitement des liens <a>
                    $this->processResources($pageContent, '/<a[^>]+href=["\'](.*?)["\']/i', $resources);

                    // Traitement des liens
                    if (!empty($linkMatches[1])) {
                        $resources = array_merge($resources, $linkMatches[1]);

                        // Remplacement des chemins pour les liens dans $pageContent
                        foreach ($linkMatches[1] as $resourceUrl) {
                            $resourcePath = parse_url($resourceUrl, PHP_URL_PATH);
                            $resourceFile = basename($resourcePath);
                            $pageContent = str_replace($resourceUrl, $resourceFile, $pageContent);
                        }
                    }

                    $datas .= $pageContent;
                }
            }

            // Créer le dossier d'export
            $path = self::FILE_DIR . 'source/' . $courseId . '/';
            if (is_dir($path . 'export') === false) {
                mkdir($path . 'export');
            }

            // Copier les ressources dans le dossier d'export
            foreach ($resources as $resourceUrl) {
                $resourcePath = parse_url($resourceUrl, PHP_URL_PATH);
                $resourceFile = basename($resourcePath);
                if (file_exists($resourcePath)) { // Utilisation du chemin correct
                    copy($resourcePath, $path . 'export/' . $resourceFile);
                }
            }

            // Ajouter les balises HTML manquantes
            $datas = '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $this->getData(['course', $courseId, 'title']) . '</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>' . $datas . '</body></html>';

            // Sauvegarder le fichier HTML
            file_put_contents($path . '/export/export_' . $this->getData(['course', $courseId, 'title']) . '.html', $datas, LOCK_EX);

            // Copie une feuille de style
            copy('core/module/course/resource/style.css', $path . 'export/style.css');

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/manage/' . $courseId,
                'notification' => helper::translate('Pages exportées dans le dossier de cet espace'),
                'state' => true,
            ]);
        }


        // Valeurs en sortie
        $this->addOutput([
            'title' => sprintf('%s id : %s', helper::translate('Export des pages de l\'espace'), $this->getUrl(2)),
            'view' => 'export'
        ]);

    }

    // Fonction utilisé par l'export en html pour corriger les URL des ressources
    private function processResources(&$pageContent, $regex, &$resources)
    {
        preg_match_all($regex, $pageContent, $matches);

        if (!empty($matches[1])) {
            $resources = array_merge($resources, $matches[1]);

            // Remplacement des chemins dans $pageContent
            foreach ($matches[1] as $resourceUrl) {
                $resourcePath = parse_url($resourceUrl, PHP_URL_PATH);
                $resourceFile = basename($resourcePath);
                $pageContent = str_replace($resourceUrl, $resourceFile, $pageContent);
            }
        }
    }

    /**
     * Récupération d'un espace sans option
     */

    public function restore()
    {

        // Espace sélectionné
        $courseId = $this->getUrl(2);

        // Accès limité aux admins, à l'auteur ou éditeurs inscrits
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === false
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
        }

        // Soumission du formulaire
        if (
            $this->isPost()
        ) {

            // Récupérer le dossier du profil
            $userPath = $this->getData(['profil', $this->getuser('group'), $this->getuser('profil'), 'folder', 'path']);
            $userPath = $userPath === '' ? self::$siteContent : $userPath;
            // Fichier avec le bon chemin selon le profil
            $zipName = self::FILE_DIR . 'source/' . $userPath . '/' . $this->getInput('courseRestoreFile', null, true);

            // Existence de l'archive
            if (
                $zipName !== '' &&
                file_exists($zipName)
            ) {
                // Init variables de retour
                $success = false;
                $notification = '';
                // Dossier temporaire
                $tempFolder = uniqid();
                // Ouvrir le zip
                $zip = new ZipArchive();
                if ($zip->open($zipName) === TRUE) {
                    mkdir(self::TEMP_DIR . $tempFolder, 0755);
                    $zip->extractTo(self::TEMP_DIR . $tempFolder);
                    // Drapeaux de gestion des erreurs
                    $success = false;
                    $notification = '';
                    // Récupérer les données de base à intégrer
                    $courseData = array();
                    if (file_exists(self::TEMP_DIR . $tempFolder . '/course.json')) {
                        $courseData = json_decode(file_get_contents(self::TEMP_DIR . $tempFolder . '/course.json'), true);
                        // Lire l'id du cours
                        $courseIds = array_keys($courseData);
                        ;
                        $courseId = $courseIds[0];
                        $success = true;
                    } else {
                        // Pas une archive d'espace
                        $notification = helper::translate('Archive invalide');
                    }
                    if ($success && $courseId) {

                        // récupérer les inscriptions disponibles
                        $enrolmentData = array();
                        if (file_exists(self::TEMP_DIR . $tempFolder . '/enrolment.json')) {
                            $enrolmentData = json_decode(file_get_contents(self::TEMP_DIR . $tempFolder . '/enrolment.json'), true);
                        }

                        // Créer le dossier absent
                        if (!is_dir(self::DATA_DIR . $courseId)) {
                            mkdir(self::DATA_DIR . $courseId);
                            $notification = sprintf(helper::translate('Importation terminée : l\'espace %s a été créé'), $courseId);
                        } else {
                            $notification = sprintf(helper::translate('Importation terminée : l\'espace %s a été actualisé'), $courseId);
                        }

                        // traiter l'archive
                        $success = $zip->extractTo(self::DATA_DIR . $courseId);
                        $zip->close();

                        // Effacer les données de transport
                        unlink(self::DATA_DIR . $courseId . '/course.json');
                        unlink(self::DATA_DIR . $courseId . '/enrolment.json');

                        // Fusionne les deux tableaux
                        $c = $this->getData(['course']);
                        $courseData = array_merge($c, $courseData);
                        $e = $this->getData(['enrolment']);
                        $enrolmentData = array_merge($e, $enrolmentData);

                        // Sauvegarde les bases
                        $this->setData(['course', $courseData]);
                        $this->setData(['enrolment', $enrolmentData]);

                        // traitement d'erreur en cas de problème de désachivage
                        $notification = $success ? $notification : helper::translate('Erreur lors de l\'extraction, vérifiez les permissions');
                    }
                    // Supprimer le dossier temporaire même si le thème est invalide
                    $this->deleteDir(self::TEMP_DIR . $tempFolder);
                } else {
                    // erreur à l'ouverture
                    $success = false;
                    $notification = helper::translate('Impossible d\'ouvrir l\'archive');
                }
                // Valeurs en sortie
                $this->addOutput([
                    'redirect' => helper::baseUrl() . 'course',
                    'state' => $success,
                    'notification' => $notification,
                ]);

            }

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'state' => $success,
                'notification' => $notification,
            ]);

        }
        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Restaurer un espace'),
            'view' => 'restore'
        ]);
    }



    /**
     * Retourne false quand l'utilisateur ne dispose pas des droits d'accès à la fonction
     * Règles d'accès à un espace :
     * Admin : tous les droits
     * Editor : Inscrits dans le cours ou propriétaire
     */
    public function permissionControl($function, $courseId)
    {
        switch ($this->getUser('group')) {
            case self::GROUP_ADMIN:
                return true;
            case self::GROUP_EDITOR:
                return (
                    $this->getUser('permission', __CLASS__, $function)
                    && $this->getUser('group') === self::$actions[$function]
                    &&
                        // Permission d'accéder aux espaces dans lesquels le membre auteur
                    (
                        $this->getData(['enrolment', $courseId]) && ($this->getUser('id') === $this->getData(['course', $courseId, 'author']))
                    )
                    ||
                    (  // Permission d'accéder aux espaces dans lesquels le membre est inscrits
                        $this->getData(['enrolment', $courseId])
                        && $this->getUser('permission', __CLASS__, 'tutor') === true
                        && array_key_exists($this->getUser('id'), $this->getData(['enrolment', $courseId]))
                    )
                );
            default:
                return false;
        }
    }



    /**
     * Autorise l'accès à un contenu
     * @return bool le user a le droit d'entrée dans le contenu
     * @param string $courseId identifiant du contenu sollicité
     */
    public function courseIsAvailable($courseId)
    {
        // L'accès à l'accueil est toujours autorisé
        if ($courseId === 'home') {
            return true;
        }
        // Si un utilisateur connecté est admin ou auteur, c'est autorisé
        if (
            $this->isConnected() === true &&
            ($this->getUser('group') === self::GROUP_ADMIN ||
                $this->getUser('id') === $this->getData(['course', $courseId, 'author']))
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
            default:
                return false;
        }
    }


    /**
     * Méthode externe pour afficher la progression dans les espaces.
     * 
     * @param mixed $courseId
     * @param mixed $userId
     * @return string Ratio de pages vues
     */
    public function userProgress($courseId, $userId): string
    {

        // Obtient les statistiques de l'ensemble de la cohorte
        $reports = $this->getReport($courseId, $userId);

        // Nombre de pages dans l'espace
        $viewPages = array_key_exists($userId, $reports) ?
            count($reports[$userId]) :
            0;
        // Nombre de pages vues
        $sumPages = $this->countPages($this->getData(['page']));

        // Calcule le ratio
        $ratio = number_format(min(round(($viewPages * 100) / $sumPages, 1) / 100, 1), 2, ',');

        return $ratio;
    }

    /**
     * 
     * Compte les pages d'un espace 
     * @param mixed $array Tableau des pages de l'espace
     * @return int Nombre de pages
     */
    private function countPages($array)
    {
        $count = 0;
        foreach ($array as $pageId => $pageData) {
            if ($pageData['position'] > 0) {
                $count++;
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
                'lastPageView' => '',
                'datePageView' => '',
                'progress' => '',
            ]
        ]);
    }

    /**
     * Autorise l'accès à un contenu
     * @return bool le user a le droit d'entrée dans le contenu
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
            case self::GROUP_MEMBER:
                $r = false;
                if (!is_null($this->getData(['enrolment', $courseId]))) {
                    $r = in_array($userId, array_keys($this->getData(['enrolment', $courseId])));
                }
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
     * Lit le contenu des fichiers de traces au format CS et renvoie un tableau associatif
     */
    private function getReport($courseId, $userId = null)
    {

        $data = [];
        if (file_exists(self::DATA_DIR . $courseId . '/report.csv')) {
            // Remplacez 'chemin/vers/votre/fichier.csv' par le chemin réel de votre fichier CSV
            $file = fopen(self::DATA_DIR . $courseId . '/report.csv', "r");

            $data = array();

            // Lire ligne par ligne
            while (($line = fgetcsv($file, 1000, ";")) !== false) {
                $name = $line[0];
                $pageId = $line[1];
                $timestamp = $line[2];
                // Filtre userId
                if (
                    is_null($userId) === false
                    && $name !== $userId
                ) {
                    continue;
                }

                // Initialiser le tableau si nécessaire
                if (!isset($data[$name][$pageId])) {
                    $data[$name][$pageId] = array();
                }
                // Ajouter le timestamp
                $data[$name][$pageId][] = $timestamp;
            }

            // Fermer le fichier
            fclose($file);

            // Trier les timestamps
            foreach ($data as &$userData) {
                foreach ($userData as &$pageData) {
                    sort($pageData);
                }
            }
        }

        // Afficher le JSON;
        return $data;
    }
}