<?php
class init extends common
{
	// Données génériques par ddéfaut
	public static $defaultData = [
		'config' => [
			'autoBackup' => true,
			'autoUpdate' => true,
			'autoUpdateDelay' => 86400,
			'autoUpdateHtaccess' => false,
			'favicon' => 'favicon.ico',
			'faviconDark' => 'faviconDark.ico',
			'maintenance' => false,
			'cookieConsent' => true,
			'homePageId' => 'bienvenue',
			'page302' => 'none',
			'page403' => 'none',
			'page404' => 'none',
			'legalPageId' => 'none',
			'searchPageId' => 'none',
			'searchPageLabel' => 'Rechercher',
			'sitemapPageLabel' => 'Sommaire',
			'legalPageLabel' => 'Mentions légales',
			'metaDescription' => 'Zwii est un CMS sans base de données qui permet de créer et gérer facilement un site web sans aucune connaissance en programmation.',
			'title' => 'Votre site en quelques clics !',
			'cookies' => [
				'mainLabel' => 'Ce site utilise des cookies nécessaires à son fonctionnement, ils permettent de fluidifier son fonctionnement par exemple en mémorisant les données de connexion, la langue que vous avez choisie ou la validation de ce message.',
				'titleLabel' => 'Cookies essentiels',
				'linkLegalLabel' => 'Consulter  les mentions légales',
				'cookiesFooterText' => 'Cookies',
				'buttonValidLabel' => 'J\'ai compris'
			],
			'social' => [
				'facebookId' => 'facebook',
				'instagramId' => '',
				'pinterestId' => '',
				'twitterId' => '',
				'youtubeId' => '',
				'youtubeUserId' => '',
				'githubId' => ''
			],
			'timezone' => 'Europe/Paris',
			'proxyUrl' => '',
			'proxyPort' => '',
			'proxyType' => 'tcp://',
			'smtp' => [
				'enable' => false,
				'from' => 'no-reply@localhost'
			],
			'seo' => [
				'robots' => true,
				'openGraphImage' => 'screenshot.png'
			],
			'connect' => [
				'timeout' => 600,
				'attempt' => 3,
				'log' => false,
				'anonymousIp' => 2,
				'captcha' => true,
				'captchaStrong' => false,
				'captchaType' => 'num',
				'autoDisconnect' => true,
				'showPassword' => true,
				'redirectLogin' => true
			]
		],
		'core' => [
			'dataVersion' => 20000,
			'lastBackup' => 0,
			'lastClearTmp' => 0,
			'lastAutoUpdate' => 0,
			'updateAvailable' => false
		],
		'font' => [
			'files' => [],
			'imported' => [
				'arimo' => [
					'name' => 'Arimo',
					'font-family' => 'Arimo,  sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/arimo'
				],
				'arvo' => [
					'name' => 'Arvo',
					'font-family' => 'Arvo,  sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/arvo'
				],
				'dancing-script' => [
					'name' => 'Dancing Script',
					'font-family' => '\'Dancing Script\', sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/dancing-script'
				],
				'droid-sans-2' => [
					'name' => 'Droid Sans',
					'font-family' => '\'Droid Sans\', sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/droid-sans-2'
				],
				'droid-serif-2' => [
					'name' => 'Droid Serif',
					'font-family' => '\'Droid Serif\', serif',
					'resource' => 'https://fonts.cdnfonts.com/css/droid-serif-2'
				],
				'indie-flower' => [
					'name' => 'Indie Flower',
					'font-family' => '\'Indie Flower\', sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/indie-flower'
				],
				'liberation-sans' => [
					'name' => 'Liberation Sans',
					'font-family' => '\'Liberation Sans\', sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/liberation-sans'
				],
				'liberation-serif' => [
					'name' => 'Liberation Serif',
					'font-family' => '\'Liberation Serif\', serif',
					'resource' => 'https://fonts.cdnfonts.com/css/liberation-serif'
				],
				'lobster-2' => [
					'name' => 'Lobster',
					'font-family' => 'Lobster, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/lobster-2'
				],
				'lato' => [
					'name' => 'lato',
					'font-family' => 'Lato, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/lato'
				],
				'lora' => [
					'name' => 'Lora',
					'font-family' => 'Lora, serif',
					'resource' => 'https://fonts.cdnfonts.com/css/lora'
				],
				'old-standard-tt-3' => [
					'name' => 'Old Standard TT',
					'font-family' => '\'Old Standard TT\', serif',
					'resource' => 'https://fonts.cdnfonts.com/css/old-standard-tt-3'
				],
				'open-sans' => [
					'name' => 'Open Sans',
					'font-family' => '\'Open Sans\', sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/open-sans'
				],
				'oswald-4' => [
					'name' => 'Oswald',
					'font-family' => 'Oswald, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/oswald-4'
				],
				'pt-mono' => [
					'name' => 'PT Mono',
					'font-family' => '\'PT Mono\', monospace',
					'resource' => 'https://fonts.cdnfonts.com/css/pt-mono'
				],
				'pt-serif' => [
					'name' => 'PR Serif',
					'font-family' => '\'PT Serif\', serif',
					'resource' => 'https://fonts.cdnfonts.com/css/pt-serif'
				],
				'rancho' => [
					'name' => 'Rancho',
					'font-family' => 'Rancho, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/rancho'
				],
				'roboto' => [
					'name' => 'Roboto',
					'font-family' => 'Roboto, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/roboto'
				],
				'ubuntu' => [
					'name' => 'Ubuntu',
					'font-family' => 'Ubuntu, sans-serif',
					'resource' => 'https://fonts.cdnfonts.com/css/ubuntu'
				],
				'vollkorn' => [
					'name' => 'Vollkorn',
					'font-family' => 'Vollkorn, serif',
					'resource' => 'https://fonts.cdnfonts.com/css/vollkorn'
				]
			]
		],
		'user' => [],
		'admin' => [
			'backgroundColor' => 'rgba(255, 255, 255, 1)',
			'fontText' => 'georgia',
			'fontSize' => '13px',
			'fontTitle' => 'arial',
			'colorText' => 'rgba(33, 34, 35, 1)',
			'colorTitle' => 'rgba(74, 105, 189, 1)',
			'backgroundColorButton' => 'rgba(63, 125, 250, 1)',
			'backgroundColorButtonGrey' => 'rgba(170, 180, 188, 1)',
			'backgroundColorButtonRed' => 'rgba(217, 95, 78, 1)',
			'backgroundColorButtonGreen' => 'rgba(100, 207, 8, 1)',
			'backgroundColorButtonHelp' => 'rgba(255, 153, 0, 1)',
			'backgroundBlockColor' => 'rgba(236, 239, 241, 1)',
			'borderBlockColor' => 'rgba(190, 202, 209, 1)',
			'width' => '960px'
		],
		'blacklist' => [],
		'language' => [
			'fr_FR' => [
				'version' => 1066,
				'date' => 1699354723
			],
		],
		'profil' => [
			'-1' => [
				'name' => 'Banni',
				'readonly' => true,
				'permanent' => true,
				'comment' => 'Accès désactivé',
			],
			'0' => [
				'name' => 'Visiteur',
				'readonly' => true,
				'permanent' => true,
				'comment' => 'Accède au site',
			],
			'1' => [
				'1' => [
					'name' => 'Membre simple',
					'readonly' => false,
					'permanent' => true,
					'comment' => 'Accède aux pages réservées',
					'filemanager' => false,
					'file' => [
						'download' => false,
						'edit' => false,
						'create' => false,
						'rename' => false,
						'upload' => false,
						'delete' => false,
						'preview' => false,
						'duplicate' => false,
						'extract' => false,
						'copycut' => false,
						'chmod' => false
					],
					'course' => [
						'tutor' => false,
						'index' => false,
						'manage' => false,
						'users' => false,
						'userHistory' => false,
						'userReportExport' => false,
						'usersAdd' => false,
						'userDelete' => false,
						'usersDelete' => false,
						'edit' => false,
						'backup' => false,
						'restore' => false,
						'reset' => false,
					],
					'folder' => [
						'create' => false,
						'delete' => false,
						'rename' => false,
						'copycut' => false,
						'chmod' => false,
						'share' => false,
						'coursePath' => 'none',
						'homePath' => 'none'
					],
					'page' => [
						'add' => false,
						'delete' => false,
						'duplicate' => false,
						'edit' => false,
						'jsEditor' => false,
						'cssEditor' => false,
						'module' => false,
					],
					'blog' => [
						'add' => false,
						'delete' => false,
						'edit' => false,
						'option' => false,
						'config' => false,
						'comment' => false,
						'commentApprove' => false,
						'commentDelete' => false,
						'commentDeleteAll' => false,
					],
					'form' => [
						'option' => false,
						'config' => false,
						'data' => false,
						'delete' => false,
						'deleteAll' => false,
						'export2csv' => false,
					],
					'gallery' => [
						'config' => false,
						'delete' => false,
						'edit' => false,
						'add' => false,
						'option' => false,
						'theme' => false,
					],
					'news' => [
						'add' => false,
						'config' => false,
						'option' => false,
						'delete' => false,
						'edit' => false,
					],
					'redirection' => [
						'config' => false,
					],
					'search' => [
						'config' => false,
					],
					'user' => [
						'edit' => true,
					]
				],
				'2' => [
					'name' => 'Membre avec droit de partage',
					'readonly' => false,
					'permanent' => false,
					'comment' => 'Accède aux pages réservées et à un dossier partagé',
					'filemanager' => true,
					'file' => [
						'download' => false,
						'edit' => false,
						'create' => false,
						'rename' => false,
						'upload' => false,
						'delete' => false,
						'preview' => false,
						'duplicate' => false,
						'extract' => false,
						'copycut' => false,
						'chmod' => false
					],
					'course' => [
						'tutor' => false,
						'index' => false,
						'manage' => false,
						'users' => false,
						'userHistory' => false,
						'userReportExport' => false,
						'usersAdd' => false,
						'userDelete' => false,
						'usersDelete' => false,
						'edit' => false,
						'backup' => false,
						'restore' => false,
						'reset' => false,
					],
					'folder' => [
						'create' => false,
						'delete' => false,
						'rename' => false,
						'copycut' => false,
						'chmod' => false,
						'share' => true,
						'coursePath' => 'none',
						'homePath' => '/site/file/source/partage/'
					],
					'page' => [
						'add' => false,
						'delete' => false,
						'duplicate' => false,
						'edit' => false,
						'jsEditor' => false,
						'cssEditor' => false,
						'module' => false,
					],
					'blog' => [
						'add' => false,
						'delete' => false,
						'edit' => false,
						'option' => false,
						'config' => false,
						'comment' => false,
						'commentApprove' => false,
						'commentDelete' => false,
						'commentDeleteAll' => false,
					],
					'form' => [
						'option' => false,
						'config' => false,
						'data' => false,
						'delete' => false,
						'deleteAll' => false,
						'export2csv' => false,
					],
					'gallery' => [
						'config' => false,
						'delete' => false,
						'edit' => false,
						'add' => false,
						'option' => false,
						'theme' => false,
						'dirs' => false,
						'sortGalleries' => false,
						'sortPictures' => false,
					],
					'news' => [
						'add' => false,
						'config' => false,
						'option' => false,
						'delete' => false,
						'edit' => false,
					],
					'redirection' => [
						'config' => false,
					],
					'search' => [
						'config' => false,
					],
					'user' => [
						'edit' => true,
					]
				],
			],
			'2' => [
				'1' => [
					'name' => 'Éditeur simple',
					'readonly' => false,
					'permanent' => true,
					'comment' => 'Édition des pages',
					'filemanager' => true,
					'file' => [
						'download' => true,
						'edit' => true,
						'create' => true,
						'rename' => true,
						'upload' => true,
						'delete' => false,
						'preview' => true,
						'duplicate' => false,
						'extract' => false,
						'copycut' => false,
						'chmod' => false
					],
					'course' => [
						'tutor' => true,
						'index' => true,
						'manage' => true,
						'users' => true,
						'userHistory' => true,
						'userReportExport' => true,
						'usersAdd' => true,
						'userDelete' => false,
						'usersDelete' => false,
						'edit' => false,
						'backup' => false,
						'restore' => false,
						'reset' => false,
					],
					'folder' => [
						'create' => false,
						'delete' => false,
						'rename' => false,
						'copycut' => false,
						'chmod' => false,
						'share' => true,
						'coursePath' => '',
						'homePath' => '/site/file/source/partage/'
					],
					'page' => [
						'add' => false,
						'delete' => false,
						'duplicate' => false,
						'edit' => true,
						'jsEditor' => true,
						'cssEditor' => true,
						'module' => true,
					],
					'blog' => [
						'add' => true,
						'delete' => false,
						'edit' => true,
						'option' => false,
						'config' => false,
						'comment' => false,
						'commentApprove' => false,
						'commentDelete' => false,
						'commentDeleteAll' => false,
					],
					'form' => [
						'option' => false,
						'config' => false,
						'data' => false,
						'delete' => false,
						'deleteAll' => false,
						'export2csv' => false,

					],
					'gallery' => [
						'config' => false,
						'delete' => false,
						'edit' => false,
						'add' => false,
						'option' => false,
						'theme' => false,
					],
					'news' => [
						'add' => true,
						'config' => false,
						'option' => false,
						'delete' => false,
						'edit' => true,
					],
					'redirection' => [
						'config' => false,
					],
					'search' => [
						'config' => false,
					],
					'user' => [
						'edit' => true,
					]
				],
				'2' => [
					'name' => 'Rédacteur',
					'readonly' => false,
					'permanent' => false,
					'comment' => 'Tous les droits d\'édition des espaces',
					'filemanager' => true,
					'file' => [
						'download' => true,
						'edit' => true,
						'create' => true,
						'rename' => true,
						'upload' => true,
						'delete' => true,
						'preview' => true,
						'duplicate' => true,
						'extract' => true,
						'copycut' => true,
						'chmod' => true
					],
					'course' => [
						'tutor' => false,
						'index' => true,
						'manage' => true,
						'users' => true,
						'userHistory' => true,
						'userReportExport' => true,
						'usersAdd' => true,
						'userDelete' => true,
						'usersDelete' => true,
						'edit' => true,
						'backup' => true,
						'restore' => true,
						'reset' => true,
					],
					'folder' => [
						'create' => true,
						'delete' => true,
						'rename' => true,
						'copycut' => true,
						'chmod' => true,
						'share' => true,
						'coursePath' => '',
						'homePath' => '/site/file/source/partage/'
					],
					'page' => [
						'add' => true,
						'delete' => true,
						'duplicate' => true,
						'edit' => true,
						'jsEditor' => true,
						'cssEditor' => true,
						'module' => true,
					],
					'blog' => [
						'add' => true,
						'delete' => true,
						'edit' => true,
						'option' => true,
						'config' => true,
						'comment' => true,
						'commentApprove' => true,
						'commentDelete' => true,
						'commentDeleteAll' => true,
					],
					'form' => [
						'option' => true,
						'config' => true,
						'data' => true,
						'delete' => true,
						'deleteAll' => true,
						'export2csv' => true,
					],
					'gallery' => [
						'config' => true,
						'delete' => true,
						'edit' => true,
						'add' => true,
						'option' => true,
						'theme' => true,
					],
					'news' => [
						'add' => true,
						'config' => true,
						'option' => true,
						'delete' => true,
						'edit' => true,
					],
					'redirection' => [
						'config' => true,
					],
					'search' => [
						'config' => true,
					],
					'user' => [
						'edit' => true,
					]
				],
			],
			'3' => [
				'name' => 'Administrateur',
				'readonly' => true,
				'permanent' => true,
				'comment' => 'Contrôle total',
			]
		],
		'course' => [
			"67c4169fd9427" => [
				"title" => "La photographie numérique",
				"author" => "test",
				"homePageId" => "accueil",
				"category" => "general",
				"description" => "Présentation de la photographie numérique et des matériels de prise de vue.\r\nTemps d'apprentissage : 2 heures.",
				"access" => 0,
				"openingDate" => 1740917973,
				"closingDate" => 1740917973,
				"enrolment" => 0,
				"enrolmentKey" => "",
				"limitEnrolment" => false,
				"limitEnrolmentDate" => 1740904020,
				"report" => true,
				"group" => null
			],
			"67c4173f32319" => [
				"title" => "La retouche avec The Gimp",
				"author" => "test",
				"homePageId" => "accueil",
				"category" => "general",
				"description" => "Les bases de la retouche avec The Gimp.\r\nTemps d'apprentissage : 4 heures.",
				"access" => 0,
				"openingDate" => "",
				"closingDate" => "",
				"enrolment" => 0,
				"enrolmentKey" => "",
				"limitEnrolment" => false,
				"limitEnrolmentDate" => 1740904200,
				"report" => true,
				"group" => null
			]
		],
		'enrolment' => [],
		'category' => [
			'general' => 'Générale'
		],
		"group" => [
			"67c4164e865bf" => "Groupe A",
			"67c41654c493f" => "Groupe B"
		]
	];

