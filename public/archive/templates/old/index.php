<?php defined('VM_ARCHIVE') or exit; ?>
<?php foreach ($categories as $cat): ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead>
	<tr><td class="tcat" colspan="5"><?php if ($cat['fid']): ?><a class="catlink" href="<?= e(url_forum($cat['fid'])) ?>"><?= e($cat['name']) ?></a><?php else: ?><?= e($cat['name']) ?><?php endif ?></td></tr>
	<tr align="center">
		<td class="thead" width="30">&nbsp;</td>
		<td class="thead" align="left">Forum</td>
		<td class="thead" width="218">Last Post</td>
		<td class="thead" width="56">Threads</td>
		<td class="thead" width="56">Posts</td>
	</tr>
</thead>
<tbody>
<?php partial($theme, 'forumrows', ['rows' => $cat['rows']]) ?>
</tbody>
</table>
<?php endforeach ?>
<?php partial($theme, 'online', ['online' => $online, 'label' => '']) ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center" style="margin-top:14px">
<thead><tr><td class="tcat">Forum Statistics</td></tr></thead>
<tbody>
<tr><td class="alt1"><div class="smallfont">
	Threads: <?= num($stats['threads']) ?>, Posts: <?= num($stats['posts']) ?>, Members: <?= num($stats['members']) ?><br>
	Welcome to our newest member, <strong><?= e($stats['newest']) ?></strong><br>
	Most users ever online was <?= e($stats['record']) ?>.
	<div class="simulated_note">Forum totals are the real figures from the last capture of this skin (<?= e(str_replace('-', '/', $stats['date'])) ?>). Only part of the forum survived, so not every thread is browsable.</div>
</div></td></tr>
</tbody>
</table>
