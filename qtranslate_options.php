<?php // encoding: utf-8
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* There is no need to edit anything here! */
define( 'QTX_STRING', 1 );
define( 'QTX_BOOLEAN', 2 );
define( 'QTX_INTEGER', 3 );
define( 'QTX_URL', 4 );
define( 'QTX_LANGUAGE', 5 );
define( 'QTX_ARRAY', 6 );
define( 'QTX_BOOLEAN_SET', 7 );
define( 'QTX_TEXT', 8 );//multi-line string

define( 'QTX_URL_QUERY', 1 );// query: domain.com?lang=en
define( 'QTX_URL_PATH', 2 );// pre path: domain.com/en
define( 'QTX_URL_DOMAIN', 3 );// pre domain: en.domain.com
define( 'QTX_URL_DOMAINS', 4 );// domain per language

define( 'QTX_DATE_WP', 0 );// default
// strftime usage (backward compability)
define( 'QTX_STRFTIME_OVERRIDE', 1 );
define( 'QTX_DATE_OVERRIDE', 2 );
define( 'QTX_DATE', 3 );// old default
define( 'QTX_STRFTIME', 4 );

define( 'QTX_FILTER_OPTIONS_ALL', 0 );
define( 'QTX_FILTER_OPTIONS_LIST', 1 );
define( 'QTX_FILTER_OPTIONS_DEFAULT', 'blogname blogdescription widget_%' );

define( 'QTX_EX_DATE_FORMATS_DEFAULT', '\'U\'' );

define( 'QTX_EDITOR_MODE_LSB', 0 );//Language Switching Buttons
define( 'QTX_EDITOR_MODE_RAW', 1 );
define( 'QTX_EDITOR_MODE_SINGLGE', 2 );

define( 'QTX_HIGHLIGHT_MODE_NONE', 0 );
define( 'QTX_HIGHLIGHT_MODE_BORDER_LEFT', 1 );
define( 'QTX_HIGHLIGHT_MODE_BORDER', 2 );
define( 'QTX_HIGHLIGHT_MODE_LEFT_SHADOW', 3 );
define( 'QTX_HIGHLIGHT_MODE_OUTLINE', 4 );
define( 'QTX_HIGHLIGHT_MODE_CUSTOM_CSS', 9 );

define( 'QTX_COOKIE_NAME_FRONT', 'qtrans_front_language' );
define( 'QTX_COOKIE_NAME_ADMIN', 'qtrans_admin_language' );

define( 'QTX_IGNORE_FILE_TYPES', 'gif,jpg,jpeg,png,svg,pdf,swf,tif,rar,zip,7z,mpg,divx,mpeg,avi,css,js,mp3,mp4,apk' );


global $q_config;
global $qtranslate_options;


/**
 * array of default option values
 * other plugins and themes should not use global variables directly, they are subject to change at any time.
 *
 * @since 3.3
 *
 * @param $ops
 */
function qtranxf_set_default_options( &$ops ) {
	$ops = [];

	//options processed in a standardized way
	$ops['front'] = [];

	$ops['front']['int'] = [
		'url_mode'            => QTX_URL_PATH,// sets default url mode
		'use_strftime'        => QTX_DATE_WP,
		//'use_strftime' => QTX_DATE,// strftime usage (backward compability)
		'filter_options_mode' => QTX_FILTER_OPTIONS_ALL,
		'language_name_case'  => 0 //Camel Case
	];

	$ops['front']['bool'] = [
		'detect_browser_language'          => true,
		// enables browser language detection
		'hide_untranslated'                => false,
		// hide pages without content
		'show_displayed_language_prefix'   => true,
		'show_alternative_content_message' => true,
		'show_alternative_content'         => false,
		'hide_default_language'            => true,
		// hide language tag for default language in urls
		'use_secure_cookie'                => false,
		'header_css_on'                    => true,
		'force_markers'                    => false,
		// always keep language markers, even if the translations are all identical
	];

	//single line options
	$ops['front']['str'] = [];

	//multi-line options
	$ops['front']['text'] = [
		'header_css' => 'qtranxf_front_header_css_default'
	];

	$ops['front']['array'] = [
		//'term_name'// uniquely special treatment
		'text_field_filters' => [],
		'front_config'       => []
	];

	//options processed in a special way

	// store other default values of specially handled options
	$ops['default_value'] = [
		'default_language'       => null,//string
		'enabled_languages'      => null,//array
		'qtrans_compatibility'   => false,//enables compatibility with former qtrans_* functions
		'disable_client_cookies' => false,//bool
		'flag_location'          => null,//string
		'filter_options'         => QTX_FILTER_OPTIONS_DEFAULT,//array
		'ignore_file_types'      => QTX_IGNORE_FILE_TYPES,//array
		'domains'                => null,//array
		'date_i18n'              => null//array
	];

	//must have function 'qtranxf_default_option_name()' which returns a default value for option 'option_name'.
	$ops['languages'] = [
		'language_name' => 'qtranslate_language_names',
		'locale'        => 'qtranslate_locales',
		'locale_html'   => 'qtranslate_locales_html',
		'not_available' => 'qtranslate_na_messages',
		'flag'          => 'qtranslate_flags',
		'date_format'   => 'qtranslate_date_formats',
		'time_format'   => 'qtranslate_time_formats'
		//'windows_locale' => null,//this property is not stored
	];

	/**
	 * A chance to add additional options
	 */
	$ops = apply_filters( 'qtranslate_option_config', $ops );
}

