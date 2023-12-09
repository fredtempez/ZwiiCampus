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

$(document).ready((function () {
    $("#courseFilterGroup, #courseFilterFirstName, #courseFilterLastName").change(function () {
        $("#courseFilterUserForm").submit();
    });
    $(".userDelete").on("click", (function () {
        var _this = $(this);
        return message = "<?php echo helper::translate('Confirmer la désinscription de cet utilisateur');?>", core.confirm(message, (function () {
            $(location).attr("href", _this.attr("href"))
        }))
    }));

    $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        locale: 'fr',
        "columnDefs": [
            {
                target: 6,
                orderable: false,
                searchable: false
            }
        ]
    });

}));