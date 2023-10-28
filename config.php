<?php if (!defined('APPLICATION')) exit();

// ContentSecurityPolicy

// Context
$Configuration['Context']['Secret'] = 'f8XlGU64gKQTF7c1DshzRXZwvanj8eF2';

// Conversations
$Configuration['Conversations']['Version'] = '3.0';
$Configuration['Conversations']['Subjects']['Visible'] = true;

// Database
$Configuration['Database']['Name'] = 'datacarg_vanil11';
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'datacarg_vanil11';
$Configuration['Database']['Password'] = '(S8p5CT1]0';

// EnabledApplications
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledLocales
$Configuration['EnabledLocales']['vf_fr'] = 'fr';

// EnabledPlugins
$Configuration['EnabledPlugins']['recaptcha'] = false;
$Configuration['EnabledPlugins']['GettingStarted'] = 'GettingStarted';
$Configuration['EnabledPlugins']['stubcontent'] = true;
$Configuration['EnabledPlugins']['swagger-ui'] = true;
$Configuration['EnabledPlugins']['Quotes'] = false;
$Configuration['EnabledPlugins']['rich-editor'] = false;
$Configuration['EnabledPlugins']['editor'] = true;
$Configuration['EnabledPlugins']['AllViewed'] = true;
$Configuration['EnabledPlugins']['Akismet'] = false;
$Configuration['EnabledPlugins']['IndexPhotos'] = true;
$Configuration['EnabledPlugins']['emojiextender'] = true;
$Configuration['EnabledPlugins']['Flagging'] = true;
$Configuration['EnabledPlugins']['Gravatar'] = true;
$Configuration['EnabledPlugins']['VanillaInThisDiscussion'] = true;
$Configuration['EnabledPlugins']['MailboxValidator'] = false;
$Configuration['EnabledPlugins']['ProfileExtender'] = false;
$Configuration['EnabledPlugins']['Signatures'] = true;
$Configuration['EnabledPlugins']['SplitMerge'] = true;
$Configuration['EnabledPlugins']['GooglePrettify'] = false;
$Configuration['EnabledPlugins']['VanillaStats'] = true;
$Configuration['EnabledPlugins']['vanillicon'] = true;
$Configuration['EnabledPlugins']['StopForumSpam'] = true;
$Configuration['EnabledPlugins']['ShareThis'] = false;
$Configuration['EnabledPlugins']['googlesignin'] = false;
$Configuration['EnabledPlugins']['QuoteSelection'] = false;
$Configuration['EnabledPlugins']['WhosOnline'] = true;
$Configuration['EnabledPlugins']['Sitemaps'] = true;
$Configuration['EnabledPlugins']['Spoof'] = true;
$Configuration['EnabledPlugins']['RoleTitle'] = true;
$Configuration['EnabledPlugins']['LastEdited'] = true;
$Configuration['EnabledPlugins']['QnA'] = false;
$Configuration['EnabledPlugins']['pockets'] = true;
$Configuration['EnabledPlugins']['CookieConsent'] = false;
$Configuration['EnabledPlugins']['CookiePop'] = true;
$Configuration['EnabledPlugins']['mailchecker'] = true;
$Configuration['EnabledPlugins']['PostCount'] = true;
$Configuration['EnabledPlugins']['GoogleTagManager'] = false;
$Configuration['EnabledPlugins']['UniversalGoogleAnalytics'] = false;
$Configuration['EnabledPlugins']['Target_Blank'] = true;
$Configuration['EnabledPlugins']['CSSedit'] = false;
$Configuration['EnabledPlugins']['HTMLedit'] = false;
$Configuration['EnabledPlugins']['CreativeCLEditor'] = false;
$Configuration['EnabledPlugins']['hcaptcha'] = true;
$Configuration['EnabledPlugins']['Reactions'] = true;

// Feature
$Configuration['Feature']['UserCards']['Enabled'] = true;
$Configuration['Feature']['DeferredLegacyScripts']['Enabled'] = true;
$Configuration['Feature']['useNewSearchPage']['Enabled'] = true;

