<div class="row">
    <div class="col12">
        <div class="block">
            <h4>
                <?php echo sprintf('%s %s', helper::translate('Permissions'), helper::translate('Redirection')); ?>
            </h4>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('profilEditRedirectionConfig', true, 'Configurer le module', [
                        'checked' => $this->getData(['profil', $this->getUrl(2), $this->getUrl(3), 'redirection', 'config'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>