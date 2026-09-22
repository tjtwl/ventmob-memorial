<?php defined('VM_ARCHIVE') or exit; ?>
<div id="pagetitle" class="pagetitle"><h1>Member List <small>(<?= num($total_members) ?> members)</small></h1></div>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_top']) ?>
<div class="blockbody" style="margin-top:6px">
<div class="blockrow">
<table cellpadding="6" cellspacing="0" border="0" width="100%" style="border-collapse:collapse">
<thead>
	<tr style="text-align:left;border-bottom:2px solid #6b91ab">
		<th style="padding:6px">Username</th>
		<th style="padding:6px">Title</th>
		<th style="padding:6px">Join Date</th>
		<th style="padding:6px;text-align:right">Posts</th>
	</tr>
</thead>
<tbody>
<?php foreach ($members as $m): ?>
<tr style="border-bottom:1px solid #dde5ea">
	<td style="padding:6px"><?= name_html($m) ?></td>
	<td style="padding:6px"><?= e($m['title'] ?: '') ?></td>
	<td style="padding:6px"><?= e($m['joined'] ?: '-') ?></td>
	<td style="padding:6px;text-align:right"><?= num($m['posts']) ?></td>
</tr>
<?php endforeach ?>
<?php if (!$members): ?><tr><td colspan="4" style="padding:12px;text-align:center">No members on this page.</td></tr><?php endif ?>
</tbody>
</table>
</div>
</div>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_bottom']) ?>
<div class="notice_box" style="margin-top:10px">
	<strong>Colour key:</strong>
	&nbsp;<span style="color:black;font-weight:bold">Super Admin</span> &middot;
	<span style="color:red;font-weight:bold">Server Admin</span> &middot;
	<span style="color:purple">Super Donator</span> &middot;
	<span style="color:green">Donator</span> &middot;
	<span style="color:red;font-weight:bold;text-decoration:line-through">Banned</span>
</div>
<div class="notice_box">Missing your name? It might not have been archived by the Internet Archive... Thanks for playing anyways!</div>
