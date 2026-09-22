<?php defined('VM_ARCHIVE') or exit;
$crumb_last = $thread['title'];
?>
<h1 style="font-size:16px;margin:0 0 8px;color:#333"><?= e($thread['title']) ?></h1>
<?php if ($thread['partial']): ?>
<div class="notice_box">Only part of this thread survives: <?= (int) $thread['preserved'] ?><?= $thread['expected'] ? ' of ' . (int) $thread['expected'] : '' ?> posts were captured<?= $thread['expected'] ? '' : ' (some pages are missing)' ?>. Posts are shown in the order they were written.</div>
<?php endif ?>
<?php partial($theme, 'pagenav', ['pager' => $pager]) ?>
<?php foreach ($posts as $p):
    $u = $thread['users'][$p['author']];
    $joined = $p['joined'] ?: $u['joined'];
    $count = $p['author_posts'] ?: $u['posts'];
?>
<table class="tborder" id="post<?= (int) $p['pid'] ?>" cellpadding="6" cellspacing="0" border="0" width="100%" align="center" style="margin-bottom:10px">
<tr>
	<td class="thead">
		<div class="normal" style="float:right"><?= $p['num'] ? '#' . (int) $p['num'] . ' &middot; ' : '' ?>#<?= (int) $p['pid'] ?></div>
		<div class="normal"><?= e(fmt_date($p['date'])) ?><?= $p['date'] ? ', ' . e(fmt_time($p['date'])) : '' ?></div>
	</td>
</tr>
<tr>
	<td class="alt2" style="padding:0">
		<table cellpadding="0" cellspacing="6" border="0" width="100%">
		<tr>
			<?php if ($u['avatar']): ?><td class="alt2 avatar_box"><img src="archive/assets/shared/avatars/<?= e($u['avatar']) ?>" alt=""></td><?php endif ?>
			<td nowrap="nowrap">
				<div class="bigusername"><?= name_html($u) ?></div>
				<div class="smallfont"><?= e($p['usertitle'] ?: $u['title'] ?: '') ?></div>
			</td>
			<td width="100%">&nbsp;</td>
			<td valign="top" nowrap="nowrap">
				<div class="smallfont">
					<?php if ($joined): ?><div>Join Date: <?= e($joined) ?></div><?php endif ?>
					<?php if ($count): ?><div>Posts: <?= e(num($count)) ?></div><?php endif ?>
				</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="alt1">
		<?php if ($p['title']): ?><div class="smallfont"><strong><?= e($p['title']) ?></strong></div><hr size="1" style="color:#ddd;background-color:#ddd"><?php endif ?>
		<div class="postbit_msg"><?= $p['html'] /* sanitized at build time */ ?></div>
		<?php if ($p['edited']): ?><div class="smallfont" style="margin-top:8px"><em><?= e($p['edited']) ?></em></div><?php endif ?>
		<?php if ($p['sig']): ?><div class="postbit_sig" style="margin-top:10px">__________________<br><?= $p['sig'] ?></div><?php endif ?>
	</td>
</tr>
</table>
<?php endforeach ?>
<?php if ($thread['partial'] && $is_last) { partial($theme, 'missing_post', ['thread' => $thread]); } ?>
<?php partial($theme, 'pagenav', ['pager' => $pager]) ?>
<?php partial($theme, 'online', ['online' => $online, 'label' => 'Users Browsing this Thread']) ?>
