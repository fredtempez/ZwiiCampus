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
        saveCheckboxState();
        $("#courseUsersFilterForm").submit();

    });
    var table = $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        "columnDefs": [
            {
                target: 3,
                orderable: false,
                searchable: false,

            }
        ]
    });

    // Handle checkbox state on DataTables draw event
    table.on('draw', function () {
        // Restore checkbox state from cookies or local storage
        restoreCheckboxState();
    });


    // Function to save checkbox state
    function saveCheckboxState() {
        var checkboxState = [];
        $('.checkboxSelect').each(function () {
            checkboxState.push({
                'rowIndex': $(this).closest('tr').index(),
                'checked': $(this).prop('checked')
            });
        });
        // Use cookies or local storage to store checkbox state
        localStorage.setItem('checkboxState', JSON.stringify(checkboxState));
    }

    // Function to restore checkbox state
    function restoreCheckboxState() {
        var checkboxState = JSON.parse(localStorage.getItem('checkboxState')) || [];
        checkboxState.forEach(function (item) {
            var rowIndex = item.rowIndex;
            var checked = item.checked;
            // Update checkbox state based on stored information
            $('#example tbody tr:eq(' + rowIndex + ') .checkboxSelect').prop('checked', checked);
        });
    }

}));