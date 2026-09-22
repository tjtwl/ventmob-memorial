<?php defined('VM_ARCHIVE') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=1010">
<meta name="robots" content="noindex">
<title><?= e($title) ?> - VentMob forum archive (2009 skin)</title>
<link rel="icon" href="favicon.ico">
<link rel="stylesheet" href="archive/assets/old/style.css">
<link rel="stylesheet" href="archive/assets/shared/search.css">
<link rel="stylesheet" href="archive/assets/old/search.css">
</head>
<body>
<?php partial($theme, 'bar', ['toggle' => $toggle]) ?>
<div id="header_outer">
<div id="wrapper">
	<div id="header">
		<a class="logo" href="archive.php"><img src="assets/images/ventmob_logo.png" alt="||VM|| Vent Mob Community"></a>
		<div id="nav">
			<ul>
				<li><a href="index.php">Memorial</a></li>
				<li><a href="archive.php">Forum</a></li>
				<li><a href="archive.php?members=1">Members List</a></li>
				<li><span title="Not part of the archive">FAQ</span></li>
				<li><span title="Not part of the archive">Calendar</span></li>
				<li><span title="Not part of the archive">Search</span></li>
			</ul>
		</div>
	</div>
	<div id="container">
	<div id="border">
		<div id="subnav">
			<ul>
				<li><span>Register</span></li>
				<li><span>Rules</span></li>
				<li><span>Today's Posts</span></li>
			</ul>
			<div id="searchbar"><strong>Search:</strong> &nbsp;<input type="text" id="vm-search-input" class="searchinput" autocomplete="off" placeholder="posts or a username&hellip;"></div>
		</div>
		<div id="navbar">
			<table class="navbar_table navbar" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
			<tr>
				<td class="navbar_left" width="100%">
					<a href="archive.php">||VM|| Vent Mob Community</a>
					<?php foreach ($crumbs as $crumb): ?>
					<span class="navbar">&gt; <a href="<?= e(url_forum($crumb['fid'])) ?>"><?= e($crumb['name']) ?></a></span>
					<?php endforeach ?>
					<?php if ($crumb_last): ?><div style="font-size:12px;padding-top:6px"><strong><?= e($crumb_last) ?></strong></div><?php endif ?>
				</td>
				<td class="navbar_right" nowrap="nowrap"><strong>Welcome, Guest!</strong><br>You are browsing a preserved copy.</td>
			</tr>
			</table>
		</div>
		<div id="page">
<?= $content ?>
		</div>
	</div>
	</div>
</div>
</div>
<div id="footer">
	<table class="footer_table" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
			VentMob forum archive &middot; original forum 2008&ndash;2011 &middot; rebuilt from Wayback Machine captures<br>
			Powered by vBulletin&reg; Version 3.8.4 &middot; skin rebuilt from the captured "Pulse Red" stylesheet
		</td>
		<td align="right"><a href="index.php">Back to the memorial</a> &nbsp; <a href="<?= e($toggle) ?>">Switch skin</a></td>
	</tr>
	</table>
</div>
<div id="vm-search-results" hidden></div>
<script src="archive/assets/shared/search-index.js" defer></script>
<script src="archive/assets/shared/search.js" defer></script>
</body>
</html>
