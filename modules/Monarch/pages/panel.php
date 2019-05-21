<?php
/*
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 */

// Can the user view the panel?
if($user->isLoggedIn()){
	if(!$user->canViewACP()){
		// No
		Redirect::to(URL::build('/'));
		die();
	}
	if(!$user->isAdmLoggedIn()){
		// Needs to authenticate
		Redirect::to(URL::build('/panel/auth'));
		die();
	} else {
		if($user->data()->group_id != 2 && !$user->hasPermission('admincp.monarch')){
			require_once(ROOT_PATH . '/404.php');
			die();
		}
	}
} else {
	// Not logged in
	Redirect::to(URL::build('/login'));
	die();
}

define('PAGE', 'panel');
define('PARENT_PAGE', 'monarch');
define('PANEL_PAGE', 'monarch');
$page_title = $monarch_language->get('language', 'monarch_title');
require_once(ROOT_PATH . '/core/templates/backend_init.php');

if(isset($_POST['view'])){
	if(Token::check(Input::get('token'))){
		// Header
		$view = $_POST['view']; 
		$getTheme = $_POST['theme']; 
		$getBG = $_POST['bg']; 
		$getPage_BG = $_POST['page_bg']; 
		$getContent_BG = $_POST['content_bg']; 
		$getLOGO = $_POST['logo']; 
		$getFAVICON = $_POST['favicon']; 
		// Slider
		$getSLIDER = $_POST['slider']; 
		$getSLIDER1_IMG = $_POST['slider1_img']; 
		$getSLIDER1_TITLE = $_POST['slider1_title']; 
		$getSLIDER1_DESC = $_POST['slider1_desc']; 
		$getSLIDER2_IMG = $_POST['slider2_img']; 
		$getSLIDER2_TITLE = $_POST['slider2_title']; 
		$getSLIDER2_DESC = $_POST['slider2_desc']; 
		$getSLIDER3_IMG = $_POST['slider3_img']; 
		$getSLIDER3_TITLE = $_POST['slider3_title']; 
		$getSLIDER3_DESC = $_POST['slider3_desc']; 
		// Welcome
		$getWELCOME = $_POST['welcome']; 
		$getWELCOME_BG = $_POST['welcome_bg']; 
		$getWELCOME_TITLE = $_POST['welcome_title']; 
		$getWELCOME_DESC = $_POST['welcome_desc']; 
		$getWELCOME_BUTTON = $_POST['welcome_button']; 
		$getWELCOME_LINK = $_POST['welcome_link']; 
		// Alert
		$getALERT = $_POST['alert']; 
		$getALERT_TYPE = $_POST['alert_type']; 
		$getALERT_ICON = $_POST['alert_icon']; 
		$getALERT_TEXT = $_POST['alert_text']; 
		// Banner
		$getHeader_Banner = $_POST['header_banner']; 
		$getHeader_Banner_Img = $_POST['header_banner_img']; 
		$getHeader_Banner_Link = $_POST['header_banner_link']; 
		$getSidebar_Banner = $_POST['sidebar_banner']; 
		$getSidebar_Banner_Img = $_POST['sidebar_banner_img']; 
		$getSidebar_Banner_Link = $_POST['sidebar_banner_link']; 
		$getFooter_Banner = $_POST['footer_banner']; 
		$getFooter_Banner_Img = $_POST['footer_banner_img']; 
		$getFooter_Banner_Link = $_POST['footer_banner_link']; 
		// Seo
		$getGoogle_Ver = $_POST['googel_ver']; 
		$getBing = $_POST['bing']; 
		$getYandex = $_POST['yandex']; 
		$getWot = $_POST['wot']; 
		$getNorton = $_POST['norton']; 
		$getPinterest = $_POST['pinterest']; 
		// Google Analytics
		$getGa_Id = $_POST['ga_id']; 
		// Google Adsense
		$getGads = $_POST['gads']; 
		$getGads_Client = $_POST['gads_client']; 
		$getGads_Slot = $_POST['gads_slot']; 
		// Facebook
		$getFb_Id = $_POST['fb_id']; 
		$getFb_App = $_POST['fb_app']; 
		// Twiiter
		$getTwitter_Site = $_POST['twitter_site']; 
		$getTwitter_Creator = $_POST['twitter_creator']; 
		// Footer
		$getDESCRIPTION = $_POST['description']; 
		$getFLOGO = $_POST['flogo'];
	} else
		$errors = array($language->get('general', 'invalid_token'));
} else
	$view = null;

