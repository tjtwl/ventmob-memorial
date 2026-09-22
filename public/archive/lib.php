<?php
/**
 * Helpers for the forum archive: data loading, formatting, pagination, simulated "online now" lists, rendering.
 * Not meant to be requested directly (see .htaccess); loaded by archive.php.
 */
defined('VM_ARCHIVE') or exit;

const ARCHIVE_DIR = __DIR__;
const THEMES = ['old', 'new'];

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Load a JSON file from archive/data/, or null when it does not exist. */
function load_json(string $relative): ?array
{
    $path = ARCHIVE_DIR . '/data/' . $relative;
    if (!is_file($path)) {
        return null;
    }
    $decoded = json_decode((string) file_get_contents($path), true);
    return is_array($decoded) ? $decoded : null;
}

function url_forum(int $fid, int $page = 1): string
{
    return 'archive.php?f=' . $fid . ($page > 1 ? '&p=' . $page : '');
}

function url_thread(int $tid, int $page = 1): string
{
    return 'archive.php?t=' . $tid . ($page > 1 ? '&p=' . $page : '');
}

function fmt_date(?string $iso): string
{
    return $iso ? (new DateTimeImmutable($iso))->format('d-m-Y') : '';
}

function fmt_time(?string $iso): string
{
    return $iso ? (new DateTimeImmutable($iso))->format('h:i A') : '';
}

function num($value): string
{
    return $value === null ? '-' : number_format((int) $value);
}

function truncate(string $text, int $length): string
{
    return mb_strlen($text) > $length ? rtrim(mb_substr($text, 0, $length - 3)) . '...' : $text;
}

/** A username, coloured/bold/struck-through the way it was on the forum. Name and colour are escaped here. */
function name_html(array $user): string
{
    $style = '';
    if (!empty($user['color']) && preg_match('/^(#[0-9a-fA-F]{3,6}|[a-zA-Z]+)$/', $user['color'])) {
        $style .= 'color:' . $user['color'] . ';';
    }
    if (!empty($user['bold'])) {
        $style .= 'font-weight:bold;';
    }
    if (!empty($user['strike'])) {
        $style .= 'text-decoration:line-through;';
    }
    return '<span class="u"' . ($style ? ' style="' . e($style) . '"' : '') . '>' . e($user['name']) . '</span>';
}

/**
 * Pagination model: ['cur', 'pages', 'items' => [null | ['n', 'href', 'current']], 'prev', 'next', 'first', 'last'].
 * $href is a callable taking a page number.
 */
function paginate(int $cur, int $pages, callable $href): ?array
{
    if ($pages <= 1) {
        return null;
    }
    $items = [];
    $last = 0;
    for ($n = 1; $n <= $pages; $n++) {
        if ($n === 1 || $n === $pages || abs($n - $cur) <= 3) {
            if ($n - $last > 1) {
                $items[] = null;
            }
            $items[] = ['n' => $n, 'href' => $href($n), 'current' => $n === $cur];
            $last = $n;
        }
    }
    return [
        'cur' => $cur,
        'pages' => $pages,
        'items' => $items,
        'prev' => $cur > 1 ? $href($cur - 1) : null,
        'next' => $cur < $pages ? $href($cur + 1) : null,
        'first' => $cur > 1 ? $href(1) : null,
        'last' => $cur < $pages ? $href($pages) : null,
    ];
}

/**
 * Simulated "online now" / "browsing this thread": random usernames from the archive's member pool.
 * $month (YYYY-MM) keeps the list plausible for the era: only users who had already joined are drawn.
 */
function pick_online(string $kind, string $month): array
{
    static $pool = null;
    $pool ??= load_json('users.json') ?? [];
    $eligible = array_values(array_filter($pool, fn ($u) => ($u['s'] ?? '0000-00') <= $month));

    $wanted = $kind === 'thread' ? random_int(0, 4) : random_int(5, 14);
    $guests = $kind === 'thread' ? random_int(0, 6) : random_int(3, 20);
    $members = [];
    if ($eligible) {
        $keys = (array) array_rand($eligible, min($wanted, count($eligible)) ?: 1);
        foreach (array_slice($keys, 0, $wanted) as $key) {
            $u = $eligible[$key];
            $members[] = ['name' => $u['n'], 'color' => $u['c'] ?? null, 'bold' => !empty($u['b']), 'strike' => !empty($u['k'])];
        }
        usort($members, fn ($a, $b) => strcasecmp($a['name'], $b['name']));
    }
    return ['kind' => $kind, 'members' => $members, 'guests' => $guests, 'total' => count($members) + $guests];
}

/** Include a template partial with its own variable scope. */
function partial(string $theme, string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include ARCHIVE_DIR . "/templates/$theme/_$name.php";
}

/** Render a page template inside the skin's layout. */
function render_page(string $theme, string $page, array $vars): void
{
    $vars += ['theme' => $theme, 'crumbs' => [], 'crumb_last' => null];
    extract($vars, EXTR_SKIP);
    ob_start();
    include ARCHIVE_DIR . "/templates/$theme/$page.php";
    $content = ob_get_clean();
    include ARCHIVE_DIR . "/templates/$theme/layout.php";
}

/** "N more posts existed here" wording for the not-archived banners; $missing null = amount unknown. */
function missing_label(?int $missing, string $noun): string
{
    if ($missing === null) {
        return "More {$noun}s existed here";
    }
    return number_format($missing) . ' more ' . $noun . ($missing === 1 ? '' : 's') . ' existed here';
}
