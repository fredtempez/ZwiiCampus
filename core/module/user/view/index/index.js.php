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
    $.fn.dataTable.ext.type.order['timestamp-custom-pre'] = function (data) {
        if (data === '' || data === 'Jamais') {
            return Number.MAX_SAFE_INTEGER; // "Jamais" est trié en dernier en DESC, en premier en ASC
        }
        return parseInt(data, 10) || 0; // Convertir le timestamp pour le tri
    };
    // Transmettre la langue au script Datatables.net
    var lang = getCookie('ZWII_UI');
    var languageUrl = 'core/vendor/datatables/' + lang + '.json';
    var table = $('#dataTables').DataTable({
        language: {
            url: languageUrl
        },
        stateSave: true,
        info: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
        dom: '<"top"lBf>rt<"bottom"p>',
        buttons: [
            {
                extend: 'csv',
                text: '<i class="zwiico-code"></i>',
                titleAttr: 'Exporter les données au format CSV',
            },
            {
                extend: 'copy',
                text: '<i class="zwiico-docs"></i>',
                titleAttr: 'Copier dans le presse papier',
            },
            {
                extend: 'print',
                text: '<i class="zwiico-print"></i>',
                titleAttr: 'Imprimer ou générer un PDF',
            }
        ],
        columnDefs: [
            {
                targets: 5,
                type: 'timestamp-custom',
                render: function (data, type, row) {
                    if (type === 'display') {
                        if (!data || isNaN(parseInt(data))) {
                            return 'Jamais';
                        }
                        // Conversion explicite en entier
                        var timestamp = parseInt(data, 10) * 1000;
                        return moment(timestamp).format('DD/MM/YYYY HH:mm');
                    }
                    // Pour le tri, retourner un nombre valide ou MAX_SAFE_INTEGER
                    return (!data || isNaN(parseInt(data))) ? Number.MAX_SAFE_INTEGER : parseInt(data, 10);
                }
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
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