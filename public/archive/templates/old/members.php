<?php defined('VM_ARCHIVE') or exit;
$crumb_last = 'Member List';
?>
<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
<thead>
	<tr><td class="tcat" colspan="4">Member List &ndash; <?= num($total_members) ?> members</td></tr>
	<tr align="center">
		<td class="thead" align="left">Username</td>
		<td class="thead" width="220">Title</td>
		<td class="thead" width="110">Join Date</td>
		<td class="thead" width="70">Posts</td>
	</tr>
</thead>
<tbody>
<?php foreach ($members as $m): ?>
<tr>
	<td class="alt1"><?= name_html($m) ?></td>
	<td class="alt2"><?= e($m['title'] ?: '') ?></td>
	<td class="alt1"><?= e($m['joined'] ?: '-') ?></td>
	<td class="alt2" align="right"><?= num($m['posts']) ?></td>
</tr>
<?php endforeach ?>
<?php if (!$members): ?><tr><td class="alt1" colspan="4" align="center">No members on this page.</td></tr><?php endif ?>
</tbody>
</table>
<?php partial($theme, 'pagenav', ['pager' => $pager]) ?>
<div class="notice_box">
	<strong>Colour key:</strong>
	&nbsp;<span style="color:black;font-weight:bold">Super Admin</span> &middot;
	<span style="color:red;font-weight:bold">Server Admin</span> &middot;
	<span style="color:purple">Super Donator</span> &middot;
	<span style="color:green">Donator</span> &middot;
	<span style="color:red;font-weight:bold;text-decoration:line-through">Banned</span>
</div>
<div class="notice_box">Missing your name? It might not have been archived by the Internet Archive... Thanks for playing anyways!</div>