// Garden
$Configuration['Garden']['Title'] = 'Zwii le Forum';
$Configuration['Garden']['Cookie']['Salt'] = 'DGBwL8xfRhbBUnGW';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Registration']['ConfirmEmail'] = '1';
$Configuration['Garden']['Registration']['Method'] = 'Basic';
$Configuration['Garden']['Registration']['InviteExpiration'] = '1 week';
$Configuration['Garden']['Registration']['InviteTarget'] = '';
$Configuration['Garden']['Registration']['InviteRoles'][3] = '0';
$Configuration['Garden']['Registration']['InviteRoles'][4] = '0';
$Configuration['Garden']['Registration']['InviteRoles'][8] = '0';
$Configuration['Garden']['Registration']['InviteRoles'][16] = '0';
$Configuration['Garden']['Registration']['InviteRoles'][32] = '0';
$Configuration['Garden']['Email']['SupportName'] = 'Zwii Forum';
$Configuration['Garden']['Email']['Format'] = 'html';
$Configuration['Garden']['Email']['SupportAddress'] = 'contact@forum.zwiicms.fr';
$Configuration['Garden']['Email']['UseSmtp'] = false;
$Configuration['Garden']['Email']['SmtpHost'] = '';
$Configuration['Garden']['Email']['SmtpUser'] = '';
$Configuration['Garden']['Email']['SmtpPassword'] = '';
$Configuration['Garden']['Email']['SmtpPort'] = '25';
$Configuration['Garden']['Email']['SmtpSecurity'] = '';
$Configuration['Garden']['Email']['OmitToName'] = false;
$Configuration['Garden']['SystemUserID'] = '1';
$Configuration['Garden']['UpdateToken'] = 'ce8ac9a1c7778aa9fa48bb3362565fb49127087e';
$Configuration['Garden']['InputFormatter'] = 'Wysiwyg';
$Configuration['Garden']['Version'] = 'Undefined';
$Configuration['Garden']['CanProcessImages'] = true;
$Configuration['Garden']['MobileInputFormatter'] = 'Wysiwyg';
$Configuration['Garden']['Installed'] = true;
$Configuration['Garden']['Locale'] = 'fr_FR';
$Configuration['Garden']['AllowFileUploads'] = true;
$Configuration['Garden']['EditContentTimeout'] = '-1';
$Configuration['Garden']['Format']['DisableUrlEmbeds'] = true;
$Configuration['Garden']['Format']['WarnLeaving'] = false;
$Configuration['Garden']['Theme'] = 'keystone';
$Configuration['Garden']['MobileTheme'] = 'keystone';
$Configuration['Garden']['ThemeOptions']['Styles']['Key'] = 'Default';
$Configuration['Garden']['ThemeOptions']['Styles']['Value'] = '%s_default';
$Configuration['Garden']['ThemeOptions']['Options']['panelToLeft'] = false;
$Configuration['Garden']['ThemeOptions']['Options']['hasHeroBanner'] = false;
$Configuration['Garden']['ThemeOptions']['Options']['hasFeatureSearchbox'] = false;
$Configuration['Garden']['Analytics']['AllowLocal'] = true;
$Configuration['Garden']['HomepageTitle'] = 'Zwii le forum';
$Configuration['Garden']['Description'] = '';
$Configuration['Garden']['FavIcon'] = 'favicon_8d137b65d00e2ff005c0c3327c8f4cc8.ico';
$Configuration['Garden']['TouchIcon'] = '';
$Configuration['Garden']['ShareImage'] = '';
$Configuration['Garden']['MobileAddressBarColor'] = '';
$Configuration['Garden']['EmailTemplate']['Image'] = '';
$Configuration['Garden']['EmailTemplate']['TextColor'] = '#333333';
$Configuration['Garden']['EmailTemplate']['BackgroundColor'] = '#eeeeee';
$Configuration['Garden']['EmailTemplate']['ContainerBackgroundColor'] = '#ffffff';
$Configuration['Garden']['EmailTemplate']['ButtonTextColor'] = '#ffffff';
$Configuration['Garden']['EmailTemplate']['ButtonBackgroundColor'] = '#38abe3';
$Configuration['Garden']['PrivateCommunity'] = false;
$Configuration['Garden']['EmojiSet'] = 'yahoo';
$Configuration['Garden']['Logo'] = 'https://forum.zwiicms.fr/uploads/2FJJRLKC9F5U/5ye97btgwrqdbis.png';
$Configuration['Garden']['MobileLogo'] = 'https://forum.zwiicms.fr/uploads/39HV9AI7K3CZ/5ye97btgwrqdbis.png';
$Configuration['Garden']['Update']['LastUpdate'] = '2021-07-11T12:07:06+00:00';
$Configuration['Garden']['Update']['Status'] = 'success';
$Configuration['Garden']['Themes']['Visible'] = 'keystone';
$Configuration['Garden']['OrgName'] = 'Zwii';
$Configuration['Garden']['BannerImage'] = '';
$Configuration['Garden']['RewriteUrls'] = true;
$Configuration['Garden']['InstallationID'] = 'A500-053872C5-A5DF7E34';
$Configuration['Garden']['InstallationSecret'] = '7c5c0a2005034e8a46565f85ed473f821d0e4b8a';
$Configuration['Garden']['TrustedDomains'] = '';
$Configuration['Garden']['Security']['Hsts']['MaxAge'] = 604800;
$Configuration['Garden']['Security']['Hsts']['IncludeSubDomains'] = false;
$Configuration['Garden']['Security']['Hsts']['Preload'] = false;

