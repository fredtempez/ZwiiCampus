<div class="row">
    <div class="col1">
        <?php echo template::button('courseManageBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
            'value' => template::ico('left')
        ]); ?>
    </div>

    <div class="col1 offset7">
        <?php echo template::button('categoryUser' . $this->getUrl(2), [
            'href' => helper::baseUrl() . 'course/users/' . $this->getUrl(2),
            'value' => template::ico('users'),
            'help' => 'Participants'
        ]); ?>
    </div>
    <div class="col1">
        <?php echo
            template::button('courseManageEdit' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/edit/' . $this->getUrl(2),
                'value' => template::ico('pencil'),
                'help' => 'Éditer'
            ]); ?>
    </div>
    <div class="col1">
        <?php echo
            template::button('courseManageDownload' . $this->getUrl(2), [
                'href' => helper::baseUrl() . 'course/backup/' . $this->getUrl(2),
                'value' => template::ico('download-cloud'),
                'help' => 'Sauvegarder'
            ]); ?>
    </div>
        <div class="col1 ">
        <?php echo
            template::button('courseManageDelete' . $this->getUrl(2), [
                'class' => 'courseDelete buttonRed',
                'href' => helper::baseUrl() . 'course/delete/' . $this->getUrl(2),
                'value' => template::ico('trash'),
                'help' => 'Supprimer'
            ]); ?>
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
                        <?php echo template::select('courseManageAuthor', $module::$courseTeachers, [
                            'label' => 'Auteur',
                            'value' => $this->getdata(['course', $this->getUrl(2), 'author']),
                            'disabled' => true,
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col6">
                        <?php echo template::select('courseManageHomePageId', helper::arrayColumn($module::$pagesList, 'title', 'SORT_ASC'), [
                            'label' => 'Page d\'accueil',
                            'selected' => $this->getdata(['course', $this->getUrl(2), 'homePageId']),
                            'disabled' => true,
                        ]); ?>
                    </div>
                    <div class="col6">
                        <?php echo template::select('courseManageCategorie', $module::$courseCategories, [
                            'label' => 'Catégorie',
                            'selected' => $this->getdata(['course', $this->getUrl(2), 'category']),
                            'disabled' => true,
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
                        <?php echo template::select('courseManageAccess', $module::$courseAccess, [
                            'label' => 'Disponibilité',
                            'selected' => $this->getdata(['course', $this->getUrl(2), 'access']),
                            'disabled' => true,
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
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col4">
                        <div class="col4">
                            <?php echo template::select('courseManageEnrolment', $module::$courseEnrolment, [
                                'label' => 'Participation',
                                'selected' => $this->getdata(['course', $this->getUrl(2), 'enrolment']),
                                'disabled' => true,
                            ]); ?>
                        </div>
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
                        <?php echo template::checkbox('courseManageEnrolmentLimit', true, 'Date de fin d\'inscription', [
                            'checked' => $this->getdata(['course', $this->getUrl(2), 'limitEnrolment']),
                            'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                            'disabled' => true,
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::date('courseManageEnrolmentLimitDate', [
                            'type' => 'datetime-local',
                            'label' => 'Fermeture',
                            'value' => is_null($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate']) / 60) * 60,
                            'readonly' => true,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>