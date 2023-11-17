<?php echo template::formOpen('registrationAddForm'); ?>
<div class='inputContainer'>
	<?php echo template::text('registrationAddFirstname', [
		'autocomplete' => 'off',
		'label' => 'Prénom'
	]); ?>
	<?php echo template::text('registrationAddLastname', [
		'autocomplete' => 'off',
		'label' => 'Nom'
	]); ?>
	<?php echo template::mail('registrationAddMail', [
		'autocomplete' => 'off',
		'label' => 'Adresse électronique'
	]); ?>
	<?php echo template::text('registrationAddId', [
		'autocomplete' => 'off',
		'label' => 'Identifiant de connexion'
	]); ?>
	<?php echo template::password('registrationAddPassword', [
		'autocomplete' => 'off',
		'label' => 'Mot de passe'
	]); ?>
	<?php echo template::password('registrationAddConfirmPassword', [
		'autocomplete' => 'off',
		'label' => 'Confirmation du mot de passe'
	]);
	?>
</div>
<div class="row">
	<div class="col2 offset10">
		<?php echo template::submit('registrationAddSubmit', [
			'value' => 'Envoyer',
			'class' => 'green'
		]); ?>
	</div>
</div>
<?php echo template::formClose(); ?>