// ImageUpload
$Configuration['ImageUpload']['Limits']['Width'] = '1000';
$Configuration['ImageUpload']['Limits']['Height'] = '1400';
$Configuration['ImageUpload']['Limits']['Enabled'] = false;

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['GettingStarted']['Profile'] = '1';
$Configuration['Plugins']['editor']['ForceWysiwyg'] = '1';
$Configuration['Plugins']['Akismet']['UserID'] = 7;
$Configuration['Plugins']['MailboxValidator']['APIKey'] = 'E1AD81HCDUNE8DALXRBO';
$Configuration['Plugins']['MailboxValidator']['ValidEmailOption'] = 'on';
$Configuration['Plugins']['MailboxValidator']['DisposableEmailOption'] = 'on';
$Configuration['Plugins']['MailboxValidator']['FreeEmailOption'] = 'off';
$Configuration['Plugins']['Vanillicon']['Type'] = 'v2';
$Configuration['Plugins']['StopForumSpam']['UserID'] = 8;
$Configuration['Plugins']['StopForumSpam']['IPThreshold1'] = '5';
$Configuration['Plugins']['StopForumSpam']['EmailThreshold1'] = '20';
$Configuration['Plugins']['StopForumSpam']['IPThreshold2'] = '20';
$Configuration['Plugins']['StopForumSpam']['EmailThreshold2'] = '50';
$Configuration['Plugins']['VanillaInThisDiscussion']['Limit'] = '20';

// Preferences
$Configuration['Preferences']['Email']['AnswerAccepted'] = 1;
$Configuration['Preferences']['Email']['QuestionAnswered'] = 1;
$Configuration['Preferences']['Popup']['AnswerAccepted'] = 1;
$Configuration['Preferences']['Popup']['QuestionAnswered'] = 1;

// ProfileExtender
$Configuration['ProfileExtender']['Fields']['Siteperso']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Siteperso']['Label'] = 'Site perso';
$Configuration['ProfileExtender']['Fields']['Siteperso']['Options'] = '';
$Configuration['ProfileExtender']['Fields']['Siteperso']['Required'] = false;
$Configuration['ProfileExtender']['Fields']['Siteperso']['OnRegister'] = '1';
$Configuration['ProfileExtender']['Fields']['Siteperso']['OnProfile'] = '1';
$Configuration['ProfileExtender']['Fields']['Siteperso']['Name'] = 'Siteperso';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['Label'] = 'Hébergeur';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['Options'] = '';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['OnRegister'] = '1';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['OnProfile'] = '1';
$Configuration['ProfileExtender']['Fields']['Hébergeur']['Required'] = false;

// QnA
$Configuration['QnA']['Points']['Enabled'] = '1';
$Configuration['QnA']['Points']['Answer'] = '1';
$Configuration['QnA']['Points']['AcceptedAnswer'] = '1';

