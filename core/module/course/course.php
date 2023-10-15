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
        'enrol' => self::GROUP_VISITOR,
        'index' => self::GROUP_ADMIN,
        'edit' => self::GROUP_ADMIN,
        'add' => self::GROUP_ADMIN,
        'delete' => self::GROUP_ADMIN,
        'category' => self::GROUP_ADMIN,
        'categoryAdd' => self::GROUP_ADMIN,
        'categoryDelete' => self::GROUP_ADMIN,
        'user' => self::GROUP_ADMIN,
        'userAdd' => self::GROUP_ADMIN,
        'userDelete' => self::GROUP_ADMIN,
        'userDeleteAll' => self::GROUP_ADMIN,
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
        //self::COURSE_ENROLMENT_MANUAL => 'Manuelle'
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


    public function index()
    {
        $courseIdShortTitle = helper::arrayColumn($this->getData(['course']), 'shortTitle');
        ksort($courseIdShortTitle);
        foreach ($courseIdShortTitle as $courseId => $courseTitle) {
            $categorieUrl = helper::baseUrl(!helper::checkRewrite()) . 'course/swap/' . $courseId;
            $authorId = $this->getData(['course', $courseId, 'author']);
            $author = sprintf('%s %s', $this->getData(['user', $authorId, 'firstname']), $this->getData(['user', $authorId, 'lastname']));
            $access = self::$courseAccess[$this->getData(['course', $courseId, 'access'])];
            $enrolment = self::$courseEnrolment[$this->getData(['course', $courseId, 'enrolment'])];
            $description = sprintf('%s<br />%s<br />%s<br />', $this->getData(['course', $courseId, 'description']), $access, $enrolment);
            self::$courses[] = [
                $courseTitle,
                $author,
                $description,
                '<a href="' . $categorieUrl . '" target="_blank">' . $categorieUrl . '</a>',
                template::button('categoryUser' . $courseId, [
                    'href' => helper::baseUrl() . 'course/user/' . $courseId,
                    'value' => template::ico('users'),
                    'help' => 'Inscrits'
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

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Cours'),
            'view' => 'index'
        ]);
    }

    /**
     * Ajoute un nouveau cours
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
                    'shortTitle' => $this->getInput('courseAddShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseAddAuthor'),
                    'homePageId' => 'accueil',
                    'category' => $this->getInput('courseAddCategories'),
                    'description' => $this->getInput('courseAddDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseAddAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseAddEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseAddEnrolmentKey'),
                ]
            ]);

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Cours créé'),
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

        // Liste des catégories de cours
        self::$courseCategories = $this->getData(['category']);

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Ajouter un cours'),
            'view' => 'add'
        ]);
    }

    /**
     * Edite un cours
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
                    'title' => $this->getInput('courseEditTitle', helper::FILTER_STRING_SHORT, true),
                    'shortTitle' => $this->getInput('courseEditShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseEditAuthor'),
                    'homePageId' => $this->getInput('courseEditHomePageId'),
                    'category' => $this->getInput('courseEditCategories'),
                    'description' => $this->getInput('courseEditDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseEditAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseEditEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseEditEnrolmentKey'),
                ]
            ]);

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Cours édité'),
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

        // Liste des catégories de cours
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
            'title' => helper::translate('Editer un cours'),
            'view' => 'edit'
        ]);
    }

    public function delete()
    {
        $courseId = $this->getUrl(2);
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) !== true ||
            // Le cours n'existe pas
            $this->getData(['course', $courseId]) === null
            // Groupe insuffisant
            and ($this->getUrl('group') < self::GROUP_EDITOR)
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
                'notification' => $success ? helper::translate('Cours supprimé') : helper::translate('Erreur de suppression'),
                'state' => $success
            ]);
        }

    }

    /**
     * Liste les catégories d'un cours
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
            'title' => helper::translate('Catégorie de cours'),
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

    public function user()
    {
        // Liste des groupes et des profils
        $courseGroups = $this->getData(['profil']);
        foreach ($courseGroups as $groupId => $groupValue) {
            switch ($groupId) {
                case "-1":
                case "0":
                    break;
                case "3":
                    self::$courseGroups['30'] = 'Administrateur';
                    break;
                case "1":
                case "2":
                    foreach ($groupValue as $profilId => $profilValue) {
                        if ($profilId) {
                            self::$courseGroups[$groupId . $profilId] = sprintf(helper::translate('Groupe %s - Profil %s'), self::$groupPublics[$groupId], $profilValue['name']);
                        }
                    }
            }
        }

        // Liste alphabétique
        self::$alphabet = range('A', 'Z');
        $alphabet = range('A', 'Z');
        self::$alphabet = array_combine($alphabet, self::$alphabet);
        self::$alphabet = array_merge(['all' => 'Tout'], self::$alphabet);

        // Cours sélectionné
        $courseId = $this->getUrl(2);

        // Statistiques du cours sélectionné calcul du nombre de pages
        $currentSite = self::$siteContent;
        $this->initDB('page', $courseId);
        $sumPages = $this->countPages($this->getHierarchy(null, false));
        // Supprimer les barres
        $sumPages =  $sumPages - count($this->getHierarchy(null, false, true));
        self::$siteContent = $currentSite;

        // Liste des inscrits dans le cours sélectionné.
        $users = $this->getData(['enrolment', $courseId]);
        // Tri du tableau par défaut par $userId
        ksort($users);
        foreach ($users as $userId => $userValue) {
            $history = $userValue['history'];

            $maxTime = max($history);
            $pageId = array_search($maxTime, $history);
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
            $viewPages = count($this->getData(['enrolment', $courseId, $userId, 'history']));
            // Construction tu tableau
            self::$courseUsers[] = [
                $userId,
                $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']),
                $pageId,
                helper::dateUTF8('%d %B %Y - %H:%M', $maxTime),
                round(($viewPages * 100)/ $sumPages, 1) . ' %',
                template::button('userDelete' . $userId, [
                    'class' => 'userDelete buttonRed',
                    'href' => helper::baseUrl() . 'course/userDelete/' . $courseId . '/' . $userId,
                    'value' => template::ico('minus'),
                    'help' => 'Désinscrire'
                ])
            ];
        }


        // Valeurs en sortie
        $this->addOutput([
            'title' => sprintf(helper::translate('%s inscrits dans le cours %s'), count(self::$courseUsers), $this->getData(['course', $courseId, 'title'])),
            'view' => 'user',
            'vendor' => [
                'datatables'
            ]
        ]);
    }

    public function userAdd()
    {
        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Inscrire'),
            'view' => 'userAdd'
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
                'redirect' => helper::baseUrl() . 'course/user/' . $this->getUrl(2),
                'notification' => sprintf(helper::translate('%s est désinscrit'), $this->getUrl(3)),
                'state' => true
            ]);
        }
    }

    /** 
     * Désinscription de tous les utilisateurs
     */
    public function userDeleteAll()
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
            $this->setData(['enrolment', $this->getUrl(2), array()]);
            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course/user/' . $this->getUrl(2),
                'notification' => helper::translate('Cours réinitialisé'),
                'state' => true
            ]);
        }
    }

    /*
     * Traitement du changement de langue
     */
    public function swap()
    {
        $courseId = $this->getUrl(2);
        $userId = $this->getuser('id');
        $message = '';
        $redirect = helper::baseUrl(true);
        $state = true;

        if (
            // Sortir du cours et afficher l'accueil
            $courseId === 'home'
        ) {
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }
        // l'étudiant est inscrit dans le cours ET le cours est ouvert
        // ou un admin  ou le prof du cours sont connectés
        elseif (
            $this->courseIsUserEnroled($courseId)
            && $this->courseIsAvailable($courseId)
        ) {
            // Récupérer la dernière page visitée par cet utilisateur si elle existe
            if ($this->getData(['enrolment', $courseId, $userId, 'history']))
                $maxTime = max($this->getData(['enrolment', $courseId, $userId, 'history']));
            if (is_int($maxTime)) {
                $redirect .= array_search($maxTime, $this->getData(['enrolment', $courseId, $userId, 'history']));
            } else {
                // Sinon la page d'accueil par défaut du module
                $redirect .= $this->getData(['course', $courseId, 'homePageId']);
            }
            if ($this->getData(['course', $courseId, 'access']) === self::COURSE_ACCESS_DATE) {
                $to = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI);
                $message = sprintf(helper::translate('Ce cours ferme le %s'), $to);
            } else {
                $message = sprintf(helper::translate('Bienvenue dans le cours %s'), $this->getData(['course', $courseId, 'shortTitle']));
            }
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }
        // Le cours est fermé
        elseif ($this->courseIsAvailable($courseId) === false) {
            // Génération du message
            $message = helper::translate('Ce cours est fermé');
            $state = false;
            if ($this->getData(['course', $courseId, 'access']) === self::COURSE_ACCESS_DATE) {
                $from = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'openingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'openingDate']), self::$i18nUI);
                $to = helper::dateUTF8('%d %B %Y', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'closingDate']), self::$i18nUI);
                $message = sprintf(helper::translate('Ce cours ouvre le <br>%s <br> et ferme le %s'), $from, $to);
            }
        }
        // le cours est ouvert, l'étudiant n'est pas inscrit, l'accès au cours est anonyme
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
                    $redirect .= 'course/enrol/' . $courseId;
                    $message = helper::translate('Veuillez vous inscrire');
                    break;
                case self::COURSE_ENROLMENT_SELF_KEY:
                    //L'étudiant doit disposer d'un compte
                    if ($this->getUser('id')) {
                        $redirect .= 'course/enrol/' . $courseId;
                        $message = helper::translate('Veuillez vous inscrire');
                        $state = true;
                    } else {
                        $message = helper::translate('Vous devez disposer d\'un compte pour accéder à ce cours');
                        $state = false;
                    }
                    break;
                // Par le prof
                /*
                case self::COURSE_ENROLMENT_MANUAL:
                    $message = helper::translate('L\'enseignant ne vous a pas inscrit dans ce cours !');
                    $state = false;
                    break;
                default:
                */
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => $redirect,
            'notification' => helper::translate($message),
            'state' => $state,
        ]);

    }

    // Génération du message d'inscription
    public function enrol()
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
                        break;
                    case self::COURSE_ENROLMENT_SELF_KEY:
                        if ($this->getInput('courseSwapEnrolmentKey') === $this->getData(['course', $courseId, 'enrolmentKey'])) {
                            $this->courseEnrolUser($courseId, $userId);
                            // Stocker la sélection
                            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
                        }
                        break;
                }

                // Valeurs en sortie
                $this->addOutput([
                    'redirect' => helper::baseUrl()
                ]);
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
                        self::$swapMessage['enrolmentMessage'] = helper::translate('Connectez-vous pour accéder à ce cours.');
                        self::$swapMessage['submitLabel'] = helper::translate('Connexion');
                    }
                    break;
                case self::COURSE_ENROLMENT_SELF_KEY:
                    if ($userId == '') {
                        self::$swapMessage['enrolmentMessage'] = helper::translate('Connectez-vous pour accéder à ce cours.');
                        self::$swapMessage['submitLabel'] = helper::translate('Connexion');
                    } else {
                        self::$swapMessage['submitLabel'] = helper::translate('Connexion');
                        self::$swapMessage['enrolmentKey'] = template::text('courseSwapEnrolmentKey', [
                            'label' => helper::translate('Clé d\'inscription'),
                        ]);
                    }
                    break;
                case self::COURSE_ENROLMENT_MANUAL:
                    self::$swapMessage['enrolmentMessage'] = helper::translate('L\'enseignant inscrit les étudiants dans le cours, vous ne pouvez pas vous inscrire vous-même.');
                    break;
            }
            // Valeurs en sortie
            $this->addOutput([
                'title' => sprintf(helper::translate('Accéder au cours %s'), $this->getData(['course', $this->getUrl(2), 'shortTitle'])),
                'view' => 'enrol',
                'display' => self::DISPLAY_LAYOUT_LIGHT,
            ]);
        }
    }

    /**
     * Autorise l'accès à un cours
     * @param @return bool le user a le droit d'entrée dans le cours
     * @param string $userId identifiant de l'utilisateur
     * @param string $courseId identifiant du cours sollicité
     */
    public function courseIsUserEnroled($courseId)
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

    public function courseEnrolUser($courseId, $userId)
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

    /**
     * Autorise l'accès à un cours
     * @param @return bool le user a le droit d'entrée dans le cours
     * @param string $courseId identifiant du cours sollicité
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
        // Retourne le statut du cours dans les autres cas
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

    private function countPages($array) {
        $count = 0;
        foreach ($array as $key => $value) {
            $count++; // Incrémente le compteur pour chaque clé associative trouvée
    
            if (is_array($value)) {
                $count += $this->countPages($value); // Appelle récursivement la fonction si la valeur est un tableau
            }
        }
        return $count;
    }

}