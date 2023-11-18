<?php echo template::formOpen('courseSwapForm'); ?>
<div class="row">
    <div class="col12">
        <?php echo "<h3>Auteur : " . $this->signature($this->getData(['course', $this->getUrl(2), 'author'])) . "</h3>"; ?>
        <?php echo "<p>Description : " . $this->getData(['course', $this->getUrl(2), 'description']) . "</p>"; ?>
         <!--Restriction de date limite d'ouverture-->
        <?php echo "<p>Disponibilité : " . $module::$courseAccess[$this->getData(['course', $this->getUrl(2), 'access'])]; ?>
        <?php if ($this->getData(['course', $this->getUrl(2), 'access']) === $module::COURSE_ACCESS_DATE): ?>
            <?php $from = helper::dateUTF8('%d %B %Y', $this->getData(['course', $this->getUrl(2), 'openingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $this->getUrl(2), 'openingDate']), self::$i18nUI); ?>
            <?php $to = helper::dateUTF8('%d %B %Y', $this->getData(['course', $this->getUrl(2), 'closingDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $this->getUrl(2), 'closingDate']), self::$i18nUI); ?>
            <?php echo sprintf(helper::translate(' du %s au %s'), $from, $to); ?>
        <?php endif; ?>
        <?php echo '</p>'; ?>
        <?php echo "<p>Inscription : " . $module::$courseEnrolment[$this->getData(['course', $this->getUrl(2), 'enrolment'])] . '.'; ?>
                <!--Restriction de date limite d'insription-->
                <?php if ($this->getData(['course', $this->getUrl(2), 'limitEnrolment']) === true && $this->getData(['course', $this->getUrl(2), 'limitEnrolmentDate']) <= time()):?>
            <?php echo  helper::translate(' Les inscriptions sont closes depuis le ') ?>
            <?php echo helper::dateUTF8('%d %B %Y', $this->getData(['course', $this->getUrl(2), 'limitEnrolmentDate']), self::$i18nUI) . helper::translate(' à ') . helper::dateUTF8('%H:%M', $this->getData(['course', $this->getUrl(2), 'limitEnrolmentDate']), self::$i18nUI); ?>
        <?php endif; ?>
        <?php echo '</p>'; ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <?php if ($module::$swapMessage['enrolmentKey']) {
            echo $module::$swapMessage['enrolmentKey'];
        }
        ?>
        <?php if ($module::$swapMessage['enrolmentMessage']) {
            echo $module::$swapMessage['enrolmentMessage'];
        }
        ?>
    </div>

</div>
<div class="row">
    <div class="col2">
        <?php echo template::button('courseSwapBack', [
            'href' => helper::baseUrl(),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <?php if ($module::$swapMessage['submitLabel'] === 'Connexion'): ?>
        <div class="col2 offset8">
            <?php echo template::button('courseConnect', [
                'href' => helper::baseUrl(true) . 'user/login',
                'value' => template::ico('login'),
                'help' => 'Connexion',
            ]); ?>
        </div>
    <?php else: ?>
        <div class="col3 offset7">
            <?php echo template::submit('courseSwapSubmit', [
                'value' => $module::$swapMessage['submitLabel'],
                'disabled' => !($module->courseIsAvailable($this->getUrl(2))
                    && !($this->getData(['course', $this->getUrl(2), 'limitEnrolment']) === true
                        && $this->getData(['course', $this->getUrl(2), 'limitEnrolmentDate']) <= time())
                ),
            ]); ?>
        </div>
    <?php endif; ?>
</div>
<?php echo template::formClose(); ?>