<?
/*
	This file can be used to convert xml files from http://unicode.org/Public/cldr/latest to the .po format.
*/
header( 'Content-type: text/plain; charset=utf-8' );
$dir    = 'core/common/main';
$po_dir = 'language-translations';

# Get all needed files
$files = glob( $dir . '/*.xml' );
foreach ( $files as $file ) {
	preg_match( "/(?:^|[\/])(([^_\/]+)[_]?([^_\/]*?)[_]?([^_\/]*))[.]xml$/", $file, $matches );
	$languages[ $matches[1] ] = [
		'file' => $file,
		'lang' => $matches[2]
	];
}
unset( $files );


# Parse all translation files from unicode consortium
$langs = [];
foreach ( $languages as $lang_code => $language ) {
	$xml   = file_get_contents( $language['file'] );
	$infos = [];
	preg_replace_callback( "/[<](identity|languages)[>](.+)[<][\/]\\1[>]/siu", function ( $matches ) use ( &$infos ) {
		$infos[ $matches[1] ] = $matches[2];

		return '';
	}, $xml );

	preg_replace_callback( "/[<](.+)\s+type[=][\"](([^\"]+)(?:[_]([^\"]+))?)[\"][^\<>]*[>]([^<>]+)/iu", function ( $matches ) use ( &$languages, &$lang_code ) {
		$languages[ $lang_code ][ $matches[1] ] = $matches[2];

		return '';
	}, $infos['identity'] );

	preg_replace_callback( "/[<]language\s+type[=][\"](([^\"]+)(?:[_]([^\"]+))?)[\"](?:\s+alt[=][\"]([^\"]+)[\"])?[^\<>]*[>]([^<>]+)/iu", function ( $matches ) use ( &$languages, &$lang_code ) {
		if ( ! isset( $languages[ $lang_code ]['translations'][ $matches[1] ] ) ) {
			$languages[ $lang_code ]['translations'][ $matches[1] ] = $matches[5];
		} else {
			$languages[ $lang_code ]['translation_alernatives'][ $matches[1] ][] = [ 'type' => $matches[4], 'translation' => $matches[5] ];
		}

		return '';
	}, $infos['languages'] );
}

