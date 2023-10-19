<div class="row">
    <?php foreach ($this->getData(['course']) as $courseId => $courseValue): ?>
        <!-- Layout en colonnes -->
        <div class="col<?php echo $this->getData(['module', $this->getUrl(0), 'config', 'layout']); ?>">

            <!-- Affchage par bloc et bordure -->
            <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                <div class="block">
                    <h4>
                    <?php endif; ?>

                    <!-- Insère le titre ou le titre court dans tous les cas -->
                    <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'title']) === true): ?>
                        <?php echo $courseValue['title']; ?>
                    <?php else: ?>
                        <?php echo $courseValue['shortTitle']; ?>
                    <?php endif; ?>

                    <!-- Fin du bloc et bordure titre 4 -->
                    <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                    </h4>
                <?php endif; ?>
                <!-- Description -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'description']) === true): ?>
                    <p>
                        <?php echo $courseValue['description']; ?>
                    </p>
                <?php endif; ?>
                <!-- Author -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'author']) === true): ?>
                    <p>
                        <?php echo 'AUtuer : ' . $this->signature($courseValue['author']); ?>
                    </p>
                <?php endif; ?>
                <!-- Modalité d'ouverture -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'author']) === true): ?>
                    <p>
                        <?php echo helper::translate('Disponibilité : ') . $module::$coursesAccess[$courseValue['access']]; ?>
                        <!--Les dates d'ouverture et de fermeture -->
                        <?php if ($courseValue['access'] === self::COURSE_ACCESS_DATE): ?>

                            <?php echo sprintf(helper::translate(' du %s au %s'), helper::dateUTF8('%d %B %Y', $courseValue['openingDate']), helper::dateUTF8('%d %B %Y', $courseValue['closingDate'])); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>

                <!-- Modalité d'inscription -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'author']) === true): ?>
                    <p>
                        <?php echo helper::translate('Inscription : ') . $module::$coursesEnrolment[$courseValue['enrolment']]; ?>
                    </p>
                <?php endif; ?>
                <!-- Fin du bloc et bordure -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>