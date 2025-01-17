<?php $startRow = 0; ?>
<?php $c = $this->getData(['course']);?>
<?php $titles = array_column($c, 'title'); ?>
<?php array_multisort($titles, SORT_ASC, $c); ?>
<?php foreach ($c as $courseId => $courseValue): ?>
    <!-- Filtre de catégorie -->
    <?php if (
        $this->getData(['module', $this->getUrl(0), 'config', 'category']) !== 'all' &&
        $courseValue['category'] !== $this->getData(['module', $this->getUrl(0), 'config', 'category'])
    ): ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php if ($startRow === 0): ?>
        <div class="row  workshopRowContainer">
        <?php endif; ?>
        <!-- Layout en colonnes -->
        <div
            class="workshopItemContainer col<?php echo $this->getData(['module', $this->getUrl(0), 'config', 'layout']); ?>">
            <!-- Affchage par bloc et bordure -->
            <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                <div class="block">
                    <h4>
                    <?php else: ?>
                        <p>
                        <?php endif; ?>

                        <!-- Insère le titre court dans tous les cas -->
                        <span class="workshopTitle">
                            <?php echo $courseValue['title']; ?>
                        </span>

                        <!-- Fin du bloc et bordure titre 4 -->
                        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                    </h4>
                <?php else: ?>
                    <p>
                    <?php endif; ?>
                    <!-- Description -->
                    <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'description']) === true): ?>
                    <p>
                        <span class="workshopDescription">
                            <?php echo $courseValue['description']; ?>
                        </span>
                    </p>
                <?php endif; ?>
                <!-- Author -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'author']) === true): ?>
                    <p>
                        <span class="workshopAuthor">
                            <?php echo $this->signature($courseValue['author']); ?>
                        </span>
                    </p>
                <?php endif; ?>
                <!-- Modalité d'ouverture -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'access']) === true): ?>
                    <div class="workshopAccessContainer">
                        <p>
                            <span class="workshopAccess">
                                <?php echo sprintf(helper::translate(workshop::$coursesAccess[$courseValue['access']]), helper::dateUTF8('%d %B %Y', $courseValue['openingDate']) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $courseValue['openingDate']), helper::dateUTF8('%d %B %Y', $courseValue['closingDate']) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $courseValue['closingDate'])) ?>
                            </span>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Modalité d'inscription -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'enrolment']) === true): ?>
                    <p>
                        <span class="workshopEnrolment">
                            <?php echo workshop::$coursesEnrolment[$courseValue['enrolment']]; ?>
                        </span>
                    </p>
                    <?php if ($this->getData(['course', $courseId, 'limitEnrolment']) === true): ?>
                        <p>
                            <span class="workshopEnrolmentLimit">
                                <?php echo $this->getData(['module', $this->getUrl(0), 'caption', 'enrolmentLimit']); ?>
                                <?php echo helper::dateUTF8(' %d %B %Y', $this->getData(['course', $courseId, 'limitEnrolmentDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $courseId, 'limitEnrolmentDate']), self::$i18nUI); ?>
                            </span>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Lien accès au contenu-->
                <div class="row">
                    <div class="col6 workshopLinkContainer">
                        <?php if (
                            $courseValue['access'] === self::COURSE_ACCESS_OPEN
                            ||
                            ($courseValue['access'] === self::COURSE_ACCESS_DATE && time() >= $courseValue['openingDate'] && time() <= $courseValue['closingDate'])
                        ): ?>
                            <span class="workshopSuscribe">
                                <a href="<?php echo helper::baseUrl(); ?>course/swap/<?php echo $courseId; ?>">
                                    <?php echo $this->getData(['module', $this->getUrl(0), 'caption', 'url']); ?>
                                </a>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col6 textAlignRight">
                        <!-- Lien désinscription-->
                        <?php if (
                            $this->getData(['enrolment', $courseId, $this->getUser('id')])
                            && $this->getData(['module', $this->getUrl(0), 'config', 'unsuscribe']) === true
                        ): ?>
                            <span class="workshopUnsuscribe">
                                <a href="<?php echo helper::baseUrl(); ?>course/unsuscribe/<?php echo $courseId; ?>">
                                    <?php echo $this->getData(['module', $this->getUrl(0), 'caption', 'unsuscribe']); ?>
                                </a>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Fin du bloc et bordure -->
                <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
                </div>
            <?php endif; ?>
        </div>
        <?php $startRow = $startRow + $this->getData(['module', $this->getUrl(0), 'config', 'layout']); ?>
        <?php if ($startRow === 12): ?>
        </div>
        <?php $startRow = 0; ?>
    <?php endif; ?>
<?php endforeach; ?>