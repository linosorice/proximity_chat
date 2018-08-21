<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
	
	// Impostazioni Generali
    'app_name' => 'Proximity Chat',
	'footer_text' => '<strong>Proximity Chat</strong> | Prodotto <a href="http://www.hubern.com" target="_blank">Hubern Srls</a> - Partita Iva 13956131000',
	'images_url' => 'images',
	'app_url' => 'http://localhost/html/public/',
	'qrcode_path_name' => 'access',
	'route_redirect_default' => '/',
	'oauth2' => 'https://stagingoauth2.promoincloud.com/oauth/',
	
	// Impostazioni Rocket Chat
	'rocket_chat_url' => 'http://staging.rocketchat.com/api/v1/',
	'rocket_chat_username' => 'admin',
	'rocket_chat_psw' => 'hubernauti',
	'auth_rocket_chat_file' => 'auth_rocket_chat',
	
	// Autorizzazioni accesso alle viste per Ruolo
	// 1 - Admin | 2 - Company
	'auth_routes' => array(
		1 => array('network', 'company_create', 'company_insert', 'company_delete', 'company_edit', 'company_update', 'stores_list', 'store_create', 'store_insert', 'store_delete', 'store_edit', 'store_update', 'account', 'account_create', 'account_insert', 'account_delete', 'account_edit', 'account_update', 'beacon', 'beacon_create', 'beacon_insert', 'beacon_delete', 'beacon_edit', 'beacon_update', 'cities_get', 'account_insert_fast', 'group', 'group_create', 'group_insert', 'group_delete', 'group_edit', 'group_update', 'profile', 'profile_update', 'help', 'help_send'),
		2 => array('group_settings', 'group_settings_update', 'qrcode', 'qrcode_create', 'qrcode_insert', 'qrcode_delete', 'qrcode_access', 'profile', 'profile_update', 'help', 'help_send')
	)
	
];
