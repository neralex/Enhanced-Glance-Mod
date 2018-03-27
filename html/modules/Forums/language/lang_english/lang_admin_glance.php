<?php
/**
 * @package: Enhanced Glance Mod (phpBB2 for RavenNuke(tm))
 * @version: 2.0.1
 * @file: lang_admin_glance.php
 * @Glance Mod (version 2.2.1):
 * copyright (c) 2001 by blulegend, Jack Kan http://www.www.phpbb.com
 * modified by netclectic http://www.netclectic.com
 * @Enhanced Glance Mod (version 1.0.0):
 * copyright (c) 2006 by Martyn http://www.bonusnuke.com
 * @RavenNuke(tm) Support: 2018 neralex
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!isset($lang) || !is_array($lang)) {
	$lang = array();
}

$lang['EGM_Global_title'] = 'Global announcement title';
$lang['EGM_Global_title_explain'] = 'Enter a different title for the announcement if the default \'Global Announcement\' is not suitable.';
$lang['EGM_Global'] = 'Global Announcement';
$lang['EGM_Global_Settings'] = 'Global Announcement Settings';
$lang['EGM_Global_explain'] = 'Enter the special announcement you want displayed on your forums main index page here.';
$lang['EGM_Enable_global'] = 'Enable Global Announcement';
$lang['EGM_Enable_global_explain'] = 'If you enable this, a global announcement will be displayed on your main index page.';
$lang['EGM_Global_marquee_effect'] = 'Enable the scrolling global announcement effect';
$lang['EGM_Global_marquee_effect_explain'] = 'If you enable this, your global announcement will scroll on the main index.';
$lang['EGM_GOBACKCONF'] = 'Click %sHere%s to return to the Glance Configuration';
$lang['EGM_DBINSTALLDONE'] = 'Database Table for Enhanced Glance Mod was installed!';
$lang['EGM_Glance_Settings'] = 'Glance Settings';
$lang['EGM_News_Forums'] = 'IDs of \'News\' forums';
$lang['EGM_News_Forums_DESC'] = 'Seperate \'News\' forums with, eg 1,2,3 - set to 0 (zero) if you do not have a news forum.';
$lang['EGM_Number_of_News_Forums'] = 'Number of \'News\' forums you wish to display';
$lang['EGM_Number_of_News_Forums_DESC'] = 'Set to zero if you do not want this to be displayed or do not have a \'News\' forum.';
$lang['EGM_Num_Recent'] = 'Number of recent topics';
$lang['EGM_Num_Recent_DSEC'] = 'Set to zero if you do not want this to be displayed.';
$lang['EGM_Recent_Ignore'] = 'Forums you wish to ignore in your recent topics';
$lang['EGM_Recent_Ignore_DESC'] = 'Seperate forums to ignore with, eg 1,2,3 - leave it blank if you want all displayed.';
$lang['EGM_Table_Width'] = 'Table Width';
$lang['EGM_Table_Width_DESC'] = 'Here you can set a specific width for the glance table.';
$lang['EGM_Show_New_Bullets'] = 'Change the bullet if a topic is new?';
$lang['EGM_Message_Tracking'] = 'Message Tracking';
$lang['EGM_Message_Tracking_DESC'] = 'Message tracking will track to see if a user has read the topic during their session.';
$lang['EGM_Auth_Read'] = 'Show topics the user can view, but not read?';
$lang['EGM_Topic_Length'] = 'Topic Char Counter';
$lang['EGM_Topic_Length_DESC'] = 'Limit the number of characters displayed for topic titles. Set to zero to display the full title.';
$lang['EGM_Recent_Popular'] = 'Display the Popular Topics';
$lang['EGM_Top_Posters_HEAD'] = 'Top Posters';
$lang['EGM_Top_Posters'] = 'Display Top Posters';
$lang['EGM_Top_Posters_DESC'] = 'Set the number of displayed top posters. Set to zero if you don\'t want this to be displayed.';
$lang['EGM_Top_Posters_POS'] = 'Top Posters\' Position';
$lang['EGM_Top_Posters_POS_TOP'] = 'top';
$lang['EGM_Top_Posters_POS_BOTTOM'] = 'bottom';
$lang['EGM_Top_Posters_Avatar'] = 'Display Top Posters\' Avatar';
$lang['EGM_Top_Posters_Ranks'] = 'Display Top Posters\' Rank';
$lang['EGM_Top_Posters_Ranks_Admin'] = 'Admin only';
$lang['EGM_Top_Posters_Ranks_Mod'] = 'Moderator only';
$lang['EGM_Top_Posters_Ranks_Admin_Mod'] = 'Admin &amp; Moderator';
$lang['EGM_Top_Posters_Ranks_All'] = 'All';
$lang['EGM_Top_Posters_Per_Row'] = 'Number of Top Posters per line';
$lang['EGM_Top_Posters_Per_Row_DESC'] = 'The default value is 5! If you leave it blank, then it goes back to default.';
$lang['EGM_Top_Posters_Skip'] = 'Skip Top Posters';
$lang['EGM_Top_Posters_Skip_DESC'] = 'Use a comma separated list with each name, like user1,user2,user3.';
$lang['EGM_Informations_HEAD'] = 'Forum Informations';
$lang['EGM_Informations'] = 'Display Forum Informations';
$lang['EGM_Jumpbox'] = 'Display Jumpbox';
$lang['EGM_Jumpbox_DESC'] = 'Display the Jumpbox inside or outside of the \'Forum Informations\'.';
$lang['EGM_Jumpbox_Inside'] = 'inside';
$lang['EGM_Jumpbox_Outside'] = 'outside';
$lang['EGM_Latest_Members'] = 'Display Latest Members';
$lang['EGM_Latest_Members_DESC'] = 'Set to zero if you do not want this to be displayed.';
$lang['Test_settings_successful'] = 'Settings Test finished, configuration seems to be fine.';