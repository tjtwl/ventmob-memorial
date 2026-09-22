<?php defined('VM_ARCHIVE') or exit; ?>
<div id="forumhome" class="forumhome">
<ol id="forums" class="floatcontainer">
<?php foreach ($categories as $cat): ?>
<li class="forumbit_nopost L1" id="cat<?= (int) $cat['fid'] ?>">
	<div class="forumhead foruminfo L1 collapse">
		<h2><span class="forumtitle"><?php if ($cat['fid']): ?><a href="<?= e(url_forum($cat['fid'])) ?>"><?= e($cat['name']) ?></a><?php else: ?><?= e($cat['name']) ?><?php endif ?></span><span class="forumlastpost">Last Post</span></h2>
	</div>
	<ol class="childforum" id="c_cat<?= (int) $cat['fid'] ?>">
	<?php partial($theme, 'forumbits', ['rows' => $cat['rows']]) ?>
	</ol>
</li>
<?php endforeach ?>
</ol>
<?php partial($theme, 'online', ['online' => $online, 'label' => '']) ?>
<div class="blockbody" style="margin-top:12px">
	<h2 class="blockhead">Forum Statistics</h2>
	<div class="blockrow">
		<p>Threads: <?= num($stats['threads']) ?>, Posts: <?= num($stats['posts']) ?>, Members: <?= num($stats['members']) ?></p>
		<p>Welcome to our newest member, <strong><?= e($stats['newest']) ?></strong></p>
		<p>Most users ever online was <?= e($stats['record']) ?>.</p>
		<p class="simulated_note">Forum totals are the real figures from the last capture of this skin (<?= e(str_replace('-', '/', $stats['date'])) ?>). Only part of the forum survived, so not every thread is browsable.</p>
	</div>
</div>
</div>
