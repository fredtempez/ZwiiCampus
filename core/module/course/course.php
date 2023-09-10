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
        'index' => self::GROUP_TEACHER,
        'add' => self::GROUP_ADMIN,
    ];

    public static $courseAccess = [
        0 => 'Ouvert',
        1 => 'Période d\'ouverture',
        2 => 'Fermé',
    ];

    public static $courseEnrolment = [
        0 => 'Anonyme',
        1 => 'Auto-inscrition',
        2 => 'Auto-inscription avec clé',
        3 => 'Manuelle'
    ];

    public static $courseTeachers = [];

    public function index()
    {
        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Cours'),
            'view' => 'index'
        ]);
    }

    public function add()
    {

        // Soumission du formulaire
        if (
            $this->getUser('permission', __CLASS__, __FUNCTION__) === true &&
            $this->isPost()
        ) {
            $this->setData([
                'course',
                uniqid(),
                [
                    'title' => $this->getInput('courseAddTitle',helper::FILTER_STRING_SHORT, true),
                    'shortTitle' => $this->getInput('courseAddShortTitle',helper::FILTER_STRING_SHORT, true),
                    'author' => $this->getInput('courseAddAuthor'),
                    'description' => $this->getInput('courseAddDescription', helper::FILTER_STRING_SHORT, true),
                    'access'  => $this->getInput('courseAddAccess'),
                    'openingDate'  => $this->getInput('courseOpeningDate', helper::FILTER_DATETIME),
                    'closingDate'  => $this->getInput('courseClosingDate', helper::FILTER_DATETIME),
                    'enrolment' => $this->getInput('courseAddEnrolment'),
                    'enrolmentKey' => $this->getInput('courseAddEnrolmentKey'),
                ]
            ]);

			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'course',
				'notification' => helper::translate('Cours créé'),
				'state' =>  true
			]);
        }

        $teachers = $this->getData(['user']);
        foreach ($teachers as $teacherId => $teacherInfo) {
            if ( $teacherInfo["group"] >= 2 ) {
                self::$courseTeachers[$teacherId] = $teacherInfo["firstname"] . ' ' . $teacherInfo["lastname"];
            }
        }

        // Valeurs en sortie
        $this->addOutput([
            'title' => helper::translate('Ajouter un cours'),
            'view' => 'add'
        ]);
    }

}