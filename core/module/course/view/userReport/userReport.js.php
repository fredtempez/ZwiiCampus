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

    var dataX = <?php echo json_encode(array_map(function ($item) { return $item[0]; }, $module::$userGraph)); ?>;
    var dataY = <?php echo json_encode(array_map(function ($item) { return $item[1];}, $module::$userGraph)); ?>;
    var dataText = <?php echo json_encode(array_map(function ($item) { return $item[2];}, $module::$userGraph)); ?>;

    var data = [{
        x: dataX,
        y: dataY,
        text: dataText,
        mode: 'markers', // Mode de tracé des points
        type: 'scatter' // Type de graphe
    }];

    // Créer un objet layout et définir les propriétés du titre, des axes, etc.
    var layout = {
        title: 'Consultations par jour', // Titre du graphe
        xaxis: {
            title: 'Jours', // Titre de l'axe des abscisses
            type: 'date' // Type de l'axe des abscisses
        },
        yaxis: {
            title: 'Temps (en secondes)', // Titre de l'axe des ordonnées
            type: 'linear' // Type de l'axe des ordonnées
        }
    };

    // Créer et afficher le graphe dans l'élément <div>
    Plotly.newPlot('graph', data, layout, {locale: 'fr-CH'});

}));