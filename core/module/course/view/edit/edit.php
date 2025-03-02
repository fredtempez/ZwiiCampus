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
                <div class="col12">
                    <?php echo template::text('courseEditTitle', [
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
                <div class="col2 periodSetup">
                    <?php var_dump( $this->getdata(['course', $this->getUrl(2), 'openingDate'])) ;echo template::date('courseOpeningDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ouvre le',
                        'value' => !is_int($this->getdata(['course', $this->getUrl(2), 'openingDate'])) ? time() : floor($this->getdata(['course', $this->getUrl(2), 'openingDate']) / 60) * 60
                    ]); ?>
                </div>
                <div class="col2 periodSetup">
                    <?php echo template::date('courseClosingDate', [
                        'type' => 'datetime-local',
                        'label' => 'Ferme le',
                        'value' => !is_int($this->getdata(['course', $this->getUrl(2), 'closingDate'])) ? time() : floor($this->getdata(['course', $this->getUrl(2), 'closingDate']) / 60) * 60
                    ]); ?>
                </div>
                <div class="col3 periodSetup">
                    <?php echo template::checkbox('courseEditEnrolmentLimit', true, 'Date limite d\'inscription', [
                        'checked' => $this->getdata(['course', $this->getUrl(2), 'limitEnrolment']),
                        'help' => 'Ne s\'applique pas à l\'inscription anonyme',
                    ]); ?>
                </div>
                <div class="col2 periodSetup">
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
                        'label' => 'Clé',
                        'value' => $this->getdata(['course', $this->getUrl(2), 'enrolmentKey'])
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
                <?php echo helper::translate('Restriction de groupe'); ?>
            </h4>
            <div class="row">
                <div class="col12">
                    <?php echo template::label('courseManageGroups', 'Accès limité aux groupes cochés :', [
                        'help' => 'Pas de restriction si aucun groupe n\'est cochée, sinon accès limité à un ou aux groupes cochés.',
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <?php foreach (course::$userGroups as $groupId): ?>
                    <div class="col2">
                        <?php echo ($groupId); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>