if($view == "update"){
	$f = fopen(ROOT_PATH . "/modules/Monarch/pages/settings.php","w");
	require ROOT_PATH . '/modules/Monarch/pages/settings.default.php';

	if(fwrite($f, $settings_inf) > 0){
		fclose($f);

		Session::flash('monarch_success', $monarch_language->get('language', 'successfully_updated'));

		Redirect::to(URL::build('/panel/monarch'));
		die();

	} else
		$errors = array($monarch_language->get('language', 'unable_to_write_to_settings'));

}

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, array($navigation, $cc_nav, $mod_nav), $widgets);

if(Session::exists('monarch_success'))
	$success = Session::flash('monarch_success');

if(isset($success))
	$smarty->assign(array(
		'SUCCESS' => $success,
		'SUCCESS_TITLE' => $language->get('general', 'success')
	));

if(isset($errors) && count($errors))
	$smarty->assign(array(
		'ERRORS' => $errors,
		'ERRORS_TITLE' => $language->get('general', 'error')
	));

require ROOT_PATH . '/modules/Monarch/pages/settings.php';
// Header
$getNavbarTheme = MONARCH_THEME;
$getNavbarBg = MONARCH_BG;
$getPage_Bg = MONARCH_PAGE_BG;
$getContent_Bg = MONARCH_CONTENT_BG;
$getNavbarLogo = MONARCH_LOGO;
$getFavicon = MONARCH_FAVICON;
// Slider
$getSlider = MONARCH_SLIDER;
$getSlider1_img = MONARCH_SLIDER1_IMG;
$getSlider1_title = MONARCH_SLIDER1_TITLE;
$getSlider1_desc = MONARCH_SLIDER1_DESC;
$getSlider2_img = MONARCH_SLIDER2_IMG;
$getSlider2_title = MONARCH_SLIDER2_TITLE;
$getSlider2_desc = MONARCH_SLIDER2_DESC;
$getSlider3_img = MONARCH_SLIDER3_IMG;
$getSlider3_title = MONARCH_SLIDER3_TITLE;
$getSlider3_desc = MONARCH_SLIDER3_DESC;
// Welcome
$getWelcome = MONARCH_WELCOME;
$getWelcome_Bg = MONARCH_WELCOME_BG;
$getWelcome_Title = MONARCH_WELCOME_TITLE;
$getWelcome_Desc = MONARCH_WELCOME_DESC;
$getWelcome_Button = MONARCH_WELCOME_BUTTON;
$getWelcome_Link = MONARCH_WELCOME_LINK;
// Alert
$getAlert = MONARCH_ALERT;
$getAlert_Type = MONARCH_ALERT_TYPE;
$getAlert_Icon = MONARCH_ALERT_ICON;
$getAlert_Text = MONARCH_ALERT_TEXT;
// Banner
$getHeader_Banner = MONARCH_HEADER_BANNER;
$getHeader_Banner_Img = MONARCH_HEADER_BANNER_IMG;
$getHeader_Banner_Link = MONARCH_HEADER_BANNER_LINK;
$getSidebar_Banner = MONARCH_SIDEBAR_BANNER;
$getSidebar_Banner_Img = MONARCH_SIDEBAR_BANNER_IMG;
$getSidebar_Banner_Link = MONARCH_SIDEBAR_BANNER_LINK;
$getFooter_Banner = MONARCH_FOOTER_BANNER;
$getFooter_Banner_Img = MONARCH_FOOTER_BANNER_IMG;
$getFooter_Banner_Link = MONARCH_FOOTER_BANNER_LINK;
// Seo
$getGoogle_Ver = MONARCH_GOOGLE_VER;
$getBing = MONARCH_BING;
$getYandex = MONARCH_YANDEX;
$getWot = MONARCH_WOT;
$getNorton = MONARCH_NORTON;
$getPinterest = MONARCH_PINTEREST;
// Google Analytics
$getGa_Id = MONARCH_GA_ID;
// Google Adsense
$getGads = MONARCH_GADS;
$getGads_Client = MONARCH_GADS_CLIENT;
$getGads_Slot = MONARCH_GADS_SLOT;
// Facebook
$getFb_Id = MONARCH_FB_ID;
$getFb_App = MONARCH_FB_APP;
// Twitter
$getTwitter_Site = MONARCH_TWITTER_SITE;
$getTwitter_Creator = MONARCH_TWITTER_CREATOR;
// Footer
$getFooterDescription = MONARCH_DESCRIPTION;
$getFooterFlogo = MONARCH_FLOGO;