	// Données pour home
	public static $siteTemplate = [
		'page' => [
			'contact' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'contact.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'form',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 3,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Contact',
				'shortTitle' => 'Contact',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'mentions-legales' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'mentions-legales.html',
				'hideTitle' => true,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => 'Mentions Légales',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Mentions légales',
				'shortTitle' => 'Mentions légales',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'erreur302' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'erreur302.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => '',
				'parentPageId' => '',
				'position' => 0,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Maintenance en cours',
				'shortTitle' => 'Maintenance en cours',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => true,
				'hideMenuHead' => true,
				'hideMenuChildren' => true,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'erreur403' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'erreur403.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Erreur 403',
				'shortTitle' => 'Erreur 403',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'erreur404' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'erreur404.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'search',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Erreur 404',
				'shortTitle' => 'Erreur 404',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'images-numeriques' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'images-numeriques.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'workshop',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 2,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Images numériques',
				'shortTitle' => 'Images numériques',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'bienvenue' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'bienvenue.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 1,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Bienvenue',
				'shortTitle' => 'Bienvenue',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'les-espaces' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'les-espaces.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => 'bienvenue',
				'position' => 1,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Les espaces',
				'shortTitle' => 'Les espaces',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'participants' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'participants.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => 'bienvenue',
				'position' => 3,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Participants',
				'shortTitle' => 'Participants',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'consultation-des-espaces' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'consultation-des-espaces.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => 'bienvenue',
				'position' => 2,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Consultation des espaces',
				'shortTitle' => 'Consultation des espaces',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'modules' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'modules.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => 'bienvenue',
				'position' => 4,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Modules',
				'shortTitle' => 'Modules',
				'block' => '12',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			]
		],
		'theme' => [
			"body" => [
				"backgroundColor" => "rgba(255, 255, 255, 1)",
				"image" => "",
				"imageAttachment" => "scroll",
				"imagePosition" => "top center",
				"imageRepeat" => "no-repeat",
				"imageSize" => "auto",
				"toTopbackgroundColor" => "rgba(33, 34, 35, .8)",
				"toTopColor" => "rgba(255, 255, 255, 1)"
			],
			"footer" => [
				"backgroundColor" => "rgba(255, 255, 255, 1)",
				"copyrightAlign" => "left",
				"height" => "5px",
				"loginLink" => "1",
				"margin" => true,
				"position" => "body",
				"fixed" => true,
				"socialsAlign" => "center",
				"text" => "<p>ZwiiCampus - L'outil d'apprentissage</p>",
				"textAlign" => "left",
				"textColor" => "rgba(33, 34, 35, 1)",
				"copyrightPosition" => "center",
				"textPosition" => "hide",
				"socialsPosition" => "hide",
				"textTransform" => "none",
				"font" => "georgia",
				"fontSize" => ".8em",
				"fontWeight" => "normal",
				"displayVersion" => true,
				"displaySiteMap" => true,
				"displayCopyright" => true,
				"displayCookie" => false,
				"displayLegal" => false,
				"displaySearch" => false,
				"memberBar" => true,
				"template" => "1"
			],
			"header" => [
				"backgroundColor" => "rgba(32, 59, 82, 1)",
				"font" => "arial",
				"fontSize" => "2em",
				"fontWeight" => "normal",
				"height" => "150px",
				"wide" => "container",
				"image" => "",
				"imagePosition" => "center center",
				"imageRepeat" => "no-repeat",
				"margin" => false,
				"position" => "hide",
				"textAlign" => "center",
				"textColor" => "rgba(255, 255, 255, 1)",
				"textHide" => false,
				"textTransform" => "none",
				"linkHomePage" => true,
				"imageContainer" => "auto auto",
				"tinyHidden" => true,
				"feature" => "wallpaper",
				"featureContent" => "<p>Banni&egrave;re vide</p>",
				"featureFiles" => []
			],
			"menu" => [
				"backgroundColor" => "rgba(5, 174, 180, 1)",
				"backgroundColorSub" => "rgba(4, 158, 163, 1)",
				"font" => "arial",
				"fontSize" => "1em",
				"fontWeight" => "normal",
				"height" => "15px 10px",
				"wide" => "container",
				"loginLink" => false,
				"margin" => false,
				"position" => "site",
				"textAlign" => "left",
				"textColor" => "rgba(255, 255, 255, 1)",
				"textTransform" => "none",
				"fixed" => false,
				"activeColorAuto" => true,
				"activeColor" => "rgba(255, 255, 255, 1)",
				"activeTextColor" => "rgba(255, 255, 255, 1)",
				"radius" => "0px",
				"burgerTitle" => false,
				"memberBar" => true,
				"selectSpace" => true,
				"hidePages" => false,
				"userReport" => false,
				"burgerLogo" => "",
				"burgerContent" => "title"
			],
			"site" => [
				"backgroundColor" => "rgba(255, 255, 255, 1)",
				"radius" => "0px",
				"shadow" => "0px",
				"width" => "960px",
				"margin" => false
			],
			"block" => [
				"backgroundColor" => "rgba(236, 239, 241, 1)",
				"borderColor" => "rgba(236, 239, 241, 1)"
			],
			"text" => [
				"font" => "georgia",
				"fontSize" => "13px",
				"textColor" => "rgba(33, 34, 35, 1)",
				"linkColor" => "rgba(5, 180, 140, 1)"
			],
			"title" => [
				"font" => "arial",
				"textColor" => "rgba(5, 174, 180, 1)",
				"fontWeight" => "normal",
				"textTransform" => "none"
			],
			"button" => [
				"backgroundColor" => "rgba(92, 155, 148, 1)"
			],
			"version" => 0
		],
		'module' => [
			"contact" => [
				"config" => [
					"button" => "",
					"captcha" => true,
					"role" => 3,
					"pageId" => "",
					"subject" => ""
				],
				"data" => [],
				"input" => [
					"0" => [
						"name" => "Adresse électronique",
						"position" => 1,
						"required" => true,
						"type" => "mail",
						"values" => ""
					],
					"1" => [
						"name" => "Sujet",
						"position" => 2,
						"required" => true,
						"type" => "text",
						"values" => ""
					],
					"2" => [
						"name" => "Message",
						"position" => 3,
						"required" => true,
						"type" => "textarea",
						"values" => ""
					]
				]
			],
			"images-numeriques" => [
				"config" => [
					"category" => "general",
					"title" => true,
					"author" => false,
					"description" => true,
					"unsuscribe" => false,
					"access" => true,
					"openingdate" => false,
					"closingdate" => false,
					"enrolment" => true,
					"caption" => "",
					"layout" => 6,
					"template" => true
				],
				"caption" => [
					"accessopen" => "Ouvert",
					"accessdate" => "P&eacute;riode d&#039;ouverture du %s au %s",
					"accessclose" => "Ferm&eacute;",
					"enrolguest" => "Anonyme",
					"enrolself" => "Membres",
					"enrolselfkey" => "Membres avec cl&eacute;",
					"enrolMandatory" => "Inscription par l&#039;enseignant",
					"url" => "Acc&eacute;der au contenu",
					"unsuscribe" => "Me d&eacute;sinscrire",
					"enrolmentLimit" => "Date limite des inscriptions"
				]
			]
		],
		'course' => [],
		'group' => []
	];

	// Contenu des pages pour home
	public static $siteTemplateContent = [
		'contact' => [
			'content' => "<p>Cette page contient un exemple de formulaire con&ccedil;u &agrave; partir du module de g&eacute;n&eacute;ration de formulaires. Il est configur&eacute; pour envoyer les donn&eacute;es saisies par mail aux administrateurs du site.</p>"
		],
		'mentions-legales' => [ 
			'content' => "<h1 style='text-align: center;'>Conditions g&eacute;n&eacute;rales d'utilisation</h1>
					<h1 style='text-align: center;'>En vigueur au 01/06/2020</h1>
					<p><strong>Avertissement</strong>Cette page fictive est donn&eacute;e &agrave; titre indicatif elle a &eacute;t&eacute; r&eacute;alis&eacute;e &agrave; l'aide d'un g&eacute;n&eacute;rateur : <a href='https://www.legalplace.fr' target='_blank' rel='noopener'>https://www.legalplace.fr</a></p>
					<p justify=''>Les pr&eacute;sentes conditions g&eacute;n&eacute;rales d'utilisation (dites &laquo; CGU &raquo;) ont pour objet l'encadrement juridique des modalit&eacute;s de mise &agrave; disposition du site et des services par et de d&eacute;finir les conditions d&rsquo;acc&egrave;s et d&rsquo;utilisation des services par &laquo; l'Utilisateur &raquo;.</p>
					<p justify=''>Les pr&eacute;sentes CGU sont accessibles sur le site &agrave; la rubrique &laquo;CGU&raquo;.</p>
					<p justify=''>Toute inscription ou utilisation du site implique l'acceptation sans aucune r&eacute;serve ni restriction des pr&eacute;sentes CGU par l&rsquo;utilisateur. Lors de l'inscription sur le site via le Formulaire d&rsquo;inscription, chaque utilisateur accepte express&eacute;ment les pr&eacute;sentes CGU en cochant la case pr&eacute;c&eacute;dant le texte suivant : &laquo; Je reconnais avoir lu et compris les CGU et je les accepte &raquo;.</p>
					<p justify=''>En cas de non-acceptation des CGU stipul&eacute;es dans le pr&eacute;sent contrat, l'Utilisateur se doit de renoncer &agrave; l'acc&egrave;s des services propos&eacute;s par le site.</p>
					<p justify=''>www.site.com se r&eacute;serve le droit de modifier unilat&eacute;ralement et &agrave; tout moment le contenu des pr&eacute;sentes CGU.</p>
					<h2>Article 1 : Les mentions l&eacute;gales</h2>
					<p justify=''>L&rsquo;&eacute;dition et la direction de la publication du site www.site.com est assur&eacute;e par John Doe, domicili&eacute; 1 rue de Paris - 75016 PARIS.</p>
					<p justify=''>Num&eacute;ro de t&eacute;l&eacute;phone est 0102030405</p>
					<p justify=''>Adresse e-mail john.doe@zwiicms.fr.</p>
					<p justify=''>L'h&eacute;bergeur du site www.site.com est la soci&eacute;t&eacute; Nom de l'h&eacute;bergeur, dont le si&egrave;ge social est situ&eacute; au 12 rue de Lyon - 69001 Lyon, avec le num&eacute;ro de t&eacute;l&eacute;phone : 0401020305.</p>
					<h2>ARTICLE 2&nbsp;: Acc&egrave;s au site</h2>
					<p justify=''>Le site www.site.com permet &agrave; l'Utilisateur un acc&egrave;s gratuit aux services suivants :</p>
					<p justify=''>Le site internet propose les services suivants :</p>
					<p justify=''>Publication</p>
					<p justify=''>Le site est accessible gratuitement en tout lieu &agrave; tout Utilisateur ayant un acc&egrave;s &agrave; Internet. Tous les frais support&eacute;s par l'Utilisateur pour acc&eacute;der au service (mat&eacute;riel informatique, logiciels, connexion Internet, etc.) sont &agrave; sa charge.</p>
					<p justify=''>L&rsquo;Utilisateur non membre n'a pas acc&egrave;s aux services r&eacute;serv&eacute;s. Pour cela, il doit s&rsquo;inscrire en remplissant le formulaire. En acceptant de s&rsquo;inscrire aux services r&eacute;serv&eacute;s, l&rsquo;Utilisateur membre s&rsquo;engage &agrave; fournir des informations sinc&egrave;res et exactes concernant son &eacute;tat civil et ses coordonn&eacute;es, notamment son Adresse électronique.</p>
					<p justify=''>Pour acc&eacute;der aux services, l&rsquo;Utilisateur doit ensuite s'identifier &agrave; l'aide de son identifiant et de son mot de passe qui lui seront communiqu&eacute;s apr&egrave;s son inscription.</p>
					<p justify=''>Tout Utilisateur membre r&eacute;guli&egrave;rement inscrit pourra &eacute;galement solliciter sa d&eacute;sinscription en se rendant &agrave; la page d&eacute;di&eacute;e sur son espace personnel. Celle-ci sera effective dans un d&eacute;lai raisonnable.</p>
					<p justify=''>Tout &eacute;v&eacute;nement d&ucirc; &agrave; un cas de force majeure ayant pour cons&eacute;quence un dysfonctionnement du site ou serveur et sous r&eacute;serve de toute interruption ou modification en cas de maintenance, n'engage pas la responsabilit&eacute; de www.site.com. Dans ces cas, l&rsquo;Utilisateur accepte ainsi ne pas tenir rigueur &agrave; l&rsquo;&eacute;diteur de toute interruption ou suspension de service, m&ecirc;me sans pr&eacute;avis.</p>
					<p justify=''>L'Utilisateur a la possibilit&eacute; de contacter le site par messagerie &eacute;lectronique &agrave; l&rsquo;Adresse électronique de l&rsquo;&eacute;diteur communiqu&eacute; &agrave; l&rsquo;ARTICLE 1.</p>
					<h2>ARTICLE 3 : Collecte des donn&eacute;es</h2>
					<p justify=''>Le site est exempt&eacute; de d&eacute;claration &agrave; la Commission Nationale Informatique et Libert&eacute;s (CNIL) dans la mesure o&ugrave; il ne collecte aucune donn&eacute;e concernant les Utilisateurs.</p>
					<h2>ARTICLE 4&nbsp;: Propri&eacute;t&eacute; intellectuelle</h2>
					<p>Les marques, logos, signes ainsi que tous les contenus du site (textes, images, son&hellip;) font l'objet d'une protection par le Code de la propri&eacute;t&eacute; intellectuelle et plus particuli&egrave;rement par le droit d'auteur.</p>
					<p>L'Utilisateur doit solliciter l'autorisation pr&eacute;alable du site pour toute reproduction, publication, copie des diff&eacute;rents contenus. Il s'engage &agrave; une utilisation des contenus du site dans un cadre strictement priv&eacute;, toute utilisation &agrave; des fins commerciales et publicitaires est strictement interdite.</p>
					<p>Toute repr&eacute;sentation totale ou partielle de ce site par quelque proc&eacute;d&eacute; que ce soit, sans l&rsquo;autorisation expresse de l&rsquo;exploitant du site Internet constituerait une contrefa&ccedil;on sanctionn&eacute;e par l&rsquo;article L 335-2 et suivants du Code de la propri&eacute;t&eacute; intellectuelle.</p>
					<p>Il est rappel&eacute; conform&eacute;ment &agrave; l&rsquo;article L122-5 du Code de propri&eacute;t&eacute; intellectuelle que l&rsquo;Utilisateur qui reproduit, copie ou publie le contenu prot&eacute;g&eacute; doit citer l&rsquo;auteur et sa source.</p>
					<h2>ARTICLE 5&nbsp;: Responsabilit&eacute;</h2>
					<p justify=''>Les sources des informations diffus&eacute;es sur le site www.site.com sont r&eacute;put&eacute;es fiables mais le site ne garantit pas qu&rsquo;il soit exempt de d&eacute;fauts, d&rsquo;erreurs ou d&rsquo;omissions.</p>
					<p justify=''>Les informations communiqu&eacute;es sont pr&eacute;sent&eacute;es &agrave; titre indicatif et g&eacute;n&eacute;ral sans valeur contractuelle. Malgr&eacute; des mises &agrave; jour r&eacute;guli&egrave;res, le site www.site.com&nbsp;ne peut &ecirc;tre tenu responsable de la modification des dispositions administratives et juridiques survenant apr&egrave;s la publication. De m&ecirc;me, le site ne peut &ecirc;tre tenue responsable de l&rsquo;utilisation et de l&rsquo;interpr&eacute;tation de l&rsquo;information contenue dans ce site.</p>
					<p justify=''>L'Utilisateur s'assure de garder son mot de passe secret. Toute divulgation du mot de passe, quelle que soit sa forme, est interdite. Il assume les risques li&eacute;s &agrave; l'utilisation de son identifiant et mot de passe. Le site d&eacute;cline toute responsabilit&eacute;.</p>
					<p justify=''>Le site www.site.com&nbsp;ne peut &ecirc;tre tenu pour responsable d&rsquo;&eacute;ventuels virus qui pourraient infecter l&rsquo;ordinateur ou tout mat&eacute;riel informatique de l&rsquo;Internaute, suite &agrave; une utilisation, &agrave; l&rsquo;acc&egrave;s, ou au t&eacute;l&eacute;chargement provenant de ce site.</p>
					<p justify=''>La responsabilit&eacute; du site ne peut &ecirc;tre engag&eacute;e en cas de force majeure ou du fait impr&eacute;visible et insurmontable d'un tiers.</p>
					<h2>ARTICLE 6&nbsp;: Liens hypertextes</h2>
					<p justify=''>Des liens hypertextes peuvent &ecirc;tre pr&eacute;sents sur le site. L&rsquo;Utilisateur est inform&eacute; qu&rsquo;en cliquant sur ces liens, il sortira du site www.site.com. Ce dernier n&rsquo;a pas de contr&ocirc;le sur les pages web sur lesquelles aboutissent ces liens et ne saurait, en aucun cas, &ecirc;tre responsable de leur contenu.</p>
					<h2>ARTICLE 7 : Cookies</h2>
					<p justify=''>L&rsquo;Utilisateur est inform&eacute; que lors de ses visites sur le site, un cookie peut s&rsquo;installer automatiquement sur son logiciel de navigation.</p>
					<p justify=''>Les cookies sont de petits fichiers stock&eacute;s temporairement sur le disque dur de l&rsquo;ordinateur de l&rsquo;Utilisateur par votre navigateur et qui sont n&eacute;cessaires &agrave; l&rsquo;utilisation du site www.site.com. Les cookies ne contiennent pas d&rsquo;information personnelle et ne peuvent pas &ecirc;tre utilis&eacute;s pour identifier quelqu&rsquo;un. Un cookie contient un identifiant unique, g&eacute;n&eacute;r&eacute; al&eacute;atoirement et donc anonyme. Certains cookies expirent &agrave; la fin de la visite de l&rsquo;Utilisateur, d&rsquo;autres restent.</p>
					<p justify=''>L&rsquo;information contenue dans les cookies est utilis&eacute;e pour am&eacute;liorer le site www.site.com.</p>
					<p justify=''>En naviguant sur le site, L&rsquo;Utilisateur les accepte.</p>
					<p justify=''>L&rsquo;Utilisateur doit toutefois donner son consentement quant &agrave; l&rsquo;utilisation de certains cookies.</p>
					<p justify=''>A d&eacute;faut d&rsquo;acceptation, l&rsquo;Utilisateur est inform&eacute; que certaines fonctionnalit&eacute;s ou pages risquent de lui &ecirc;tre refus&eacute;es.</p>
					<p justify=''>L&rsquo;Utilisateur pourra d&eacute;sactiver ces cookies par l&rsquo;interm&eacute;diaire des param&egrave;tres figurant au sein de son logiciel de navigation.</p>
					<h2>ARTICLE 8&nbsp;: Droit applicable et juridiction comp&eacute;tente</h2>
					<p justify=''>La l&eacute;gislation fran&ccedil;aise s'applique au pr&eacute;sent contrat. En cas d'absence de r&eacute;solution amiable d'un litige n&eacute; entre les parties, les tribunaux fran&ccedil;aais seront seuls comp&eacute;tents pour en conna&icirc;tre.</p>
					<p justify=''>Pour toute question relative &agrave; l&rsquo;application des pr&eacute;sentes CGU, vous pouvez joindre l&rsquo;&eacute;diteur aux coordonn&eacute;es inscrites &agrave; l&rsquo;ARTICLE 1.</p>"
		],
		'erreur302' => [
			'content' => '<p>Notre site est actuellement en maintenance. Nous sommes désolés pour la gêne occasionnée et faisons notre possible pour être rapidement de retour.</p>
								<div class="row"><div class="col4 offset8 textAlignCenter"><a href="./?user/login" id="maintenanceLogin" name="maintenanceLogin" class="button"><span class="zwiico-lock zwiico-margin-right"></span>Administration</a></div></div>'
		],
		'erreur403' => [
			'content' => '<h2 style="text-align: center;">Vous n\'êtes pas autorisé à accéder à cette page...</h2><p style="text-align: center;">Personnalisez cette page à votre convenance sans qu\'elle apparaisse dans les menus.</p>']
		,
		'erreur404' => [
			'content' => '<h2 style="text-align: center;">Oups ! La page demandée est introuvable...</h2><p style="text-align: center;">Personnalisez cette page à votre convenance sans qu\'elle apparaisse dans les menus.</p>']
		,
		'images-numeriques' => [
			'content' => '<p>Cette page contient un module permettant de lister une cat&eacute;gorie de modules.</p>'
		],
		'bienvenue' => [
			'content' => '<p>L\'installation s\'est déroulée correctement, ZwiiCampus est prêt à être utilisé.</p>
					<p>Avant de commencer, quelques explications sont nécessaires. ZwiiCampus permet de mettre en ligne des contenus en les protégeant comme pourrait le faire un système d\'apprentissage distant (LMS).</p>
					<p>Ces contenus sont stockés dans des <a href="?les-espaces">espaces</a>, comparable à des sites Web.</p>
					<p>ZwiiCampus propose des modules qui permettent de doper vos contenus.</p>'
			
		],
		'consultation-des-espaces' => [
			'content' => "<p>L'enregistrement des actions des participants est r&eacute;serv&eacute; aux espaces n&eacute;cessitant un compte d'acc&egrave;s. Il est stock&eacute; dans un historique, qui peut &ecirc;tre d&eacute;sactiv&eacute; depuis la gestion de l'espace.</p>
<p>Le suivi des participants s'effectue via l'ic&ocirc;ne <strong >Participations</strong> dans la gestion des espaces.</p>
<p>Une table exportable affiche la liste des participants, leur derni&egrave;re page consult&eacute;e et leur pourcentage de progression dans le module, bas&eacute; sur le nombre de pages visit&eacute;es.</p>
<p>En cliquant sur le bouton de progression, un graphique d&eacute;taillant l'historique des consultations des pages s'affiche.</p>"
		],
		'les-espaces' => [
			'content' => "
					<h2 style='text-align: center;'>Espaces d'apprentissage</h2>
					<p>Un <strong>espace</strong> est une zone d'apprentissage que vous pouvez créer en autant d'exemplaires que nécessaire. Ils sont accessibles depuis le sélecteur de la barre d'administration et gérés via <a href='?course' rel='data-lity'>l'icône dédiée</a>. Chaque espace dispose d'un <a href='?theme' rel='data-lity'>thème </a>personnalisable.</p>
					<h2>Caractéristiques des espaces</h2>
					<ul><li><strong>Catégories</strong> : Permettent de regrouper les espaces et de les afficher sur la page d'accueil via le module <strong>Atelier</strong>.</li>
					</ul><h2>Modalités d'ouverture</h2>
					<p>Un espace peut être :</p><ul>
						<li><strong>Ouvert</strong> : Accessible sans restriction.</li>
						<li><strong>Fermé</strong> : Inaccessible aux nouveaux participants.</li>
						<li><strong>Disponible entre deux dates</strong> : Une période d'accès peut être définie, avec une éventuelle date limite d'inscription.</li>
					</ul><h2>Méthodes d'inscription</h2><ul>
						<li><strong>Accès anonyme</strong> : Permet d'entrer sans compte, mais sans historique d'activité enregistré.</li>
						<li><strong>Inscription libre</strong> : Requiert un compte sur la plateforme.</li>
						<li><strong>Inscription avec clé</strong> : Nécessite une clé d'inscription.</li>
						<li><strong>Inscription imposée</strong> : Gérée directement par l'éditeur de l'espace.</li>
					</ul><h2>Restriction de groupe</h2>
					<p>L'accès peut être limité aux participants inscrits dans un groupe spécifique.</p>
					<h4>Gestion des espaces</h4><ul>
						<li><strong>Réinitialisation</strong> : Désinscrit tous les participants et remet l'espace à zéro.</li>
						<li><strong>Sauvegarde et réinstallation</strong> : Assure la sécurité des données et leur récupération.</li>
						<li><strong>Clonage</strong> : Permet de dupliquer un espace ou de générer une page web regroupant l'ensemble de ses contenus.</li>
					</ul><p>📌 L'accueil de <strong>ZwiiCampus</strong> est stocké dans un espace spécifique nommé <strong>'home'</strong>.</p>"
			
		],
		'participants' => [
			'content' => "
					<p>Les participants sont gérés depuis la fenêtre de gestion des utilisateurs.</p>
					<h2>Rôles et profils</h2>
					<p>Quatre rôles de base sont disponibles :</p>
					<ul>
						<li><strong>Visiteur</strong> : Peut parcourir le site sans restriction.</li>
						<li><strong>Étudiant</strong> : Dispose d'un compte et peut accéder à des espaces et pages spécifiques.</li>
						<li><strong>Formateur</strong> : À accès à certaines fonctionnalités d'édition.</li>
						<li><strong>Administrateur</strong> : Gère toutes les fonctionnalités de la plateforme.</li>
					</ul>
					<p>Les rôles <strong>étudiant</strong> et <strong>formateur</strong> peuvent être personnalisés via des <a href='?user/profil' rel='data-lity'>profils</a>, ce qui permet de définir un ensemble de permissions spécifiques, tel que le rôle de <strong>tuteur</strong>.</p>
					<h2>Étiquettes et groupes</h2>
					<ul>
						<li><a href='?user/tag' rel='data-lity'>Étiquettes </a>: Elles sont attribuées aux participants via la gestion des utilisateurs et servent à définir des cohortes, facilitant la sélection dans les tables de gestion.</li>
						<li><a href='?group' rel='data-lity'>Groupes </a>: Gérés séparément, les groupes permettent non seulement de filtrer les participants comme les étiquettes, mais aussi de cibler l'accès aux espaces pour certains groupes. L'attribution de groupes peut également être effectuée en masse via un import à partir d'un export LMS, comme <strong>Moodle</strong>.</li>
					</ul>
					<p>Toutes les tables, tout comme pour les espaces, bénéficient d'une fonctionnalité d'export au format <strong>CSV</strong>, <strong>PDF</strong>, ou permettent une <strong>copie dans le presse-papier</strong>.</p>
					"
			
		],
		'modules' => [
			'content' => "Les modules enrichissent les fonctionnalit&eacute;s des pages. Autonomes, ils peuvent &ecirc;tre d&eacute;velopp&eacute;s pour r&eacute;pondre &agrave; des besoins sp&eacute;cifiques.</p>
				<ul>
					<li>Modules int&eacute;gr&eacute;s &agrave; la version distribu&eacute;e</li>
					<li>Blog : R&eacute;daction d'articles avec commentaires.</li>
					<li>News : Publication d'articles sans commentaires.</li>
					<li>Download : Mise &agrave; disposition de ressources t&eacute;l&eacute;chargeables.</li>
					<li>Form : Cr&eacute;ation de formulaires avec messagerie int&eacute;gr&eacute;e.</li>
					<li>Share : Partage de fichiers et ressources.</li>
					<li>Gallery : Affichage d'une ou plusieurs galeries d'images.</li>
					<li>Slide : Pr&eacute;sentation d'images d&eacute;filantes.</li>
					<li>Redirection : Lien vers un site externe.</li>
					<li>Search : Moteur de recherche textuel int&eacute;gr&eacute;.</li>
					<li>Sondage : Collecte d'avis et de retours d'exp&eacute;rience.</li>
					<li>Subscribe (auto-inscription) : Formulaire d'inscription pour les apprenants.</li>
					<li>Workshop (atelier) : Liste les espaces d'une cat&eacute;gorie donn&eacute;e.</li>
				</ul>"
		]
	];

	// Données pour espace
	public static $courseDefault = [
		'page' => [
			'accueil' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'accueil.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 1,
				'role' => self::ROLE_VISITOR,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Sommaire',
				'shortTitle' => 'Sommaire',
				'block' => '3-9',
				'barLeft' => 'barre',
				'barRight' => '',
				'navLeft' => 'top',
				'navRight' => 'top',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'page1' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'page1.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 1,
				'role' => self::ROLE_VISITOR,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Première page',
				'shortTitle' => 'Première page',
				'block' => '3-9',
				'barLeft' => 'barre',
				'barRight' => '',
				'navLeft' => 'top',
				'navRight' => 'bottom',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'page2' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'page1.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 1,
				'role' => self::ROLE_VISITOR,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Seconde page',
				'shortTitle' => 'Seconde page',
				'block' => '3-9',
				'barLeft' => 'barre',
				'barRight' => '',
				'navLeft' => 'top',
				'navRight' => 'bottom',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'page3' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'page3.html',
				'hideTitle' => false,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 1,
				'role' => self::ROLE_VISITOR,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Troisième page',
				'shortTitle' => 'Troisième page',
				'block' => '3-9',
				'barLeft' => 'barre',
				'barRight' => '',
				'navLeft' => 'top',
				'navRight' => 'bottom',
				'navTemplate' => 'dir',
				'displayMenu' => 'none',
				'hideMenuSide' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''
			],
			'barre' => [
				'typeMenu' => 'text',
				'iconUrl' => '',
				'disable' => false,
				'content' => 'barre.html',
				'hideTitle' => true,
				'breadCrumb' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'role' => 0,
				'profil' => 0,
				'targetBlank' => false,
				'title' => 'Menu',
				'shortTitle' => 'Menu',
				'block' => 'bar',
				'barLeft' => '',
				'barRight' => '',
				'navLeft' => 'none',
				'navRight' => 'none',
				'navTemplate' => 'dir',
				'displayMenu' => 'parents',
				'hideMenuSide' => false,
				'hideMenuHead' => false,
				'hideMenuChildren' => false,
				'extraPosition' => false,
				'css' => '',
				'js' => ''

			],
		],
		'theme' => [
			'body' => [
				'backgroundColor' => 'rgba(236, 239, 241, 1)',
				'image' => '',
				'imageAttachment' => 'scroll',
				'imageRepeat' => 'no-repeat',
				'imagePosition' => 'top center',
				'imageSize' => 'auto',
				'toTopbackgroundColor' => 'rgba(33, 34, 35, .8)',
				'toTopColor' => 'rgba(255, 255, 255, 1)'
			],
			'footer' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'font' => 'georgia',
				'fontSize' => '.8em',
				'fontWeight' => 'normal',
				'height' => '5px',
				'loginLink' => true,
				'margin' => true,
				'position' => 'site',
				'textColor' => 'rgba(33, 34, 35, 1)',
				'copyrightPosition' => 'right',
				'copyrightAlign' => 'right',
				'text' => '<p>Pied de page personnalisé</p>',
				'textPosition' => 'left',
				'textAlign' => 'left',
				'textTransform' => 'none',
				'socialsPosition' => 'center',
				'socialsAlign' => 'center',
				'displayVersion' => true,
				'displaySiteMap' => true,
				'displayCopyright' => false,
				'displayCookie' => false,
				'displayLegal' => false,
				'displaySearch' => false,
				'memberBar' => true,
				'template' => '3'
			],
			'header' => [
				'backgroundColor' => 'rgba(32, 59, 82, 1)',
				'font' => 'arial',
				'fontSize' => '2em',
				'fontWeight' => 'normal',
				'height' => '150px',
				'image' => 'banniere960.jpg',
				'imagePosition' => 'center center',
				'imageRepeat' => 'no-repeat',
				'margin' => false,
				'position' => 'site',
				'textAlign' => 'center',
				'textColor' => 'rgba(255, 255, 255, 1)',
				'textHide' => false,
				'textTransform' => 'none',
				'linkHomePage' => true,
				'imageContainer' => 'auto',
				'tinyHidden' => true,
				'feature' => 'wallpaper',
				'featureContent' => '<p>Bannière vide</p>',
				'width' => 'container'
			],
			'menu' => [
				'backgroundColor' => 'rgba(32, 59, 82, 1)',
				'backgroundColorSub' => 'rgba(32, 59, 82, 1)',
				'font' => 'arial',
				'fontSize' => '1em',
				'fontWeight' => 'normal',
				'height' => '15px 10px',
				'loginLink' => false,
				'margin' => false,
				'position' => 'hide',
				'textAlign' => 'left',
				'textColor' => 'rgba(255, 255, 255, 1)',
				'textTransform' => 'none',
				'fixed' => false,
				'activeColorAuto' => true,
				'activeColor' => 'rgba(255, 255, 255, 1)',
				'activeTextColor' => 'rgba(255, 255, 255, 1)',
				'radius' => '0px',
				'memberBar' => false,
				'burgerLogo' => '',
				'burgerContent' => 'title',
				'width' => 'container'
			],
			'site' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'radius' => '0px',
				'shadow' => '0px 0px 0px',
				'width' => '960px'
			],
			'block' => [
				'backgroundColor' => 'rgba(236, 239, 241, 1)',
				'borderColor' => 'rgba(236, 239, 241, 1)'
			],
			'text' => [
				'font' => 'georgia',
				'fontSize' => '13px',
				'textColor' => 'rgba(33, 34, 35, 1)',
				'linkColor' => 'rgba(74, 105, 189, 1)'
			],
			'title' => [
				'font' => 'arial',
				'fontWeight' => 'normal',
				'textColor' => 'rgba(74, 105, 189, 1)',
				'textTransform' => 'none'
			],
			'button' => [
				'backgroundColor' => 'rgba(32, 59, 82, 1)'
			]
		],
		'module' => [
		],
	];

	// Contenu des pages pour espace
	public static $courseContent = [
		'accueil' => [
			'content' => '<h2>Bienvenue sur votre nouveau contenu !</h2>'
		],
		'page1' => [
			'content' => '<h2>Ceci est la première page.</h2>'
		],
		'page2' => [
			'content' => '<h2>Ceci est la seconde page.</h2>'
		],
		'page3' => [
			'content' => '<h2>Ceci est la troisième page.</h2>'
		],
		'barre' => [
			'content' => ''
		]
	];

}