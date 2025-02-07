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
        order: [[3, 'desc']],
        locale: 'fr',
        stateSave: true,
        "lengthMenu": [[10, 25, 50, 100, 299, -1], [10, 25, 50, 100, 200, "Tout"]],
        "columnDefs": [
            {
                targets: 2,
                type: 'datetime', 
                searchable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        if (typeof data === 'number' || !isNaN(data)) {
                            return moment(Number(data) * 1000).format('DD/MM/YYYY HH:mm');
                        } else {
                            return data;
                        }
                    }
                    // Pour le tri, retournez la valeur au format ISO
                    return moment(Number(data) * 1000).toISOString();
                }
            },
            {
                targets: 5,
                orderable: false,
                searchable: false
            }]
    });

}));