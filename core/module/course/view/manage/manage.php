<div class="row">
    <div class="col1">
        <?php echo template::button('courseManageBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>
</div>
<div class="row textAlignCenter">
    <?php if ($this->getUser('permission', 'course', 'delete') === true): ?>
        <div class="col2 ">
            <?php echo template::button('courseManageDelete' . $this->getUrl(2), [
                'class' => 'courseDelete buttonRed',
                'href' => helper::baseUrl() . 'course/delete/' . $this->getUrl(2),
                'value' => 'Supprimer',
                'ico' => 'trash',
                'help' => 'Supprime l\'espace et les historiques des participants',
            ]); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->getUser('permission', 'course', 'reset') === true): ?>
        <div class="col2 ">
            <?php echo template::button('courseManageReset' . $this->getUrl(2), [
                'class' => 'courseReset buttonRed',
                'href' => helper::baseUrl() . 'course/reset/' . $this->getUrl(2),
                'value' => 'Réinitaliser',
                'ico' => 'cancel',
                'help' => 'Désinscrit les participants et supprime les historiques',
            ]); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->getUser('permission', 'course', 'backup') === true): ?>
        <div class="col2">
            <?php echo template::button('courseManageDownload' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/backup/' . $this->getUrl(2),
                'value' => 'Sauvegarder',
                'ico' => 'download-cloud',
                'help' => 'Génère une copie de sauvegarde de l\'espace',
            ]); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->getUser('permission', 'course', 'clone') === true): ?>
        <div class="col2">
            <?php echo template::button('courseManageDuplicate' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/clone/' . $this->getUrl(2),
                'value' => 'Cloner',
                'ico' => 'clone',
                'help' => 'Copie l\'espace et son contenu sans les participants et leurs historiques',
            ]); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->getUser('permission', 'course', 'edit') === true): ?>
        <div class="col2">
            <?php echo template::button('courseManageEdit' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/edit/' . $this->getUrl(2),
                'value' => 'Éditer',
                'ico' => 'pencil',
                'help' => 'Modifie les paramètres de l\'espace',
            ]); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->getUser('permission', 'course', 'export') === true): ?>
        <div class="col2">
            <?php echo template::button('courseManageExport' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/export/' . $this->getUrl(2),
                'value' => 'Exporter HTML',
                'ico' => 'upload',
                'help' => 'Le contenu de l\'espace est exporté dans une page web autonome',
            ]); ?>
        </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Paramètres'); ?>
            </h4>
            <div class="row">
                <div class="col12">
                    <?php echo template::text('courseEditShortTitle', [
                        'label' => 'Titre',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'title'])
                    ]); ?>
                </div>

            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::textarea('courseEditDescription', [
                        'label' => 'Description',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'description'])
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseEditAuthor', course::$courseTeachers, [
                        'label' => 'Auteur',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'author'])
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('courseEditHomePageId', helper::arrayColumn(course::$pagesList, 'title'), [
                        'label' => 'Page d\'accueil',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'homePageId']),
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('courseEditCategorie', course::$courseCategories, [
                        'label' => 'Catégorie',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'category'])
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('courseEditEnrolmentReport', true, 'Statistique des consultations', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'report']),
                        'help' => 'Enregistre une trace des consultations. Ne s\'applique pas à l\'inscription anonyme',
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
                <?php echo helper::translate('Disponibilité'); ?>
            </h4>
            <div class="row">
                <div class="col3">
                    <?php echo template::select('courseEditAccess', course::$courseAccess, [
                        'label' => 'Modalité',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'access'])
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::date('courseOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouvre le',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'openingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'openingDate']) / 60) * 60
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ferme le',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'closingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'closingDate']) / 60) * 60
                    ]); ?>
                </div>
                <div class="col3 verticalAlignBottom">
                    <?php echo template::checkbox('courseEditEnrolmentLimit', true, 'Date limite d\'inscription', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'limitEnrolment']),
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col2">
                    <?php echo template::date('courseEditEnrolmentLimitDate', [
                        'type' => 'datetime-local',
                        'label' => 'Jusqu\'au',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate']) / 60) * 60
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
                <?php echo helper::translate('Inscription'); ?>
            </h4>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseEditEnrolment', course::$courseEnrolment, [
                        'label' => 'Méthode',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'enrolment'])
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('courseEditEnrolmentKey', [
                        'label' => 'Nécessite une clé',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'enrolmentKey'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>