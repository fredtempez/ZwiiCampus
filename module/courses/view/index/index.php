<?php foreach ($this->getData(['course']) as $courseId => $courseValue): ?>
    <!-- Layout en colonnes -->
    <div class="col<?php echo $this->getData(['module', $this->getUrl(0), 'config', 'layout']) ?>">

        <!-- Affchage par bloc et bordure -->
        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
            <div class="block">
                <h4>
        <?php endif; ?>

        <!-- Insère le titre ou le titre court dans tous les cas -->
        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'title']) === true): ?>
            <?php echo $courseValue['title'] ?>
        <?php else: ?>
            <?php echo $courseValue['shortTitle'] ?>
        <?php endif; ?>

        <!-- Fin du bloc et bordure titre 4 -->
        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
            </h4>
        <?php endif; ?>

        
        
        <!-- Fin du bloc et bordure -->
        <?php if ($this->getData(['module', $this->getUrl(0), 'config', 'template']) === true): ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>