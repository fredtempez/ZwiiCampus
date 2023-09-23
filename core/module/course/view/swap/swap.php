<?php echo template::formOpen('courseSwapForm'); ?>
<div class="row">
    <div class="col12">
        <?php echo "<h3>Auteur : " . $this->getData(['course', $this->getUrl(2), 'author']) . "</h3>"; ?>
        <?php echo "<p> Description : " . $this->getData(['course', $this->getUrl(2), 'description']) . "</p>"; ?>
        <?php echo "<p> Disponibilité : " . $module::$courseAccess[$this->getData(['course', $this->getUrl(2), 'access'])] . "</p>"; ?>
        <?php echo "<p> Inscription : " . $module::$courseEnrolment[$this->getData(['course', $this->getUrl(2), 'enrolment'])] . "</p>"; ?>
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
    <div class="col3 offset7">
        <?php echo template::submit('courseSwapSubmit', [
            'value' => $module::$swapMessage['submitLabel'],
            'disabled' => !$this->courseIsAvailable($this->getUrl(2)),
            'ico' => ''
        ]); ?>
    </div>
</div>

<?php echo template::formClose(); ?>