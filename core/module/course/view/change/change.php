<?php echo template::formOpen('courseChangeForm'); ?>
<div class="row">
    <div class="col12">
        <?php echo "<h3>Auteur : " . $this->getData(['course', $this->getUrl(2), 'author' ]) . "</h3>"; ?>
        <?php echo "<p> Description : " . $this->getData(['course', $this->getUrl(2), 'description' ]) . "</p>"; ?>
        <?php echo "<p> Disponibilité : " . $module::$courseAccess[$this->getData(['course', $this->getUrl(2), 'access' ])] . "</p>";?>
        <?php echo "<p> Inscription : " . $module::$courseEnrolment[$this->getData(['course', $this->getUrl(2), 'enrolment' ])]. "</p>";?>
    
    </div>
</div>
<div class="row">
    <div class="col2">
        <?php echo template::button('courseChangeBack', [
            'href' => helper::baseUrl(),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col3 offset7">
        <?php echo template::submit('courseChangeSubmit', [
            'value' => 'Se connecter',
            'disabled' => !$this->courseIsAvailable($this->getUrl(2)),
            'ico' => ''
        ]); ?>
    </div>
</div>

<?php echo template::formClose(); ?>