/**
 * Names for languages in the corresponding language, add more if needed
 *
 * @since 3.3
 */
function qtranxf_default_language_name() {
	//Native Name
	$nnm       = [];
	$nnm['ar'] = 'العربية';
	$nnm['ca'] = 'Català';//Nov 6 2015
	$nnm['cy'] = 'Cymraeg';// Oct 22 2015
	$nnm['de'] = 'Deutsch';
	$nnm['el'] = 'Ελληνικά';
	$nnm['en'] = 'English';
	$nnm['es'] = 'Español';
	$nnm['et'] = 'Eesti';
	$nnm['eu'] = 'Euskera';
	$nnm['fi'] = 'suomi';
	$nnm['fr'] = 'Français';
	$nnm['gl'] = 'galego';
	$nnm['hr'] = 'Hrvatski';
	$nnm['hu'] = 'Magyar';
	$nnm['it'] = 'Italiano';
	$nnm['ja'] = '日本語';
	$nnm['lb'] = 'Lëtzebuergesch';
	$nnm['nl'] = 'Nederlands';
	$nnm['pb'] = 'Português do Brasil';
	$nnm['pl'] = 'Polski';
	$nnm['pt'] = 'Português';
	$nnm['ro'] = 'Română';
	$nnm['ru'] = 'Русский';
	$nnm['sk'] = 'Slovenčina';//Nov 12 2015
	$nnm['sr'] = 'Српски';//Nov 19 2015
	$nnm['sv'] = 'Svenska';
	$nnm['tr'] = 'Türkçe';
	$nnm['ua'] = 'Українська';
	$nnm['vi'] = 'Tiếng Việt';
	$nnm['zh'] = '中文';// 简体中文

	return $nnm;
}

/**
 * Locales for languages
 *
 * @since 3.3
 */
function qtranxf_default_locale() {
	// see locale -a for available locales
	$loc       = [];
	$loc['ar'] = 'ar';
	$loc['ca'] = 'ca';
	$loc['cy'] = 'cy';// not 'cy_GB'
	$loc['de'] = 'de_DE';
	$loc['el'] = 'el';//corrected from el_GR on Nov 10 2015 http://qtranslate-x.com/support/index.php?topic=27
	$loc['en'] = 'en_US';
	$loc['es'] = 'es_ES';
	$loc['et'] = 'et';//changed from et_EE on Nov 10 2015 to match WordPress locale
	$loc['eu'] = 'eu';//changed from eu_ES on Nov 10 2015 to match WordPress locale
	$loc['fi'] = 'fi';//changed from fi_FI on Nov 10 2015 to match WordPress locale
	$loc['fr'] = 'fr_FR';
	$loc['gl'] = 'gl_ES';
	$loc['hr'] = 'hr';//changed from hr_HR on Nov 10 2015 to match WordPress locale
	$loc['hu'] = 'hu_HU';
	$loc['it'] = 'it_IT';
	$loc['ja'] = 'ja';
	$loc['lb'] = 'lb_LU';
	$loc['nl'] = 'nl_NL';
	$loc['pb'] = 'pt_BR';
	$loc['pl'] = 'pl_PL';
	$loc['pt'] = 'pt_PT';
	$loc['ro'] = 'ro_RO';
	$loc['ru'] = 'ru_RU';
	$loc['sk'] = 'sk_SK';
	$loc['sr'] = 'sr_RS';
	$loc['sv'] = 'sv_SE';
	$loc['tr'] = 'tr_TR';
	$loc['ua'] = 'uk';
	$loc['vi'] = 'vi';
	$loc['zh'] = 'zh_CN';

	return $loc;
}

