<?php echo template::formOpen('userEditForm'); ?>
<div class="row">
	<div class="col1">
		<?php if ($this->getUser('role') === self::ROLE_ADMIN): ?>
			<?php echo template::button('userEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'user',
				'value' => template::ico('left')
			]); ?>
		<?php else: ?>
			<?php echo template::button('userEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl(false),
				'value' => template::ico('home')
			]); ?>
		<?php endif; ?>
	</div>
	<div class="col2 offset9">
		<?php echo template::submit('userEditSubmit'); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<h4>
				<?php echo helper::translate('Identité'); ?>
			</h4>
			<div class="row">
				<div class="col4">
					<?php echo template::text('userEditFirstname', [
						'autocomplete' => 'off',
						'disabled' => $this->getUser('role') > self::ROLE_EDITOR ? false : true,
						'label' => 'Prénom',
						'value' => $this->getData(['user', $this->getUrl(2), 'firstname'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::text('userEditLastname', [
						'autocomplete' => 'off',
						'disabled' => $this->getUser('role') > self::ROLE_EDITOR ? false : true,
						'label' => 'Nom',
						'value' => $this->getData(['user', $this->getUrl(2), 'lastname'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::mail('userEditMail', [
						'autocomplete' => 'off',
						'label' => 'Adresse électronique',
						'value' => $this->getData(['user', $this->getUrl(2), 'mail'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col4">
					<?php echo template::text('userEditPseudo', [
						'autocomplete' => 'off',
						'label' => 'Pseudo',
						'value' => $this->getData(['user', $this->getUrl(2), 'pseudo'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::select('userEditSignature', user::$signature, [
						'label' => 'Signature',
						'selected' => $this->getData(['user', $this->getUrl(2), 'signature'])
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::select('userEditLanguage', user::$languagesInstalled, [
						'label' => 'Langue',
						'selected' => $this->getData(['user', $this->getUrl(2), 'language'])
					]); ?>
				</div>
			</div>
			<div class="row">
				<div class="col12">
					<?php echo template::text('userEditTags', [
						'label' => 'Étiquettes',
						'readonly' => $this->getUser('role') > self::ROLE_EDITOR ? false : true,
						'value' => $this->getData(['user', $this->getUrl(2), 'tags']),
						'help' => 'Les étiquettes sont séparées par des espaces'
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Authentification'); ?>
			</h4>
			<?php echo template::text('userEditId', [
				'autocomplete' => 'off',
				'help' => 'L\'identifiant est défini lors de la création du compte, il ne peut pas être modifié.',
				'label' => 'Identifiant',
				'readonly' => true,
				'value' => $this->getUrl(2)
			]); ?>
			<?php
			// Les admins ont le pouvoir de forcer le changement de mot de passe
			if ($this->getUser('role') < self::ROLE_ADMIN): ?>
				<?php echo template::password('userEditOldPassword', [
					'autocomplete' => 'new-password',
					// remplace 'off' pour éviter le pré remplissage auto
					'label' => 'Ancien mot de passe',
				]); ?>
			<?php endif; ?>
			<?php echo template::password('userEditNewPassword', [
				'autocomplete' => 'off',
				'label' => 'Nouveau mot de passe'
			]); ?>
			<?php echo template::password('userEditConfirmPassword', [
				'autocomplete' => 'off',
				'label' => 'Confirmation'
			]); ?>
		</div>
	</div>
	<div class="col6">
		<div class="block">
			<h4>
				<?php echo helper::translate('Permissions'); ?>
			</h4>
			<div class="row">
				<div class="col12">
					<?php if ($this->getUser('role') === self::ROLE_ADMIN): ?>
						<?php echo template::select('userEditGroup', self::$roleEdits, [
							'disabled' => ($this->getUrl(2) === $this->getUser('id')),
							'help' => ($this->getUrl(2) === $this->getUser('id') ? 'Impossible de modifier votre propre rôle.' : ''),
							'label' => 'Rôle',
							'selected' => $this->getData(['user', $this->getUrl(2), 'role']),
						]); ?>
					<?php else: ?>
						<?php echo template::hidden('userEditGroup', [
							'value' => $this->getData(['user', $this->getUrl(2), 'role'])
						]); ?>
					<?php endif; ?>
				</div>
				<div class="col12">
					<div class="userEditGroupProfil" id="userEditGroupProfil<?php echo self::ROLE_MEMBER; ?>">
						<?php echo template::select('userEditProfil' . self::ROLE_MEMBER, user::$userProfils[self::ROLE_MEMBER], [
							'label' => 'Profil',
							'selected' => $this->getData(['user', $this->getUrl(2), 'profil']),
							'disabled' => $this->getUser('role') !== self::ROLE_ADMIN,
						]); ?>
					</div>
					<div class="userEditGroupProfil" id="userEditGroupProfil<?php echo self::ROLE_EDITOR; ?>">
						<?php echo template::select('userEditProfil' . self::ROLE_EDITOR, user::$userProfils[self::ROLE_EDITOR], [
							'label' => 'Profil',
							'selected' => $this->getData(['user', $this->getUrl(2), 'profil']),
							'disabled' => $this->getUser('role') !== self::ROLE_ADMIN,
						]); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="userCommentProfil<?php echo self::ROLE_MEMBER; ?>" class="col12  userCommentProfil">
					<?php echo template::textarea('userEditProfilComment' . self::ROLE_MEMBER, [
						'label' => 'Commentaire',
						'value' => implode("\n", user::$userProfilsComments[self::ROLE_MEMBER]),
						'disabled' => true,

					]);
					?>
				</div>
				<div id="userCommentProfil<?php echo self::ROLE_EDITOR; ?>" class="col12  userCommentProfil">
					<?php echo template::textarea('userEditProfilComment' . self::ROLE_EDITOR, [
						'label' => 'Commentaire',
						'value' => implode("\n", user::$userProfilsComments[self::ROLE_EDITOR]),
						'disabled' => true,

					]);
					?>
				</div>
				<div id="userCommentProfil<?php echo self::ROLE_ADMIN; ?>" class="col12  userCommentProfil">
					<?php echo template::textarea('userEditProfilComment' . self::ROLE_ADMIN, [
						'label' => 'Commentaire',
						'value' => implode("\n", user::$userProfilsComments[self::ROLE_ADMIN]),
						'disabled' => true,
					]);
					?>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="block">
	<h4>
		<?php echo helper::translate('Groupes'); ?>
	</h4>
	<div class="row">
		<?php foreach (user::$userGroups as $groupId):?>
			<div class="col2">
			<?php echo ($groupId); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
</div <?php echo template::formClose(); ?>