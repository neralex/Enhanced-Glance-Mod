<h1>RavenNuke&trade; - Enhanced Glance Mod</h1>
<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_GLOBAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_GLOBAL_TITLE}<br /><span class="gensmall">{L_GLOBAL_TITLE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="55" size="30" name="global_title" value="{GLOBAL_TITLE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLOBAL}<br /><span class="gensmall">{L_GLOBAL_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="global_announcement" maxlength="255" size="55" title="max length 255 chars" value="{GLOBAL_ANNOUNCEMENT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ENABLE_GLOBAL}<br /><span class="gensmall">{L_ENABLE_GLOBAL_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="global_enable" value="1"{S_ENABLE_GLOBAL_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="global_enable" value="0"{S_ENABLE_GLOBAL_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DISABLE_MARQUEE}<br /><span class="gensmall">{L_DISABLE_MARQUEE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="marquee_disable" value="0"{S_DISABLE_MARQUEE_NO} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="marquee_disable" value="1"{S_DISABLE_MARQUEE_YES} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_GLANCE_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TABLE_WIDTH}<br /><span class="gensmall">{L_GLANCE_TABLE_WIDTH_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="6" name="glance_table_width" value="{GLANCE_TABLE_WIDTH}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_NEWS_FORUMS}<br /><span class="gensmall">{L_GLANCE_NEWS_FORUMS_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="55" size="12" name="glance_news_forum_id" value="{GLANCE_NEWS_FORUMS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_NEWS_FORUMS_NUM}<br /><span class="gensmall">{L_GLANCE_NEWS_FORUMS_NUM_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="2" name="glance_num_news" value="{GLANCE_NUM_NEWS_FORUMS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_NUM_RECENT}<br /><span class="gensmall">{L_GLANCE_NUM_RECENT_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="2" name="glance_num_recent" value="{GLANCE_NUM_RECENT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_RECENT_IGNORE}<br /><span class="gensmall">{L_GLANCE_RECENT_IGNORE_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="55" size="12" name="glance_recent_ignore" value="{GLANCE_RECENT_IGNORE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOPIC_LENGTH}<br /><span class="gensmall">{L_GLANCE_TOPIC_LENGTH_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="5" name="glance_topic_length" value="{GLANCE_TOPIC_LENGTH}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_SHOW_NEW_BULLETS}</td>
		<td class="row2"><input type="radio" name="glance_show_new_bullets" value="1"{S_ENABLE_BULLETS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_show_new_bullets" value="0"{S_ENABLE_BULLETS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_SHOW_MESSAGE_TRACKING}<br /><span class="gensmall">{L_GLANCE_SHOW_MESSAGE_TRACKING_DESC}</span></td>
		<td class="row2"><input type="radio" name="glance_track" value="1"{S_ENABLE_TRACK_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_track" value="0"{S_ENABLE_TRACK_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_SHOW_AUTH_READ}</td>
		<td class="row2"><input type="radio" name="glance_auth_read" value="1"{S_ENABLE_AUTHREAD_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_auth_read" value="0"{S_ENABLE_AUTHREAD_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_RECENT_POPULAR}</td>
		<td class="row2"><input type="radio" name="glance_recentpopular" value="1"{S_ENABLE_RECENTPOPULAR_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_recentpopular" value="0"{S_ENABLE_RECENTPOPULAR_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_GLANCE_TOP_POSTERS_HEAD}</th>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS}<br /><span class="gensmall">{L_GLANCE_TOP_POSTERS_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="2" name="glance_topposters" value="{GLANCE_TOP_POSTERS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS_POS}</td>
		<td class="row2"><input type="radio" name="glance_topposters_pos" value="0"{S_TOP_POSTERS_POS_TOP} /> {L_GLANCE_TOP_POSTERS_POS_TOP}&nbsp;&nbsp;<input type="radio" name="glance_topposters_pos" value="1"{S_TOP_POSTERS_POS_BOTTOM} /> {L_GLANCE_TOP_POSTERS_POS_BOTTOM}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS_AVATAR}</td>
		<td class="row2"><input type="radio" name="glance_topposters_avatar" value="1"{S_TOP_POSTERS_AVATAR_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_topposters_avatar" value="0"{S_TOP_POSTERS_AVATAR_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS_RANKS}</td>
		<td class="row2">
        	<select name="glance_topposters_ranks" size="1">
				<option value="0"{S_TOP_POSTERS_RANKS_NO}>{L_NO}</option>
				<option value="1"{S_TOP_POSTERS_RANKS_ADMIN}>{L_GLANCE_TOP_POSTERS_RANKS_ADMIN}</option>
				<option value="2"{S_TOP_POSTERS_RANKS_MOD}>{L_GLANCE_TOP_POSTERS_RANKS_MOD}</option>
				<option value="3"{S_TOP_POSTERS_RANKS_ADMINMOD}>{L_GLANCE_TOP_POSTERS_RANKS_ADMINMOD}</option>
				<option value="4"{S_TOP_POSTERS_RANKS_ALL}>{L_GLANCE_TOP_POSTERS_RANKS_ALL}</option>
            </select>
        </td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS_PERROW}<br /><span class="gensmall">{L_GLANCE_TOP_POSTERS_PERROW_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="2" name="glance_topposters_perrow" value="{GLANCE_TOP_POSTERS_PERROW}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_TOP_POSTERS_SKIP}<br /><span class="gensmall">{L_GLANCE_TOP_POSTERS_SKIP_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="20" name="glance_topposters_skip" value="{GLANCE_TOP_POSTERS_SKIP}" /></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_GLANCE_INFORMATIONS_HEAD}</th>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_INFORMATIONS}</td>
		<td class="row2"><input type="radio" name="glance_informations" value="1"{S_ENABLE_INFORMATIONS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="glance_informations" value="0"{S_ENABLE_INFORMATIONS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_LATEST_MEMBERS}<br /><span class="gensmall">{L_GLANCE_LATEST_MEMBERS_DESC}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="2" name="glance_lastmembers" value="{GLANCE_LASTMEMBERS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GLANCE_JUMPBOX}<br /><span class="gensmall">{L_GLANCE_JUMPBOX_DESC}</span></td>
		<td class="row2">
        	<select name="glance_jumpbox" size="1">
				<option value="0"{S_DISABLE_JUMPBOX}>{L_NO}</option>
				<option value="1"{S_INSIDE_JUMPBOX}>{L_GLANCE_JUMPBOX_INSIDE}</option>
				<option value="2"{S_OUTSIDE_JUMPBOX}>{L_GLANCE_JUMPBOX_OUTSIDE}</option>
            </select>
        </td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>
<br clear="all" />
