<?php defined('VM_ARCHIVE') or exit; ?>
<div id="pagetitle" class="pagetitle"><h1>Thread: <span class="threadtitle"><?= e($thread['title']) ?></span></h1></div>
<?php if ($thread['partial']): ?>
<div class="notice_box">Only part of this thread survives: <?= (int) $thread['preserved'] ?><?= $thread['expected'] ? ' of ' . (int) $thread['expected'] : '' ?> posts were captured<?= $thread['expected'] ? '' : ' (some pages are missing)' ?>. Posts are shown in the order they were written.</div>
<?php endif ?>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_top']) ?>
<div id="postlist" class="postlist restrain">
<ol id="posts" class="posts" start="<?= (int) $first_no ?>">
<?php foreach ($posts as $p):
    $u = $thread['users'][$p['author']];
    $joined = $p['joined'] ?: $u['joined'];
    $count = $p['author_posts'] ?: $u['posts'];
?>
<li class="postbitlegacy postbitim postcontainer" id="post_<?= (int) $p['pid'] ?>">
	<div class="posthead">
		<span class="postdate old"><span class="date"><?= e(fmt_date($p['date'])) ?><span class="time"> <?= e(fmt_time($p['date'])) ?></span></span></span>
		<span class="nodecontrols"><a class="postcounter" name="post<?= (int) $p['pid'] ?>" href="#post<?= (int) $p['pid'] ?>"><?= $p['num'] ? '#' . (int) $p['num'] . ' &middot; ' : '' ?>#<?= (int) $p['pid'] ?></a></span>
	</div>
	<div class="postdetails">
		<div class="userinfo">
			<div class="username_container">
				<a class="username offline popupctrl" href="#post<?= (int) $p['pid'] ?>" title="<?= e($u['name']) ?>"><strong><?= name_html($u) ?></strong></a>
				<img class="inlineimg onlinestatus" src="archive/assets/new/images/statusicon/user-offline.png" alt="offline">
			</div>
			<span class="usertitle"><?= e($p['usertitle'] ?: $u['title'] ?: '') ?></span>
			<?php if ($u['avatar']): ?><a class="postuseravatar" href="#post<?= (int) $p['pid'] ?>"><img src="archive/assets/shared/avatars/<?= e($u['avatar']) ?>" alt=""></a><?php endif ?>
			<hr>
			<dl class="userinfo_extra">
				<?php if ($joined): ?><dt>Join Date</dt> <dd><?= e($joined) ?></dd><?php endif ?>
				<?php if ($count): ?><dt>Posts</dt> <dd><?= e(num($count)) ?></dd><?php endif ?>
			</dl>
		</div>
		<div class="postbody">
			<div class="postrow has_after_content">
				<div class="content">
					<?php if ($p['title']): ?><h2 class="title icon"><?= e($p['title']) ?></h2><?php endif ?>
					<div id="post_message_<?= (int) $p['pid'] ?>"><blockquote class="postcontent restore"><?= $p['html'] /* sanitized at build time */ ?></blockquote></div>
					<?php if ($p['edited']): ?><div class="postlinking" style="font-size:11px;color:#888;margin-top:6px"><em><?= e($p['edited']) ?></em></div><?php endif ?>
				</div>
			</div>
			<?php if ($p['sig']): ?><div class="after_content"><blockquote class="signature restore"><div class="signaturecontainer"><?= $p['sig'] ?></div></blockquote></div><?php endif ?>
			<div class="cleardiv"></div>
		</div>
	</div>
	<hr>
</li>
<?php endforeach ?>
</ol>
<?php if ($thread['partial'] && $is_last) { partial($theme, 'missing_post', ['thread' => $thread]); } ?>
</div>
<?php partial($theme, 'pagination', ['pager' => $pager, 'cls' => 'pagination_bottom']) ?>
<?php partial($theme, 'online', ['online' => $online, 'label' => 'Users Browsing this Thread']) ?>
