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
        return message = "<?php echo helper::translate('Confirmer la suppression de cet utilisateur');?>", core.confirm(message, (function () {
            $(location).attr("href", _this.attr("href"))
        }))
    }));

    $("#userFilterGroup, #userFilterFirstName, #userFilterLastName").change(function () {
        $("#userFilterUserForm").submit();
    });
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        locale: 'fr',
        stateSave: true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
        "columnDefs": [
            {
                target: 4,
                type: 'num', // Utilisez 'num' pour le tri
                render: function (data) {
                    // Si data est un nombre, formatez-le en date
                    if (typeof data === 'number' || !isNaN(data)) {
                        return moment(Number(data) * 1000).format('DD/MM/YYYY HH:mm');
                    } else {
                        return data; // Sinon, affichez le texte tel quel
                    }
                },
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

    // Injecter la règle CSS pour la colonne cible
    $('<style>')
    .prop('type', 'text/css')
    .html(`
        table.dataTable tbody td:nth-child(5) {
            color: inherit !important; /* Rétablir la couleur du texte */
        }
    `)
    .appendTo('head');

}));