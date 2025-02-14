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

    $('#groupUsersSelectAll').on('click', function() {
        $('.checkboxSelect').prop('checked', true);
    });
    $('#groupUsersSelectNone').on('click', function() {
        $('.checkboxSelect').prop('checked', false);

    });

    $('#groupFilterGroup, #groupFilterFirstName, #groupFilterLastName').change(function () {
        $('#groupUsersForm').submit();
    });

    var table = $('#dataTables').DataTable({
        language: {
            url: 'core/vendor/datatables/french.json'
        },
        locale: 'fr',
        stateSave: true,
        info: false,
        "lengthMenu": [[10, 25, 50, 100, 299,  -1], [10, 25, 50, 100, 200, "Tout"]],
        "columnDefs": [
            {
                target: 0,
                orderable: false,
                searchable: false,
            }
        ]
    });

    // Empty local storage after submit
    $("#groupUserssSubmit").on("click", function () {
        localStorage.setItem('checkboxState', JSON.stringify({}));
    });

 
}));