<?php defined('VM_ARCHIVE') or exit; ?>
<div id="pagetitle" class="pagetitle"><h1><?= e($forum['name']) ?></h1><?php if ($forum['desc']): ?><p class="description"><?= e($forum['desc']) ?></p><?php endif ?></div>
<?php if ($forum['subrows']): ?>
<ol id="forums" class="floatcontainer">
<li class="forumbit_nopost L1">
	<div class="forumhead foruminfo L1 collapse"><h2><span class="forumtitle"><?= $forum['is_cat'] ? 'Forums in this category' : 'Sub-Forums' ?></span><span class="forumlastpost">Last Post</span></h2></div>
	<ol class="childforum"><?php partial($theme, 'forumbits', ['rows' => $forum['subrows']]) ?></ol>
</li>
</ol>
<?php endif ?>
<?php if ($rows || !$forum['subrows']): ?>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_top']) ?>
<div id="threadlist" class="threadlist">
	<div class="threadlisthead"><div><span class="c1">Threads in this forum<?php if ($forum['threads']): ?> (<?= count($forum['threads']) ?> listed)<?php endif ?> / Thread starter</span><span class="c2">Replies / Views</span><span class="c3">Last post</span></div></div>
	<ol id="threads" class="threads">
	<?php foreach ($rows as $r): ?>
	<li class="threadbit<?= $r['linkable'] ? '' : ' ghost' ?>">
		<div class="icon"><img src="archive/assets/new/images/statusicon/<?= ($r['replies'] ?? 0) >= 15 ? 'thread_hot' : 'thread' ?>.png" alt="" width="32" height="32"></div>
		<div class="threadinfo">
			<h3 class="threadtitle"><?php if ($r['linkable']): ?><a class="title" href="<?= e(url_thread($r['tid'])) ?>"><?= e($r['title']) ?></a><?php else: ?><span title="This thread's posts were not preserved"><?= e($r['title']) ?></span><?php endif ?>
			<?php if ($r['partial']): ?><span class="partial_tag" title="Only some pages of this thread survive">[partial]</span><?php endif ?>
			<?php if (!$r['linkable']): ?><span class="partial_tag">[not preserved]</span><?php endif ?></h3>
			<div class="threadmeta">Started by <?= e($r['author'] ?? 'unknown') ?><?= $r['date'] ? ', ' . e(fmt_date($r['date'])) : '' ?></div>
		</div>
		<ul class="threadstats"><li>Replies: <?= num($r['replies']) ?></li><li>Views: <?= num($r['views']) ?></li></ul>
		<div class="threadlastpost"><?php if ($r['last_date']): ?><span class="who"><?= e($r['last_author'] ?? 'unknown') ?></span><br><?= e(fmt_date($r['last_date'])) ?> <span class="time"><?= e(fmt_time($r['last_date'])) ?></span><?php else: ?>&ndash;<?php endif ?></div>
	</li>
	<?php endforeach ?>
	<?php if (!$rows): ?><li class="threadbit"><div class="threadinfo" style="text-align:center;padding:16px">No threads from this forum were preserved.</div></li><?php endif ?>
	<?php if ($is_last) { partial($theme, 'missing_thread', ['forum' => $forum]); } ?>
	</ol>
</div>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_bottom']) ?>
<?php endif ?>
<?php partial($theme, 'online', ['online' => $online, 'label' => 'Users Viewing This Forum']) ?>
