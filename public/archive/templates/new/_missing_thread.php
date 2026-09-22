<?php defined('VM_ARCHIVE') or exit;
/** @var array $forum */
$missing = $forum['total_threads'] !== null ? max(0, (int) $forum['total_threads'] - count($forum['threads'])) : null;
if ($missing === 0) {
    return;
}
?>
<li class="threadbit ghost missing_box">
	<div class="icon"><img src="archive/assets/new/images/statusicon/thread_lock.png" alt="" width="32" height="32"></div>
	<div class="threadinfo">
		<h3 class="threadtitle"><span><?= e(missing_label($missing, 'thread')) ?>, but the Wayback Machine never archived them.</span></h3>
		<div class="threadmeta">This is everything that survived of this forum. The rest of its threads are gone.</div>
	</div>
</li>
