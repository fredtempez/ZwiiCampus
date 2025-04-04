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

    $('tr').click(function () {
        // Cochez ou décochez la case à cocher dans cette ligne
        $(this).find('input[type="checkbox"]').prop('checked', function (i, val) {
            return !val; // Inverse l'état actuel de la case à cocher
        });
    });

    $('#usersTagSelectAll').on('click', function () {
        $('.checkboxSelect').prop('checked', true);
        saveCheckboxState();
    });
    $('#usersTagSelectNone').on('click', function () {
        $('.checkboxSelect').prop('checked', false);
        saveCheckboxState();
    });

    $("#usersFilterGroup, #usersFilterFirstName, #usersFilterLastName").change(function () {
        saveCheckboxState();
        $("#usersTagForm").submit();
    });
    // Transmettre la langue au script Datatables.net
    var lang = getCookie('ZWII_UI');
    var languageUrl = 'core/vendor/datatables/' + lang + '.json';
    var table = new DataTable('#dataTables', {
        language: {
            url: languageUrl
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
        "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Tout"]],
        "columnDefs": [
            {
                targets: 0, // Correction de 'target' -> 'targets'
                orderable: false,
                searchable: false,
            }
        ]
    });

    // Handle checkbox change event
    $('.checkboxSelect').on('change', function () {
        // Save checkbox state to cookies or local storage
        saveCheckboxState();
    });

    // Handle checkbox state on DataTables draw event
    table.on('draw', function () {
        // Restore checkbox state from cookies or local storage
        restoreCheckboxState();
    });

    // Empty local storage after submit
    $("#usersTagSubmit").on("click", function () {
        localStorage.setItem('checkboxState', JSON.stringify({}));
    });

    // Restore checkbox state on page load
    restoreCheckboxState();

    function saveCheckboxState() {

        // Récupérer d'abord les données existantes dans le localStorage
        var existingData = JSON.parse(localStorage.getItem('checkboxState')) || {};

        // Ajouter ou mettre à jour les données actuelles
        $('.checkboxSelect').each(function () {
            var checkboxId = $(this).attr('id');
            var checked = $(this).prop('checked');
            existingData[checkboxId] = checked;
        });

        // Sauvegarder les données mises à jour dans le localStorage
        localStorage.setItem('checkboxState', JSON.stringify(existingData));
    }

    // Function to restore checkbox state
    function restoreCheckboxState() {
        var checkboxState = JSON.parse(localStorage.getItem('checkboxState')) || {};
        // console.log(checkboxState);
        for (var checkboxId in checkboxState) {
            if (checkboxState.hasOwnProperty(checkboxId)) {
                var checked = checkboxState[checkboxId];
                // Update checkbox state based on stored information
                $('#' + checkboxId).prop('checked', checked);
            }
        }
    }

}));