# WP locales according to https://make.wordpress.org/polyglots/teams/   + en_US + en
# 'Locale','WP Locale','Version','GlotPress',''
$wp_langs = [
	[ 'English', 'en', 'None', '100 ', 'en' ],
	[ 'English (USA)', 'en_US', 'None', '100 ', 'en' ],
	[ 'Afrikaans', 'af', 'None', '33 ', 'af' ],
	[ 'Akan', 'ak', 'No site', '', 'ak' ],
	[ 'Albanian', 'sq', '4.3.1', '100', 'sq' ],
	[ 'Algerian Arabic', 'arq', 'None', '13', 'arq' ],
	[ 'Amharic', 'am', 'None', '8', 'am' ],
	[ 'Arabic', 'ar', '4.3.1', '100', 'ar' ],
	[ 'Armenian', 'hy', '4.3.1', '100', 'hy' ],
	[ 'Aromanian', 'rup_MK', 'No site', '', 'rup' ],
	[ 'Arpitan', 'frp', 'None', '1', 'frp' ],
	[ 'Assamese', 'as', 'None', '38', 'as' ],
	[ 'Azerbaijani', 'az', '4.3.1', '100', 'az' ],
	[ 'Azerbaijani (Turkey)', 'az_TR', 'None', '0', 'az-tr' ],
	[ 'Balochi Southern', 'bcc', 'None', '2', 'bcc' ],
	[ 'Bashkir', 'ba', 'No site', '', 'ba' ],
	[ 'Basque', 'eu', '4.3.1', '100', 'eu' ],
	[ 'Belarusian', 'bel', 'None', '52', 'bel' ],
	[ 'Bengali', 'bn_BD', '4.3.1', '100', 'bn' ],
	[ 'Bosnian', 'bs_BA', '4.3.1', '100', 'bs' ],
	[ 'Breton', 'bre', 'None', '0', 'br' ],
	[ 'Bulgarian', 'bg_BG', '4.3.1', '100', 'bg' ],
	[ 'Catalan', 'ca', '4.3', '100', 'ca' ],
	[ 'Catalan (Balear)', 'bal', 'No site', '0', 'bal' ],
	[ 'Chinese (China)', 'zh_CN', '4.3.1', '100', 'zh-cn' ],
	[ 'Chinese (Hong Kong)', 'zh_HK', 'None', '', 'zh-hk' ],
	[ 'Chinese (Taiwan)', 'zh_TW', '4.3.1', '100', 'zh-tw' ],
	[ 'Corsican', 'co', 'None', '6', 'co' ],
	[ 'Croatian', 'hr', '4.3.1', '100', 'hr' ],
	[ 'Czech', 'cs_CZ', '4.2.4', '87', 'cs' ],
	[ 'Danish', 'da_DK', '4.3.1', '100', 'da' ],
	[ 'Dhivehi', 'dv', 'None', '4', 'dv' ],
	[ 'Dutch', 'nl_NL', '4.3.1', '100', 'nl' ],
	[ 'Dutch (Belgium)', 'nl_BE', 'None', '', 'nl-be' ],
	[ 'Dzongkha', 'dzo', 'None', '0', 'dzo' ],
	[ 'English (Australia)', 'en_AU', '4.3.1', '100', 'en-au' ],
	[ 'English (Canada)', 'en_CA', '4.3.1', '100', 'en-ca' ],
	[ 'English (New Zealand)', 'en_NZ', '4.3.1', '100', 'en-nz' ],
	[ 'English (South Africa)', 'en_ZA', 'None', '0', 'en-za' ],
	[ 'English (UK)', 'en_GB', '4.3.1', '100', 'en-gb' ],
	[ 'Esperanto', 'eo', '4.3.1', '100', 'eo' ],
	[ 'Estonian', 'et', '4.3.1', '100', 'et' ],
	[ 'Faroese', 'fo', 'No site', '34', 'fo' ],
	[ 'Finnish', 'fi', '4.3.1', '100', 'fi' ],
	[ 'French (Belgium)', 'fr_BE', '4.3.1', '100', 'fr-be' ],
	[ 'French (Canada)', 'fr_CA', 'None', '94', 'fr-ca' ],
	[ 'French (France)', 'fr_FR', '4.3.1', '100', 'fr' ],
	[ 'Frisian', 'fy', '3.2.1', '53', 'fy' ],
	[ 'Friulian', 'fur', 'None', '0', 'fur' ],
	[ 'Fulah', 'fuc', 'None', '1', 'fuc' ],
	[ 'Galician', 'gl_ES', '4.3.1', '100', 'gl' ],
	[ 'Georgian', 'ka_GE', '3.3', '93', 'ka' ],
	[ 'German', 'de_DE', '4.3.1', '100', 'de' ],
	[ 'German (Switzerland)', 'de_CH', '4.3.1', '100', 'de-ch' ],
	[ 'Greek', 'el', '4.3.1', '100', 'el' ],
	[ 'Guaraní', 'gn', 'No site', '', 'gn' ],
	[ 'Gujarati', 'gu', 'None', '9', 'gu' ],
	[ 'Hawaiian', 'haw_US', 'No site', '0', 'haw' ],
	[ 'Hazaragi', 'haz', '4.1.2', '93', 'haz' ],
	[ 'Hebrew', 'he_IL', '4.3.1', '100', 'he' ],
	[ 'Hindi', 'hi_IN', 'None', '98', 'hi' ],
	[ 'Hungarian', 'hu_HU', '4.3.1', '100', 'hu' ],
	[ 'Icelandic', 'is_IS', '4.3.1', '100', 'is' ],
	[ 'Ido', 'ido', 'None', '0', 'ido' ],
	[ 'Indonesian', 'id_ID', '4.3.1', '100', 'id' ],
	[ 'Irish', 'ga', 'None', '63', 'ga' ],
	[ 'Italian', 'it_IT', '4.3.1', '100', 'it' ],
	[ 'Japanese', 'ja', '4.3.1', '100', 'ja' ],
	[ 'Javanese', 'jv_ID', '3.0.1', '46', 'jv' ],
	[ 'Kabyle', 'kab', 'None', '81', 'kab' ],
	[ 'Kannada', 'kn', '3.6', '27', 'kn' ],
	[ 'Kazakh', 'kk', 'None', '44', 'kk' ],
	[ 'Khmer', 'km', 'None', '80', 'km' ],
	[ 'Kinyarwanda', 'kin', 'No site', '0', 'kin' ],
	[ 'Kirghiz', 'ky_KY', '4.2', '30', 'ky' ],
	[ 'Korean', 'ko_KR', '4.3.1', '100', 'ko' ],
	[ 'Kurdish (Sorani)', 'ckb', '4.3', '78', 'ckb' ],
	[ 'Lao', 'lo', 'None', '65', 'lo' ],
	[ 'Latvian', 'lv', '4.3.1', '65', 'lv' ],
	[ 'Limburgish', 'li', 'None', '0', 'li' ],
	[ 'Lingala', 'lin', 'None', '', 'lin' ],
	[ 'Lithuanian', 'lt_LT', '4.3.1', '100', 'lt' ],
	[ 'Luxembourgish', 'lb_LU', 'None', '9', 'lb' ],
	[ 'Macedonian', 'mk_MK', '4.1.1', '93', 'mk' ],
	[ 'Malagasy', 'mg_MG', 'None', '14', 'mg' ],
	[ 'Malay', 'ms_MY', '2.9.2', '77', 'ms' ],
	[ 'Malayalam', 'ml_IN', 'None', '1', 'ml' ],
	[ 'Maori', 'mri', 'None', '0', 'mri' ],
	[ 'Marathi', 'mr', 'None', '7', 'mr' ],
	[ 'Mingrelian', 'xmf', 'No site', '', 'xmf' ],
	[ 'Mongolian', 'mn', 'None', '60', 'mn' ],
	[ 'Montenegrin', 'me_ME', 'None', '70', 'me' ],
	[ 'Moroccan Arabic', 'ary', '4.3.1', '100', 'ary' ],
	[ 'Myanmar (Burmese)', 'my_MM', '4.1', '91', 'mya' ],
	[ 'Nepali', 'ne_NP', 'None', '48', 'ne' ],
	[ 'Norwegian (Bokmål)', 'nb_NO', '4.3.1', '100', 'nb' ],
	[ 'Norwegian (Nynorsk)', 'nn_NO', '4.3.1', '100', 'nn' ],
	[ 'Occitan', 'oci', '4.2.4', '99', 'oci' ],
	[ 'Oriya', 'ory', 'None', '0', 'ory' ],
	[ 'Ossetic', 'os', '3.4.2', '16', 'os' ],
	[ 'Pashto', 'ps', '4.1.2', '96', 'ps' ],
	[ 'Persian', 'fa_IR', '4.3', '100', 'fa' ],
	[ 'Persian (Afghanistan)', 'fa_AF', 'None', '23', 'fa-af' ],
	[ 'Polish', 'pl_PL', '4.3.1', '100', 'pl' ],
	[ 'Portuguese (Brazil)', 'pt_BR', '4.3.1', '100', 'pt-br' ],
	[ 'Portuguese (Portugal)', 'pt_PT', '4.3.1', '100', 'pt' ],
	[ 'Punjabi', 'pa_IN', 'None', '2', 'pa' ],
	[ 'Rohingya', 'rhg', 'None', '56', 'rhg' ],
	[ 'Romanian', 'ro_RO', '4.3.1', '100', 'ro' ],
	[ 'Romansh Vallader', 'roh', 'None', '0', 'roh' ],
	[ 'Russian', 'ru_RU', '4.3.1', '100', 'ru' ],
	[ 'Russian (Ukraine)', 'ru_UA', 'No site', '', 'ru-ua' ],
	[ 'Rusyn', 'rue', 'No site', '', 'rue' ],
	[ 'Sakha', 'sah', 'None', '14', 'sah' ],
	[ 'Sanskrit', 'sa_IN', 'None', '2', 'sa-in' ],
	[ 'Sardinian', 'srd', 'None', '0', 'srd' ],
	[ 'Scottish Gaelic', 'gd', '4.3.1', '100', 'gd' ],
	[ 'Serbian', 'sr_RS', '4.3.1', '100', 'sr' ],
	[ 'Silesian', 'szl', 'None', '28', 'szl' ],
	[ 'Sindhi', 'sd_PK', 'No site', '', 'sd' ],
	[ 'Sinhala', 'si_LK', '2.8.5', '85', 'si' ],
	[ 'Slovak', 'sk_SK', '4.3.1', '100', 'sk' ],
	[ 'Slovenian', 'sl_SI', '4.3.1', '100', 'sl' ],
	[ 'Somali', 'so_SO', 'None', '32', 'so' ],
	[ 'South Azerbaijani', 'azb', 'None', '42', 'azb' ],
	[ 'Spanish (Argentina)', 'es_AR', 'None', '31', 'es-ar' ],
	[ 'Spanish (Chile)', 'es_CL', '4.0', '89', 'es-cl' ],
	[ 'Spanish (Colombia)', 'es_CO', 'None', '0', 'es-co' ],
	[ 'Spanish (Mexico)', 'es_MX', '4.3', '99', 'es-mx' ],
	[ 'Spanish (Peru)', 'es_PE', '4.3.1', '100', 'es-pe' ],
	[ 'Spanish (Puerto Rico)', 'es_PR', 'No site', '', 'es-pr' ],
	[ 'Spanish (Spain)', 'es_ES', '4.3.1', '100', 'es' ],
	[ 'Spanish (Venezuela)', 'es_VE', '4.0', '71', 'es-ve' ],
	[ 'Sundanese', 'su_ID', '3.1.3', '42', 'su' ],
	[ 'Swahili', 'sw', '3.0.5', '43', 'sw' ],
	[ 'Swedish', 'sv_SE', '4.3.1', '100', 'sv' ],
	[ 'Swiss German', 'gsw', '3.7', '74', 'gsw' ],
	[ 'Tagalog', 'tl', '4.3.1', '100', 'tl' ],
	[ 'Tajik', 'tg', 'None', '6', 'tg' ],
	[ 'Tamazight (Central Atlas)', 'tzm', 'None', '4', 'tzm' ],
	[ 'Tamil', 'ta_IN', 'None', '35', 'ta' ],
	[ 'Tamil (Sri Lanka)', 'ta_LK', '3.9', '79', 'ta-lk' ],
	[ 'Tatar', 'tt_RU', 'None', '2', 'tt' ],
	[ 'Telugu', 'te', '4.3', '43', 'te' ],
	[ 'Thai', 'th', '4.3', '100', 'th' ],
	[ 'Tibetan', 'bo', 'None', '0', 'bo' ],
	[ 'Tigrinya', 'tir', 'No site', '', 'tir' ],
	[ 'Turkish', 'tr_TR', '4.3.1', '100', 'tr' ],
	[ 'Turkmen', 'tuk', 'None', '0', 'tuk' ],
	[ 'Uighur', 'ug_CN', '4.1.2', '91', 'ug' ],
	[ 'Ukrainian', 'uk', '4.3', '100', 'uk' ],
	[ 'Urdu', 'ur', '3.6.2', '52', 'ur' ],
	[ 'Uzbek', 'uz_UZ', '4.1.1', '70', 'uz' ],
	[ 'Vietnamese', 'vi', '4.2.1', '93', 'vi' ],
	[ 'Walloon', 'wa', 'No site', '', 'wa' ],
	[ 'Welsh', 'cy', '4.3', '100', 'cy' ],
	[ 'Yoruba', 'yor', 'None', '0', 'yor' ]
];


