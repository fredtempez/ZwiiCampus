/**
 * This file is part of Zwii.
 *
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

$(document).ready(function() {
    // Quand le bouton "Cocher toutes" est cliqué
    $('#courseExportSelectAll').on('click', function() {
        // Cocher toutes les checkboxes avec la classe 'courseManageCheckbox'
        $('.courseManageCheckbox').prop('checked', true);
    });

    // Quand le bouton "Décocher toutes" est cliqué
    $('#courseExportSelectNone').on('click', function() {
        // Décocher toutes les checkboxes avec la classe 'courseManageCheckbox'
        $('.courseManageCheckbox').prop('checked', false);
    });
});