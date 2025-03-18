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
	 * Tri dynamique de la galerie
	 */
	$("#galleryTable").tableDnD({
		onDrop: function (table, row) {
			$("#galleryEditFormResponse").val($.tableDnD.serialize());
			sortPictures();
			location.reload();
		},
		serializeRegexp: ""
	});

	/**
 	* Tri dynamique des images
 	*/

	function sortPictures() {
		var url = "<?php echo helper::baseUrl() . $this->getUrl(0); ?>/sortPictures";
		var d1 = $("#galleryEditFormResponse").val();
		var d2 = $("#galleryEditFormGalleryName").val();
		$.ajax({
			type: "POST",
			url: url,
			data: {
				response: d1,
				gallery: d2
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
		  }
		});
	}

	if ($("#galleryEditSort").val() !== "SORT_HAND") {
		$("#galleryTable tr").addClass("nodrag nodrop");
		$(".zwiico-sort").hide();
		$("#galleryTable").tableDnDUpdate();
	} else {
		$("#galleryTable tr").removeClass("nodrag nodrop");
		$(".zwiico-sort").show();
		$("#galleryTable").tableDnDUpdate();
	}


	$("#galleryEditSort").change(function () {
		if ($("#galleryEditSort").val() !== "SORT_HAND") {
			$("#galleryTable tr").addClass("nodrag nodrop");
			$(".zwiico-sort").hide();
			$("#galleryTable").tableDnDUpdate();
		} else {
			$("#galleryTable tr").removeClass("nodrag nodrop");
			$(".zwiico-sort").show();
			$("#galleryTable").tableDnDUpdate();
		}
	});

	/**
	 * Checkbox unique
	 */

	$('.homePicture').click(function () {
		$('.homePicture').prop('checked', false);
		$(this).prop('checked', true);
	});

});
