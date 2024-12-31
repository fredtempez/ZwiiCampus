<div class="row">
    <div class="col1">
        <?php echo template::button('courseUserHistoryBack', [
            'class' => 'buttonGrey',
            // Le retour est différent selon que c'est un admin ou un tuteur ou l'utilisateur lui-même
            'href' => $this->getUser('group') === self::GROUP_MEMBER ? helper::baseUrl(false) : helper::baseUrl() . 'course/users/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col1 offset10">
        <?php echo template::button('userReportExportAll', [
            'href' => helper::baseUrl() . 'course/userReportExport/' . $this->getUrl(2) . '/' . $this->getUrl(3),
            'value' => template::ico('download'),
            'help' => 'Exporter rapport',
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col10 offset1">
        <div id="graph">
        </div>
    </div>
</div>
<?php if (course::$userReport): ?>
    <div class="row">
        <div class="col4 offset2">
            <?php if ($this->getData(['course', $this->getUrl(2), 'access']) === self::COURSE_ACCESS_DATE): ?>
                <p>Espace ouvert le :
                    <?php echo helper::dateUTF8('%d %B %Y %H:%M', $this->getData(['course', $this->getUrl(2), 'openingDate'])); ?>
                </p>
                <p>Espace fermé le :
                    <?php echo helper::dateUTF8('%d %B %Y %H:%M', $this->getData(['course', $this->getUrl(2), 'closingDate'])); ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="col4">
            <p>Commencé le :
                <?php echo course::$userStat['floor']; ?>
            </p>
            <p>Terminé le :
                <?php echo course::$userStat['top']; ?>
            </p>
            <p>Temps passé :
                <?php echo course::$userStat['time']; ?>
            </p>
        </div>
    </div>
    <div class="row textAlignCenter">
        <div class="col8">
            <?php echo template::table([6, 3, 3], course::$userReport, ['Page', 'Début de Consultation', 'Temps consultation']); ?>
        </div>
    </div>
<?php else: ?>
    <?php echo template::speech('Aucun historique'); ?>
<?php endif; ?>