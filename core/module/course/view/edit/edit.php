<?php echo template::formOpen('courseEditForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('courseEditBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'course',
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
                    <?php echo template::select('courseEditAuthor', $module::$courseTeachers, [
                        'label' => 'Auteur',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'author'])
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('courseEditHomePageId', helper::arrayColumn($module::$pagesList, 'title', 'SORT_ASC'), [
                        'label' => 'Accueil du contenu',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'homePageId']),
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('courseEditCategorie', $module::$courseCategories, [
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
                    <?php echo template::select('courseEditAccess', $module::$courseAccess, [
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
                <div class="col6">
                    <?php echo template::select('courseEditEnrolment', $module::$courseEnrolment, [
                        'label' => 'Inscription',
                        'selected' => $this->getdata(['course', $this->getUrl(2), 'enrolment'])
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('courseEditEnrolmentKey', [
                        'label' => 'Clé',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'enrolmentKey'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo template::formClose(); ?>