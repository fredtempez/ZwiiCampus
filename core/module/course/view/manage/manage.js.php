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
  * Confirmation de suppression
  */
 $(".courseReset").on("click", function () {
  var _this = $(this);
  var message = "<?php echo helper::translate('Réinitialiser cet espace ?'); ?>";
  return core.confirm(message, function () {
      $(location).attr("href", _this.attr("href"));
  });
});