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

    var table = new DataTable('#dataTables', {
        language: {
            url: 'core/vendor/datatables/french.json'
        },
        locale: 'fr',
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
                targets: 3, // Désactiver le tri et la recherche sur la 4e colonne (index 3)
                orderable: false,
                searchable: false,
            }
        ]
    });
    

}));