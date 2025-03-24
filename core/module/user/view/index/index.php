
<?php echo template::formOpen('userFilterUserForm'); ?>
<div class="row">
	<div class="col1">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col2 offset1">
		<?php echo template::button('userGroup', [
			'href' => helper::baseUrl() . 'group',
			'value' => 'Groupes',
			'ico' => 'users'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userTag', [
			'href' => helper::baseUrl() . 'user/tag',
			'value' => 'Étiquettes',
			'ico' => 'tags'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userGroup', [
			'href' => helper::baseUrl() . 'user/profil',
			'value' =>'Rôle & Profil',
			'ico' => 'lock'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userDeleteAll', [
			'class' => 'userDeleteAll buttonRed',
			'href' => helper::baseUrl() . 'user/usersDelete/' . $this->getUrl(2),
			'value' => 'Désinscription',
			'ico' => 'user-times'
		]) ?>
	</div>
	<div class="col2">
		<?php echo template::button('userImport', [
			'href' => helper::baseUrl() . 'user/import',
			'value' => 'Importation',
			'ico' => 'download',
			'class' => 'buttonGreen',
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col3">
		<?php echo template::select('userFilterGroup', user::$usersRoles, [
			'label' => 'Rôles/ Profils',
			'selected' => isset($_POST['userFilterGroup']) ? $_POST['userFilterGroup'] : 'all',
		]); ?>
	</div>
	<div class="col3">
		<?php echo template::select('userFilterFirstName', user::$alphabet, [
			'label' => 'Prénom commence par',
			'selected' => isset($_POST['userFilterFirstName']) ? $_POST['userFilterFirstName'] : 'all',
		]); ?>
	</div>
	<div class="col3">
		<?php echo template::select('userFilterLastName', user::$alphabet, [
			'label' => 'Nom commence par',
			'selected' => isset($_POST['userFilterLastName']) ? $_POST['userFilterLastName'] : 'all',
		]); ?>
	</div>
	<div class="col1 offset2">
		<?php echo template::button('userAdd', [
			'href' => helper::baseUrl() . 'user/add',
			'value' => template::ico('user-plus'),
			'class' => 'buttonGreen',
			'help' => 'Ajouter un utilisateur'
		]); ?>
	</div>
</div>
<?php echo template::formClose(); ?>
<?php echo template::table([2, 2, 1, 2, 2, 2, 1,], user::$users, ['Nom', 'Courriel', 'Rôle / Profil', 'Groupes', 'Étiquettes', 'Dernière connexion', ''], ['id' => 'dataTables'], ['name', 'mail', 'role', 'profile', 'tag', 'data-timestamp', 'commands']); ?>