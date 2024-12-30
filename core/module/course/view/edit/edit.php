<?php echo template::formOpen('courseEditForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseEditBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course/manage/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('courseEditSubmit'); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo helper::translate('Paramètres'); ?>
            </h4>
            <div class="row">
                <div class="col7">
                    <?php echo template::text('courseEditShortTitle', [
                        'label' => 'Titre',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'title'])
                    ]); ?>
                </div>
                <div class="col5">
                    <?php echo template::select('courseEditAuthor', course::$courseTeachers, [
                        'label' => 'Auteur',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'author'])
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('courseEditHomePageId', helper::arrayColumn(course::$pagesList, 'title'), [
                        'label' => 'Page d\'accueil',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'homePageId']),
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('courseEditCategorie', course::$courseCategories, [
                        'label' => 'Catégorie',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'category'])
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
                    <?php echo template::select('courseEditAccess', course::$courseAccess, [
                        'label' => 'Disponibilité',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'access'])
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouverture',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'openingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'openingDate']) / 60) * 60
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fermeture',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'closingDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'closingDate']) / 60) * 60
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('courseEditEnrolment', course::$courseEnrolment, [
                        'label' => 'Participation',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'enrolment'])
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('courseEditEnrolmentKey', [
                        'label' => 'Clé',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'enrolmentKey'])
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('courseEditEnrolmentReport', true, 'Rapport des consultations', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'report']),
                        'help' => 'Enregistre une trace des consultations. Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::checkbox('courseEditEnrolmentLimit', true, 'Date de fin d\'inscription', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'limitEnrolment']),
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::date('courseEditEnrolmentLimitDate', [
                        'type' => 'datetime-local',
                        'label' => 'Fin d\'inscription',
                        'value' => is_null($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate'])) ? '' : floor($this->getdata(['course', $this->getUrl(2), 'limitEnrolmentDate']) / 60) * 60
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>