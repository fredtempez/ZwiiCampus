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
        'index' => self::GROUP_ADMIN,
        'edit' => self::GROUP_ADMIN,
        'add' => self::GROUP_ADMIN,
        'delete' => self::GROUP_ADMIN,
        'swap' => self::GROUP_VISITOR,
    ];

    public static $courseAccess = [
        0 => 'Ouvert',
        1 => 'Période d\'ouverture',
        2 => 'Fermé',
    ];

    public static $courseEnrolment = [
        0 => 'Anonyme',
        1 => 'Auto-inscrition libre',
        2 => 'Auto-inscription avec clé',
        3 => 'Manuelle'
    ];

    public static $courseTeachers = [];

    public static $courses = [];

    public function index()
    {
        $courseIdShortTitle = helper::arrayColumn($this->getData(['course']), 'shortTitle');
        ksort($courseIdShortTitle);
        foreach ($courseIdShortTitle as $courseId => $courseTitle) {
            self::$courses[] = [
                $courseTitle,
                $this->getData(['course', $courseId, 'author']),
                $this->getData(['course', $courseId, 'description']),
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
        //var_dump($this->getCourseHierarchy(1, 1));
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
            $author = $this->getInput('courseAddAuthor');
            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseAddTitle', helper::FILTER_STRING_SHORT, true),
                    'shortTitle' => $this->getInput('courseAddShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' => $author,
                    'description' => $this->getInput('courseAddDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseAddAccess'),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseAddEnrolment'),
                    'enrolmentKey' => $this->getInput('courseAddEnrolmentKey'),
                ]
            ]);

            // Créer la structure de données
            mkdir(self::DATA_DIR . $courseId);

            // BDD des inscrits
            $this->setData([
                'enrolment',
                $courseId,
                [
                    'teacher' => $author,
                    'students' => []
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

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Ajouter un cours'),
            'view' => 'add'
        ]);
    }

    public function delete()
    {

        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) !== true ||
            // Le cours n'existe pas
            $this->getData(['course', $this->getUrl(2)]) === null
            // Groupe insuffisant
            and ($this->getUrl('group') < self::GROUP_TEACHER)
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
            $author = $this->getInput('courseAddAuthor');
            $this->setData([
                'course',
                $courseId,
                [
                    'title' => $this->getInput('courseEditTitle', helper::FILTER_STRING_SHORT, true),
                    'shortTitle' => $this->getInput('courseEditShortTitle', helper::FILTER_STRING_SHORT, true),
                    'author' =>$author,
                    'description' => $this->getInput('courseEditDescription', helper::FILTER_STRING_SHORT, true),
                    'access' => $this->getInput('courseEditAccess', helper::FILTER_INT),
                    'openingDate' => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate' => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseEditEnrolment', helper::FILTER_INT),
                    'enrolmentKey' => $this->getInput('courseEditEnrolmentKey'),
                ]
            ]);

            // BDD des inscrits
            $students = is_null($this->getData(['enrolment', $courseId, 'students'])) ? [] : $this->getData([ 'enrolment', $courseId, 'students']);
            $this->setData([
                'enrolment',
                $courseId,
                [
                    'teacher' => $author,
                    'students' => $students
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

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Editer un cours'),
            'view' => 'edit'
        ]);
    }

    /*
     * Traitement du changement de langue
     * Fonction utilisée par le noyau
     */
    public function swap()
    {
        // Cours sélectionnée
        $courseId = $this->getUrl(2);
        if (
            // home n'est pas présent dans la base de donénes des cours
            $courseId === 'home' ||
            (is_dir(self::DATA_DIR . $courseId) &&
                $this->getData(['course', $courseId]))
        ) {
            // Stocker la sélection
            $_SESSION['ZWII_SITE_CONTENT'] = $courseId;
        }

        // Valeurs en sortie
        $this->addOutput([
            'redirect' => helper::baseUrl()
        ]);
    }

    /**
     * Retourne un tableau des cours 
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
    public function getCourseHierarchy($access = null, $enrolment = null)
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

}