# Get all possible translation sources in the correct order
foreach ( $wp_langs as $wp_lang ) {
	$langs2translate[ $wp_lang[1] ]['sources'][] = $wp_lang[1];
	$langs2translate[ $wp_lang[1] ]['sources'][] = $wp_lang[4];

	if ( strpos( $wp_lang[1], '_' ) ) {
		$lang = strstr( $wp_lang[1], '_', true );
		if ( $languages[ $wp_lang[1] ]['script'] ) {
			$langs2translate[ $wp_lang[1] ]['sources'][] = $languages[ $lang ]['language'] . '_' . $languages[ $lang ]['script'];
		}
		$langs2translate[ $wp_lang[1] ]['sources'][] = $languages[ $lang ]['language'];
	}
	$langs2translate[ $wp_lang[1] ]['sources'] = array_unique( $langs2translate[ $wp_lang[1] ]['sources'] );
}
$translations = [];
foreach ( $langs2translate as $lang => $lang2translate ) {
	$translations[ $lang ] = [];
	#echo "source: $lang ->";print_r($lang2translate);
	foreach ( $lang2translate['sources'] as $source ) {
		foreach ( $wp_langs as $wp_lang ) {
			if ( ! isset( $translations[ $lang ][ $wp_lang[1] ] ) and isset( $languages[ $source ] ) and isset( $languages[ $source ]['translations'] ) ) {
				$translations[ $lang ][ $wp_lang[1] ] = $languages[ $source ]['translations'][ $wp_lang[1] ] ? $languages[ $source ]['translations'][ $wp_lang[1] ] : $languages[ $source ]['translations'][ $wp_lang[4] ];
				# 
			}
		}
	}
}

if ( ! file_exists( $po_dir ) ) {
	mkdir( $po_dir );
}

# Compile .po files
foreach ( $translations as $lang => $words ) {
	$po_content = 'msgid ""' . "\n";
	$po_content .= 'msgstr ""' . "\n";
	$po_content .= '"Content-Type: text/plain; charset=UTF-8\n"' . "\n";
	$po_content .= '"Language: ' . $langcode . '\n"' . "\n\n";
	foreach ( $words as $key => $translation ) {
		$po_content .= 'msgid "' . $key . '"' . "\n";
		$po_content .= 'msgstr "' . $translation . '"' . "\n";
		$po_content .= "\n";
	}
	file_put_contents( $po_dir . '/language-' . $lang . '.po', $po_content );
}
