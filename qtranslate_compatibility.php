<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'QTRANS_INIT' ) ) {
	define( 'QTRANS_INIT', true );
}
if ( ! function_exists( 'qtrans_convertURL' ) ) {
	/**
	 * @param string $url
	 * @param string $lang
	 * @param bool $forceadmin
	 * @param bool $showDefaultLanguage
	 *
	 * @return string
	 */
	function qtrans_convertURL( $url = '', $lang = '', $forceadmin = false, $showDefaultLanguage = false ) {
		return qtranxf_convertURL( $url, $lang, $forceadmin, $showDefaultLanguage );
	}
}
if ( ! function_exists( 'qtrans_generateLanguageSelectCode' ) ) {
	/**
	 * @param string $style
	 * @param string $id
	 */
	function qtrans_generateLanguageSelectCode( $style = '', $id = '' ) {
		qtranxf_generateLanguageSelectCode( $style, $id );
	}
}

/**
 * Some 3rd-party plugins (for example "Google XML Sitemaps v3 for qTranslate") use this function and expect an array in return.
 */
if ( ! function_exists( 'qtrans_getAvailableLanguages' ) ) {
	/**
	 * @param $text
	 *
	 * @return array|bool
	 */
	function qtrans_getAvailableLanguages( $text ) {
		$langs = qtranxf_getAvailableLanguages( $text );
		if ( is_array( $langs ) ) {
			return $langs;
		}
		if ( empty( $text ) ) {
			return [];
		}
		global $q_config;

		return [ $q_config['default_language'] ];
	}
}

if ( ! function_exists( 'qtrans_getLanguage' ) ) {
	/**
	 * @return mixed
	 */
	function qtrans_getLanguage() {
		return qtranxf_getLanguage();
	}
}
if ( ! function_exists( 'qtrans_getLanguageName' ) ) {
	/**
	 * @param string $lang
	 *
	 * @return mixed
	 */
	function qtrans_getLanguageName( $lang = '' ) {
		return qtranxf_getLanguageNameNative( $lang );
	}
}
if ( ! function_exists( 'qtrans_getSortedLanguages' ) ) {
	/**
	 * @param bool $reverse
	 *
	 * @return array
	 */
	function qtrans_getSortedLanguages( $reverse = false ) {
		return qtranxf_getSortedLanguages( $reverse );
	}
}
if ( ! function_exists( 'qtrans_join' ) ) {
	/**
	 * @param $texts
	 *
	 * @return null|string
	 */
	function qtrans_join( $texts ) {
		if ( ! is_array( $texts ) ) {
			$texts = qtranxf_split( $texts );
		}

		return qtranxf_join_b( $texts );
	}
}
if ( ! function_exists( 'qtrans_split' ) ) {
	/**
	 * @param $text
	 * @param bool $quicktags
	 *
	 * @return array
	 */
	function qtrans_split( $text, $quicktags = true ) {
		return qtranxf_split( $text );
	}
}
if ( ! function_exists( 'qtrans_use' ) ) {
	/**
	 * @param $lang
	 * @param $text
	 * @param bool $show_available
	 *
	 * @return array|string
	 */
	function qtrans_use( $lang, $text, $show_available = false ) {
		return qtranxf_use( $lang, $text, $show_available );
	}
}
if ( ! function_exists( 'qtrans_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
	/**
	 * @param $content
	 *
	 * @return array|string
	 */
	function qtrans_useCurrentLanguageIfNotFoundShowAvailable( $content ) {
		return qtranxf_useCurrentLanguageIfNotFoundShowAvailable( $content );
	}
}
if ( ! function_exists( 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage' ) ) {
	/**
	 * @param $content
	 *
	 * @return array|string
	 */
	function qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage( $content ) {
		return qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage( $content );
	}
}
if ( ! function_exists( 'qtrans_useDefaultLanguage' ) ) {
	/**
	 * @param $content
	 *
	 * @return array|string
	 */
	function qtrans_useDefaultLanguage( $content ) {
		return qtranxf_useDefaultLanguage( $content );
	}
}
if ( ! function_exists( 'qtrans_useTermLib' ) ) {
	/**
	 * @param $obj
	 *
	 * @return array
	 */
	function qtrans_useTermLib( $obj ) {
		return qtranxf_useTermLib( $obj );
	}
}
