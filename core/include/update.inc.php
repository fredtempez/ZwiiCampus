<?php

/**
 * Mises à jour suivant les versions de ZwiiCampus
 */


if (
    $this->getData(['core', 'dataVersion']) < 1700
) {
    // Supprime la variable path des profils, seul l'accès à l'espace et autorisé.
    foreach (['1', '2'] as $group) {
        foreach ( array_keys($this->getData(['profil', $group])) as $profil) {
            if (is_null($this->getData(['profil', $group, $profil, 'folder', 'path'])) === false) {
                $path = $this->getData(['profil', $group, $profil, 'folder', 'path']);
                $this->setData(['profil', $group, $profil, 'folder', 'homePath', $path]);
                $this->setData(['profil', $group, $profil, 'folder', 'coursePath', $path]);
                $this->deleteData(['profil', $group, $profil, 'folder', 'path']);
            }
        }
    }
    $this->setData(['core', 'dataVersion', 1700]);
}


if (
    $this->getData(['core', 'dataVersion']) < 1800
) {
    // Déplace les historiques dans les dossiers des esapaces 
    // Parcourir les espaces
    foreach ($this->getData(['course']) as $courseId => $courseValues) {        
        $data = [];
        //Parcourir les participants
        foreach ($this->getData(['user']) as $userId => $userValues) {
            // Un historique existe pour ce participant
            $report = $this->getData(['enrolment', $courseId, $userId, 'history']);
            if ( is_array($report)
            ) {
                // Ecriture dans un fichier report dans le dossier de l'espace
                $data[$userId] = array_merge($data, [$userId => $report]);
                // Nettoyage du fichier des inscriptions
                // Ce fichier ne contient que l'id du participant et de la date et de l'id de la dernière page vue
               // $this->deleteData(['enrolment', $courseId, $userId, 'history']);
            } 
        }
        // Stocke le rapport en CSV
        $file = fopen(self::DATA_DIR . $courseId . '/report.csv', 'a+');
        fputcsv($file,  [$data], ';');
        fclose($file);
    } 
    //$this->setData(['core', 'dataVersion', 1800]);

}