$smarty->assign(array(
	// Header
	'PARENT_PAGE' => PARENT_PAGE,
	'DASHBOARD' => $language->get('admin', 'dashboard'),
	'MONARCH' => $monarch_language->get('language', 'monarch_title'),
	'PAGE' => PANEL_PAGE,
	'TOKEN' => Token::get(),
	'SUBMIT' => $language->get('general', 'submit'),
	'NAV_THEME_VALUE' => $getNavbarTheme,
	'HEADER_BG_VALUE' => $getNavbarBg,
	'PAGE_BG_VALUE' => $getPage_BG,
	'CONTENT_BG_VALUE' => $getContent_BG,
	'LOGO_VALUE' => $getNavbarLogo,
	'FAVICON_VALUE' => $getFavicon,
	// Slider
	'SLIDER_VALUE' => $getSlider,
	'SLIDER1_IMG_VALUE' => $getSlider1_img,
	'SLIDER1_TITLE_VALUE' => $getSlider1_title,
	'SLIDER1_DESC_VALUE' => $getSlider1_desc,
	'SLIDER2_IMG_VALUE' => $getSlider2_img,
	'SLIDER2_TITLE_VALUE' => $getSlider2_title,
	'SLIDER2_DESC_VALUE' => $getSlider2_desc,
	'SLIDER3_IMG_VALUE' => $getSlider3_img,
	'SLIDER3_TITLE_VALUE' => $getSlider3_title,
	'SLIDER3_DESC_VALUE' => $getSlider3_desc,
	// Welcome
	'WELCOME_VALUE' => $getWelcome,
	'WELCOME_BG_VALUE' => $getWelcome_Bg,
	'WELCOME_TITLE_VALUE' => $getWelcome_Title,
	'WELCOME_DESC_VALUE' => $getWelcome_Desc,
	'WELCOME_BUTTON_VALUE' => $getWelcome_Button,
	'WELCOME_LINK_VALUE' => $getWelcome_Link,
	// Alert
	'ALERT_VALUE' => $getAlert,
	'ALERT_TYPE_VALUE' => $getAlert_Type,
	'ALERT_ICON_VALUE' => $getAlert_Icon,
	'ALERT_TEXT_VALUE' => $getAlert_Text,
	// Banner
	'HEADER_BANNER_VALUE' => $getHeader_Banner,
	'HEADER_BANNER_IMG_VALUE' => $getHeader_Banner_Img,
	'HEADER_BANNER_LINK_VALUE' => $getHeader_Banner_Link,
	'SIDEBAR_BANNER_VALUE' => $getSidebar_Banner,
	'SIDEBAR_BANNER_IMG_VALUE' => $getSidebar_Banner_Img,
	'SIDEBAR_BANNER_LINK_VALUE' => $getSidebar_Banner_Link,
	'FOOTER_BANNER_VALUE' => $getFooter_Banner,
	'FOOTER_BANNER_IMG_VALUE' => $getFooter_Banner_Img,
	'FOOTER_BANNER_LINK_VALUE' => $getFooter_Banner_Link,
	// SEO
	'GOOGLE_VER_VALUE' => $getGoogle_Ver,
	'BING_VALUE' => $getBing,
	'YANDEX_VALUE' => $getYandex,
	'WOT_VALUE' => $getWot,
	'NORTON_VALUE' => $getNorton,
	'PINTEREST_VALUE' => $getPinterest,
	// Facebook
	'FB_ID_VALUE' => $getFb_Id,
	'FB_APP_VALUE' => $getFb_App,
	// Twitter
	'TWITTER_SITE_VALUE' => $getTwitter_Site,
	'TWITTER_CREATOR_VALUE' => $getTwitter_Creator,
	// Google Analytics
	'GA_ID_VALUE' => $getGa_Id,
	// Google Adsense
	'GADS_VALUE' => $getGads,
	'GADS_CLIENT_VALUE' => $getGads_Client,
	'GADS_SLOT_VALUE' => $getGads_Slot,
	// Footer
	'DESCRIPTION_VALUE' => $getFooterDescription,
	'FLOGO_VALUE' => $getFooterFLogo,

	/*******************************************************************/
	
	// Header
	'NAV_THEME' => $monarch_language->get('language', 'theme'),
	'HEADER_BG' => $monarch_language->get('language', 'header_background'),
	'HEADER_BG_PLACEHOLDER' => $monarch_language->get('language', 'header_background_placeholder'),
	'PAGE_BG' => $monarch_language->get('language', 'page_bg'),
	'PAGE_BG_PLACEHOLDER' => $monarch_language->get('language', 'page_bg_placeholder'),
	'CONTENT_BG' => $monarch_language->get('language', 'content_bg'),
	'CONTENT_BG_PLACEHOLDER' => $monarch_language->get('language', 'content_bg_placeholder'),
	'LOGO' => $monarch_language->get('language', 'logo'),
	'LOGO_PLACEHOLDER' => $monarch_language->get('language', 'logo_placeholder'),
	'FAVICON' => $monarch_language->get('language', 'favicon'),
	'FAVICON_PLACEHOLDER' => $monarch_language->get('language', 'favicon_placeholder'),
	// Footer
	'DESCRIPTION' => $monarch_language->get('language', 'description'),
	'DESCRIPTION_PLACEHOLDER' => $monarch_language->get('language', 'description_placeholder'),
	'FLOGO' => $monarch_language->get('language', 'flogo'),
	'FLOGO_PLACEHOLDER' => $monarch_language->get('language', 'flogo_placeholder'),
	'LINKS' => $monarch_language->get('language', 'links'),
	'LEGAL' => $monarch_language->get('language', 'legal'),
	// Enable & Disable
	'ENABLE' => $monarch_language->get('language', 'enable'),
	'DISABLE' => $monarch_language->get('language', 'disable'),
	// Slider
	'SLIDER' => $monarch_language->get('language', 'slider'),
	'SLIDER1' => $monarch_language->get('language', 'slider1'),
	'SLIDER2' => $monarch_language->get('language', 'slider2'),
	'SLIDER3' => $monarch_language->get('language', 'slider3'),
	'SLIDER_IMG' => $monarch_language->get('language', 'slider_img'),
	'SLIDER_IMG_PLACEHOLDER' => $monarch_language->get('language', 'slider_img_placeholder'),
	'SLIDER_TITLE' => $monarch_language->get('language', 'slider_title'),
	'SLIDER_TITLE_PLACEHOLDER' => $monarch_language->get('language', 'slider_title_placeholder'),
	'SLIDER_DESC' => $monarch_language->get('language', 'slider_desc'),
	'SLIDER_DESC_PLACEHOLDER' => $monarch_language->get('language', 'slider_desc_placeholder'),
	// Welcome
	'WELCOME' => $monarch_language->get('language', 'welcome'),
	'WELCOME_PLACEHOLDER' => $monarch_language->get('language', 'welcome_placeholder'),
	'WELCOME_BG' => $monarch_language->get('language', 'welcome_bg'),
	'WELCOME_BG_PLACEHOLDER' => $monarch_language->get('language', 'welcome_bg_placeholder'),
	'WELCOME_TITLE' => $monarch_language->get('language', 'welcome_title'),
	'WELCOME_TITLE_PLACEHOLDER' => $monarch_language->get('language', 'welcome_title_placeholder'),
	'WELCOME_DESC' => $monarch_language->get('language', 'welcome_desc'),
	'WELCOME_DESC_PLACEHOLDER' => $monarch_language->get('language', 'welcome_desc_placeholder'),
	'WELCOME_BUTTON' => $monarch_language->get('language', 'welcome_button'),
	'WELCOME_BUTTON_PLACEHOLDER' => $monarch_language->get('language', 'welcome_button_placeholder'),
	'WELCOME_LINK' => $monarch_language->get('language', 'welcome_link'),
	'WELCOME_LINK_PLACEHOLDER' => $monarch_language->get('language', 'welcome_link_placeholder'),
	// Alert
	'ALERT' => $monarch_language->get('language', 'alert'),
	'ALERT_TYPE' => $monarch_language->get('language', 'alert_type'),
	'INFO' => $monarch_language->get('language', 'info'),
	'SUCCESS' => $monarch_language->get('language', 'success'),
	'DANGER' => $monarch_language->get('language', 'danger'),
	'WARNING' => $monarch_language->get('language', 'warning'),
	'DEFAULT' => $monarch_language->get('language', 'default'),
	'LIGHT' => $monarch_language->get('language', 'light'),
	'DARK' => $monarch_language->get('language', 'dark'),
	'PRIMARY' => $monarch_language->get('language', 'primary'),
	'ALERT_ICON' => $monarch_language->get('language', 'alert_icon'),
	'ALERT_ICON_PLACEHOLDER' => $monarch_language->get('language', 'alert_icon_placeholder'),
	'ALERT_TEXT' => $monarch_language->get('language', 'alert_text'),
	'ALERT_TEXT_PLACEHOLDER' => $monarch_language->get('language', 'alert_text_placeholder'),
	// Banner
	'HEADER_BANNER' => $monarch_language->get('language', 'header_banner'),
	'SIDEBAR_BANNER' => $monarch_language->get('language', 'sidebar_banner'),
	'FOOTER_BANNER' => $monarch_language->get('language', 'footer_banner'),
	'BANNER_IMG' => $monarch_language->get('language', 'banner_img'),
	'BANNER_IMG_PLACEHOLDER' => $monarch_language->get('language', 'banner_img_placeholder'),
	'BANNER_LINK' => $monarch_language->get('language', 'banner_link'),
	'BANNER_LINK_PLACEHOLDER' => $monarch_language->get('language', 'banner_link_placeholder'),
	// Seo
	'SEO' => $monarch_language->get('language', 'seo'),
	'GOOGLE_VER' => $monarch_language->get('language', 'google_ver'),
	'BING' => $monarch_language->get('language', 'bing'),
	'YANDEX' => $monarch_language->get('language', 'yandex'),
	'WOT' => $monarch_language->get('language', 'wot'),
	'NORTON' => $monarch_language->get('language', 'norton'),
	'PINTEREST' => $monarch_language->get('language', 'pinterest'),
	// Facebook Tags
	'FB_TAGS' => $monarch_language->get('language', 'fb_tags'),
	'FB_ID' => $monarch_language->get('language', 'fb_id'),
	'FB_ID_PLACEHOLDER' => $monarch_language->get('language', 'fb_id_placeholder'),
	'FB_APP' => $monarch_language->get('language', 'fb_app'),
	'FB_APP_PLACEHOLDER' => $monarch_language->get('language', 'fb_app_placeholder'),
	// Twitter Tags
	'TWITTER_TAGS' => $monarch_language->get('language', 'twitter_tags'),
	'TWITTER_SITE' => $monarch_language->get('language', 'twitter_site'),
	'TWITTER_SITE_PLACEHOLDER' => $monarch_language->get('language', 'twitter_site_placeholder'),
	'TWITTER_CREATOR' => $monarch_language->get('language', 'twitter_creator'),
	'TWITTER_CREATOR_PLACEHOLDER' => $monarch_language->get('language', 'twitter_creator_placeholder'),
	// Google Analytics
	'GOOGLE_ANALYTICS' => $monarch_language->get('language', 'google_analytics'),
	'GA_ID' => $monarch_language->get('language', 'ga_id'),
	'GA_ID_PLACEHOLDER' => $monarch_language->get('language', 'ga_id_placeholder'),
	// Googla Adsense
	'GOOGLE_ADSENSE' => $monarch_language->get('language', 'google_adsense'),
	'GADS' => $monarch_language->get('language', 'gads'),
	'GADS_CLIENT' => $monarch_language->get('language', 'gads_client'),
	'GADS_CLIENT_PLACEHOLDER' => $monarch_language->get('language', 'gads_client_placeholder'),
	'GADS_SLOT' => $monarch_language->get('language', 'gads_slot'),
	'GADS_SLOT_PLACEHOLDER' => $monarch_language->get('language', 'gads_slot_placeholder'),
	// Thems
	'MONARCH' => $monarch_language->get('language', 'monarch'),
	'SOMEWHATORANGE' => $monarch_language->get('language', 'somewhatorange'),
	'RED' => $monarch_language->get('language', 'red'),
	'DARKRED' => $monarch_language->get('language', 'darkred'),
	'AQUA' => $monarch_language->get('language', 'aqua'),
	'BLUE' => $monarch_language->get('language', 'blue'),
	'DARKBLUE' => $monarch_language->get('language', 'darkblue'),
	'GREEN' => $monarch_language->get('language', 'green'),
	'DARKGREEN' => $monarch_language->get('language', 'darkgreen'),
	'GOLD' => $monarch_language->get('language', 'gold'),
	'ORANGE' => $monarch_language->get('language', 'orange'),
	'BROWN' => $monarch_language->get('language', 'brown'),
	'PINK' => $monarch_language->get('language', 'pink'),
	'PURPLE' => $monarch_language->get('language', 'purple'),
	'GRAY' => $monarch_language->get('language', 'gray'),
	'BLACK' => $monarch_language->get('language', 'black'),
	'RAINBOW' => $monarch_language->get('language', 'rainbow'),
));

$page_load = microtime(true) - $start;
define('PAGE_LOAD_TIME', str_replace('{x}', round($page_load, 3), $language->get('general', 'page_loaded_in')));

$template->onPageLoad();

require(ROOT_PATH . '/core/templates/panel_navbar.php');

// Display template
$template->displayTemplate('monarch/index.tpl', $smarty);