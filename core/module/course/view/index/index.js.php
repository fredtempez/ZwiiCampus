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
    $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        locale: 'fr',
        "columnDefs": [
            {
                target: 2,
                orderable: false,
                searchable: false
            },
            {
                target: 3,
                orderable: false,
                searchable: false
            },
            {
                target: 4,
                orderable: false,
                searchable: false
            },
            {
                target: 5,
                orderable: false,
                searchable: false
            },
            {
                target: 6,
                orderable: false,
                searchable: false
            }
        ]
    });
});