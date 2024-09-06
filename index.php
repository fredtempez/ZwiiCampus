<?php

/**
 * This file is part of Zwii.
 *
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

 /**
 * Initialisation de Zwii
 */
// Remplace la directive htaccess
ini_set('session.use_trans_sid', FALSE);
// Crée un identifiant unique pour chaque site en fonction du nom de domaine ou autre
$siteId = md5($_SERVER['SERVER_NAME']); // Ou utilise un autre identifiant unique pour chaque site
// Change le nom de la session en fonction de cet identifiant
session_name('zwii_session_' . $siteId);
// Démarre la session
session_start();
// Contrôle des conditions de fonctionnement
include_once('core/include/checkup.php');

/*
 *Localisation par défaut 

 * Locales :
 * french : free.fr
 * fr_FR : XAMPP Macos
 * fr_FR.utf8 : la majorité
*/
date_default_timezone_set('Europe/Paris');
setlocale (LC_ALL, 'fr_FR.UTF8', 'fr_FR', 'french');

/**
 * Chargement des classes
 */
require 'core/class/autoload.php';
autoload::autoloader();
spl_autoload_register('core::autoload');

/**
 * Chargement du coeur
 */
$core = new core;
echo $core->router();
