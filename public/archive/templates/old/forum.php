<?php defined('VM_ARCHIVE') or exit; ?>
<h1 style="font-size:16px;margin:0 0 8px;color:#333"><?= e($forum['name']) ?></h1>
<?php if ($forum['desc']): ?><div class="smallfont" style="margin-bottom:8px"><?= e($forum['desc']) ?></div><?php endif ?>
<?php if ($forum['subrows']): ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead>
	<tr><td class="tcat" colspan="5"><?= $forum['is_cat'] ? 'Forums in this category' : 'Sub-Forums' ?></td></tr>
	<tr align="center"><td class="thead" width="30">&nbsp;</td><td class="thead" align="left">Forum</td><td class="thead" width="218">Last Post</td><td class="thead" width="56">Threads</td><td class="thead" width="56">Posts</td></tr>
</thead>
<tbody><?php partial($theme, 'forumrows', ['rows' => $forum['subrows']]) ?></tbody>
</table>
<?php endif ?>
<?php if ($rows || !$forum['subrows']): ?>
<?php partial($theme, 'pagenav', ['pager' => $pager]) ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead>
	<tr><td class="tcat" colspan="6">Threads in Forum<?php if ($forum['threads']): ?> &ndash; <?= count($forum['threads']) ?> listed<?php endif ?></td></tr>
	<tr>
		<td class="thead" colspan="2">&nbsp;</td>
		<td class="thead" width="100%">Thread / Thread Starter</td>
		<td class="thead" width="150" align="center">Last Post</td>
		<td class="thead" align="center">Replies</td>
		<td class="thead" align="center">Views</td>
	</tr>
</thead>
<tbody>
<?php foreach ($rows as $r): ?>
<tr<?= $r['linkable'] ? '' : ' class="thread_ghost"' ?>>
	<td class="alt1" width="26"><img src="archive/assets/old/img/<?= ($r['replies'] ?? 0) >= 15 ? 'thread_hot' : 'thread' ?>.png" alt="" width="20" height="20"></td>
	<td class="alt2" width="1"></td>
	<td class="alt1" align="left">
		<div><?php if ($r['linkable']): ?><a href="<?= e(url_thread($r['tid'])) ?>"><?= e($r['title']) ?></a><?php else: ?><span class="ttl" title="This thread's posts were not preserved"><?= e($r['title']) ?></span><?php endif ?>
		<?php if ($r['partial']): ?><span class="partial_tag" title="Only some pages of this thread survive">[partial]</span><?php endif ?>
		<?php if (!$r['linkable']): ?><span class="partial_tag">[not preserved]</span><?php endif ?></div>
		<div class="smallfont"><?= e($r['author'] ?? 'unknown') ?></div>
	</td>
	<td class="alt2">
		<div class="smallfont" style="text-align:right;white-space:nowrap">
		<?php if ($r['last_date']): ?><?= e(fmt_date($r['last_date'])) ?> <span class="time"><?= e(fmt_time($r['last_date'])) ?></span><br>by <?= e($r['last_author'] ?? 'unknown') ?><?php else: ?>&ndash;<?php endif ?>
		</div>
	</td>
	<td class="alt1" align="center"><?= num($r['replies']) ?></td>
	<td class="alt2" align="center"><?= num($r['views']) ?></td>
</tr>
<?php endforeach ?>
<?php if (!$rows): ?><tr><td class="alt1" colspan="6" align="center">No threads from this forum were preserved.</td></tr><?php endif ?>
<?php if ($is_last) { partial($theme, 'missing_thread', ['forum' => $forum]); } ?>
</tbody>
</table>
<?php partial($theme, 'pagenav', ['pager' => $pager]) ?>
<?php endif ?>
<br>
<?php partial($theme, 'online', ['online' => $online, 'label' => 'Users Viewing This Forum']) ?>
