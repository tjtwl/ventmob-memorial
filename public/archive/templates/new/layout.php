<?php defined('VM_ARCHIVE') or exit; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title><?= e($title) ?> - VentMob forum archive (2011 skin)</title>
<link rel="icon" href="favicon.ico">
<link rel="stylesheet" href="archive/assets/new/style.css">
<style>
  h2.blockhead { background: none; border: none; }
  .postcontainer { border-top-left-radius: 5px; border-top-right-radius: 5px; overflow: hidden; }
</style>
</head>
<body>
<div class="archive_bar">
	<strong>Forum archive</strong> &mdash; a preserved copy of the VentMob forums (2008&ndash;2011), rebuilt from Wayback Machine captures.
	Skin: <a href="<?= e($toggle) ?>">2009</a> | <strong>2011</strong>
	&middot; <a href="index.php">Back to the memorial</a>
</div>
<div class="above_body">
<div id="header" class="floatcontainer doc_header">
	<div><a name="top" href="archive.php" class="logo-image"><img src="assets/images/ventmob_logo.png" alt="||VM|| Vent Mob Community" title="||VM|| Vent Mob Community"></a></div>
	<div id="toplinks" class="toplinks">
		<ul class="nouser">
			<li><span>Register</span></li>
			<li><span>Help</span></li>
		</ul>
	</div>
	<hr>
</div>
<div id="navbar" class="navbar">
	<ul id="navtabs" class="navtabs floatcontainer">
		<li><a class="navtab" href="index.php">Memorial</a></li>
		<li class="<?= $title === 'Member List' ? '' : 'selected' ?>"><a class="navtab" href="archive.php">Forum</a></li>
		<li class="<?= $title === 'Member List' ? 'selected' : '' ?>"><a class="navtab" href="archive.php?members=1">Member List</a></li>
		<li class="off"><span class="navtab">Donations</span></li>
		<li class="off"><span class="navtab">Bans</span></li>
				<li class="off"><span class="navtab">What's New?</span></li>
	</ul>
	<div id="globalsearch" class="globalsearch">
		<form class="navbar_search" action="#">
			<span class="textboxcontainer"><span><input type="text" class="textbox" disabled></span></span>
			<span class="buttoncontainer"><span><input type="image" class="searchbutton" src="archive/assets/new/images/buttons/search.png" alt="Search" disabled></span></span>
		</form>
	</div>
</div>
</div>
<div class="body_wrapper">
<div id="breadcrumb" class="breadcrumb">
	<ul class="floatcontainer">
		<li class="navbithome"><a href="archive.php" accesskey="1"><img src="archive/assets/new/images/misc/navbit-home.png" alt="Home" title="Forum index"></a></li>
		<?php foreach ($crumbs as $crumb): ?>
		<li class="navbit"><a href="<?= e(url_forum($crumb['fid'])) ?>"><?= e($crumb['name']) ?></a></li>
		<?php endforeach ?>
		<li class="navbit lastnavbit"><span><?= e($title) ?></span></li>
	</ul>
	<hr>
</div>
<?= $content ?>
<div id="footer" class="floatcontainer footer">
	<ul id="footer_links" class="footer_links">
		<li><a href="index.php">Back to the memorial</a></li>
		<li><a href="archive.php">||VM|| Vent Mob Community</a></li>
		<li><a href="<?= e($toggle) ?>">Switch skin</a></li>
		<li><a href="#top">Top</a></li>
	</ul>
</div>
</div>
<div class="below_body">
	<div id="footer_time" class="shade footer_time">Preserved copy &middot; forum totals and skin as captured on <?= e(str_replace('-', '/', $stats['date'])) ?>.</div>
	<div id="footer_copyright" class="shade footer_copyright">Powered by vBulletin&reg; Version 4.1.3<br>Copyright &copy; 2011 vBulletin Solutions, Inc. All rights reserved. Archive rebuilt from Wayback Machine captures.</div>
</div>
</body>
</html>
