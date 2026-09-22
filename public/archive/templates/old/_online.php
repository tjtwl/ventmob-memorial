<?php defined('VM_ARCHIVE') or exit;
/** @var array $online  @var string $label */
$names = implode(', ', array_map('name_html', $online['members']));
?>
<?php if ($online['kind'] === 'index'): ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead><tr><td class="tcat" colspan="2">What's Going On?</td></tr></thead>
<tbody>
<tr><td class="thead" colspan="2">Currently Active Users: <?= $online['total'] ?> (<?= count($online['members']) ?> members and <?= $online['guests'] ?> guests)</td></tr>
<tr><td class="alt1" colspan="2"><span class="smallfont"><?= $names ?></span>
<div class="simulated_note">Online lists are simulated: names are drawn at random from the forum's members.</div></td></tr>
</tbody>
</table>
<?php else: ?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead><tr><td class="thead"><?= e($label) ?>: <?= $online['total'] ?> (<?= count($online['members']) ?> members and <?= $online['guests'] ?> guests)</td></tr></thead>
<?php if ($online['members']): ?><tbody><tr><td class="alt1"><span class="smallfont"><?= $names ?></span></td></tr></tbody><?php endif ?>
</table>
<?php endif ?>
