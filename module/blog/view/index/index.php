<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'feeds'])): ?>
	<div id="rssFeed">
		<a type="application/rss+xml" href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/rss'; ?>" target="_blank">
			<img src='module/blog/ressource/feed-icon-16.gif' />
			<?php
			echo $this->getData(['module', $this->getUrl(0), 'config', 'feedsLabel']) ? '<p>' . $this->getData(['module', $this->getUrl(0), 'config', 'feedsLabel']) . '</p>' : '';
			?>
		</a>
	</div>
<?php endif; ?>
<?php if (blog::$articles): ?>
	<article id="article">
		<?php foreach (blog::$articles as $articleId => $article): ?>
			<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'layout']) === true): ?>
				<div class="readMoreModernContainer">
					<div class="row">
						<div class="col12">
							<h2 class="blogTitle">
								<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>">
									<?php echo $article['title']; ?>
								</a>
							</h2>
						</div>
					</div>
					<div class="row">
						<div class="col6 blogEdit">
							<!-- bloc signature -->
							<?php if (
								$this->getData(['module', $this->getUrl(0), 'config', 'showPseudo']) === true
							): ?>
								<?php echo template::ico('user'); ?>
								<?php echo $this->signature($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'userId'])); ?>
							<?php endif; ?>
							<!-- bloc Date -->
							<?php if (
								$this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true
								|| $this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true
							): ?>
								<?php echo template::ico('calendar-empty', ['margin' => 'left']); ?>
							<?php endif; ?>
							<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true): ?>
								<?php echo helper::dateUTF8(blog::$dateFormat, $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'publishedOn']), self::$i18nUI); ?>
							<?php endif; ?>
							<?php if (
								$this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true
								&& $this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true
							): ?>
								<?php echo '&nbsp;-&nbsp;'; ?>
							<?php endif; ?>
							<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true): ?>
								<?php echo helper::dateUTF8(blog::$timeFormat, $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'publishedOn']), self::$i18nUI); ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<?php if (
								$this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picture']) &&
								file_exists(self::FILE_DIR . 'source/' . $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picture']))
							): ?>
								<?php $pictureSize = $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'pictureSize']) === null ? '100' : $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'pictureSize']); ?>
								<?php if ($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'hidePicture']) == false) {
									echo '<img class="blogArticlePicture blogArticlePicture' . $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picturePosition']) .
										' pict' . $pictureSize . '" src="' . helper::baseUrl(false) . self::FILE_DIR . 'source/' . $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picture']) .
										'" alt="' . $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picture']) . '">';
								} ?>
							<?php endif; ?>
							<?php echo $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'content']); ?>
						</div>
					</div>
					<div class="row">
						<div class="col6 blogEdit">
							<!-- Bloc edition -->
							<?php if (
								$this->isConnected() === true
								and
								( // Propriétaire
									($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'editConsent']) === blog::EDIT_OWNER
										and ($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'userId']) === $this->getUser('id')
											or $this->getUser('role') === self::GROUP_ADMIN)
									)
									or (
											// Groupe
										($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'editConsent']) === self::GROUP_ADMIN
											or $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'editConsent']) === self::GROUP_EDITOR)
										and $this->getUser('role') >= $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'editConsent'])
									)
									or (
										// Tout le monde
										$this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'editConsent']) === blog::EDIT_ALL
										and $this->getUser('role') >= blog::$actions['config']
									)
								)
							): ?>
								<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/edit/' . $articleId; ?>">
									<?php echo template::ico('pencil'); ?> Éditer
								</a>
							<?php endif; ?>
						</div>
						<div class="col6 textAlignRight" id="comment">
							<?php if ($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'commentClose'])): ?>
								<p>Cet article ne reçoit pas de commentaire.</p>
							<?php else: ?>
								<p>
									<?php echo template::ico('comment', ['margin' => 'right']); ?>
									<?php
									if (blog::$comments[$articleId] > 0) {
										echo '<a href="' . helper::baseUrl() . $this->getUrl(0) . '/' . $articleId . '">';
										echo blog::$comments[$articleId] . ' commentaire' . (blog::$comments[$articleId] > 1 ? 's' : '');
										echo '</a>';
									} else {
										echo 'Pas encore de commentaire';
									}
									?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="row">
					<?php if (
						$article['picture'] &&
						file_exists(self::FILE_DIR . 'source/' . $article['picture'])
					): ?>
						<div class="col3">
							<?php
							// Déterminer le nom de la miniature
							$parts = pathinfo($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'picture']));
							$thumb = 'mini_' . $parts['basename'];
							// Créer la miniature si manquante
							if (!file_exists(self::FILE_DIR . 'thumb/' . $thumb)) {
								$this->makeThumb(
									self::FILE_DIR . 'source/' . $article['picture'],
									self::FILE_DIR . 'thumb/' . $thumb,
									self::THUMBS_WIDTH
								);
							}
							?>
							<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>" class="blogPicture">
								<img src="<?php echo helper::baseUrl(false) . self::FILE_DIR . 'thumb/' . $thumb; ?>"
									alt="<?php echo $article['picture']; ?>">
							</a>
						</div>
						<div class="col9">
						<?php else: ?>
							<div class="col12">
							<?php endif; ?>
							<h2 class="blogTitle">
								<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>">
									<?php echo $article['title']; ?>
								</a>
							</h2>
							<div class="blogComment">
								<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>#comment">
									<?php if (blog::$comments[$articleId]): ?>
										<?php echo blog::$comments[$articleId]; ?>
										<?php echo template::ico('comment', ['margin' => 'left']); ?>
									<?php endif; ?>
								</a>
							</div>
							<div class="blogDate">
								<!-- bloc signature -->
								<?php if (
									$this->getData(['module', $this->getUrl(0), 'config', 'showPseudo']) === true
								): ?>
									<?php echo template::ico('user'); ?>
									<?php echo $this->signature($this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'userId'])); ?>
								<?php endif; ?> <!-- bloc date -->
								<?php if (
									$this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true
									|| $this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true
								): ?>
									<?php echo template::ico('calendar-empty', ['margin' => 'left']); ?>
								<?php endif; ?>
								<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true): ?>
									<?php echo helper::dateUTF8(blog::$dateFormat, $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'publishedOn']), self::$i18nUI); ?>
								<?php endif; ?>
								<?php if (
									$this->getData(['module', $this->getUrl(0), 'config', 'showDate']) === true
									&& $this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true
								): ?>
									<?php echo '&nbsp;-&nbsp;'; ?>
								<?php endif; ?>
								<?php if ($this->getData(['module', $this->getUrl(0), 'config', 'showTime']) === true): ?>
									<?php echo helper::dateUTF8(blog::$timeFormat, $this->getData(['module', $this->getUrl(0), 'posts', $articleId, 'publishedOn']), self::$i18nUI); ?>
								<?php endif; ?>
								<div class="blogContent">
									<?php $lenght = $this->getData(['module', $this->getUrl(0), 'config', 'articlesLenght']); ?>
									<?php if ($lenght > 0): ?>
										<?php ?>
										<?php echo helper::subword($article['content'], 0, $lenght); ?>...
										<div class="readMoreContainer">
											<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>">
												<button class="readMoreButton">
													<?php echo helper::translate('Lire la suite'); ?>
												</button>
											</a>
										</div>
									<?php else: ?>
										<?php echo $article['content']; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
	</article>
	<?php echo blog::$pages; ?>
<?php else: ?>
	<?php echo template::speech('Aucun article'); ?>
<?php endif; ?>