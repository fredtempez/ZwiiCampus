/**
 * * For full copyright and license information, please see the LICENSE
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
	$("#courseEditTitle").on("input", function () {
		$("#courseEditShortTitle").val($(this).val());
	});

	// Gestion de l'affichage de la période d'ouverture
	function togglePeriodSetup() {
		if ($('#courseEditAccess').val() == 1) {
			$('.periodSetup').slideDown();
		} else {
			$('.periodSetup').slideUp();
		}
	}

	// Afficher ou masquer la date limite d'inscription
	function toggleEnrolmentLimitDate() {
		if ($('#courseEditEnrolmentLimit').is(':checked')) {
			$('#courseEditEnrolmentLimitDateWrapper').slideDown();
		} else {
			$('#courseEditEnrolmentLimitDateWrapper').slideUp();
		}
	}

	// Vérifie que la date limite d'inscription est valide
	function validateEnrolmentLimitDate() {
		let openingDate = new Date($('#courseOpeningDate').val());
		let closingDate = new Date($('#courseClosingDate').val());
		let enrolmentDate = new Date($('#courseEditEnrolmentLimitDate').val());

		// Vérifie si les dates sont valides
		if (isNaN(openingDate.getTime()) || isNaN(closingDate.getTime()) || isNaN(enrolmentDate.getTime())) {
			return; // Ne fait rien si une des dates est vide ou invalide
		}

		// Vérifie que la date d'inscription est entre les deux bornes
		if (enrolmentDate < openingDate || enrolmentDate > closingDate) {
			alert("La date limite d'inscription doit être entre la date d'ouverture et de fermeture.");
			$('#courseEditEnrolmentLimitDate').val(''); // Réinitialise l'input
		}
	}

	// Fonction pour afficher ou masquer le champ courseEditEnrolmentKey
	function toggleEnrolmentKey() {
		if ($('#courseEditEnrolment').prop('selectedIndex') == 2) {
			$('#courseEditEnrolmentKeyWrapper').slideDown();
		} else {
			$('#courseEditEnrolmentKeyWrapper').slideUp();
		}
	}

	// Fonction pour valider l'ordre des dates d'ouverture et de fermeture
	function validateDateOrder() {
		let openingDate = new Date($('#courseOpeningDate').val());
		let closingDate = new Date($('#courseClosingDate').val());

		// Vérifie si les dates sont valides
		if (isNaN(openingDate.getTime()) || isNaN(closingDate.getTime())) {
			return; // Ne fait rien si une des dates est vide ou invalide
		}

		// Vérifie que la date d'ouverture est avant la date de fermeture
		if (openingDate >= closingDate) {
			alert("La date d'ouverture doit être antérieure à la date de fermeture.");
			$('#courseClosingDate').val(''); // Réinitialise la date de fermeture
		}

		// Si la date limite d'inscription existe, la revérifier
		if ($('#courseEditEnrolmentLimit').is(':checked') && $('#courseEditEnrolmentLimitDate').val()) {
			validateEnrolmentLimitDate();
		}
	}

	// Initialisation
	togglePeriodSetup();
	toggleEnrolmentLimitDate();
	toggleEnrolmentKey();

	// Gestion du changement de valeur
	$('#courseEditAccess').on('change', togglePeriodSetup);

	// Événement au changement
	$('#courseEditEnrolmentLimit').on('change', toggleEnrolmentLimitDate);

	// Vérifie la date lors de la saisie
	$('#courseEditEnrolmentLimitDate').on('change', validateEnrolmentLimitDate);

	// Affichage du champ clé
	$('#courseEditEnrolment').on('change', toggleEnrolmentKey);

	// Validation de l'ordre des dates
	$('#courseOpeningDate, #courseClosingDate').on('change', validateDateOrder);

});