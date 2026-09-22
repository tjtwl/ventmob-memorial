<?php defined('VM_ARCHIVE') or exit;
/** @var array $thread */
$missing = $thread['expected'] ? max(0, (int) $thread['expected'] - (int) $thread['preserved']) : null;
?>
<ol class="posts" style="margin-top:0"><li class="postbitlegacy postcontainer missing_box">
	<div class="posthead"><span class="postdate old"><span class="date">Not archived</span></span><span class="nodecontrols"><span class="postcounter">#?</span></span></div>
	<div class="postdetails">
		<div class="userinfo">
			<div class="username_container"><strong class="u">Lost to time</strong></div>
			<span class="usertitle">Missing posts</span>
		</div>
		<div class="postbody"><div class="postrow"><div class="content">
			<h2 class="title icon"><?= e(missing_label($missing, 'post')) ?></h2>
			<blockquote class="postcontent restore"><strong>The Wayback Machine never archived them.</strong><br>What you see above is everything that survived of this thread. The rest of the conversation is gone.</blockquote>
		</div></div><div class="cleardiv"></div></div>
	</div>
	<hr>
</li></ol>
