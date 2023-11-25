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

    $('#courseUserAddSelectAll').on('click', function() {
        $('.checkboxSelect').prop('checked', true);
        saveCheckboxState();
    });
    $('#courseUserAddSelectNone').on('click', function() {
        $('.checkboxSelect').prop('checked', false);
        saveCheckboxState();
    });

    $("#courseFilterGroup, #courseFilterFirstName, #courseFilterLastName").change(function () {
        saveCheckboxState();
        $("#courseUsersAddForm").submit();
    });

    var table = $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        "columnDefs": [
            {
                target: 0,
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
    $("#courseUsersAddSubmit").on("click", function () {
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