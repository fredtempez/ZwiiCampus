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

    $('tr').click(function(){
        // Cochez ou décochez la case à cocher dans cette ligne
        $(this).find('input[type="checkbox"]').prop('checked', function(i, val){
            return !val; // Inverse l'état actuel de la case à cocher
        });
    });

    $('#groupUserAddSelectAll').on('click', function() {
        $('.checkboxSelect').prop('checked', true);

    });
    $('#groupUserAddSelectNone').on('click', function() {
        $('.checkboxSelect').prop('checked', false);

    });

    $('#groupFilterGroup, #groupFilterFirstName, #groupFilterLastName').change(function () {
        $('#groupUsersAddForm').submit();
    });

    var table = new DataTable('#dataTables', {
        language: {
            url: 'core/vendor/datatables/french.json'
        },
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
        "lengthMenu": [[10, 25, 50, 100, 200,  -1], [10, 25, 50, 100, 200, "Tout"]],
        "columnDefs": [
            {
                targets: 0, // Correction de 'target' -> 'targets'
                orderable: false,
                searchable: false,
            }
        ]
    });
    

}));