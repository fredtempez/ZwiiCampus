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