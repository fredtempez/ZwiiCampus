<?php echo template::formOpen('profilAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('profilAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'user/profil',
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('profilAddSubmit'); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Paramètres du profil'); ?>
            </h4>
            <div class="row">
                <div class="col6">
                    <div class="row">
                        <div class="col12">
                            <?php echo template::text('profilAddName', [
                                'label' => 'Nom du profil',
                                'value' => $this->getData(['profil', $this->getUrl(2), $this->getUrl(3), 'name'])
                            ]); ?>
                        </div>
                        <div class="col12">
                            <?php echo template::select('profilAddRole', user::$roleProfils, [
                                'label' => 'Rôle associé',
                                'selected' => $this->getUrl(2)
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col6">
                    <?php echo template::textarea('profilAddComment', [
                        'label' => 'Commentaire',
                        'value' => $this->getData(['profil', $this->getUrl(2), $this->getUrl(3), 'comment'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Compte de l\'utilisateur'); ?>
            </h4>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('profilAddUserEdit', true, 'Éditer'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Gestionnaire de fichiers'); ?>
            </h4>
            <div class="row">
                <div class="col2">
                    <?php echo template::checkbox('profilAddFileManager', true, 'Autorisé'); ?>
                </div>
                <div class="col5">
                    <?php echo template::select('profilAddCoursePath', user::$sharePath, [
                        'label' => 'Dossier depuis un espace',
                        'class' => 'filemanager',
                    ]); ?>
                </div>
                <div class="col5">
                    <?php echo template::select('profilAddHomePath', user::$sharePath, [
                        'label' => 'Dossier depuis l\'accueil',
                        'class' => 'filemanager',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <div class="block">
                        <h4>
                            <?php echo helper::translate('Permissions sur les dossiers'); ?>
                        </h4>
                        <div class="row">
                            <div class="col2">
                                <?php echo template::checkbox('profilAddFolderCreate', true, 'Ajouter', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col2">
                                <?php echo template::checkbox('profilAddFolderDelete', true, 'Effacer', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col2">
                                <?php echo template::checkbox('profilAddFolderRename', true, 'Renommer', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col2">
                                <?php echo template::checkbox('profilAddFolderCopycut', true, 'Presse Papier', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddFolderChmod', true, 'Droits sur les dossiers', ['class' => 'filemanager']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <div class="block">
                        <h4>
                            <?php echo helper::translate('Permissions sur les fichiers'); ?>
                        </h4>
                        <div class="row">
                            <div class="col3">
                                <?php echo template::checkbox('profilAddDownload', true, 'Télécharger', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddEdit', true, 'Éditer', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddCreate', true, 'Ajouter', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddRename', true, 'Renommer', ['class' => 'filemanager']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col3">
                                <?php echo template::checkbox('profilAddUpload', true, 'Téléverser', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddDelete', true, 'Effacer', ['class' => 'filemanager']); ?>
                            </div>

                            <div class="col3">
                                <?php echo template::checkbox('profilAddPreview', true, 'Prévisualiser', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddDuplicate', true, 'Dupliquer', ['class' => 'filemanager']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col3">
                                <?php echo template::checkbox('profilAddExtract', true, 'Extraire', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddCopycut', true, 'Presse papier', ['class' => 'filemanager']); ?>
                            </div>
                            <div class="col3">
                                <?php echo template::checkbox('profilAddChmod', true, 'Droits sur les fichiers', ['class' => 'filemanager']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row containerPage">
<div class="row">
        <div class="col12">
            <div class="block">
                <h4>
                    <?php echo helper::translate('Gestion des espaces'); ?>
                </h4>
                <div class="row">
                    <div class="col6">
                        <?php echo template::checkbox('profilAddCourseTutor', true, 'Tuteur de tous les espaces', [
                            'help' => 'Est autorisé à gérer tous les espaces, y compris ceux des autres auteurs',
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseAdd', true, 'Ajuter un espace'); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseDelete', true, 'Supprimer un espace'); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseEdit', true, 'Éditer un espace'); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseBackup', true, 'Sauvegarder un espace'); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseRestore', true, 'Restaurer un espace'); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseExport', true, 'Exporter un espace en html'); ?>
                    </div>
                    <div class="col3">
                            <?php echo template::checkbox('profilAddCourseReset', true, 'Réinitialiser un espace'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col3">
                        <?php echo template::checkbox('profilAddCourseUsers', true, 'Gérer les participants'); ?>
                    </div>
                </div>
                <div id="courseContainer">
                    <div class="row">
                        <div class="col3">
                            <?php echo template::checkbox('profilAddCourseUserHistory', true, "Voir historique d'un participant"); ?>
                        </div>
                        <div class="col3">
                            <?php echo template::checkbox('profilAddCourseuserReportExport', true, "Exporter historique d'un participant"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col3">
                            <?php echo template::checkbox('profilAddCourseUserDelete', true, 'Désinscrire un participant'); ?>
                        </div>
                        <div class="col3">
                            <?php echo template::checkbox('profilAddCourseUsersAdd', true, 'Inscrire en masse'); ?>
                        </div>
                        <div class="col3">
                            <?php echo template::checkbox('profilAddCourseUsersDelete', true, 'Désinscrire en masse'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col12">
            <div class="block">
                <h4>
                    <?php echo helper::translate('Groupes de participants'); ?>
                </h4>
                <div class="col3">
                        <?php echo template::checkbox('profilAddGroupAdd', true, 'Ajouter'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddGroupEdit', true, 'Éditer'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddGroupDelete', true, 'Effacer'); ?>
                </div>
                <div class="col2">
                    <?php echo template::checkbox('profilAddGroupImport', true, 'Importer'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Permissions sur les pages'); ?>
            </h4>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('profilAddPageAdd', true, 'Ajouter'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddPageEdit', true, 'Éditer'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddPageDelete', true, 'Effacer'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddPageDuplicate', true, 'Dupliquer'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('profilAddPageModule', true, 'Module'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddPagecssEditor', true, 'Éditeur CSS'); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('profilAddPagejsEditor', true, 'Éditeur JS'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="containerModule">
    <?php foreach (user::$listModules as $moduleId): ?>
        <?php if (file_exists('module/' . $moduleId . '/profil/view/add.inc.php')) {
            include('module/' . $moduleId . '/profil/view/add.inc.php');
        } ?>
    <?php endforeach; ?>
</div>
<?php echo template::formClose(); ?>