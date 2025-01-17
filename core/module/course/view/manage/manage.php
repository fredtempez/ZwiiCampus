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
                <div class="col7">
                    <?php echo template::text('courseManageShortTitle', [
                        'label' => 'Titre',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'title']),
                        'readonly' => true,
                    ]); ?>
                </div>
                <div class="col5">
                    <?php echo template::text('courseManageAuthor', [
                        'label' => 'Auteur',
                        'value' => $this->signature($this->getdata(['course', $this->getUrl(2), 'author'])),
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::text('courseManageHomePageId', [
                        'label' => 'Page d\'accueil',
                        'value' => course::$pagesList[$this->getdata(['course', $this->getUrl(2), 'homePageId'])]['shortTitle'],
                        'readonly' => true,
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('courseManageCategorie', [
                        'label' => 'Catégorie',
                        'value' => course::$courseCategories[$this->getdata(['course', $this->getUrl(2), 'category'])],
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::textarea('courseManageDescription', [
                        'label' => 'Description',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'description']),
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('courseManageAccess', [
                        'label' => 'Disponibilité',
                        'value' => course::$courseAccess[$this->getdata(['course', $this->getUrl(2), 'access'])],
                        'readonly' => true,
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouverture',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'openingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'openingDate']) / 60) * 60,
                        'readonly' => true,
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fermeture',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'closingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'closingDate']) / 60) * 60,
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('courseManageEnrolment', [
                        'label' => 'Participation',
                        'value' => course::$courseEnrolment[$this->getdata(['course', $this->getUrl(2), 'enrolment'])],
                        'readonly' => true,
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('courseManageEnrolmentKey', [
                        'label' => 'Clé',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'enrolmentKey']),
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('courseManageEnrolmentReport', true, 'Rapport des consultations', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'report']),
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                        'disabled' => true,
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::checkbox('courseManageEnrolmentLimit', true, 'Date de fin d\'inscription', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'limitEnrolment']),
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                        'disabled' => true,
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseManageEnrolmentLimitDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fin d\'inscription',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate']) / 60) * 60,
                        'readonly' => true,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>