<?php defined('VM_ARCHIVE') or exit;
/** @var array $rows forum rows from site.json / forums/<fid>.json */
foreach ($rows as $r):
    $last = $r['last'];
    $recent = $last && substr((string) $last['date'], 0, 4) === '2011';
?>
<tr align="center">
	<td class="alt2"><img src="archive/assets/old/img/<?= $recent ? 'forum_new' : 'forum_old' ?>.png" alt="" width="24" height="24"></td>
	<td align="left" class="alt1Active">
		<div><a href="<?= e(url_forum($r['fid'])) ?>"><strong><?= e($r['name']) ?></strong></a><?php if ($r['viewing']): ?> <span class="smallfont">(<?= (int) $r['viewing'] ?> Viewing)</span><?php endif ?></div>
		<?php if ($r['desc']): ?><div class="smallfont"><?= e($r['desc']) ?></div><?php endif ?>
		<?php if ($r['subs']): ?><div class="smallfont subline"><strong>Sub-Forums:</strong>
			<?= implode(', ', array_map(fn ($s) => '<a href="' . e(url_forum($s['fid'])) . '">' . e($s['name']) . '</a>', $r['subs'])) ?></div><?php endif ?>
	</td>
	<td class="alt2">
		<div class="lastpost_bg"><div align="left" class="smallfont">
		<?php if ($last): ?>
			<div style="white-space:nowrap"><?php if ($last['linkable']): ?><a href="<?= e(url_thread($last['tid'])) ?>"><strong><?= e(truncate($last['title'], 28)) ?></strong></a><?php else: ?><strong title="This thread was not preserved"><?= e(truncate($last['title'], 28)) ?></strong><?php endif ?></div>
			<div style="white-space:nowrap">by <?= e($last['author'] ?? 'unknown') ?></div>
			<div align="right" style="white-space:nowrap"><?= e(fmt_date($last['date'])) ?> <span class="time"><?= e(fmt_time($last['date'])) ?></span></div>
		<?php else: ?>Never<?php endif ?>
		</div></div>
	</td>
	<td class="alt1"><?= num($r['threads']) ?></td>
	<td class="alt2"><?= num($r['posts']) ?></td>
</tr>
<?php endforeach ?>
