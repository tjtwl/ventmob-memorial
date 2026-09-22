<?php defined('VM_ARCHIVE') or exit;
/** @var array $forum */
$missing = $forum['total_threads'] !== null ? max(0, (int) $forum['total_threads'] - count($forum['threads'])) : null;
if ($missing === 0) {
    return;
}
?>
<tr class="missing_box">
	<td class="alt1" width="26"><img src="archive/assets/old/img/thread_lock.png" alt="" width="20" height="20"></td>
	<td class="alt2" width="1"></td>
	<td class="alt1" align="left" colspan="4">
		<div><strong><?= e(missing_label($missing, 'thread')) ?>, but the Wayback Machine never archived them.</strong></div>
		<div class="smallfont">This is everything that survived of this forum. The rest of its threads are gone.</div>
	</td>
</tr>
