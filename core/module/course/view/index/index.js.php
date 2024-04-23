/**
 * This file is part of Zwii.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2024, Frédéric Tempez
 * @license CC Attribution-NonCommercial-NoDerivatives 4.0 International
 * @link http://zwiicms.fr/
 */

$(document).ready(function () {
    $('#dataTables').DataTable({
        language: {
            url: "core/vendor/datatables/french.json"
        },
        locale: 'fr',
        stateSave: true,
        "columnDefs": [
            {
                target: 2,
                orderable: false,
                searchable: false
            },
            {
                target: 3,
                orderable: false,
                searchable: false
            },
            {
                target: 4,
                orderable: false,
                searchable: false
            }
        ]
    });
});