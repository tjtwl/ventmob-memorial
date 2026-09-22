<?php defined('VM_ARCHIVE') or exit; ?>
<?php if ($pager): ?>
<div class="pagenav" align="right">
<table class="tborder pagenav_t" cellpadding="3" cellspacing="0" border="0">
<tr>
	<td class="vbmenu_control" style="font-weight:normal">Page <?= $pager['cur'] ?> of <?= $pager['pages'] ?></td>
	<?php if ($pager['first']): ?><td class="alt1"><a class="smallfont" href="<?= e($pager['first']) ?>">&laquo; First</a></td><?php endif ?>
	<?php if ($pager['prev']): ?><td class="alt1"><a class="smallfont" href="<?= e($pager['prev']) ?>">&lt;</a></td><?php endif ?>
	<?php foreach ($pager['items'] as $item): ?>
		<?php if ($item === null): ?><td class="alt1">&hellip;</td>
		<?php elseif ($item['current']): ?><td class="alt2"><span class="smallfont"><strong><?= $item['n'] ?></strong></span></td>
		<?php else: ?><td class="alt1"><a class="smallfont" href="<?= e($item['href']) ?>"><?= $item['n'] ?></a></td><?php endif ?>
	<?php endforeach ?>
	<?php if ($pager['next']): ?><td class="alt1"><a class="smallfont" href="<?= e($pager['next']) ?>">&gt;</a></td><?php endif ?>
	<?php if ($pager['last']): ?><td class="alt1"><a class="smallfont" href="<?= e($pager['last']) ?>">Last &raquo;</a></td><?php endif ?>
</tr>
</table>
</div>
<?php endif ?>
