<?php

/*
Ce script PHP est conçu pour être appelé via une requête HTTP GET avec une clé spécifique pour déclencher la création d'une archive ZIP de sauvegarde.

Exemple d'appel dans une URL :
http://example.com/chemin/vers/autobackup.php?key=your_secret_key&filter=site

La clé doit être fournie en tant que paramètre "key" dans l'URL et correspondre à celle stockée dans le fichier "data.key" pour que la création de l'archive soit autorisée. Si la clé est valide, le script parcourt le répertoire spécifié en fonction du paramètre "filter" et ajoute les fichiers à l'archive ZIP. Si la clé est invalide ou absente, le script renvoie une réponse avec le code d'erreur 401 Unauthorized.

Le paramètre "filter" en GET permet de spécifier le filtre à appliquer lors de la création de l'archive. Sa valeur peut être "file" ou "data". Si le paramètre n'est pas spécifié, le filtre est vide par défaut, ce qui signifie que tous les fichiers seront inclus dans l'archive.

*/

// Vérification de la clé
if (isset($_GET['key'])) {
    $key = $_GET['key'];
    $storedKey = file_get_contents('data.key');
    if ($key !== $storedKey) {
        http_response_code(401); // Clé invalide, renvoie une réponse avec le code d'erreur 401 Unauthorized
        exit();
    }

    // Définition du filtre par défaut
    $filter = ['backup', 'tmp'];

    // Tableau de correspondance entre les valeurs de "filter" et les répertoires à inclure
    $filterDirectories = [
        'file' => ['backup', 'tmp', 'file'],
        'data' => ['backup', 'tmp', 'data'],
        'i18n' => ['backup', 'tmp', 'i18n'],
    ];

    // Vérification et traitement du paramètre "filter" en GET
    if (isset($_GET['filter']) && isset($filterDirectories[$_GET['filter']])) {
        $filter = $filterDirectories[$_GET['filter']];
    }

    // Création du ZIP
    $fileName = date('Y-m-d-H-i-s', time()) . '-rolling-backup.zip';
    $zip = new ZipArchive();
    $zip->open('../../../../site/backup/' . $fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $directory = '../../../../site';
    $files = new RecursiveIteratorIterator(
        new RecursiveCallbackFilterIterator(
            new RecursiveDirectoryIterator(
                $directory,
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
            function ($fileInfo, $key, $iterator) use ($filter) {
                return $fileInfo->isFile() || !in_array($fileInfo->getBaseName(), $filter);
            }
        )
    );
    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen(realpath($directory)) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }
    $zip->close();

    http_response_code(201); // Création de l'archive réussie, renvoie une réponse avec le code 201 Created
}
?>
