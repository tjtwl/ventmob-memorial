<?php defined('VM_ARCHIVE') or exit;
/** @var array $thread */
$missing = $thread['expected'] ? max(0, (int) $thread['expected'] - (int) $thread['preserved']) : null;
?>
<table class="tborder missing_box" cellpadding="6" cellspacing="0" border="0" width="100%" align="center" style="margin-bottom:10px">
<tr><td class="thead"><div class="normal" style="float:right">#?</div><div class="normal">Not archived</div></td></tr>
<tr>
	<td class="alt2" style="padding:0">
		<table cellpadding="0" cellspacing="6" border="0" width="100%"><tr>
			<td nowrap="nowrap"><div class="bigusername">Lost to time</div><div class="smallfont">Missing posts</div></td>
			<td width="100%">&nbsp;</td>
		</tr></table>
	</td>
</tr>
<tr>
	<td class="alt1">
		<div class="postbit_msg"><strong><?= e(missing_label($missing, 'post')) ?>, but the Wayback Machine never archived them.</strong><br>
		What you see above is everything that survived of this thread. The rest of the conversation is gone.</div>
	</td>
</tr>
</table>