/**
 * HTML locales for languages
 *
 * @since 3.4
 */
function qtranxf_default_locale_html() {
	//HTML locales for languages are not provided by default
	$cfg = [];

	return $cfg;
}

/**
 * Language 'not-available' messages
 *
 * @since 3.3
 */
function qtranxf_default_not_available() {
	// %LANG:<normal_separator>:<last_separator>% generates a list of languages separated by <normal_separator> except for the last one, where <last_separator> will be used instead.
	//Not-Available Message
	$nam = [];
	//Sorry, this entry is only available in "%LANG:, :" and "%".
	$nam['ar'] = 'عفوا، هذه المدخلة موجودة فقط في %LANG:, : و %.';
	$nam['ca'] = 'Ho sentim, aquesta entrada es troba disponible únicament en %LANG:, : i %.';
	$nam['cy'] = 'Mae&#8217;n ddrwg gen i, mae\'r cofnod hwn dim ond ar gael mewn %LANG:, : a %.';
	$nam['de'] = 'Leider ist der Eintrag nur auf %LANG:, : und % verfügbar.';
	$nam['el'] = 'Συγγνώμη,αυτή η εγγραφή είναι διαθέσιμη μόνο στα %LANG:, : και %.';
	$nam['en'] = 'Sorry, this entry is only available in %LANG:, : and %.';
	$nam['es'] = 'Disculpa, pero esta entrada está disponible sólo en %LANG:, : y %.';
	$nam['et'] = 'Vabandame, see kanne on saadaval ainult %LANG : ja %.';
	$nam['eu'] = 'Sentitzen dugu, baina sarrera hau %LANG-z:, : eta % bakarrik dago.';
	$nam['fi'] = 'Anteeksi, mutta tämä kirjoitus on saatavana ainoastaan näillä kielillä: %LANG:, : ja %.';
	$nam['fi'] = 'Tämä teksti on valitettavasti saatavilla vain kielillä: %LANG:, : ja %.';//Jyrki Vanamo, Oct 20 2015, 3.4.6.5
	$nam['fr'] = 'Désolé, cet article est seulement disponible en %LANG:, : et %.';
	$nam['gl'] = 'Sentímolo moito, ista entrada atopase unicamente en %LANG;,: e %.';
	$nam['hr'] = 'Žao nam je, ne postoji prijevod na raspolaganju za ovaj proizvod još %LANG:, : i %.';
	$nam['hu'] = 'Sajnos ennek a bejegyzésnek csak %LANG:, : és % nyelvű változata van.';
	$nam['it'] = 'Ci spiace, ma questo articolo è disponibile soltanto in %LANG:, : e %.';
	$nam['ja'] = '申し訳ありません、このコンテンツはただ今　%LANG:、 :と %　のみです。';
	$nam['lb'] = 'Leider ass dëse Bäitrag just op %LANG:, : oder % disponibel.';
	$nam['nl'] = 'Onze verontschuldigingen, dit bericht is alleen beschikbaar in %LANG:, : en %.';
	$nam['pb'] = 'Desculpe-nos, mas este texto está apenas disponível em %LANG:, : y %.';
	$nam['pl'] = 'Przepraszamy, ten wpis jest dostępny tylko w języku %LANG:, : i %.';
	$nam['pt'] = 'Desculpe, este conteúdo só está disponível em %LANG:, : e %.';
	$nam['ro'] = 'Din păcate acest articol este disponibil doar în %LANG:, : și %.';
	$nam['ru'] = 'Извините, этот техт доступен только в &ldquo;%LANG:&rdquo;, &ldquo;:&rdquo; и &ldquo;%&rdquo;.';
	$nam['sk'] = 'Ľutujeme, táto stránka je dostupná len v %LANG:, : a %.';
	$nam['sr'] = 'Извините али унос је доступан једино на %LANG:, : и %.';
	$nam['sv'] = 'Tyvärr är denna artikel enbart tillgänglig på %LANG:, : och %.';
	$nam['tr'] = 'Sorry, this entry is only available in %LANG:, : and %.';
	$nam['ua'] = 'Вибачте цей текст доступний тільки в &ldquo;%LANG:&rdquo;, &ldquo;: і &ldquo;%&rdquo;.';
	$nam['vi'] = 'Rất tiếc, mục này chỉ tồn tại ở %LANG:, : và %.';
	$nam['zh'] = '对不起，此内容只适用于%LANG:，:和%。';

	return $nam;
}