// Recaptcha
$Configuration['Recaptcha']['PrivateKey'] = '6Lc2likaAAAAABke-UNrcLEvpyy3YRSD6RhvL99Q';
$Configuration['Recaptcha']['PublicKey'] = '6Lc2likaAAAAAFE1GNy01t-ewqDokf3G9vxsKq8H';

// RecaptchaV3
$Configuration['RecaptchaV3']['PublicKey'] = '';
$Configuration['RecaptchaV3']['PrivateKey'] = '';

// RichEditor
$Configuration['RichEditor']['Quote']['Enable'] = true;

// Routes
$Configuration['Routes']['YXBwbGUtdG91Y2gtaWNvbi5wbmc='] = array (
  0 => 'utility/showtouchicon',
  1 => 'Internal',
);
$Configuration['Routes']['cm9ib3RzLnR4dA=='] = array (
  0 => '/robots',
  1 => 'Internal',
);
$Configuration['Routes']['dXRpbGl0eS9yb2JvdHM='] = array (
  0 => '/robots',
  1 => 'Internal',
);
$Configuration['Routes']['Y29udGFpbmVyLmh0bWw='] = array (
  0 => 'staticcontent/container',
  1 => 'Internal',
);
$Configuration['Routes']['DefaultController'] = array (
  0 => 'categories',
  1 => 'Internal',
);
$Configuration['Routes']['c2l0ZW1hcGluZGV4LnhtbA=='] = array (
  0 => '/utility/sitemapindex.xml',
  1 => 'Internal',
);
$Configuration['Routes']['c2l0ZW1hcC0oLisp'] = array (
  0 => '/utility/sitemap/$1',
  1 => 'Internal',
);

// Signatures
$Configuration['Signatures']['Images']['MaxNumber'] = '2';
$Configuration['Signatures']['Images']['MaxHeight'] = '';
$Configuration['Signatures']['Text']['MaxLength'] = '';
$Configuration['Signatures']['Hide']['Guest'] = '';
$Configuration['Signatures']['Hide']['Embed'] = '1';
$Configuration['Signatures']['Hide']['Mobile'] = '1';
$Configuration['Signatures']['Allow']['Embeds'] = '1';

// Tagging
$Configuration['Tagging']['Discussions']['Enabled'] = true;

// Vanilla
$Configuration['Vanilla']['Version'] = '3.0';
$Configuration['Vanilla']['AdminCheckboxes']['Use'] = '1';
$Configuration['Vanilla']['Categories']['MaxDisplayDepth'] = '3';
$Configuration['Vanilla']['Categories']['Layout'] = 'modern';
$Configuration['Vanilla']['Discussions']['PerPage'] = '30';
$Configuration['Vanilla']['Discussions']['Layout'] = 'modern';
$Configuration['Vanilla']['Comments']['PerPage'] = '30';
$Configuration['Vanilla']['Comment']['MaxLength'] = '8000';
$Configuration['Vanilla']['Comment']['MinLength'] = '';
$Configuration['Vanilla']['Password']['SpamCount'] = 2;
$Configuration['Vanilla']['Password']['SpamTime'] = 1;
$Configuration['Vanilla']['Password']['SpamLock'] = 120;
$Configuration['Vanilla']['EnableCategoryFollowing'] = '1';
$Configuration['Vanilla']['Email']['FullPost'] = false;

// WhosOnline
$Configuration['WhosOnline']['Location']['Show'] = 'every';
$Configuration['WhosOnline']['Hide'] = '1';
$Configuration['WhosOnline']['DisplayStyle'] = 'list';

// hCaptcha
$Configuration['hCaptcha']['SecretKey'] = '0xa9cf7861b6358A7937a8F7883417FE8311D82BC3';
$Configuration['hCaptcha']['SiteKey'] = '2522c956-d445-4e04-8bcb-ed02cb771894';
$Configuration['hCaptcha']['Theme'] = 'light';
$Configuration['hCaptcha']['Size'] = 'normal';

// mailchecker
$Configuration['mailchecker']['LastUpdate'] = '1616081674';

// rating
$Configuration['rating']['Comments']['OrderBy'] = 'Score desc';