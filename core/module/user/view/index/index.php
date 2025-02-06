<div class="row">
	<div class="col1">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'value' => template::ico('home')
		]); ?>
	</div>
	<div class="col2 offset2">
		<?php echo template::button('userImport', [
			'href' => helper::baseUrl() . 'user/import',
			'ico' => 'users',
			'value' => 'Importer en masse'
		]); ?>
	</div>
	<div class="col2">
	<?php echo template::button('userDeleteAll', [
		'class' => 'userDeleteAll buttonRed',
		'href' => helper::baseUrl() . 'user/usersDelete/' . $this->getUrl(2),
		'ico' => 'users',
		'value' => 'Désinscrire en masse',
	]) ?>
	</div>
	<div class="col2">
		<?php echo template::button('userTag', [
			'href' => helper::baseUrl() . 'user/tag',
			'ico' => 'tags',
			'value' => 'Étiquettes',
			'help' => 'Filtrer les utilisateurs avec des tags'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userGroup', [
			'href' => helper::baseUrl() . 'user/profil',
			'ico' => 'lock',
			'value' => 'Profils',
			'help' => 'Permissions par profils'
		]); ?>
	</div>
	<div class="col1">
		<?php echo template::button('userAdd', [
			'href' => helper::baseUrl() . 'user/add',
			'value' => template::ico('plus'),
			'class' => 'buttonGreen',
			'help' => 'Ajouter un utilisateur'
		]); ?>
	</div>
</div>
<?php echo template::formOpen('userFilterUserForm'); ?>
<div class="row">
	<div class="col3">
		<?php echo template::select('userFilterGroup', user::$usersGroups, [
			'label' => 'Groupes / Profils',
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
<?php echo template::table([3, 2, 2, 1, 3, 1, 1], user::$users, ['Nom', 'Rôle', 'Profil', 'Étiquettes', 'Dernière connexion', '', ''], ['id' => 'dataTables'], ['name','role','profile','tag','data-timestamp','edit','delete']); ?>