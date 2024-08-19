<?php echo template::formOpen('configForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('configBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl(false),
            'value' => template::ico('home')
        ]); ?>
    </div>
    <div class="col1">
        <?php /**echo template::button('configHelp', [
 'class' => 'buttonHelp',
 'href' => 'https://doc.zwiicms.fr/configuration-du-site',
 'target' => '_blank',
 'value' => template::ico('help'),
 'help' => 'Consulter l\'aide en ligne'
]); */?>
    </div>
    <div class="col2 offset8">
        <?php echo template::submit('Submit'); ?>
    </div>
</div>

<div class="tab">
    <?php echo template::button('configLocaleButton', [
        'value' => 'Identité - Étiquettes',
        'class' => 'buttonTab'
    ]); ?>
    <?php echo template::button('configSetupButton', [
        'value' => 'Configuration - Outils',
        'class' => 'buttonTab'
    ]); ?>
    <?php echo template::button('configSocialButton', [
        'value' => 'Réseaux sociaux',
        'class' => 'buttonTab'
    ]); ?>

    <?php echo template::button('configConnectButton', [
        'value' => 'Sécurité',
        'class' => 'buttonTab'
    ]); ?>

    <?php echo template::button('configNetworkButton', [
        'value' => 'Réseau',
        'class' => 'buttonTab'
    ]); ?>

</div>
<?php include('core/module/config/view/locale/locale.php') ?>
<?php include('core/module/config/view/setup/setup.php') ?>
<?php include('core/module/config/view/social/social.php') ?>
<?php include('core/module/config/view/connect/connect.php') ?>
<?php include('core/module/config/view/network/network.php') ?>
<?php echo template::formClose(); ?>