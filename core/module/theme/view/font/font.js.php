/**
 * This file is part of Zwii.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2025, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */
$(".themeFontDelete").on("click", (function () {
    var _this = $(this);
    return core.confirm("Êtes-vous sûr de vouloir supprimer cette fonte ?", (function () {
        $(location).attr("href", _this.attr("href"))
    }))
}));


var table = new DataTable('#dataTables', {
    language: {
        url: 'core/vendor/datatables/french.json'
    },
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
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
    "columnDefs": [{
            targets: 5,
            orderable: false,
            searchable: false
        },
        {
            targets: 6,
            orderable: false,
            searchable: false,
        }
    ]
});