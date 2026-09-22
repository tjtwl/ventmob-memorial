<?php defined('VM_ARCHIVE') or exit;
/** @var array $online  @var string $label */
$names = implode(', ', array_map('name_html', $online['members']));
?>
<?php if ($online['kind'] === 'index'): ?>
<div id="wgo" class="wgo_block">
	<h2 class="blockhead" style="margin-top:14px">Currently Active Users: <?= $online['total'] ?></h2>
	<div class="blockbody"><div class="blockrow">
		<p><?= count($online['members']) ?> members and <?= $online['guests'] ?> guests</p>
		<p class="wgo_list"><?= $names ?></p>
		<p class="simulated_note">Online lists are simulated: names are drawn at random from the forum's members.</p>
	</div></div>
</div>
<?php else: ?>
<div class="blockbody" style="margin-top:12px"><h2 class="blockhead"><?= e($label) ?>: <?= $online['total'] ?> (<?= count($online['members']) ?> members and <?= $online['guests'] ?> guests)</h2>
<?php if ($online['members']): ?><div class="blockrow"><?= $names ?></div><?php endif ?></div>
<?php endif ?>
