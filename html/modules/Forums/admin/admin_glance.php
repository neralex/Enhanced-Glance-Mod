<?php
/**
 * @package: Enhanced Glance Mod (phpBB2 for RavenNuke(tm))
 * @version: 2.0.1
 * @file: admin_glance.php
 * @Glance Mod (version 2.2.1):
 * copyright (c) 2001 by blulegend, Jack Kan http://www.www.phpbb.com
 * modified by netclectic http://www.netclectic.com
 * @Enhanced Glance Mod (version 1.0.0):
 * copyright (c) 2006 by Martyn http://www.bonusnuke.com
 * @RavenNuke(tm) Support: 2018 neralex
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('IN_PHPBB', true);

if(!empty($setmodules)) {
	$filename = basename(__FILE__);
	$module['Glance']['Manage'] = $filename;
	return;
}

// Let's set the root dir for phpBB
$phpbb_root_path = './../';
$root_path = './../../../';
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include_once($phpbb_root_path .'/includes/functions_admin.' . $phpEx);


/**
* wrapper function for determining the correct language directory
*/
function glance_mod_get_lang($language_file) {
	global $phpbb_root_path, $phpEx, $board_config;
	$language = $board_config['default_lang'];
	if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/' . $language_file . '.' . $phpEx)) {
		message_die(GENERAL_MESSAGE, 'Glance Mod language file does not exist: language/lang_' . $language . '/' . $language_file . '.' . $phpEx);
	} else {
		return $language;
	}
}

/**
* Include glance mod language entries
*/
function include_glance_lang() {
	global $phpbb_root_path, $phpEx, $lang, $board_config, $attach_config;
	
	// Include Language
	//$language = glance_mod_get_lang('lang_main_attach');
	//include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_main_attach.' . $phpEx);

	if (defined('IN_ADMIN')) {
		$language = glance_mod_get_lang('lang_admin_glance');
		include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_admin_glance.' . $phpEx);
	}
}

// Check if the language got included
if (isset($lang['Test_settings_successful'])) {
	// include_once is used within the function
	include_glance_lang();
}

