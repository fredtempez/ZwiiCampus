<?php echo template::formOpen('groupUsersAddForm'); ?>
<div class="row">
    <div class="col1">
        <?php echo template::button('groupUserAddBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'group/users/' . $this->getUrl(2),
            'value' => template::ico('left')
        ]); ?>
    </div>
    <div class="col2 offset9">
        <?php echo template::submit('groupUsersAddSubmit', [
            'value' => 'Inscrire',
            'ico' => 'plus',
        ]); ?>
    </div>
</div>
<?php if (group::$groupUsers): ?>
    <?php echo template::table([5, 4, 1], group::$groupUsers, ['Nom', 'Prénom', ''], ['id' => 'dataTables']); ?>
<?php else: ?>
    <?php echo template::speech('Aucun inscrit'); ?>
<?php endif; ?>
<?php echo template::formClose(); ?>