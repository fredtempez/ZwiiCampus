<?php

/**
 * Mises à jour suivant les versions de ZwiiCampus
 */

// Version 1.7.00
if (
    $this->getData(['core', 'dataVersion']) < 1700
) {
    // Supprime la variable path des profils, seul l'accès à l'espace et autorisé.
    foreach (['1', '2'] as $role) {
        foreach (array_keys($this->getData(['profil', $role])) as $profil) {
            if (is_null($this->getData(['profil', $role, $profil, 'folder', 'path'])) === false) {
                $path = $this->getData(['profil', $role, $profil, 'folder', 'path']);
                $this->setData(['profil', $role, $profil, 'folder', 'homePath', $path]);
                $this->setData(['profil', $role, $profil, 'folder', 'coursePath', $path]);
                $this->deleteData(['profil', $role, $profil, 'folder', 'path']);
            }
        }
    }
    $this->setData(['core', 'dataVersion', 1700]);
}

// Version 1.8.00
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

// Version 1.20.02
if (
    $this->getData(['core', 'dataVersion']) < 12002
) {

    /**
     * Installe  dans le thème du menu la variable hidePages 
     **/
    // Tableau à insérer
    $a = [
        'theme' =>
            [
                'menu' => [
                    'hidePages' => false
                ]
            ]
    ];
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
    $this->setData(['core', 'dataVersion', 12002]);
}

// Version 1.21.00

if (
    $this->getData(['core', 'dataVersion']) < 12100
) {
    /**
     * Renomme la clé dans la base des utilisateurs
     */
    if (
        is_array($this->getData(['user']))
        && empty($this->getData(['user'])) === false
    ) {
        foreach ($this->getData(['user']) as $userId => $userValue) {
            $d = $this->getData(['user', $userId]);
            if (isset($d['group']) && $d['group'] !== '') {
                $position = array_search('group', array_keys($d)) + 1;
                $l = array_merge(
                    array_slice($d, 0, $position),
                    ['role' => $d['group']],
                    array_slice($d, $position)
                );
                unset($l['group']);
                $this->setData(['user', $userId, $l], false);
            }
        }
    }
    $this->saveDb('user');


    /**
     * Convertit les pages et les modules
     */
    $courses = array_merge($this->getData(['course']), ['home' => array()]);

    foreach ($courses as $courseId => $courseValue) {
        // Les pages
        $filePath = self::DATA_DIR . $courseId . '/page.json';
        $jsonContent = file_get_contents($filePath);
        $updatedJsonContent = str_replace('"group":', '"role":', $jsonContent);
        if ($updatedJsonContent !== $jsonContent) {
            file_put_contents($filePath, $updatedJsonContent);
        }

        // Les modules
        $filePath = self::DATA_DIR . $courseId . '/module.json';
        $jsonContent = file_get_contents($filePath);
        $updatedJsonContent = str_replace('"group":', '"role":', $jsonContent);
        if ($updatedJsonContent !== $jsonContent) {
            file_put_contents($filePath, $updatedJsonContent);
        }
    }
    $this->setData(['core', 'dataVersion', 12100]);
}
