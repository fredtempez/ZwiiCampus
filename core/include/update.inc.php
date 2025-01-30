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
            $history = array_key_exists('history', $userData) ? $userData['history'] : null;

            if (is_array($history)) {
                foreach ($history as $pageId => $timestamps) {
                    foreach ($timestamps as $timestamp) {
                        fputcsv($fp, [$userId, $pageId, $timestamp], ';');
                    }
                }
            }
            $this->deleteData(['enrolment', $courseId, $userId, 'history']);
        }
        fclose($fp);
    }
    $this->setData(['core', 'dataVersion', 1800]);
}

if (
    $this->getData(['core', 'dataVersion']) < 12002
) {

    /**
     * Installe  dans le thème du menu la variable hidePages 
     **/
    // Tableau à insérer
    $a = [
        'theme' =>
        ['menu' => [
            'hidePages' => false
    ]]];
    // Parcourir la structure pour écrire dans les fichiers JSON
    foreach ($this->getData(['course']) as $courseId => $courseValues) {
        $d = json_decode(file_get_contents(self::DATA_DIR . $courseId . '/theme.json'), true);
        //  Insérer la variable hidePages si elle n'existe pas
        if (isset($d['theme']['menu']['hidePages']) === false) {
             $result = array_replace_recursive($d, $a);
             file_put_contents(self::DATA_DIR . $courseId . '/theme.json', json_encode($result,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        // Forcer la régénération du fichier theme.css
        if (file_exists(self::DATA_DIR . $courseId . '/theme.css')) {
            unlink(self::DATA_DIR . $courseId . '/theme.css');
        }
    }
    //$this->setData(['core', 'dataVersion', 12002]);
}
