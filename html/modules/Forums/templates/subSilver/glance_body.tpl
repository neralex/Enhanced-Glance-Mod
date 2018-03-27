<br />
<!-- BEGIN glance_top_posters_top -->
{TOP_POSTERS}
<!-- END glance_top_posters_top -->
<!-- BEGIN global_enable -->
<table width="{GLANCE_TABLE_WIDTH}" cellpadding="2" cellspacing="1" border="0" class="forumline">  
    <tr>
		<th class="thTop" colspan="2" height="28" align="left">{GLOBAL_TITLE}</th>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="middle" class="row1" align="center" width="30"><img src="{ANNOUNCEMENT_BULLET}" alt="Announcements" /></td>
		<td class="row1 thick" align="center" height="40">
              <div style="width:99%" class="marquee">{GLOBAL_ANNOUNCEMENT}</div>
        </td>
	</tr>
</table>
<!-- END global_enable -->
<table width="{GLANCE_TABLE_WIDTH}" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<!-- BEGIN switch_glance_news -->
    <tr>
		<th class="thTop" width="100%" colspan="2" height="28" align="left">	
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<th style="border:none !important;" align="left">{NEWS_HEADING}</th>
        			<th style="border:none !important;" align="right">{switch_glance_news.PREV_URL}&nbsp;&nbsp;{switch_glance_news.NEXT_URL}&nbsp;&nbsp;</th>
				</tr>
			</table>
		</th>
		<th class="thTop" width="100" align="center" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
		<th class="thTop" width="100" align="center" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
		<th class="thTop" width="50" align="center" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
		<th class="thCornerR" width="100" align="center" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
    </tr>
	<!-- END switch_glance_news -->
    <!-- BEGIN news -->
    <tr>
		<td nowrap="nowrap" valign="middle" class="row1" align="center" width="30"><a href="{news.TOPIC_LINK}">{news.BULLET}</a></td>
		<td valign="middle" width="100%" class="row1"><span class="gensmall"><a href="{news.TOPIC_LINK}" class="gensmall">{news.TOPIC_TITLE}</a></span></td>
		<td valign="middle" class="row2" nowrap="nowrap" align="center"><span class="gensmall"><a href="{news.FORUM_LINK}" class="gensmall">{news.FORUM_TITLE}</a></span></td>
		<td valign="middle" class="row3" nowrap="nowrap" align="center"><span class="gensmall">{news.TOPIC_POSTER}</span></td>
		<td valign="middle" class="row2" nowrap="nowrap" align="center"><span class="gensmall">{news.TOPIC_REPLIES}</span></td>
		<td valign="middle" class="row3" nowrap="nowrap" align="center"><span class="gensmall">{news.TOPIC_TIME}<br />{news.LAST_POSTER}</span></td>
    </tr>
    <!-- END news -->
    <!-- BEGIN switch_glance_recent -->
    <tr>
    	<th colspan="2" class="thTop" height="28" align="left">
    		<table width="100%" cellpadding="0" cellspacing="0" border="0">
    			<tr>
            		<th style="border:none !important;" align="left">{RECENT_HEADING}</th>
                                       
            		<th style="border:none !important;" align="right">
                    	<!-- BEGIN recent_offset -->
                        {switch_glance_recent.recent_offset.PREV_URL}&nbsp;&nbsp;{switch_glance_recent.recent_offset.NEXT_URL}&nbsp;&nbsp;
                    	<!-- END recent_offset -->
            		</th>    
            	</tr>
            </table>
    	</th>
    	<th class="thTop" width="100" align="center" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
    	<th class="thTop" width="100" align="center" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
    	<th class="thTop" width="50" align="center" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
    	<th class="thCornerR" width="100" align="center" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
    </tr>
	<!-- END switch_glance_recent -->
    <!-- BEGIN recent -->
	<tr>
        <td nowrap="nowrap" valign="middle" class="row1" align="center" width="30"><a href="{recent.TOPIC_LINK}">{recent.BULLET}</a></td>
        <td valign="middle" width="100%" class="row1"><span class="gensmall"><a href="{recent.TOPIC_LINK}" class="gensmall">{recent.TOPIC_TITLE}</a></span></td>
        <td valign="middle" class="row2" nowrap="nowrap" align="center"><span class="gensmall"><a href="{recent.FORUM_LINK}" class="gensmall">{recent.FORUM_TITLE}</a></span></td>
        <td valign="middle" class="row3" nowrap="nowrap" align="center"><span class="gensmall">{recent.TOPIC_POSTER}</span></td>
        <td valign="middle" class="row2" nowrap="nowrap" align="center"><span class="gensmall">{recent.TOPIC_REPLIES}</span></td>
        <td valign="middle" class="row3" nowrap="nowrap" align="center"><span class="gensmall">{recent.LAST_POST_TIME}<br />{recent.LAST_POSTER}</span></td>
    </tr>
    <!-- END recent -->
    <!-- BEGIN activepopular -->
  	<tr>
		<td class="row1" colspan="6">
			<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
				<tr>
					<th width="50%" colspan="2" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICSPOPULAR}&nbsp;</th>
					<th width="50%" colspan="2" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICSPOPULARVIEW}&nbsp;</th>
				</tr>
              	<!-- END activepopular -->
              	<!-- BEGIN topicrecentpopular -->
				<tr>
					<td width="44%" class="row2" align="left" valign="middle"><span class="gensmall">{topicrecentpopular.TOPICSPOPULAR}</span></td>
					<td width="6%" class="row3" align="center" valign="middle"><span class="gensmall">{topicrecentpopular.TOPICSPOPULARC}</span></td>
					<td width="44%" class="row2" align="left" valign="middle"><span class="gensmall">{topicrecentpopular.TOPICSPOPULARVIEW}</span></td>
					<td width="6%" class="row3" align="center" valign="middle"><span class="gensmall">{topicrecentpopular.TOPICSPOPULARVIEWC}</span></td>
				</tr>
				<!-- END topicrecentpopular -->
				<!-- BEGIN activepopular -->
			</table>
		</td>
	</tr>
	<!-- END activepopular -->
    <!-- BEGIN active_informations -->
	<tr>
		<th class="thTop" colspan="6" height="28" align="left">Forum Information</th>
    </tr>
	<tr>
		<td nowrap="nowrap" valign="middle" class="row1" align="center" width="30"><img src="modules/Forums/glance_mod/images/w_info.png" alt="Forum navigation, tools and information" /></td>
        <td valign="middle" width="100%" colspan="5" class="row1">
			<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center">
				<tr>
                	<td align="left" valign="top" class="gensmall">
                		{LAST_VISIT_DATE}<br />
                		{CURRENT_TIME}<br />
                		{S_TIMEZONE}<br />
                		{TOTAL_POSTS}<br />
                        {L_LATEST_MEMBERS}{LATEST_USERS}
					</td>
                	<td align="right" valign="top" class="gensmall">
                    	<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
                    	<a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
                    	<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a><br />
                    	<a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a><br />
                        <!-- BEGIN inside_jumpbox -->
                    	{JUMPBOX}
                        <!-- END inside_jumpbox -->
                	</td>
				</tr>
			</table>
		</td>
	</tr>
    <!-- END active_informations -->
	<!-- BEGIN glance_top_posters_bottom -->
	<td colspan="6" align="center">{TOP_POSTERS}</td>
	<!-- END glance_top_posters_bottom -->
    <!-- BEGIN outside_jumpbox -->
	<tr>
		<td align="right" colspan="6" width="100%" valign="middle">
        	{JUMPBOX}
		</td>
	</tr>
	<!-- END outside_jumpbox -->
</table>
<br />
