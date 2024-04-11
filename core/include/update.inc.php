<?php

/**
 * Mises à jour suivant les versions de ZwiiCampus
 */


if (
    $this->getData(['core', 'dataVersion']) < 1700
) {
    // Supprime la variable path des profils, seul l'accès à l'espace et autorisé.
    foreach (['1', '2'] as $group) {
        foreach (array_keys($this->getData(['profil', $group])) as $profil) {
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
    // Parcourir la structure pour écrire dans les fichiers CSV
    foreach ($this->getData(['enrolment']) as $courseId => $users) {
        $filename = self::DATA_DIR . $courseId . '/report.csv';
        $fp = fopen($filename, 'w');

        foreach ($users as $userId => $userData) {
            $history = $userData['history'];
            foreach ($history as $pageId => $timestamps) {
                foreach ($timestamps as $timestamp) {
                    fputcsv($fp, [$userId, $pageId, $timestamp]);
                }
            }
        }

        fclose($fp);
    }
    //$this->setData(['core', 'dataVersion', 1800]);
}