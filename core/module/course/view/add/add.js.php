/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @authorFrédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2025, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */



$(document).ready(function () {

	/**
	 * Duplication du champ Title dans Short title
	 */
	$("#courseAddTitle").on("input", function () {
		$("#courseAddShortTitle").val($(this).val());
	});

	// Gestion de l'affichage de la période d'ouverture
	function togglePeriodSetup() {
		if ($('#courseAddAccess').val() == 1) {
			$('.periodSetup').slideDown();
		} else {
			$('.periodSetup').slideUp();
		}
	}

	// Afficher ou masquer la date limite d'inscription
	function toggleEnrolmentLimitDate() {
		if ($('#courseAddEnrolmentLimit').is(':checked')) {
			$('#courseAddEnrolmentLimitDateWrapper').slideDown();
		} else {
			$('#courseAddEnrolmentLimitDateWrapper').slideUp();
		}
	}

	// Vérifie que la date limite d'inscription est valide
	function validateEnrolmentLimitDate() {
		let openingDate = new Date($('#courseOpeningDate').val());
		let closingDate = new Date($('#courseClosingDate').val());
		let enrolmentDate = new Date($('#courseAddEnrolmentLimitDate').val());

		// Vérifie si les dates sont valides
		if (isNaN(openingDate.getTime()) || isNaN(closingDate.getTime()) || isNaN(enrolmentDate.getTime())) {
			return; // Ne fait rien si une des dates est vide ou invalide
		}

		// Vérifie que la date d'inscription est entre les deux bornes
		if (enrolmentDate < openingDate || enrolmentDate > closingDate) {
			alert("La date limite d'inscription doit être entre la date d'ouverture et de fermeture.");
			$('#courseAddEnrolmentLimitDate').val(''); // Réinitialise l'input
		}
	}

	// Fonction pour afficher ou masquer le champ courseAddEnrolmentKey
	function toggleEnrolmentKey() {
		if ($('#courseAddEnrolment').prop('selectedIndex') == 2) {
			$('#courseAddEnrolmentKeyWrapper').slideDown();
		} else {
			$('#courseAddEnrolmentKeyWrapper').slideUp();
		}
	}


	// Initialisation
	togglePeriodSetup();
	toggleEnrolmentLimitDate();
	toggleEnrolmentKey();

	// Gestion du changement de valeur
	$('#courseAddAccess').on('change', togglePeriodSetup);

	// Événement au changement
	$('#courseAddEnrolmentLimit').on('change', toggleEnrolmentLimitDate);

	// Vérifie la date lors de la saisie
	$('#courseAddEnrolmentLimitDate').on('change', validateEnrolmentLimitDate);

	// Affichage du champ clé
	$('#courseAddEnrolment').on('change', toggleEnrolmentKey);

});
