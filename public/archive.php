<?php
/**
 * VentMob forum archive: a read-only replica of the old forums, in the two skins the forum had.
 *
 *   archive.php                 board index
 *   archive.php?f=ID[&p=N]      forum / category
 *   archive.php?t=ID[&p=N]      thread
 *   archive.php?theme=old|new   switch skin (remembered in a cookie), then redirects to the clean URL
 *
 * Content comes from archive/data/*.json (generated from the Wayback Machine scrape) and is rendered
 * through archive/templates/<skin>/.
 */

define('VM_ARCHIVE', true);
require __DIR__ . '/archive/lib.php';

$theme = $_COOKIE['vm_theme'] ?? 'old';
if (!in_array($theme, THEMES, true)) {
    $theme = 'old';
}

if (isset($_GET['theme']) && in_array($_GET['theme'], THEMES, true)) {
    setcookie('vm_theme', $_GET['theme'], [
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'samesite' => 'Lax',
    ]);
    $query = $_GET;
    unset($query['theme']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . ($query ? '?' . http_build_query($query) : ''), true, 302);
    exit;
}

$site = load_json('site.json');
if ($site === null) {
    http_response_code(503);
    header('Content-Type: text/plain; charset=UTF-8');
    echo "The forum archive data has not been installed.\n";
    exit;
}

$page = isset($_GET['p']) ? max(1, (int) $_GET['p']) : 1;
$other = $theme === 'old' ? 'new' : 'old';
$route = array_intersect_key($_GET, ['t' => 1, 'f' => 1, 'p' => 1]);
$common = [
    'stats' => $site['stats'][$theme],
    'toggle' => 'archive.php?' . http_build_query($route + ['theme' => $other]),
];

header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-cache'); // the "online now" lists are random on every load

if (isset($_GET['t'])) {
    $thread = load_json('threads/' . (int) $_GET['t'] . '.json');
    $pages = $thread ? max(1, (int) ceil(count($thread['posts']) / $site['per_page'])) : 0;
    if ($thread && $page <= $pages) {
        $tid = $thread['tid'];
        $posts = array_slice($thread['posts'], ($page - 1) * $site['per_page'], $site['per_page']);
        render_page($theme, 'thread', $common + [
            'title' => $thread['title'],
            'crumbs' => $thread['crumbs'],
            'thread' => $thread,
            'posts' => $posts,
            'first_no' => ($page - 1) * $site['per_page'] + 1,
            'pager' => paginate($page, $pages, fn ($n) => url_thread($tid, $n)),
            'is_last' => $page === $pages,
            'online' => pick_online('thread', substr($thread['last_date'] ?? $common['stats']['date'], 0, 7)),
        ]);
        exit;
    }
} elseif (isset($_GET['f'])) {
    $forum = load_json('forums/' . (int) $_GET['f'] . '.json');
    $pages = $forum ? max(1, (int) ceil(count($forum['threads']) / $site['threads_per_page'])) : 0;
    if ($forum && $page <= $pages) {
        $fid = $forum['fid'];
        render_page($theme, 'forum', $common + [
            'title' => $forum['name'],
            'crumbs' => $forum['crumbs'],
            'forum' => $forum,
            'rows' => array_slice($forum['threads'], ($page - 1) * $site['threads_per_page'], $site['threads_per_page']),
            'pager' => paginate($page, $pages, fn ($n) => url_forum($fid, $n)),
            'is_last' => $page === $pages,
            'online' => pick_online('thread', substr($common['stats']['date'], 0, 7)),
        ]);
        exit;
    }
} else {
    render_page($theme, 'index', $common + [
        'title' => 'Forum',
        'categories' => $site['categories'],
        'online' => pick_online('index', substr($common['stats']['date'], 0, 7)),
    ]);
    exit;
}

http_response_code(404);
render_page($theme, 'notfound', $common + ['title' => 'Page not found']);