//
// Pull all config data
//
global $prefix, $db;
$result = $db->sql_query('SHOW TABLES LIKE \'' . $prefix . '_bbglance\'');
$table = $db->sql_fetchrow($result);
if (isset($table['0'])) {
	$sql = 'SELECT * FROM `' . $prefix . '_bbglance`';
	if(!$result = $db->sql_query($sql)) {
		message_die(CRITICAL_ERROR, 'Could not query glance information in admin_board', '', __LINE__, __FILE__, $sql);
	} else {
		while($row = $db->sql_fetchrow($result)) {
			$config_name = $row['config_name'];
			$config_value = $row['config_value'];
			$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
			$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
		
			if (isset($HTTP_POST_VARS['submit'])) {
				if (!is_numeric($new['global_enable'])) {$new['global_enable'] = 0;}
				if (!is_numeric($new['marquee_disable'])) {$new['marquee_disable'] = 0;}
				if ($new['glance_news_forum_id'] == '' || $new['glance_news_forum_id'] < 0) {
					$new['glance_news_forum_id'] = 0;
				} else {
					$new['glance_news_forum_id'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['glance_news_forum_id'], 'nohtml'), ENT_QUOTES));
				}
				if ($new['glance_num_news'] == '' || !is_numeric($new['glance_num_news']) || $new['glance_num_news'] < 0) {$new['glance_num_news'] = 0;}
				if ($new['glance_num_recent'] == '' || !is_numeric($new['glance_num_recent']) || $new['glance_num_recent'] < 0) {$new['glance_num_recent'] = 0;}
				if (!is_numeric($new['glance_show_new_bullets']) || $new['glance_show_new_bullets'] < 0) {$new['glance_show_new_bullets'] = 0;}
				if (!is_numeric($new['glance_track']) || $new['glance_track'] < 0) {$new['glance_track'] = 0;}
				if (!is_numeric($new['glance_auth_read']) || $new['glance_auth_read'] < 0) {$new['glance_auth_read'] = 0;}
				if ($new['glance_topic_length'] == '' || !is_numeric($new['glance_topic_length'])) {$new['glance_topic_length'] = 0;}											
				if ($new['glance_table_width'] == '' || $new['glance_table_width'] < 0) {$new['glance_table_width'] = '100%';}
				$new['glance_table_width'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['glance_table_width'], 'nohtml'), ENT_QUOTES));	
				$new['global_title'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['global_title'], 'nohtml'), ENT_QUOTES));
				$new['global_announcement'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['global_announcement'], 'nohtml'), ENT_QUOTES));
				if ($new['glance_recent_ignore'] <= 0) {
					$new['glance_recent_ignore'] = '';
				} else {
					$new['glance_recent_ignore'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['glance_recent_ignore'], 'nohtml'), ENT_QUOTES));
				}				
				if (!is_numeric($new['glance_recentpopular']) || $new['glance_recentpopular'] < 0) {$new['glance_recentpopular'] = 0;}
				if (!is_numeric($new['glance_topposters']) || $new['glance_topposters'] < 0) {$new['glance_topposters'] = 0;}
				if (!is_numeric($new['glance_topposters_avatar']) || $new['glance_topposters_avatar'] < 0) {$new['glance_topposters_avatar'] = 0;}			
				if (!is_numeric($new['glance_topposters_ranks']) || $new['glance_topposters_ranks'] < 0) {$new['glance_topposters_ranks'] = 0;}
				if (!is_numeric($new['glance_topposters_perrow']) || $new['glance_topposters_perrow'] <= 0) {$new['glance_topposters_perrow'] = 5;}				
				$new['glance_topposters_skip'] = $db->sql_escape_string(htmlspecialchars_decode(check_html($new['glance_topposters_skip'], 'nohtml'), ENT_QUOTES));
				if (!is_numeric($new['glance_topposters_pos']) || $new['glance_topposters_pos'] < 0) {$new['glance_topposters_pos'] = 0;}
				if (!is_numeric($new['glance_informations']) || $new['glance_informations'] < 0) {$new['glance_informations'] = 0;}
				if (!is_numeric($new['glance_jumpbox']) || $new['glance_jumpbox'] < 0) {$new['glance_jumpbox'] = 0;}
				if (!is_numeric($new['glance_lastmembers']) || $new['glance_lastmembers'] < 0) {$new['glance_lastmembers'] = 0;}	
				$sql = 'UPDATE `' . $prefix . '_bbglance` SET `config_value` = \'' . $new[$config_name] . '\' WHERE `config_name` = \'' . $db->sql_escape_string($config_name) . '\'';
				if(!$db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Failed to update general configuration for ' . $config_name . '', '', __LINE__, __FILE__, $sql);
				}
			}
		}
	
		if (isset($HTTP_POST_VARS['submit'])) {
			$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['EGM_GOBACKCONF'], '<a href="' . append_sid('admin_glance.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');	
			message_die(GENERAL_MESSAGE, $message);
		}
	}
} else {
 	// install glance mod db table
	$createtable = 'CREATE TABLE IF NOT EXISTS `' . $prefix . '_bbglance` (
	`gid` int(11) NOT NULL AUTO_INCREMENT,
	`config_name` varchar(255) NOT NULL,
	`config_value` varchar(255) NOT NULL,
	PRIMARY KEY (`gid`),
	KEY `gid` (`gid`)
	) ENGINE=MyISAM AUTO_INCREMENT=24 ;';
	$qry1 = $db->sql_query($createtable);
	$qry2 = $db->sql_query('INSERT INTO `' . $prefix . '_bbglance` (`gid`, `config_name`, `config_value`) VALUES
	(1, \'global_title\', \'Global Announcement\'),
	(2, \'global_announcement\', \'Any important information relating to this site will be posted here!\'),
	(3, \'global_enable\', \'1\'),
	(4, \'marquee_disable\', \'0\'),
	(5, \'glance_news_forum_id\', \'1\'),
	(6, \'glance_num_news\', \'1\'),
	(7, \'glance_num_recent\', \'5\'),
	(8, \'glance_recent_ignore\', \'\'),
	(9, \'glance_table_width\', \'100%\'),
	(10, \'glance_show_new_bullets\', \'1\'),
	(11, \'glance_track\', \'1\'),
	(12, \'glance_auth_read\', \'0\'),
	(13, \'glance_topic_length\', \'0\'),
	(14, \'glance_recentpopular\', \'1\'),
	(15, \'glance_topposters\', \'5\'),	
	(16, \'glance_topposters_avatar\', \'1\'),
	(17, \'glance_topposters_ranks\', \'1\'),
	(18, \'glance_topposters_perrow\', \'5\'),
	(19, \'glance_topposters_skip\', \'\'),
	(20, \'glance_topposters_pos\', \'0\'),
	(21, \'glance_informations\', \'1\'),	
	(22, \'glance_jumpbox\', \'1\'),
	(23, \'glance_lastmembers\', \'5\')
	');
	if ($qry1 && $qry2) {
		$message = $lang['EGM_DBINSTALLDONE'] . '<br /><br />' . sprintf($lang['EGM_GOBACKCONF'], '<a href="' . append_sid('admin_glance.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else {
		message_die(GENERAL_ERROR, 'Failed to create Database Table for Enhanced Glance Mod!', '', __LINE__, __FILE__, $createtable);
	}
}

$enable_global_yes = ( $new['global_enable'] ) ? ' checked="checked"' : '';
$enable_global_no = ( !$new['global_enable'] ) ? ' checked="checked"' : '';
$marquee_disable_yes = ( $new['marquee_disable'] ) ? ' checked="checked"' : '';
$marquee_disable_no = ( !$new['marquee_disable'] ) ? ' checked="checked"' : '';
$show_new_bullets_yes = ( $new['glance_show_new_bullets'] ) ? ' checked="checked"' : '';
$show_new_bullets_no = ( !$new['glance_show_new_bullets'] ) ? ' checked="checked"' : '';
$glance_track_yes = ( $new['glance_track'] ) ? ' checked="checked"' : '';
$glance_track_no = ( !$new['glance_track'] ) ? ' checked="checked"' : '';
$glance_authread_yes = ( $new['glance_auth_read'] ) ? ' checked="checked"' : '';
$glance_authread_no = ( !$new['glance_auth_read'] ) ? ' checked="checked"' : '';
$glance_recentpopular_yes = ( $new['glance_recentpopular'] ) ? ' checked="checked"' : '';
$glance_recentpopular_no = ( !$new['glance_recentpopular'] ) ? ' checked="checked"' : '';
$glance_informations_yes = ( $new['glance_informations'] ) ? ' checked="checked"' : '';
$glance_informations_no = ( !$new['glance_informations'] ) ? ' checked="checked"' : '';
$glance_jumpbox_inside = ( $new['glance_jumpbox'] == 1 ) ? ' selected="selected"' : '';
$glance_jumpbox_outside = ( $new['glance_jumpbox'] == 2 ) ? ' selected="selected"' : '';
$glance_jumpbox_no = ( !$new['glance_jumpbox'] ) ? ' selected="selected"' : '';
$glance_topposters_pos_top = ( !$new['glance_topposters_pos'] ) ? ' checked="checked"' : '';
$glance_topposters_pos_bottom = ( $new['glance_topposters_pos'] ) ? ' checked="checked"' : '';
$glance_topposters_avatar_yes = ( $new['glance_topposters_avatar'] ) ? ' checked="checked"' : '';
$glance_topposters_avatar_no = ( !$new['glance_topposters_avatar'] ) ? ' checked="checked"' : '';
$glance_topposters_ranks_no = ( !$new['glance_topposters_ranks'] ) ? ' checked="checked"' : '';
$glance_topposters_ranks_admin = ( $new['glance_topposters_ranks'] == 1 ) ? ' selected="selected"' : '';
$glance_topposters_ranks_mod = ( $new['glance_topposters_ranks'] == 2 ) ? ' selected="selected"' : '';
$glance_topposters_ranks_adminmod = ( $new['glance_topposters_ranks'] == 3 ) ? ' selected="selected"' : '';
$glance_topposters_ranks_all = ( $new['glance_topposters_ranks'] == 4 ) ? ' selected="selected"' : '';
$new['global_title'] = htmlspecialchars($new['global_title'], ENT_QUOTES);
$new['global_announcement'] = htmlspecialchars($new['global_announcement'], ENT_QUOTES);
$new['glance_topposters_skip'] = htmlspecialchars($new['glance_topposters_skip'], ENT_QUOTES);

$template->set_filenames(array(
	'body' => 'admin/glance_config.tpl')
);

$template->assign_vars(array(
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_GLOBAL_SETTINGS' => $lang['EGM_Global_Settings'],
	'L_GLOBAL_TITLE' => $lang['EGM_Global_title'],
	'L_GLOBAL_TITLE_EXPLAIN' => $lang['EGM_Global_title_explain'],
	'L_GLOBAL' => $lang['EGM_Global'],
	'L_GLOBAL_EXPLAIN' => $lang['EGM_Global_explain'],
	'L_ENABLE_GLOBAL' => $lang['EGM_Enable_global'],
	'L_ENABLE_GLOBAL_EXPLAIN' => $lang['EGM_Enable_global_explain'],
	'L_DISABLE_MARQUEE' => $lang['EGM_Global_marquee_effect'],
	'L_DISABLE_MARQUEE_EXPLAIN' => $lang['EGM_Global_marquee_effect_explain'],
	'L_GLANCE_SETTINGS' => $lang['EGM_Glance_Settings'],
	'L_GLANCE_NEWS_FORUMS' => $lang['EGM_News_Forums'],
	'L_GLANCE_NEWS_FORUMS_DESC' => $lang['EGM_News_Forums_DESC'],
	'L_GLANCE_NEWS_FORUMS_NUM' => $lang['EGM_Number_of_News_Forums'],
	'L_GLANCE_NEWS_FORUMS_NUM_DESC' => $lang['EGM_Number_of_News_Forums_DESC'],
	'L_GLANCE_NUM_RECENT' => $lang['EGM_Num_Recent'],
	'L_GLANCE_NUM_RECENT_DESC' => $lang['EGM_Num_Recent_DSEC'],
	'L_GLANCE_RECENT_IGNORE' => $lang['EGM_Recent_Ignore'],
	'L_GLANCE_RECENT_IGNORE_DESC' => $lang['EGM_Recent_Ignore_DESC'],
	'L_GLANCE_RECENT_POPULAR' => $lang['EGM_Recent_Popular'],
	'L_GLANCE_TABLE_WIDTH' => $lang['EGM_Table_Width'],
	'L_GLANCE_TABLE_WIDTH_DESC' => $lang['EGM_Table_Width_DESC'],
	'L_GLANCE_SHOW_NEW_BULLETS' => $lang['EGM_Show_New_Bullets'],
	'L_GLANCE_SHOW_MESSAGE_TRACKING' => $lang['EGM_Message_Tracking'],
	'L_GLANCE_SHOW_MESSAGE_TRACKING_DESC' => $lang['EGM_Message_Tracking_DESC'],
	'L_GLANCE_SHOW_AUTH_READ' => $lang['EGM_Auth_Read'],
	'L_GLANCE_TOPIC_LENGTH' => $lang['EGM_Topic_Length'],
	'L_GLANCE_TOPIC_LENGTH_DESC' => $lang['EGM_Topic_Length_DESC'],
	'L_GLANCE_TOP_POSTERS_HEAD' => $lang['EGM_Top_Posters_HEAD'],
	'L_GLANCE_TOP_POSTERS' => $lang['EGM_Top_Posters'],
	'L_GLANCE_TOP_POSTERS_DESC' => $lang['EGM_Top_Posters_DESC'],
	'L_GLANCE_TOP_POSTERS_POS' => $lang['EGM_Top_Posters_POS'],
	'L_GLANCE_TOP_POSTERS_POS_TOP' => $lang['EGM_Top_Posters_POS_TOP'],	
	'L_GLANCE_TOP_POSTERS_POS_BOTTOM' => $lang['EGM_Top_Posters_POS_BOTTOM'],		
	'L_GLANCE_TOP_POSTERS_AVATAR' => $lang['EGM_Top_Posters_Avatar'],
	'L_GLANCE_TOP_POSTERS_RANKS' => $lang['EGM_Top_Posters_Ranks'],
	'L_GLANCE_TOP_POSTERS_RANKS_ADMIN' => $lang['EGM_Top_Posters_Ranks_Admin'],
	'L_GLANCE_TOP_POSTERS_RANKS_MOD' => $lang['EGM_Top_Posters_Ranks_Mod'],
	'L_GLANCE_TOP_POSTERS_RANKS_ADMINMOD' => $lang['EGM_Top_Posters_Ranks_Admin_Mod'],
	'L_GLANCE_TOP_POSTERS_RANKS_ALL' => $lang['EGM_Top_Posters_Ranks_All'],
	'L_GLANCE_TOP_POSTERS_PERROW' => $lang['EGM_Top_Posters_Per_Row'],
	'L_GLANCE_TOP_POSTERS_PERROW_DESC' => $lang['EGM_Top_Posters_Per_Row_DESC'],
	'L_GLANCE_TOP_POSTERS_SKIP' => $lang['EGM_Top_Posters_Skip'],
	'L_GLANCE_TOP_POSTERS_SKIP_DESC' => $lang['EGM_Top_Posters_Skip_DESC'],
	'L_GLANCE_INFORMATIONS_HEAD' => $lang['EGM_Informations_HEAD'],
	'L_GLANCE_INFORMATIONS' => $lang['EGM_Informations'],
	'L_GLANCE_JUMPBOX' => $lang['EGM_Jumpbox'],
	'L_GLANCE_JUMPBOX_DESC' => $lang['EGM_Jumpbox_DESC'],
	'L_GLANCE_JUMPBOX_INSIDE' => $lang['EGM_Jumpbox_Inside'],
	'L_GLANCE_JUMPBOX_OUTSIDE' => $lang['EGM_Jumpbox_Outside'],
	'L_GLANCE_LATEST_MEMBERS' => $lang['EGM_Latest_Members'],
	'L_GLANCE_LATEST_MEMBERS_DESC' => $lang['EGM_Latest_Members_DESC'],
	'GLOBAL_TITLE' => $new['global_title'],
	'GLOBAL_ANNOUNCEMENT' => $new['global_announcement'],
	'GLANCE_NEWS_FORUMS' => $new['glance_news_forum_id'],
	'GLANCE_NUM_NEWS_FORUMS' => $new['glance_num_news'],
	'GLANCE_NUM_RECENT' => $new['glance_num_recent'],
	'GLANCE_RECENT_IGNORE' => $new['glance_recent_ignore'],	
	'GLANCE_TABLE_WIDTH' => $new['glance_table_width'],	
	'GLANCE_TOPIC_LENGTH' => $new['glance_topic_length'],
	'GLANCE_TOP_POSTERS' => $new['glance_topposters'],
	'GLANCE_LASTMEMBERS' => $new['glance_lastmembers'],
	'GLANCE_TOP_POSTERS_PERROW' => $new['glance_topposters_perrow'],
	'GLANCE_TOP_POSTERS_SKIP' => $new['glance_topposters_skip'],
	'S_ENABLE_GLOBAL_YES' => $enable_global_yes,
	'S_ENABLE_GLOBAL_NO' => $enable_global_no,
	'S_DISABLE_MARQUEE_YES' => $marquee_disable_yes,
	'S_DISABLE_MARQUEE_NO' => $marquee_disable_no,
	'S_ENABLE_BULLETS_YES' => $show_new_bullets_yes,
	'S_ENABLE_BULLETS_NO' => $show_new_bullets_no,
	'S_ENABLE_TRACK_YES' => $glance_track_yes,
	'S_ENABLE_TRACK_NO' => $glance_track_no,	
	'S_ENABLE_AUTHREAD_YES' => $glance_authread_yes,
	'S_ENABLE_AUTHREAD_NO' => $glance_authread_no,	
	'S_ENABLE_RECENTPOPULAR_YES' => $glance_recentpopular_yes,
	'S_ENABLE_RECENTPOPULAR_NO' => $glance_recentpopular_no,	
	'S_ENABLE_INFORMATIONS_YES' => $glance_informations_yes,
	'S_ENABLE_INFORMATIONS_NO' => $glance_informations_no,	
	'S_INSIDE_JUMPBOX' => $glance_jumpbox_inside,
	'S_OUTSIDE_JUMPBOX' => $glance_jumpbox_outside,
	'S_DISABLE_JUMPBOX' => $glance_jumpbox_no,
	'S_TOP_POSTERS_POS_TOP' => $glance_topposters_pos_top,
	'S_TOP_POSTERS_POS_BOTTOM' => $glance_topposters_pos_bottom,
	'S_TOP_POSTERS_AVATAR_YES' => $glance_topposters_avatar_yes,
	'S_TOP_POSTERS_AVATAR_NO' => $glance_topposters_avatar_no,
	'S_TOP_POSTERS_RANKS_YES' => $glance_topposters_ranks_yes,
	'S_TOP_POSTERS_RANKS_NO' => $glance_topposters_ranks_no,
	'S_TOP_POSTERS_RANKS_ADMIN' => $glance_topposters_ranks_admin,
	'S_TOP_POSTERS_RANKS_MOD' => $glance_topposters_ranks_mod,
	'S_TOP_POSTERS_RANKS_ADMINMOD' => $glance_topposters_ranks_adminmod,
	'S_TOP_POSTERS_RANKS_ALL' => $glance_topposters_ranks_all)
);

$template->pparse('body');

include('page_footer_admin.' . $phpEx);