/**
 * Date Configuration
 *
 * @since 3.3
 */
function qtranxf_default_date_format() {
	$dtf       = [];
	$dtf['ar'] = '%d/%m/%Y';
	$dtf['ca'] = 'j F, Y';
	$dtf['cy'] = '%A %B %e, %Y';
	$dtf['de'] = '%A, \d\e\r %e. %B %Y';
	$dtf['el'] = '%d/%m/%y';
	$dtf['en'] = '%A %B %e%q, %Y';// %q ('S' for date) works in English only
	$dtf['es'] = '%d \d\e %B \d\e %Y';
	$dtf['et'] = '%A %B %e, %Y';
	$dtf['eu'] = '%Y %B %e, %A';
	$dtf['fi'] = '%d.%m.%Y';//Jyrki Vanamo, Oct 20 2015, 3.4.6.5
	$dtf['fr'] = '%A %e %B %Y';
	$dtf['gl'] = '%d \d\e %B \d\e %Y';
	$dtf['hr'] = '%d/%m/%Y';
	$dtf['hu'] = '%Y %B %e, %A';
	$dtf['it'] = '%e %B %Y';
	$dtf['ja'] = '%Y年%m月%d日';
	$dtf['lb'] = '%A, \d\e\n %e. %B %Y';
	$dtf['nl'] = '%d/%m/%y';
	$dtf['pb'] = '%d \d\e %B \d\e %Y';
	$dtf['pl'] = '%d/%m/%y';
	$dtf['pt'] = '%A, %e \d\e %B \d\e %Y';
	$dtf['ro'] = '%A, %e %B %Y';
	$dtf['ru'] = '%A %B %e, %Y';
	$dtf['sk'] = 'j.F Y';
	$dtf['sr'] = '%A %B %e, %Y';
	$dtf['sv'] = '%Y-%m-%d';
	$dtf['tr'] = '%A %B %e, %Y';
	$dtf['ua'] = '%A %B %e, %Y';
	$dtf['vi'] = '%d/%m/%Y';
	$dtf['zh'] = '%x %A';

	return $dtf;
}

/**
 * Time Configuration
 *
 * @since 3.3
 */
function qtranxf_default_time_format() {
	$tmf       = [];
	$tmf['ar'] = '%H:%M';
	$tmf['ca'] = 'G:i';
	$tmf['cy'] = '%I:%M %p';//not verified
	$tmf['de'] = '%H:%M';
	$tmf['el'] = '%H:%M';
	$tmf['en'] = '%I:%M %p';
	$tmf['es'] = '%H:%M hrs.';
	$tmf['et'] = '%H:%M';
	$tmf['eu'] = '%H:%M';
	$tmf['fi'] = '%H:%M';
	$tmf['fr'] = '%H:%M';
	$tmf['gl'] = '%H:%M hrs.';
	$tmf['hr'] = '%H:%M';
	$tmf['hu'] = '%H:%M';
	$tmf['it'] = '%H:%M';
	$tmf['ja'] = '%H:%M';
	$tmf['lb'] = '%H:%M';
	$tmf['nl'] = '%H:%M';
	$tmf['pb'] = '%H:%M hrs.';
	$tmf['pl'] = '%H:%M';
	$tmf['pt'] = '%H:%M';
	$tmf['ro'] = '%H:%M';
	$tmf['ru'] = '%H:%M';
	$tmf['sk'] = 'G:i';
	$tmf['sr'] = '%I:%M %p';
	$tmf['sv'] = '%H:%M';
	$tmf['tr'] = '%H:%M';
	$tmf['ua'] = '%H:%M';
	$tmf['vi'] = '%H:%M';
	$tmf['zh'] = '%I:%M%p';

	return $tmf;
}

