<?php
/**
 * @package: Enhanced Glance Mod (for RavenNuke(tm) 2.5+)
 * @version: 2.0.1
 * @file: glance.php
 * @Glance Mod (version 2.2.1):
 * copyright (c) 2001 by blulegend, Jack Kan http://www.www.phpbb.com
 * modified by netclectic http://www.netclectic.com
 * @Enhanced Glance Mod (version 1.0.0):
 * copyright (c) 2006 by Martyn http://www.bonusnuke.com
 * @RavenNuke(tm) Support: 2018 neralex
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_PHPBB')) {die('Hacking attempt');}
global $prefix;
define('IN_GLANCE', true);
	//
	// LOAD THE GLANCE CONFIGURATION
	//
	class glance_config {
		// extample: $glanceconfig->dbexists();
		function dbexists() {
			global $prefix, $db;
			$result = $db->sql_query('SHOW TABLES LIKE \'' . $prefix . '_bbglance\'');
			$table = $db->sql_fetchrow($result);
			if (isset($table['0'])) {
				$dbexists = 1;
			} else {
				$dbexists = 0;
			}
			return $dbexists;
		}

		// extample: $glanceconfig->value('glance_recentpopular');
		function value($config_name) {
			global $prefix, $db;
			$config_sql = $db->sql_query('SELECT `config_value` FROM `' . $prefix . '_bbglance` WHERE `config_name` = \'' . $db->sql_escape_string($config_name) . '\'');
			list($config_value) = $db->sql_fetchrow($config_sql);
			return $config_value;
		}
	
		/*function exists($config_name) {
			// extample: $glanceconfig->exists('glance_recentpopular');
			global $prefix, $db;
			$config_sql = $db->sql_query('SELECT `config_name` FROM `' . $prefix . '_bbglance` WHERE `config_name` = \'' . $db->sql_escape_string($config_name) . '\'');
			list($cconfig_name) = $db->sql_fetchrow($config_sql);
			if($cconfig_name != '') { 
				$config_exists = 1; 
			} else { 
				$config_exists = 0;
			}
			return $config_exists;
		}*/	
	}
	$glanceconfig = new glance_config();

	if ($glanceconfig->dbexists()) {

		// FORUM DIRECTORY
		$glance_forum_dir = 'modules.php?name=' . $module_name . '&amp;file=';
		
		if ($glanceconfig->value('global_enable') == 1) {
			$template->assign_block_vars('global_enable', array());
			if ($glanceconfig->value('marquee_disable') == 0) {
				addJSToBody('modules/' . $module_name . '/glance_mod/js/jquery.scroll_announcement.js', 'file');
			}
		}
	
		$glance_topposters = $glanceconfig->value('glance_topposters');
		if ($glance_topposters) {
	
			// MOD START - TOP 'X' USERS MOD - AbelaJohnB
			// This function will be used to acquire the "Top 'x'" members of your forum.
			// neralex: added some features from block-ForumsCallapsing.php
	
			function top_posters($str_input) {
				global $db, $phpEx, $module_name, $glanceconfig, $textcolor1, $lang;
	
				$show_avatar = $glanceconfig->value('glance_topposters_avatar');
				$show_ranks = $glanceconfig->value('glance_topposters_ranks');
				$show_per_row = $glanceconfig->value('glance_topposters_perrow');
				$skip_usernames = $glanceconfig->value('glance_topposters_skip');
				if ($skip_usernames != '') {
					$skip_usernames = str_replace(',', '\',\'',$skip_usernames);
				}
				
				$sql = 'SELECT u.`user_id`, u.`username`, u.`user_posts`, count(u.`user_id`) as `user_posts`, u.`user_avatar`, u.`user_level`, r.`rank_title`, r.`rank_id`
				FROM `' . USERS_TABLE . '` u LEFT JOIN `' . RANKS_TABLE . '` r ON u.`user_rank` = r.`rank_id`, `' . POSTS_TABLE . '` p
				WHERE (u.`user_id` <> ' . ANONYMOUS . ') AND (u.`user_id` = p.`poster_id`) AND u.`username` NOT IN (\'' . $skip_usernames . '\')
				GROUP BY `user_id`, `username`
				ORDER BY `user_posts` DESC LIMIT ' . $str_input . '';
	
				if ( !($result = $db->sql_query($sql)) ) {
						message_die(GENERAL_ERROR, 'Could not query forum top poster information', '', __LINE__, __FILE__, $sql);
				}
				$num_posters = $db->sql_numrows($result);
				if ($num_posters > 0) {
					$top_posters = '<div class="text-center"><span class="thick">' . $lang['EGM_Top_Posters'] . '</span><br /><br />'
								 . '<table class="centered" cellpadding="0" style="border-collapse: collapse; border-color: ' . $textcolor1 . '; vertical-align: middle;" cellspacing="1" border="0">';
					$cycle = 1;
					$top_posters .= '<tr>';	
					while($row = $db->sql_fetchrow($result)) {
						$row['username'] = htmlspecialchars($row['username'], ENT_QUOTES, _CHARSET);
						$row['rank_title'] = htmlspecialchars($row['rank_title'], ENT_QUOTES, _CHARSET);
						$staffTitle = '';
						if ($show_ranks == 3) {
							if ($row['user_level'] == 2 || $row['user_level'] == 3) {
								$staffTitle = ' title="' . $row['rank_title'] . '"';
							} else {
								$staffTitle = '';
							}
						} elseif ($show_ranks == 4) {
							$staffTitle =  'title="' . $row['rank_title'] . '"';
						} elseif ($show_ranks == 1) {
							if ($row['user_level'] == 2) {
								$staffTitle = ' title="' . $row['rank_title'] . '"';
							} else {
								$staffTitle = '';
							}
						} elseif ($show_ranks == 2) {
							if ($row['user_level'] == 3) {
								$staffTitle = ' title="' . $row['rank_title'] . '"';
							} else {
								$staffTitle = '';
							}
						}
						if ($show_avatar) {
							$top_posters .= '<td class="text-center">';
							if ($row['user_avatar'] == '') {
								$top_posters .= '&nbsp;&nbsp;<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $row['user_id']) . '"' . $staffTitle . '>'
											  . '<img alt="" src="modules/' . $module_name . '/images/avatars/noimage.gif" border ="0" width="32" /></a></td>';
							} elseif (stristr($row['user_avatar'], 'http://')) {
								$top_posters .= '&nbsp;&nbsp;<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $row['user_id']) . '"' . $staffTitle . '>'
											  . '<img alt="" src="' . $row['user_avatar'] . '" border ="0" width="32" /></a></td>';
							} else {
								$top_posters .= '&nbsp;&nbsp;<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $row['user_id']) . '"' . $staffTitle . '>'
											  . '<img alt="" src="modules/' . $module_name . '/images/avatars/' . $row['user_avatar'] . '" border ="0" width="32" /></a></td>';
							}
						}
						$top_posters .= '<td><a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $row['user_id']) . '"' . $staffTitle . '>' . $row['username'] . '</a>&nbsp;<br />&nbsp;'
									  . '<a href="modules.php?name=' . $module_name . '&amp;file=search&amp;search_author=' . $row['username'] . '"' . $staffTitle . '>Posts:</a>'
									  . '&nbsp;<a href="modules.php?name=' . $module_name . '&amp;file=search&amp;search_author=' . $row['username'] . '"' . $staffTitle . '>' . $row['user_posts'] . '</a>&nbsp;</td>'; 
					}
					if (!($cycle % ($show_per_row ? $show_per_row : '5')) || $cycle == $num_posters) {
						$top_posters .= '</tr>';
					}
					$cycle++;
					if ($show_per_row > 1) {
						$top_posters .= '</tr>';
					}
					$top_posters .= '</table></div><br />';
				} else {
					$top_posters = false;
				}
			  return $top_posters;
			}
			if ($glanceconfig->value('glance_topposters_pos')) {
				$topposters_pos = 'glance_top_posters_bottom';
			} else {
				$topposters_pos = 'glance_top_posters_top';
			}
			$template->assign_block_vars($topposters_pos, array());
			$template->assign_vars(array(
				'TOP_POSTERS' => top_posters($glance_topposters),
				'L_TOP_POSTERS' => $lang['EGM_Top_Posters'])
			);
			// MOD END - TOP 'X' USERS MOD - AbelaJohnB
		}
	
		//
		// GET USER LAST VISIT
		//
		$glance_last_visit = $userdata['user_lastvisit'];
		$recent_offset = $HTTP_GET_VARS['recent_offset'];
		//
		// MESSAGE TRACKING
		//
		if ( !isset($tracking_topics) && $glanceconfig->value('glance_track') ) $tracking_topics = ( isset($_COOKIE[$board_config['cookie_name'] . '_t']) ) ? unserialize($_COOKIE[$board_config['cookie_name'] . '_t']) : '';
	
		// CHECK FOR BAD WORDS
		//
		// Define censored word matches
		//
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);
	
		// set the topic title sql depending on the character limit	set in glance_config
		$glance_topic_length = $glanceconfig->value('glance_topic_length');
		$sql_title = ($glance_topic_length) ? ', LEFT(t.`topic_title`, ' . $glance_topic_length . ') as `topic_title`' : ', t.`topic_title`';
	
		//
		// GET THE LATEST NEWS TOPIC
		//
		if ($glanceconfig->value('glance_num_news')) {
			$glance_num_news = $glanceconfig->value('glance_num_news');
			$news_data = $db->sql_fetchrow($result);
			$sql = '
				SELECT 
					f.`forum_id`, f.`forum_name`' . $sql_title . ', t.`topic_id`, t.`topic_last_post_id`, t.`topic_poster`, t.`topic_views`, t.`topic_replies`, t.`topic_type`, t.`topic_status`, 
					p2.`post_time`, p2.`poster_id`, 
					u.`username` as `last_username`, 
					u2.`username` as `author_username`
				FROM `' . FORUMS_TABLE . '` f, `' . POSTS_TABLE . '` p, `' . TOPICS_TABLE . '` t, `' . POSTS_TABLE . '` p2, `' . USERS_TABLE . '` u, `' . USERS_TABLE . '` u2
				WHERE
					f.`forum_id` IN (' . $glanceconfig->value('glance_news_forum_id') . ')
					AND t.`forum_id` = f.`forum_id`
					AND p.`post_id` = t.`topic_first_post_id`
					AND p2.`post_id` = t.`topic_last_post_id`
					AND t.`topic_moved_id` = 0
					AND p2.`poster_id` = u.`user_id`
					AND t.`topic_poster` = u2.`user_id`
					AND f.`auth_view` = 0
				ORDER BY t.`topic_last_post_id` DESC';
			$news_topicnum = $db->sql_numrows($db->sql_query($sql));
			if (!is_numeric($news_offset) || $news_offset < 0 || $news_offset >= $news_topicnum) {$news_offset = 0;}
			$sql .= ($news_offset) ? ' LIMIT ' . $news_offset . ', ' . $glance_num_news : ' LIMIT ' . $glance_num_news;
	
			if(!($result = $db->sql_query($sql))) {
				message_die(GENERAL_ERROR, 'Could not query new news information', '', __LINE__, __FILE__, $sql);
			}
			$latest_news = array();
			while ( $topic_row = $db->sql_fetchrow($result)) {
				$topic_row['topic_title'] = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_row['topic_title']) : $topic_row['topic_title'];
				$latest_news[] = $topic_row;
			}
			$db->sql_fetchrow($result);
	
			// MOD NAV BEGIN
			// obtain the total number of topic for our news topic navigation bit
			$sql = 'SELECT SUM(`forum_topics`) as `topic_total` FROM `' . FORUMS_TABLE . '` f WHERE f.`forum_id` IN (' . $glanceconfig->value('glance_news_forum_id') . ')';
			if (!($result = $db->sql_query($sql))) {
				message_die(GENERAL_ERROR, 'Could not query total topics information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$overall_news_topics = $row['topic_total'];
			$db->sql_fetchrow($result);
			// MOD NAV END
		}
	
		//
		// GET THE LAST 5 TOPICS
		//
		if ($glanceconfig->value('glance_num_recent')) {
			$glance_num_recent = $glanceconfig->value('glance_num_recent');
			$glance_auth_level = ( $glanceconfig->value('glance_auth_read') ) ? AUTH_VIEW : AUTH_ALL;
			//$is_auth_ary = auth($glance_auth_level, AUTH_LIST_ALL, $userdata);
			$is_auth_ary = auth($glance_auth_level, AUTH_LIST_ALL, $userdata, $forum_data);
			
			
			$forumsignore = $glanceconfig->value('glance_news_forum_id');
			if ($num_forums = count($is_auth_ary)) {
				while ( list($forum_id, $auth_mod) = each($is_auth_ary)) {
					$unauthed = false;
					if (!$auth_mod['auth_view']) {
						$unauthed = true;
					}
					
					if (!$glanceconfig->value('glance_auth_read') && !$auth_mod['auth_read']) {
						$unauthed = true;
					}
					if ($unauthed) {
						$forumsignore .= ($forumsignore) ? ',' . $forum_id : $forum_id;				
					}
				}
			}
		
			$forumsignore .= ($forumsignore && $glanceconfig->value('glance_recent_ignore')) ? ',' : '';
			$sql = '
				SELECT
					f.`forum_id`, f.`forum_name`' . $sql_title . ', t.`topic_id`, t.`topic_last_post_id`, t.`topic_poster`, t.`topic_views`, t.`topic_replies`, t.`topic_type`,
					p2.`post_time`, p2.`poster_id`, 
					u.`username` as `last_username`, 
					u2.`username` as `author_username`
				FROM `' . FORUMS_TABLE . '` f, `' . POSTS_TABLE . '` p, `' . TOPICS_TABLE . '` t, `' . POSTS_TABLE . '` p2, `' . USERS_TABLE . '` u, `'	. USERS_TABLE . '` u2
				WHERE
					f.`forum_id` NOT IN (' . $forumsignore . $glanceconfig->value('glance_recent_ignore') . ')
					AND t.`forum_id` = f.`forum_id`
					AND p.`post_id` = t.`topic_first_post_id`
					AND p2.`post_id` = t.`topic_last_post_id`
					AND t.`topic_moved_id` = 0
					AND p2.`poster_id` = u.`user_id`
					AND t.`topic_poster` = u2.`user_id`
				ORDER BY t.`topic_last_post_id` DESC';
	
			$recent_topicnum = $db->sql_numrows($db->sql_query($sql));
			if (!is_numeric($recent_offset) || $recent_offset < 0 || $recent_offset >= $recent_topicnum) {$recent_offset = 0;}
			$sql .= ($recent_offset) ? ' LIMIT ' . $recent_offset . ', ' . $glance_num_recent : ' LIMIT ' . $glance_num_recent;
			if(!($result = $db->sql_query($sql))) {
				message_die(GENERAL_ERROR, 'Could not query latest topic information', '', __LINE__, __FILE__, $sql);
			}
	
			$latest_topics = array();
			$latest_anns = array();
			$latest_stickys = array();
			while ($topic_row = $db->sql_fetchrow($result)) {
				$topic_row['topic_title'] = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_row['topic_title']) : $topic_row['topic_title'];
				switch ($topic_row['topic_type']) {
						case POST_ANNOUNCE:
							$latest_anns[] = $topic_row;
							break;
						case POST_STICKY:
							$latest_stickys[] = $topic_row;
							break;
						default:
							$latest_topics[] = $topic_row;
							break;
					}
			}
			$latest_topics = array_merge($latest_anns, $latest_stickys, $latest_topics);
	
			$db->sql_freeresult($result);
			// MOD NAV BEGIN
			// obtain the total number of topic for our recent topic navigation bit
			$sql = 'SELECT SUM(`forum_topics`) as `topic_total` FROM `' . FORUMS_TABLE . '` f WHERE f.`forum_id` NOT IN (' . $forumsignore . $glanceconfig->value('glance_recent_ignore') . $glanceconfig->value('glance_news_forum_id') . ')';
			if (!($result = $db->sql_query($sql))) {
				message_die(GENERAL_ERROR, 'Could not query total topics information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$overall_total_topics = $row['topic_total'];
			$db->sql_fetchrow($result);
			// MOD NAV END
		}
	
		//
		// BEGIN OUTPUT
		//
		$template->set_filenames(array(
			'glance_output' => 'glance_body.tpl')
		);
		
		if ($glance_num_news && $news_topicnum > 0) {
			if (!empty($latest_news)) {
				$bullet_pre = '<img src="';
				if ($news_topicnum > count($latest_news)) {
					$counter1 = count($latest_news);
				} else {
					$counter1 = $news_topicnum;
				}
				for ($i = 0; $i < $counter1; $i++) {
					if ($userdata['session_logged_in']) {
						$unread_topics = false;
						$topic_id = $latest_news[$i]['topic_id'];
						if ($latest_news[$i]['post_time'] > $glance_last_visit)	{
							$unread_topics = true;
							if(!empty($tracking_topics[$topic_id]) && $glanceconfig->value('glance_track'))	{
								if($tracking_topics[$topic_id] >= $latest_news[$i]['post_time']) {
									$unread_topics = false;
								}
							}
						}
						$shownew = $unread_topics;
					} else {
						$unread_topics = false;
						$shownew = ($board_config['time_today'] < $latest_news[$i]['post_time']);
					}
	
					$bullet_full = $bullet_pre . (($userdata['session_logged_in'] && $shownew && $glanceconfig->value('glance_show_new_bullets') ) ? $images['folder_announce_new'] : $images['folder_announce']) . '" border="0" alt="" />';
	
					#$newest_code = ( $unread_topics && $glanceconfig->value('glance_show_new_bullets') ) ? '&amp;view=newest' : '';
	
					$topic_link = $glance_forum_dir . 'viewtopic&t=' . $latest_news[$i]['topic_id']; #  . $newest_code
					$latest_topics[$i]['author_username'] = htmlspecialchars($latest_topics[$i]['author_username'], ENT_QUOTES, _CHARSET);
					$latest_topics[$i]['last_username'] = htmlspecialchars($latest_topics[$i]['last_username'], ENT_QUOTES, _CHARSET);
					$last_post_time = create_date($board_config['default_dateformat'], $latest_news[$i]['post_time'], $board_config['board_timezone']);
					$last_poster = ($latest_news[$i]['poster_id'] == ANONYMOUS ) ? ( ($latest_news[$i]['last_username'] != '' ) ? $latest_news[$i]['last_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid('profile&mode=viewprofile&amp;' . POST_USERS_URL . '='  . $latest_news[$i]['poster_id']) . '">' . $latest_news[$i]['last_username'] . '</a> ';
					$last_poster .= '<a href="' . append_sid('viewtopic.' . $phpEx . '?'  . POST_POST_URL . '=' . $latest_news[$i]['topic_last_post_id']) . '#' . $latest_news[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
					$topic_poster = ($latest_news[$i]['topic_poster'] == ANONYMOUS ) ? ( ($latest_news[$i]['author_username'] != '' ) ? $latest_news[$i]['author_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid('profile&mode=viewprofile&amp;' . POST_USERS_URL . '=' . $latest_news[$i]['topic_poster']) . '">' . $latest_news[$i]['author_username'] . '</a> ';
					$template->assign_block_vars('news', array(
						'BULLET' => $bullet_full,
						'TOPIC_TITLE' => $latest_news[$i]['topic_title'],
						'TOPIC_LINK' => $topic_link,
						'TOPIC_TIME' => $last_post_time,
						'TOPIC_POSTER' => $topic_poster,
						'TOPIC_VIEWS' => $latest_news[$i]['topic_views'],
						'TOPIC_REPLIES' => $latest_news[$i]['topic_replies'],
						'LAST_POSTER' => $last_poster,
						'FORUM_TITLE' => $latest_news[$i]['forum_name'],
						'FORUM_LINK' => $glance_forum_dir . 'viewforum&f=' . $latest_news[$i]['forum_id'])
						);
				}
				// MOD NAV BEGIN
				if (($news_offset > 0) || ($news_offset+$glance_num_news < $overall_news_topics)) {
					$new_url = '<a href="' . $glance_forum_dir . $file . '&news_offset=';
					
					if ($news_offset > 0) {
						// if we're not on the first record, we can always go backwards
						$prev_news_url = ($recent_offset > 0) ? $new_url . ($news_offset-$glance_num_news) . '&recent_offset=' . $recent_offset . '" class="th">&lt;&lt; Prev ' . $glance_num_news . '</a>' : $new_url . ($news_offset-$glance_num_news).'" class="th">&lt;&lt; Prev ' . $glance_num_news . '</a>';
					}
					if ($news_offset+$glance_num_news < $overall_total_topics) {
						// offset + limit gives us the maximum record number
						// that we could have displayed on this page. if it's
						// less than the total number of entries, that means
						// there are more entries to see, and we can go forward
						// ***************************************************************************
						// neralex: count down, if recent_topicnum smaller than glance_num_recent
						if ($news_offset+$glance_num_news < $news_topicnum) {
							if ($glance_num_news > ($news_topicnum-($news_offset+$glance_num_news))) {
								$next_news = $news_topicnum-($news_offset+$glance_num_news);
							} else {
								$next_news = $glance_num_news;
							}
						} else {
							$next_news = $glance_num_news;
						}
						$next_news_url = ($recent_offset > 0) ? $new_url . ($news_offset+$glance_num_news) . '&recent_offset=' . $recent_offset . '" class="th">Next ' . $glance_num_news . ' &gt;&gt;</a>' : $new_url . ($news_offset+$glance_num_news).'" class="th">Next ' . $next_news . ' &gt;&gt;</a>';
					}
				}
				// MOD NAV END
			} else {
				$template->assign_block_vars('news', array(
					'BULLET' => '<img src="' . $images['forum'] . '" border="0" alt="" />', $glance_recent_bullet_old,
					'TOPIC_TITLE' => 'None')
				);
			}
		}
		if ($glance_num_recent) {
			$glance_info = 'counted recent';
			$bullet_pre = '<img src="';
			if (!empty($latest_topics)) {
				if ($recent_topicnum > count($latest_topics)) {
					$counter = count($latest_topics);
				} elseif ($glance_num_recent < $recent_topicnum) {
					$counter = $glance_num_recent;
				} else {
					$counter = $recent_topicnum;
				}
				for ($i = 0; $i < $counter; $i++) {
					if ($userdata['session_logged_in']) {
						$unread_topics = false;
						$topic_id = $latest_topics[$i]['topic_id'];
						if ($latest_topics[$i]['post_time'] > $glance_last_visit) {
							$unread_topics = true;
							if(!empty($tracking_topics[$topic_id]) && $glanceconfig->value('glance_track')) {
								if($tracking_topics[$topic_id] >= $latest_topics[$i]['post_time']) {
									$unread_topics = false;
								}
							}
						}
						$shownew = $unread_topics;
					} else {
						$unread_topics = false;
						$shownew = ($board_config['time_today'] < $latest_topics[$i]['post_time']);
					}
	
					switch ($latest_topics[$i]['topic_type']) {
						case POST_ANNOUNCE:
							$bullet_full = $bullet_pre . (($userdata['session_logged_in'] && $shownew && $glanceconfig->value('glance_show_new_bullets')) ? $images['folder_announce_new'] : $images['folder_announce']) . '" border="0" alt="" />';
							break;
						case POST_STICKY:
							$bullet_full = $bullet_pre . (($userdata['session_logged_in'] && $shownew && $glanceconfig->value('glance_show_new_bullets')) ? $images['folder_sticky_new'] : $images['folder_sticky']) . '" border="0" alt="" />';
							break;
						default:
							if ($latest_topics[$i]['topic_status'] == TOPIC_LOCKED) {
								$folder = $images['folder_locked'];
								$folder_new = $images['folder_locked_new'];
							} elseif ($latest_topics[$i]['topic_replies'] >= $board_config['hot_threshold']) {
								$folder = $images['folder_hot'];
								$folder_new = $images['folder_hot_new'];
							} else {
								$folder = $images['folder'];
								$folder_new = $images['folder_new'];
							}
	
							$bullet_full = $bullet_pre . ( ($userdata['session_logged_in'] && $shownew && $glanceconfig->value('glance_show_new_bullets') ) ? $folder_new :  $folder ) . '" border="0" alt="" />';
							break;
					}
					$newest_code = ( $unread_topics && $glanceconfig->value('glance_show_new_bullets') ) ? '&amp;view=newest' : '';
	
					$topic_link = $glance_forum_dir . 'viewtopic&t=' . $latest_topics[$i]['topic_id']; #  . $newest_code
					$latest_topics[$i]['author_username'] = htmlspecialchars($latest_topics[$i]['author_username'], ENT_QUOTES, _CHARSET);
					$topic_poster = ($latest_topics[$i]['topic_poster'] == ANONYMOUS ) ? ( ($latest_topics[$i]['author_username'] != '' ) ? $latest_topics[$i]['author_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&' . POST_USERS_URL . '='  . $latest_topics[$i]['topic_poster']) . '">' . $latest_topics[$i]['author_username'] . '</a>';
	
					$last_post_time = create_date($board_config['default_dateformat'], $latest_topics[$i]['post_time'], $board_config['board_timezone']);
					$latest_topics[$i]['last_username'] = htmlspecialchars($latest_topics[$i]['last_username'], ENT_QUOTES, _CHARSET);
					$last_poster = ($latest_topics[$i]['poster_id'] == ANONYMOUS ) ? ( ($latest_topics[$i]['last_username'] != '' ) ? $latest_topics[$i]['last_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&' . POST_USERS_URL . '='  . $latest_topics[$i]['poster_id']) . '">' . $latest_topics[$i]['last_username'] . '</a> ';
					$last_poster .= '<a href="' . append_sid('viewtopic.' . $phpEx . '?'  . POST_POST_URL . '=' . $latest_topics[$i]['topic_last_post_id']) . '#' . $latest_topics[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
	
					//
					// MOD TODAY AT BEGIN
					//
					//if ( $board_config['time_today'] < $latest_topics[$i]['post_time'])
					//{
					//	$last_post_time = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $latest_topics[$i]['post_time'], $board_config['board_timezone']));
					//}
					//else if ( $board_config['time_yesterday'] < $latest_topics[$i]['post_time'])
					//{
					//	$last_post_time = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $latest_topics[$i]['post_time'], $board_config['board_timezone']));
					//}
					// MOD TODAY AT END
	
					$template->assign_block_vars('recent', array(
						'BULLET' => $bullet_full,
						'TOPIC_LINK' => $topic_link,
						'TOPIC_TITLE' => $latest_topics[$i]['topic_title'],
						'TOPIC_POSTER' => $topic_poster,
						'TOPIC_VIEWS' => $latest_topics[$i]['topic_views'],
						'TOPIC_REPLIES' => $latest_topics[$i]['topic_replies'],
						'LAST_POST_TIME' => $last_post_time,
						'LAST_POSTER' => $last_poster,
						'FORUM_TITLE' => $latest_topics[$i]['forum_name'],
						'FORUM_LINK' => $glance_forum_dir . 'viewforum&f=' . $latest_topics[$i]['forum_id'])
					);
				}
	
				// MOD NAV BEGIN
				if (($recent_offset > 0) or ($recent_offset+$glance_num_recent < $overall_total_topics)) {
					$new_url = '<a href="' . $glance_forum_dir . $file . '&recent_offset=';
					if ($recent_offset > 0)	{
						// if we're not on the first record, we can always go backwards
						$prev_recent_url = ($news_offset > 0) ? $new_url . ($recent_offset-$glance_num_recent) . '&news_offset=' . $news_offset . '" class="th">&lt;&lt; Prev ' . $glance_num_recent . '</a>' : $new_url . ($recent_offset-$glance_num_recent).'" class="th">&lt;&lt; Prev ' . $glance_num_recent . '</a>';
					}
					if ($recent_offset+$glance_num_recent < $overall_total_topics) {
						// offset + limit gives us the maximum record number
						// that we could have displayed on this page. if it's
						// less than the total number of entries, that means
						// there are more entries to see, and we can go forward
						// ***************************************************************************
						// neralex: count down, if recent_topicnum smaller than glance_num_recent
						if ($recent_offset+$glance_num_recent < $recent_topicnum) {
							if ($glance_num_recent > ($recent_topicnum-($recent_offset+$glance_num_recent))) {
								$next_recent = $recent_topicnum-($recent_offset+$glance_num_recent);
							} else {
								$next_recent = $glance_num_recent;
							}
						} else {
							$next_recent = $glance_num_recent;
						}
						$next_recent_url = ($news_offset > 0) ? $new_url . ($recent_offset+$glance_num_recent) . '&news_offset=' . $news_offset . '" class="th">Next ' . $glance_num_recent . ' &gt;&gt;</a>' : $new_url . ($recent_offset+$glance_num_recent).'" class="th">Next ' . $next_recent . ' &gt;&gt;</a>';
					}
				}
				// MOD NAV END
			} else {
				$template->assign_block_vars('recent', array(
				'BULLET' => '<img src="' . $images['forum'] . '" border="0" alt="" />', $glance_recent_bullet_old,
				'TOPIC_TITLE' => 'None')
				);
			}
		}
		if ($glance_num_news && $news_topicnum > 0) {
			$template->assign_block_vars('switch_glance_news', array(
				'NEXT_URL' => $next_news_url,
				'PREV_URL' => $prev_news_url)
			);
		}
	
		// 
		// Okay, let's build the topic recent and popular
		//
		if ($glanceconfig->value('glance_recentpopular')) {
			$template->assign_block_vars('activepopular', array());
			$active_topics_sql = 'SELECT a.`topic_id`,a.`topic_title`, a.`topic_replies`, a.`topic_last_post_id`, c.`post_time`
						FROM `' . TOPICS_TABLE . '` a, `' . USERS_TABLE . '` b, `' . POSTS_TABLE . '` c, `' . FORUMS_TABLE . '` d
						where a.`topic_last_post_id` = c.`post_id` AND b.`user_id` = c.`poster_id`
							AND d.`forum_id` = a.`forum_id`
							AND d.`auth_view` = 0
						ORDER BY `topic_last_post_id` DESC LIMIT 5';
			$active_topics = $db->sql_query($active_topics_sql);
	
			$active_topics_sql2 = 'SELECT a.`topic_id`, a.`topic_title`, a.`topic_replies`, a.`topic_last_post_id`, c.`post_time`
						FROM `' . TOPICS_TABLE . '` a, `' . USERS_TABLE . '` b, `' . POSTS_TABLE . '` c, `' . FORUMS_TABLE . '` d
						where a.`topic_last_post_id` = c.`post_id` AND b.`user_id` = c.`poster_id`
							AND d.`forum_id` = a.`forum_id`
							AND d.`auth_view` = 0
						ORDER BY `topic_replies` DESC LIMIT 5';
			$active_topics2 = $db->sql_query($active_topics_sql2);
	
			$active_topics_sql3 = 'SELECT a.`topic_id`, a.`topic_title`, a.`topic_views`, a.`topic_replies`, a.`topic_last_post_id`, c.`post_time`
						FROM `' . TOPICS_TABLE . '` a, `' . USERS_TABLE . '` b, `' . POSTS_TABLE . '` c, `' . FORUMS_TABLE . '` d
						WHERE a.`topic_last_post_id` = c.`post_id` AND b.`user_id` = c.`poster_id`
							AND d.`forum_id` = a.`forum_id`
							AND d.`auth_view` = 0
						ORDER BY `topic_views` DESC	LIMIT 5';
			$active_topics3 = $db->sql_query($active_topics_sql3);
			while (($line = $db->sql_fetchrow($active_topics)) && ($line2 = $db->sql_fetchrow($active_topics2)) && ($line3 = $db->sql_fetchrow($active_topics3))) {
				if (strlen($line['topic_title']) > 40) {
					$line_topic_title = substr($line['topic_title'], 0, 40) . ' ...';
				} else {
					$line_topic_title = $line['topic_title'];
				}
				if (strlen($line2['topic_title']) > 40) {
					$line_topic_title2 = substr($line2['topic_title'], 0, 40) . ' ...';
				} else {
					$line_topic_title2 = $line2['topic_title'];
				}
				if (strlen($line3['topic_title']) > 40) {
					$line_topic_title3 = substr($line3['topic_title'], 0, 40) .  ' ...';
				} else {
					$line_topic_title3 = $line3['topic_title'];
				}
				$lastpost = '<a href="' . append_sid('viewtopic.' . $phpEx . '?'  . POST_TOPIC_URL . '=' . $line['topic_id']) . '">' . htmlspecialchars($line_topic_title, ENT_QUOTES, _CHARSET) . '</a>';
				$poppost = '<a href="' . append_sid('viewtopic.' . $phpEx . '?'  . POST_TOPIC_URL . '=' . $line2['topic_id']) . '">' . htmlspecialchars($line_topic_title2, ENT_QUOTES, _CHARSET) . '</a>';
				$poppostc = $line2['topic_replies'];
				$popviewpost = '<a href="' . append_sid('viewtopic.' . $phpEx . '?'  . POST_TOPIC_URL . '=' . $line3['topic_id']) . '">' . htmlspecialchars($line_topic_title3, ENT_QUOTES, _CHARSET) . '</a>';
				$popviewpostc = $line3['topic_views'];
				$template->assign_block_vars('topicrecentpopular', array(
					'TOPICSPOPULAR' => $poppost,
					'TOPICSPOPULARC' => $poppostc,
					'TOPICSPOPULARVIEW' => $popviewpost,
					'TOPICSPOPULARVIEWC' => $popviewpostc,
					'TOPICSRECENT' => $lastpost)
				);
			}
		}
	
		if ($glance_num_recent && $recent_topicnum > 0) {
			$template->assign_block_vars('switch_glance_recent', array());
			if ($recent_topicnum > $glance_num_recent) {
				$template->assign_block_vars('switch_glance_recent.recent_offset', array(
					'NEXT_URL' => $next_recent_url,
					'PREV_URL' => $prev_recent_url)
				);
			}
		}
	
		/*$glance_topposters = $glanceconfig->value('glance_topposters');
		if ($glance_topposters) {
			$template->assign_block_vars('glance_top_posters', array());
			$template->assign_vars(array(
				'TOP_POSTERS' => top_posters($glance_topposters),
				'L_TOP_POSTERS' => $lang['EGM_Top_Posters'])
			);
		}*/
	
		$glance_informations = $glanceconfig->value('glance_informations');
		if ($glance_informations) {
			$template->assign_block_vars('active_informations', array());
		}
	
		// Begin Latest Members
		$glance_lastmembers = $glanceconfig->value('glance_lastmembers');
		if ($glance_informations && $glance_lastmembers) {
			$members = $glance_lastmembers;  // How Many to display
			$query = $db->sql_query('SELECT `username`, `user_id`, `user_avatar` FROM `' . USERS_TABLE . '` WHERE `user_id` != ' . ANONYMOUS . ' ORDER BY `user_id` DESC LIMIT ' . $members . '');
			$numc = $db->sql_numrows($query);
			$count_tatest = 0;
			while(list($username, $uid, $user_avatar) = $db->sql_fetchrow($query)) {
				$count_tatest++;
				$ShowLatest .= '<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $uid) . '">' . htmlspecialchars($username, ENT_QUOTES, _CHARSET) . '</a>' . ($count_tatest > 1 ? ', ' : '');
			}
			$template->assign_vars(array(
				'L_LATEST_MEMBERS' => $lang['EGM_Latest_Members'],
				'LATEST_USERS' => $ShowLatest)
			);
		}
	
		$glance_jumpbox = $glanceconfig->value('glance_jumpbox');
		if ($glance_jumpbox) {
			make_jumpbox('viewforum.' . $phpEx);
			if ($glance_informations && $glance_jumpbox == 1) {
				$template->assign_block_vars('active_informations.inside_jumpbox', array());
			} elseif ($glance_jumpbox == 2) {
				$template->assign_block_vars('outside_jumpbox', array());
			}
		}
		$template->assign_vars(array(
			'GLANCE_TABLE_WIDTH' =>	$glanceconfig->value('glance_table_width'),
			'RECENT_HEADING' => $lang['EGM_Recent_Heading'],
			'NEWS_HEADING' => $lang['EGM_News_Heading'],
			'GLOBAL_TITLE' => $glanceconfig->value('global_title'),
			'GLOBAL_ANNOUNCEMENT' => htmlspecialchars($glanceconfig->value('global_announcement'), ENT_QUOTES, _CHARSET),
			'ANNOUNCEMENT_BULLET' => $images['folder_announce'],
			'L_TOPICS' => $lang['Topics'],
			'L_TOPICSPOPULAR' => $lang['EGM_TopicsPopular'],
			'L_TOPICSPOPULARVIEW' => $lang['EGM_TopicsPopularView'],
			'L_REPLIES' => $lang['Replies'],
			'L_VIEWS' => $lang['Views'],
			'L_LASTPOST' => $lang['Last_Post'],
			'L_AUTHOR' => $lang['Author'])
		);
	
		$template->assign_var_from_handle('GLANCE_OUTPUT', 'glance_output');
	}
// THE END