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
    // Transmettre la langue au script Datatables.net
    var lang = getCookie('ZWII_UI');
    var languageUrl = 'core/vendor/datatables/' + lang + '.json';
    $('#dataTables').DataTable({
        language: {
            url: languageUrl
        },
        order: [[0, 'desc']],
        locale: 'fr',
        stateSave: true,
        info: true,
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
        dom: '<"top"lBf>rt<"bottom"p>',
        "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Tout"]],
        "columnDefs": [
            {
                targets: 5,
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
                targets: 6,
                orderable: false,
                searchable: false
            }]
    });

}));