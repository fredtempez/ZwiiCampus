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


$(document).ready((function () {
    $(".userDelete").on("click", (function () {
        var _this = $(this);
        return message = "<?php echo helper::translate('Confirmer la suppression de ce groupe');?>", core.confirm(message, (function () {
            $(location).attr("href", _this.attr("href"))
        }))
    }));

    var table = $('#dataTables').DataTable({
        language: {
            url: 'core/vendor/datatables/french.json'
        },
        locale: 'fr',
        stateSave: true,
        info: false,
        "lengthMenu": [[10, 25, 50,  -1], [10, 25, 50, "Tout"]],
        "columnDefs": [
            {
                target: 3,
                orderable: false,
                searchable: false,
            }
        ]
    });

}));