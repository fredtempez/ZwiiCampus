<?php echo template::formOpen('userAddForm'); ?>
<div class="row">
	<div class="col1">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'user',
			'value' => template::ico('left')
		]); ?>
	</div>
	<div class="col2 offset9">
		<?php echo template::submit('userAddSubmit'); ?>
	</div>
</div>
<div class="row">
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Identité'); ?>
			</h4>
			<div class="row">
				<div class="col6">
					<?php echo template::text('userAddFirstname', [
						'autocomplete' => 'off',
						'label' => 'Prénom'
					]); ?>
				</div>
				<div class="col6">
					<?php echo template::text('userAddLastname', [
						'autocomplete' => 'off',
						'label' => 'Nom'
					]); ?>
				</div>
			</div>

			<div class="row">
				<div class="col6">
					<?php echo template::text('userAddPseudo', [
						'autocomplete' => 'off',
						'label' => 'Pseudo'
					]); ?>
				</div>
				<div class="col6">
					<?php echo template::select('userAddSignature', $module::$signature, [
						'label' => 'Signature',
						'selected' => 1
					]); ?>
				</div>
			</div>
			<?php echo template::mail('userAddMail', [
				'autocomplete' => 'off',
				'label' => 'Adresse électronique'
			]); ?>
			<?php echo template::select('userAddLanguage', $module::$languagesInstalled, [
				'label' => 'Langues'
			]); ?>
		</div>
	</div>
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Authentification'); ?>
			</h4>
			<?php echo template::text('userAddId', [
				'autocomplete' => 'off',
				'label' => 'Identifiant'
			]); ?>
			<?php echo template::password('userAddPassword', [
				'autocomplete' => 'off',
				'label' => 'Mot de passe'
			]); ?>
			<?php echo template::password('userAddConfirmPassword', [
				'autocomplete' => 'off',
				'label' => 'Confirmation'
			]); ?>
			<?php echo template::checkbox(
				'userAddSendMail',
				true,
				'Prévenir l\'utilisateur par mail'
			);
			?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Permissions'); ?>
			</h4>
			<div class="row">
				<div class="col6">
					<?php echo template::select('userAddGroup', self::$groupNews, [
						'label' => 'Groupe',
						'selected' => self::GROUP_STUDENT
					]); ?>
				</div>
				<div class="col6">
					<div class="userAddGroupProfil displayNone"
						id="userAddGroupProfil<?php echo self::GROUP_STUDENT; ?>">
						<?php echo template::select('userAddProfil' . self::GROUP_STUDENT, $module::$userProfils[self::GROUP_STUDENT], [
							'label' => 'Profil',
						]); ?>
					</div>
					<div class="userAddGroupProfil displayNone"
						id="userAddGroupProfil<?php echo self::GROUP_TEACHER; ?>">
						<?php echo template::select('userAddProfil' . self::GROUP_TEACHER, $module::$userProfils[self::GROUP_TEACHER], [
							'label' => 'Profil',
						]); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="userCommentProfil<?php echo self::GROUP_STUDENT; ?>" class="col12 displayNone userCommentProfil">
					<?php echo template::textarea('useraddProfilComment' . self::GROUP_STUDENT, [
						"value" => implode("\n",$module::$userProfilsComments[self::GROUP_STUDENT])
					]);
					?>
				</div>
				<div id="userCommentProfil<?php echo self::GROUP_TEACHER; ?>" class="col12 displayNone userCommentProfil">
					<?php echo template::textarea('useraddProfilComment2' . self::GROUP_TEACHER, [
						"value" => implode("\n",$module::$userProfilsComments[self::GROUP_TEACHER])
					]);
					?>
				</div>
				<div id="userCommentProfil<?php echo self::GROUP_ADMIN; ?>" class="col12 displayNone userCommentProfil">
					<?php echo template::textarea('useraddProfilComment' . self::GROUP_ADMIN, [
						"value" => implode("\n",$module::$userProfilsComments[self::GROUP_ADMIN])
					]);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>