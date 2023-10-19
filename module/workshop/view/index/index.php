<div class="row">
    <?php foreach ($this->getData(['course']) as $courseId => $courseValue): ?>
        <!-- Layout en colonnes -->
        <div class="col<?php echo $this->getData(['module', $this->getUrl(0), 'config', 'layout']); ?>">

            <!-- Affchage par bloc et bordure -->
            <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                <div class="block">
                    <h4>
                    <?php endif; ?>

                    <!-- Insère le titre court dans tous les cas -->
                    <?php echo $courseValue['title']; ?>

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
                        <?php echo sprintf(helper::translate('Auteur : %s'), $this->signature($courseValue['author'])); ?>
                    </p>
                <?php endif; ?>
                <!-- Modalité d'ouverture -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'access']) === true): ?>
                    <p>
                        <?php echo helper::translate('Disponibilité : ') . $module::$coursesAccess[$courseValue['access']]; ?>
                        <!--Les dates d'ouverture et de fermeture -->
                        <?php if ($courseValue['access'] === self::COURSE_ACCESS_DATE): ?>
                            <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'openingdate']) === true): ?>
                            <p>
                                <?php echo sprintf(helper::translate('%s Ouvre le %s'), template::ico('calendar-empty'), helper::dateUTF8('%d %B %Y', $courseValue['openingDate'])); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'closingdate']) === true): ?>
                            <p>
                                <?php echo sprintf(helper::translate('%s Ferme le %s'), template::ico('calendar-empty'), helper::dateUTF8('%d %B %Y', $courseValue['closingDate'])); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                    </p>
                <?php endif; ?>

                <!-- Modalité d'inscription -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'enrolment']) === true): ?>
                    <p>
                        <?php echo  sprintf(helper::translate('Inscription : %s '), $module::$coursesEnrolment[$courseValue['enrolment']]); ?>
                    </p>
                <?php endif; ?>

                <!-- Lien -->
                <?php if (
                    $courseValue['access'] === self::COURSE_ACCESS_OPEN
                    ||
                    ($courseValue['access'] === self::COURSE_ACCESS_DATE && time() >= $courseValue['openingDate'] && time() <= $courseValue['closingDate'])
                ): ?>
                    <a href="<?php echo helper::baseUrl(); ?>course/swap/<?php echo $courseId; ?>">
                        <?php echo $this->getData(['module', $this->getUrl(0), 'config', 'caption']); ?>
                    </a>
                <?php endif; ?>

                <!-- Fin du bloc et bordure -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>