/**
 * Flag images configuration
 * Look in /flags/ directory for a huge list of flags for usage
 *
 * @since 3.3
 */
function qtranxf_default_flag() {
	$flg       = [];
	$flg['ar'] = 'arle.png';
	$flg['ca'] = 'catala.png';
	$flg['cy'] = 'cy_GB.png';
	$flg['de'] = 'de.png';
	$flg['el'] = 'gr.png';
	$flg['en'] = 'gb.png';
	$flg['es'] = 'es.png';
	$flg['et'] = 'ee.png';
	$flg['eu'] = 'eu_ES.png';
	$flg['fi'] = 'fi.png';
	$flg['fr'] = 'fr.png';
	$flg['gl'] = 'galego.png';
	$flg['hr'] = 'hr.png';
	$flg['hu'] = 'hu.png';
	$flg['it'] = 'it.png';
	$flg['ja'] = 'jp.png';
	$flg['lb'] = 'lu.png';
	$flg['nl'] = 'nl.png';
	$flg['pb'] = 'br.png';
	$flg['pl'] = 'pl.png';
	$flg['pt'] = 'pt.png';
	$flg['ro'] = 'ro.png';
	$flg['ru'] = 'ru.png';
	$flg['sk'] = 'sk.png';
	$flg['sr'] = 'rs.png';
	$flg['sv'] = 'se.png';
	$flg['tr'] = 'tr.png';
	$flg['ua'] = 'ua.png';
	$flg['vi'] = 'vn.png';
	$flg['zh'] = 'cn.png';

	return $flg;
}

/**
 * @param $lang
 *
 * @return bool
 */
function qtranxf_language_predefined( $lang ) {
	$language_names = qtranxf_default_language_name();

	return isset( $language_names[ $lang ] );
}

/**
 * @param $prop
 * @param null $opn
 *
 * @return array|mixed
 */
function qtranxf_language_configured( $prop, $opn = null ) {
	$val = call_user_func( 'qtranxf_default_' . $prop );
	if ( ! $opn ) {
		global $qtranslate_options;
		if ( isset( $qtranslate_options['languages'][ $prop ] ) ) {
			$opn = $qtranslate_options['languages'][ $prop ];
		} else {
			$opn = 'qtranslate_' . $prop;
		}
	}
	$opt = get_option( $opn, [] );
	if ( $opt ) {
		$val = array_merge( $val, $opt );
	}

	return $val;
}

/**
 * Load enabled languages properties from  database
 *
 * @since 3.3
 */
function qtranxf_load_language_props() {
	global $q_config, $qtranslate_options;
	foreach ( $qtranslate_options['languages'] as $nm => $opn ) {
		$f = 'qtranxf_default_' . $nm;
		qtranxf_load_option_func( $nm, $opn, $f );
		$val = [];
		$def = null;
		foreach ( $q_config['enabled_languages'] as $lang ) {
			if ( isset( $q_config[ $nm ][ $lang ] ) ) {
				$val[ $lang ] = $q_config[ $nm ][ $lang ];
			} else {
				if ( is_null( $def ) && function_exists( $f ) ) {
					$def = call_user_func( $f );
				}
				$val[ $lang ] = isset( $def[ $lang ] ) ? $def[ $lang ] : '';
			}
		}
		$q_config[ $nm ] = $val;
	}
	//$locales = qtranxf_default_windows_locale();
	//foreach($q_config['enabled_languages'] as $lang){
	//	$q_config['windows_locale'][$lang] = $locales[$lang];
	//}
}

function qtranxf_load_languages_enabled() {
	global $q_config;
	qtranxf_load_language_props();
	$date_i18n = get_option( 'qtranslate_date_i18n' );
	if ( is_array( $date_i18n ) ) {
		$q_config['date_i18n'] = $date_i18n;
	} else {
		require_once( QTRANSLATE_DIR . '/admin/qtx_admin_options_update.php' );
		qtranxf_set_default_date_i18n( $q_config, $q_config['enabled_languages'] );
		update_option( 'qtranslate_date_i18n', $q_config['date_i18n'] );
	}
}
