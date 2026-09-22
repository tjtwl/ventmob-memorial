<?php defined('VM_ARCHIVE') or exit;
/** @var array $rows forum rows from site.json / forums/<fid>.json */
foreach ($rows as $r):
    $last = $r['last'];
    $recent = $last && substr((string) $last['date'], 0, 4) === '2011';
?>
<li class="forumbit_post L2" id="forum<?= (int) $r['fid'] ?>">
	<div class="forumrow table">
		<div class="foruminfo td">
			<img class="forumicon" src="archive/assets/new/images/statusicon/<?= $recent ? 'forum_new-48' : 'forum_old-48' ?>.png" alt="">
			<div class="forumdata"><div class="datacontainer">
				<div class="titleline"><h2 class="forumtitle"><a href="<?= e(url_forum($r['fid'])) ?>"><?= e($r['name']) ?></a></h2><?php if ($r['viewing']): ?><span class="viewing">(<?= (int) $r['viewing'] ?> Viewing)</span><?php endif ?></div>
				<?php if ($r['desc']): ?><p class="forumdescription"><?= e($r['desc']) ?></p><?php endif ?>
				<?php if ($r['subs']): ?><div class="subforumline"><strong>Sub-Forums:</strong>
					<?= implode(', ', array_map(fn ($s) => '<a href="' . e(url_forum($s['fid'])) . '">' . e($s['name']) . '</a>', $r['subs'])) ?></div><?php endif ?>
			</div></div>
		</div>
		<h4 class="nocss_label">Forum Statistics:</h4>
		<ul class="forumstats td"><li>Threads: <?= num($r['threads']) ?></li><li>Posts: <?= num($r['posts']) ?></li></ul>
		<div class="forumlastpost td">
			<h4 class="lastpostlabel">Last Post:</h4>
			<?php if ($last): ?>
			<div>
				<p class="lastposttitle"><?php if ($last['linkable']): ?><a class="threadtitle" href="<?= e(url_thread($last['tid'])) ?>"><?= e(truncate($last['title'], 30)) ?></a><?php else: ?><span class="noplace" title="This thread was not preserved"><?= e(truncate($last['title'], 30)) ?></span><?php endif ?></p>
				<div class="lastpostby">by <?= e($last['author'] ?? 'unknown') ?></div>
				<p class="lastpostdate"><?= e(fmt_date($last['date'])) ?>, <span class="time"><?= e(fmt_time($last['date'])) ?></span></p>
			</div>
			<?php else: ?><div><p class="lastposttitle noplace">Never</p></div><?php endif ?>
		</div>
	</div>
</li>
<?php endforeach ?>
