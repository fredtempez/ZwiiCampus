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
    ];

    public static $courseAccess = [
        self::COURSE_ACCESS_OPEN => 'Ouvert',
        self::COURSE_ACCESS_DATE => 'Période d\'ouverture',
        self::COURSE_ACCESS_CLOSE => 'Fermé',
    ];

    public static $courseEnrolment = [
        self::COURSE_ENROLMENT_GUEST => 'Anonyme',
        self::COURSE_ENROLMENT_SELF => 'Auto-inscrition libre',
        self::COURSE_ENROLMENT_SELF_KEY => 'Auto-inscription avec clé',
        self::COURSE_ENROLMENT_MANUAL => 'Manuelle'
    ];

    public static $courseTeachers = [];

    public static $courseCategories = [];

    public static $courses = [];

    public static $swapMessage = [];

    public static $pagesList = [];


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
            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseAddTitle', helper::FILTER_STRING_SHORT, true),
                    'shortTitle' => $this->getInput('courseAddShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseAddAuthor'),
                    'homePageId' => $this->getInput('courseAddHomePageId'),
                    'category' => $this->getInput('courseAddCategories'),
                    'description' => $this->getInput('courseAddDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseAddAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseAddEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseAddEnrolmentKey'),
                ]
            ]);

            // Créer la structure de données
            mkdir(self::DATA_DIR . $courseId);
            $this->initDB('page', $courseId);
            $this->initDB('module', $courseId);
            $this->initData('page', $courseId);
            $this->initData('module', $courseId);

            // BDD des inscrits
            $this->setData([
                'enrolment',
                $courseId,
                []
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

        // Liste des pages disponibles
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

        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) !== true ||
            // Le cours n'existe pas
            $this->getData(['course', $this->getUrl(2)]) === null
            // Groupe insuffisant
            and ($this->getUrl('group') < self::GROUP_EDITOR)
        ) {
            // Valeurs en sortie
            $this->addOutput([
                'access' => false
            ]);
            // Suppression
        } else {
            $this->deleteData(['course', $this->getUrl(2)]);
            $this->deleteData(['enrolment', $this->getUrl(2)]);
            if (is_dir(self::DATA_DIR . $this->getUrl(2))) {
                $this->deleteDir(self::DATA_DIR . $this->getUrl(2));
            }

            // Valeurs en sortie
            $this->addOutput([
                'redirect' => helper::baseUrl() . 'course',
                'notification' => helper::translate('Cours supprimé'),
                'state' => true
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
                template::button('courseEdit' . $categoryId, [
                    'href' => helper::baseUrl() . 'course/categoryEdit/' . $categoryId,
                    'value' => template::ico('pencil'),
                    'help' => 'Éditer'
                ]),
                template::button('courseDelete' . $categoryId, [
                    'class' => 'courseDelete buttonRed',
                    'href' => helper::baseUrl() . 'course/categoryDelete/' . $categoryId,
                    'value' => template::ico('trash'),
                    'help' => 'Supprimer'
                ])
            ];
        }
        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Catégorie'),
            'view' => 'category'
        ]);
    }

    /*
     * Traitement du changement de langue
     */
    public function swap()
    {
        $courseId = $this->getUrl(2);
        $userId = $this->getUser('id');
        $message = '';
        $redirect = helper::baseUrl();
        $state = true;

        if (
            // Sortir du cours et afficher l'accueil
            $courseId === 'home' ||
                // Un admin ou l'auteur du cours demande l'accès
            ( $userId &&
              $this->getUser('group') === self::GROUP_ADMIN || $this->getUser('id') === $this->getData(['user', $courseId, 'author']))
        ) {
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }
        // l'étudiant est inscrit dans le cours ET le cours est ouvert 
        // ou un admin est connecté ou le prof du cours
        elseif (
            $userId
            && $this->courseIsUserEnroled($courseId)
            && $this->courseIsAvailable($courseId)
        ) {
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
            $message = sprintf(helper::translate('Bienvenue dans le cours %s'), $this->getData(['course', $courseId, 'shortTitle']));
            // Récupérer la dernière page visitée par cet utilisateur si elle existe
            if (empty($this->getData(['enrolment', $courseId, $userId, 'lastPageId']))) {
                // Sinon la page d'accueil par défaut du module
                $redirect = $redirect . $this->getData(['course', $courseId, 'homePageId']);
            } else {
                $redirect = $redirect . $this->getData(['enrolment', $courseId, $userId, 'lastPageId']);
            }
        }
        // Le cours est fermé
        elseif ($this->courseIsAvailable($courseId) === false) {
            // Génération du message
            $message = helper::translate('Ce cours est fermé');
            $state = false;
            if ($this->getData(['course', $courseId, 'access']) === self::COURSE_ACCESS_DATE) {
                $from = helper::dateUTF8('%m %B %Y', $this->getData(['course', $courseId, 'openingDate'])) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'openingDate']));
                $to = helper::dateUTF8('%m %B %Y', $this->getData(['course', $courseId, 'closingDate'])) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'closingDate']));
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
                case self::COURSE_ENROLMENT_SELF_KEY:
                    //L'étudiant dispsoe d'un compte
                    if ($this->getUser('id')) {
                        $redirect = $redirect . 'course/enrol/' . $courseId;
                        $message = helper::translate('Veuillez vous inscrire');
                        $state = true;
                    } else {
                        $message = helper::translate('Vous devez disposer d\'un compte pour accéder à ce cours');
                        $state = false;
                    }

                    break;
                // Par le prof
                case self::COURSE_ENROLMENT_MANUAL:
                    $message = helper::translate('L\'enseignant ne vous a pas inscrit dans ce cours !');
                    $state = false;
                    break;
                default:
                    # code...
                    break;
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
                        break;
                    case self::COURSE_ENROLMENT_SELF_KEY:
                        if ($this->getInput('courseSwapEnrolmentKey') === $this->getData(['course', $courseId, 'enrolmentKey'])) {
                            $this->courseEnrolUser($courseId, $userId);
                        }
                        break;
                }

                // Stocker la sélection
                $_SESSION['ZWII_SITE_CONTENT'] = $courseId;

                // Valeurs en sortie
                $this->addOutput([
                    'redirect' => helper::baseUrl()
                ]);
            }
        }
        // L'étudiant est-il  inscrit
        self::$swapMessage['submitLabel'] = 'Se connecter';
        self::$swapMessage['enrolmentMessage'] = '';
        self::$swapMessage['enrolmentKey'] = '';
        if ($this->courseIsUserEnroled($courseId) === false) {
            switch ($this->getData(['course', $courseId, 'enrolment'])) {
                case self::COURSE_ENROLMENT_GUEST:
                case self::COURSE_ENROLMENT_SELF:
                    self::$swapMessage['submitLabel'] = helper::translate('M\'inscrire');
                    break;
                case self::COURSE_ENROLMENT_SELF_KEY:
                    if ($userId) {
                        self::$swapMessage['enrolmentKey'] = template::text('courseSwapEnrolmentKey', [
                            'label' => helper::translate('Clé d\'inscription'),
                        ]);
                    } else {
                        self::$swapMessage['enrolmentMessage'] = helper::translate('Connectez-vous pour accéder à ce cours.');
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
                'lastPageId' => '',
                'lastVisit' => 0
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


}