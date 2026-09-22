<?php defined('VM_ARCHIVE') or exit;
/** @var ?array $pager  @var string $cls */
if (!$pager) { return; }
$img = 'archive/assets/new/images/pagination/';
?>
<div class="<?= e($cls) ?>"><div class="pagination static floatcontainer">
	<span class="pgtext">Page <?= $pager['cur'] ?> of <?= $pager['pages'] ?></span>
	<?php if ($pager['first']): ?><span class="first_last"><a href="<?= e($pager['first']) ?>"><img src="<?= $img ?>first-right.png" alt="First">First</a></span><?php endif ?>
	<?php if ($pager['prev']): ?><span class="prev_next"><a href="<?= e($pager['prev']) ?>"><img src="<?= $img ?>previous-right.png" alt="Previous"></a></span><?php endif ?>
	<?php foreach ($pager['items'] as $item): ?>
		<?php if ($item === null): ?><span class="gap pgtext">&hellip;</span>
		<?php elseif ($item['current']): ?><span class="selected"><a href="<?= e($item['href']) ?>"><?= $item['n'] ?></a></span>
		<?php else: ?><span><a href="<?= e($item['href']) ?>"><?= $item['n'] ?></a></span><?php endif ?>
	<?php endforeach ?>
	<?php if ($pager['next']): ?><span class="prev_next"><a href="<?= e($pager['next']) ?>"><img src="<?= $img ?>next-right.png" alt="Next"></a></span><?php endif ?>
	<?php if ($pager['last']): ?><span class="first_last"><a href="<?= e($pager['last']) ?>">Last<img src="<?= $img ?>last-right.png" alt="Last"></a></span><?php endif ?>
</div></div>
