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




$(document).ready(function () {

  /**
  * Confirmation de suppression
  */
$(".courseDelete").on("click", function () {
  var _this = $(this);
  var message = "<?php echo helper::translate('Supprimer cet espace et les documents du gestionnaire de fichier ?'); ?>";
  return core.confirm(message, function () {
      $(location).attr("href", _this.attr("href"));
  });
});

/**
* Confirmation de reset
*/
$(".courseReset").on("click", function () {
var _this = $(this);
var message = "<?php echo helper::translate('Réinitialiser cet espace ?'); ?>";
return core.confirm(message, function () {
    $(location).attr("href", _this.attr("href"));
});
});



	// Gestion de l'affichage de la période d'ouverture
	function togglePeriodSetup() {
		if ($('#courseManageAccess').val() == 1) {
			$('.periodSetup').slideDown();
		} else {
			$('.periodSetup').slideUp();
		}
	}

	// Afficher ou masquer la date limite d'inscription
	function toggleEnrolmentLimitDate() {
		if ($('#courseManageEnrolmentLimit').is(':checked')) {
			$('#courseManageEnrolmentLimitDateWrapper').slideDown();
		} else {
			$('#courseManageEnrolmentLimitDateWrapper').slideUp();
		}
	}

	// Vérifie que la date limite d'inscription est valide
	function validateEnrolmentLimitDate() {
		let openingDate = new Date($('#courseOpeningDate').val());
		let closingDate = new Date($('#courseClosingDate').val());
		let enrolmentDate = new Date($('#courseManageEnrolmentLimitDate').val());

		// Vérifie si les dates sont valides
		if (isNaN(openingDate.getTime()) || isNaN(closingDate.getTime()) || isNaN(enrolmentDate.getTime())) {
			return; // Ne fait rien si une des dates est vide ou invalide
		}

		// Vérifie que la date d'inscription est entre les deux bornes
		if (enrolmentDate < openingDate || enrolmentDate > closingDate) {
			alert("La date limite d'inscription doit être entre la date d'ouverture et de fermeture.");
			$('#courseManageEnrolmentLimitDate').val(''); // Réinitialise l'input
		}
	}

	// Fonction pour afficher ou masquer le champ courseManageEnrolmentKey
	function toggleEnrolmentKey() {
		if ($('#courseManageEnrolment').prop('selectedIndex') == 2) {
			$('#courseManageEnrolmentKeyWrapper').slideDown();
		} else {
			$('#courseManageEnrolmentKeyWrapper').slideUp();
		}
	}


	// Initialisation
	togglePeriodSetup();
	toggleEnrolmentLimitDate();
	toggleEnrolmentKey();

});

