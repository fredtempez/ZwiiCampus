<div id="localeContainer" class="tabContent">
    <div class="row">
        <div class="col12">
            <div class="block">
                <h4>
                    <?php echo helper::translate('Identité du site'); ?>
                    <!--<span id="localeHelpButton" class="helpDisplayButton" title="Cliquer pour consulter l'aide en ligne">
                    <a href="https://doc.zwiicms.fr/localisation-et-identite" target="_blank">
                        <?php //echo template::ico('help', ['margin' => 'left']); ?>
                    </a>
                </span>-->
                </h4>
                <div class="row">
                    <div class="col12">
                        <?php echo template::text('configLocaleTitle', [
                            'label' => 'Titre',
                            'value' => $this->getData(['config', 'title']),
                            'help' => 'Il apparaît dans la barre de titre et les partages sur les réseaux sociaux.'
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col12">
                        <?php echo template::textarea('configLocaleMetaDescription', [
                            'label' => 'Description',
                            'value' => $this->getData(['config', 'metaDescription']),
                            'help' => 'La description d\'une page participe à son référencement, chaque page doit disposer d\'une description différente.'
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
                    <?php echo helper::translate('Assignation des pages spéciales') ?>
                    <!--<span id="localeHelpButton" class="helpDisplayButton" title="Cliquer pour consulter l'aide en ligne">
                    <a href="https://doc.zwiicms.fr/localisation-et-identite" target="_blank">
                        <?php //echo template::ico('help', ['margin' => 'left']); ?>
                    </a>
                </span>-->
                </h4>
                <div class="row">
                    <div class="col4">
                        <?php echo template::select('configLocaleHomePageId', helper::arrayColumn($module::$pagesList, 'title', 'SORT_ASC'), [
                            'label' => 'Accueil',
                            'selected' => $this->getData(['config', 'homePageId']),
                            'help' => 'La première page que vos visiteurs verront.'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('configLocalePage403', array_merge(['none' => 'Page par défaut'], helper::arrayColumn($module::$orphansList, 'title', 'SORT_ASC')), [
                            'label' => 'Accès interdit, erreur 403',
                            'selected' => $this->getData(['config', 'page403']),
                            'help' => 'Cette page ne doit pas apparaître dans l\'arborescence du menu. Créez une page orpheline.'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('configLocalePage404', array_merge(['none' => 'Page par défaut'], helper::arrayColumn($module::$orphansList, 'title', 'SORT_ASC')), [
                            'label' => 'Page inexistante, erreur 404',
                            'selected' => $this->getData(['config', 'page404']),
                            'help' => 'Cette page ne doit pas apparaître dans l\'arborescence du menu. Créez une page orpheline.'
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col4">
                        <?php echo template::select('configLocaleLegalPageId', array_merge(['none' => 'Aucune'], helper::arrayColumn($module::$pagesList, 'title', 'SORT_ASC')), [
                            'label' => 'Mentions légales',
                            'selected' => $this->getData(['config', 'legalPageId']),
                            'help' => 'Les mentions légales sont obligatoires en France. Une option du pied de page ajoute un lien discret vers cette page.'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('configLocaleSearchPageId', array_merge(['none' => 'Aucune'], helper::arrayColumn($module::$pagesList, 'title', 'SORT_ASC')), [
                            'label' => 'Recherche dans le site',
                            'selected' => $this->getData(['config', 'searchPageId']),
                            'help' => 'Sélectionnez une page contenant le module \'Recherche\'. Une option du pied de page ajoute un lien discret vers cette page.'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php
                        echo template::select('configLocalePage302', array_merge(['none' => 'Page par défaut'], helper::arrayColumn($module::$orphansList, 'title', 'SORT_ASC')), [
                            'label' => 'Site en maintenance',
                            'selected' => $this->getData(['config', 'page302']),
                            'help' => 'Cette page ne doit pas apparaître dans l\'arborescence du menu. Créez une page orpheline.'
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
                    <?php echo helper::translate('Étiquettes des pages spéciales'); ?>
                    <!--<span id="labelHelpButton" class="helpDisplayButton" title="Cliquer pour consulter l'aide en ligne">
                    <a href="https://doc.zwiicms.fr/etiquettes-des-pages-speciales" target="_blank">
                        <?php //echo template::ico('help', ['margin' => 'left']); ?>
                    </a>
                </span>-->
                </h4>
                <div class="row">
                    <div class="col4">
                        <?php echo template::text('configLocalePoweredPageLabel', [
                            'label' => 'Motorisé par',
                            'placeholder' => 'Motorisé par',
                            'value' => $this->getData(['config', 'poweredPageLabel']),
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleLegalPageLabel', [
                            'label' => 'Mentions légales',
                            'placeholder' => 'Mentions légales',
                            'value' => $this->getData(['config', 'legalPageLabel']),
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleSearchPageLabel', [
                            'label' => 'Rechercher',
                            'placeholder' => 'Rechercher',
                            'value' => $this->getData(['config', 'searchPageLabel']),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col4 offset2">
                        <?php echo template::text('configLocaleSitemapPageLabel', [
                            'label' => 'Plan du site',
                            'placeholder' => 'Plan du site',
                            'value' => $this->getData(['config', 'sitemapPageLabel']),
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleCookiesFooterText', [
                            'label' => 'Cookies',
                            'value' => $this->getData(['config', 'cookiesFooterText']),
                            'placeHolder' => 'Cookies'
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
                    <?php echo helper::translate('Message d\'acceptation des Cookies'); ?>
                    <!--<span id="specialeHelpButton" class="helpDisplayButton" title="Cliquer pour consulter l'aide en ligne">
                    <a href="https://doc.zwiicms.fr/cookies" target="_blank">
                        <?php //echo template::ico('help', ['margin' => 'left']); ?>
                    </a>
                </span>-->
                </h4>
                <div class="row">
                    <div class="col4">
                        <?php echo template::text('configLocaleCookiesTitleText', [
                            'label' => 'Titre',
                            'value' => $this->getData(['config', 'cookies', 'cookiesFooterText']),
                            'placeHolder' => 'Cookies essentiels'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleCookiesButtonText', [
                            'label' => 'Bouton de validation',
                            'value' => $this->getData(['config', 'cookies', 'buttonValidLabel']),
                            'placeHolder' => 'J\'ai compris'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleCookiesFooterText', [
                            'label' => 'Texte dans le pied de page',
                            'value' => $this->getData(['config', 'cookies', 'cookiesFooterText']),
                            'placeHolder' => 'Cookies'
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col8">
                        <?php echo template::textarea('configLocaleCookiesZwiiText', [
                            'help' => 'Saisissez le message pour les cookies déposés par ZwiiCMS, nécessaires au fonctionnement et qui ne nécessitent pas de consentement.',
                            'label' => 'Cookies Zwii',
                            'value' => $this->getData(['config', 'cookies', 'mainLabel']),
                            'placeHolder' => 'Ce site utilise des cookies nécessaires à son fonctionnement, ils permettent de fluidifier son fonctionnement par exemple en mémorisant les données de connexion, la langue que vous avez choisie ou la validation de ce message.'
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('configLocaleCookiesLinkMlText', [
                            'help' => 'Saisissez le texte du lien vers les mentions légales,la page doit être définie dans la configuration du site.',
                            'label' => 'Lien page des mentions légales.',
                            'value' => $this->getData(['config',  'cookies', 'linkLegalLabel']),
                            'placeHolder' => 'Consulter  les mentions légales'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>