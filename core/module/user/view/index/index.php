<div class="row">
	<div class="col1">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col1 offset6">
		<?php echo template::button('userTag', [
			'href' => helper::baseUrl() . 'user/tag',
			'value' => template::ico('tags'),
			'help' => 'Ajouter des étiquettes'
		]); ?>
	</div>
	<div class="col1">
		<?php echo template::button('userGroup', [
			'href' => helper::baseUrl() . 'user/profil',
			'value' => template::ico('lock'),
			'help' => 'Permissions par profils'
		]); ?>
	</div>
	<div class="col1">
		<?php echo template::button('userDeleteAll', [
			'class' => 'userDeleteAll buttonRed',
			'href' => helper::baseUrl() . 'user/usersDelete/' . $this->getUrl(2),
			'value' => template::ico('user-times'),
			'help' => 'Désinscrire en masse',
		]) ?>
	</div>
	<div class="col1">
		<?php echo template::button('userImport', [
			'href' => helper::baseUrl() . 'user/import',
			'value' => template::ico('download'),
			'class' => 'buttonGreen',
			'help' => 'Importer en masse'
		]); ?>
	</div>
	<div class="col1">
		<?php echo template::button('userAdd', [
			'href' => helper::baseUrl() . 'user/add',
			'value' => template::ico('user-plus'),
			'class' => 'buttonGreen',
			'help' => 'Ajouter un utilisateur'
		]); ?>
	</div>
</div>
<?php echo template::formOpen('userFilterUserForm'); ?>
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
</div>
<?php echo template::formClose(); ?>
<?php echo template::table([2, 2, 1, 2, 2, 2, 1,], user::$users, ['Nom', 'Courriel', 'Rôle / Profil', 'Groupes', 'Étiquettes', 'Dernière connexion', ''], ['id' => 'dataTables'], ['name', 'mail', 'role', 'profile', 'tag', 'data-timestamp', 'commands']); ?>