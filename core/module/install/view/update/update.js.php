function step(i, data) {
    var errors = ["<?php echo helper::translate('Préparation de la mise à jour'); ?>", "<?php echo helper::translate('Téléchargement et validation de l\'archive'); ?>", "<?php echo helper::translate('Installation'); ?>", "<?php echo helper::translate('Configuration'); ?>"];
    $(".installUpdateProgressText").hide(), $(".installUpdateProgressText[data-id=" + i + "]").show();

    $("body").css("cursor", "wait");

    $.ajax({
        type: "POST",
        url: "<?php echo helper::baseUrl(false); ?>?install/steps",
        data: {
            step: i,
            data: data
        },
        success: function (result) {
            setTimeout((function () {
                if (4 === i) {
                    $("#installUpdateSuccess").show();
                    $("body").css("cursor", "default");
                    $("#installUpdateEnd").removeClass("disabled");
                    $("#installUpdateProgress").hide();
                } else {
                    step(i + 1, result.data);
                }
            }), 2e3)
        },
        error: function (xhr) {
            console.log(i);
            console.log(xhr.responseText);
            console.log(errors);
            showError(i, xhr.responseText, errors);

            // Vérification du code d'erreur HTTP pour gérer la déconnexion
            if (xhr.status === 401 || xhr.status === 403) {

                alert("Votre session a expiré. Veuillez vous reconnecter. La réactivation de la réécriture des URL a échoué.");
                window.location.href = "?user/login"; // Redirige vers la page de connexion
            }
        }
    });
}

function showError(step, message, errors) {
    $("body").css("cursor", "default");
    $("#installUpdateErrorStep").text(errors[step] + " (étape n°" + step + ")");
    $("#installUpdateError").show();
    $("#installUpdateEnd").removeClass("disabled");
    $("#installUpdateProgress").hide();

    // Vérifier si l'accolade ouvrante est trouvée et qu'elle n'est pas en première position
    if (typeof message !== 'object') {

        // Trouver la position du premier "{" pour repérer le début du tableau
        const startOfArray = message.indexOf('{');

        // Extraire le message du warning jusqu'au début du tableau
        const warningMessage = message.substring(0, startOfArray).trim();

        // Extraire le tableau JSON entre les accolades
        const jsonString = message.substring(startOfArray);
        const jsonData = JSON.parse(jsonString);

        // Afficher les résultats
        if (jsonData) {
            $("#installUpdateErrorMessage").html("<strong>Détails de l'erreur :</strong><br> " +
                jsonData.data.replace(/^"(.*)"$/, '$1') +
                "<br>" +
                warningMessage.replace(/<[^p].*?>/g, ""));
        }

    } else {
        // Vous pouvez également faire quelque chose d'autre ici, par exemple, afficher un message à l'utilisateur, etc.
        $("#installUpdateErrorMessage").html(message);
    }
}

$(window).on("load", function () {
    step(1, null);
});