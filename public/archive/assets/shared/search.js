/**
 * Client-side search for the forum archive. Runs entirely against window.VM_SEARCH
 * (see build-search-index.php), no network requests. Shared by both skins; each skin
 * supplies its own #vm-search-input / #vm-search-results and a search.css for the look.
 */
(function () {
	'use strict';

	var data = window.VM_SEARCH;
	var input = document.getElementById('vm-search-input');
	var panel = document.getElementById('vm-search-results');
	if (!data || !input || !panel) {
		return;
	}
	document.body.appendChild(panel); // fixed-position overlay: escape any clipping/stacking ancestors

	var MAX_POSTS = 25;
	var MAX_USERS = 6;
	var authorFilter = null; // when set, results show only this author's posts
	var debounceTimer = null;

	function escapeHtml(s) {
		return String(s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}

	function escapeRegExp(s) {
		return String(s).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
	}

	function highlight(text, tokens) {
		var escaped = escapeHtml(text);
		if (!tokens.length) {
			return escaped;
		}
		var re = new RegExp('(' + tokens.map(escapeRegExp).join('|') + ')', 'ig');
		return escaped.replace(re, '<mark>$1</mark>');
	}

	function snippet(text, tokens) {
		var lower = text.toLowerCase();
		var pos = -1;
		for (var i = 0; i < tokens.length; i++) {
			var found = lower.indexOf(tokens[i]);
			if (found !== -1 && (pos === -1 || found < pos)) {
				pos = found;
			}
		}
		var radius = 70;
		var start = pos === -1 ? 0 : Math.max(0, pos - radius);
		var end = pos === -1 ? Math.min(text.length, radius * 2) : Math.min(text.length, pos + radius);
		var out = text.slice(start, end);
		if (start > 0) {
			out = '…' + out;
		}
		if (end < text.length) {
			out += '…';
		}
		return highlight(out, tokens);
	}

	function formatDate(iso) {
		if (!iso) {
			return '';
		}
		var d = new Date(iso);
		if (isNaN(d.getTime())) {
			return '';
		}
		var dd = String(d.getUTCDate()).padStart(2, '0');
		var mm = String(d.getUTCMonth() + 1).padStart(2, '0');
		return dd + '-' + mm + '-' + d.getUTCFullYear();
	}

	function positionPanel() {
		var r = input.getBoundingClientRect();
		panel.style.left = Math.round(r.left) + 'px';
		panel.style.top = Math.round(r.bottom + 4) + 'px';
		panel.style.minWidth = Math.round(Math.max(r.width, 280)) + 'px';
	}

	function postUrl(post) {
		var tid = post[0], pid = post[1], page = post[2];
		return 'archive.php?t=' + tid + (page > 1 ? '&p=' + page : '') + '#post' + pid;
	}

	function render(query) {
		var tokens = query.toLowerCase().split(/\s+/).filter(Boolean);
		var html = '';

		if (authorFilter) {
			var mine = data.posts.filter(function (p) {
				return p[3] && p[3].toLowerCase() === authorFilter.toLowerCase();
			});
			mine.sort(function (a, b) {
				return (b[4] || '').localeCompare(a[4] || '');
			});
			html += '<div class="vm-sr-authorbar">'
				+ 'Posts by <strong>' + escapeHtml(authorFilter) + '</strong> (' + mine.length + ')'
				+ ' <button type="button" class="vm-sr-clear" data-vm-clear>Back to search</button>'
				+ '</div>';
			html += renderPosts(mine.slice(0, 200), []);
			panel.innerHTML = html;
			positionPanel();
			panel.hidden = false;
			return;
		}

		if (!tokens.length) {
			panel.hidden = true;
			panel.innerHTML = '';
			return;
		}

		var matchingUsers = data.users.filter(function (u) {
			var lu = u.toLowerCase();
			return tokens.some(function (t) { return lu.indexOf(t) !== -1; });
		}).slice(0, MAX_USERS);

		var matchingPosts = data.posts.filter(function (p) {
			var thread = data.threads[p[0]];
			var title = thread ? thread[0] : '';
			var hay = (title + ' ' + p[3] + ' ' + p[5]).toLowerCase();
			return tokens.every(function (t) { return hay.indexOf(t) !== -1; });
		});

		matchingPosts.sort(function (a, b) {
			return score(b, tokens) - score(a, tokens);
		});

		if (matchingUsers.length) {
			html += '<div class="vm-sr-heading">Members</div>';
			html += '<div class="vm-sr-users">' + matchingUsers.map(function (u) {
				return '<button type="button" class="vm-sr-user" data-vm-user="' + escapeHtml(u) + '">'
					+ highlight(u, tokens) + '</button>';
			}).join('') + '</div>';
		}

		if (matchingPosts.length) {
			html += '<div class="vm-sr-heading">Posts (' + matchingPosts.length + (matchingPosts.length > MAX_POSTS ? ', showing ' + MAX_POSTS : '') + ')</div>';
			html += renderPosts(matchingPosts.slice(0, MAX_POSTS), tokens);
		}

		if (!matchingUsers.length && !matchingPosts.length) {
			html = '<div class="vm-sr-empty">No matches for &ldquo;' + escapeHtml(query) + '&rdquo;.</div>';
		}

		panel.innerHTML = html;
		positionPanel();
		panel.hidden = false;
	}

	function score(post, tokens) {
		var thread = data.threads[post[0]];
		var title = (thread ? thread[0] : '').toLowerCase();
		var author = (post[3] || '').toLowerCase();
		var text = post[5].toLowerCase();
		var s = 0;
		tokens.forEach(function (t) {
			if (title.indexOf(t) !== -1) s += 100;
			if (author === t) s += 60;
			else if (author.indexOf(t) !== -1) s += 20;
			var idx = text.indexOf(t);
			while (idx !== -1) {
				s += 1;
				idx = text.indexOf(t, idx + t.length);
			}
		});
		return s;
	}

	function renderPosts(posts, tokens) {
		return '<div class="vm-sr-posts">' + posts.map(function (p) {
			var thread = data.threads[p[0]] || ['(unknown thread)', '', 0];
			return '<a class="vm-sr-post" href="' + postUrl(p) + '">'
				+ '<div class="vm-sr-title">' + highlight(thread[0], tokens) + '</div>'
				+ '<div class="vm-sr-snippet">' + snippet(p[5], tokens) + '</div>'
				+ '<div class="vm-sr-meta">by <span class="vm-sr-author">' + escapeHtml(p[3] || 'unknown') + '</span>'
				+ ' &middot; ' + escapeHtml(formatDate(p[4]))
				+ (thread[1] ? ' &middot; in ' + escapeHtml(thread[1]) : '')
				+ '</div>'
				+ '</a>';
		}).join('') + '</div>';
	}

	function onInput() {
		authorFilter = null; // typing always returns to a live search, even from an author filter
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(function () {
			render(input.value.trim());
		}, 120);
	}

	panel.addEventListener('click', function (e) {
		var userBtn = e.target.closest('[data-vm-user]');
		if (userBtn) {
			authorFilter = userBtn.getAttribute('data-vm-user');
			render(input.value.trim());
			return;
		}
		if (e.target.closest('[data-vm-clear]')) {
			authorFilter = null;
			render(input.value.trim());
		}
	});

	input.addEventListener('input', onInput);
	input.addEventListener('focus', function () {
		if (input.value.trim() || authorFilter) {
			render(input.value.trim());
		}
	});
	input.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			panel.hidden = true;
			authorFilter = null;
			input.blur();
		} else if (e.key === 'Enter') {
			e.preventDefault();
			var first = panel.querySelector('.vm-sr-post');
			if (first) {
				window.location.href = first.getAttribute('href');
			}
		}
	});
	document.addEventListener('click', function (e) {
		if (!panel.contains(e.target) && e.target !== input) {
			panel.hidden = true;
		}
	});
	window.addEventListener('resize', function () {
		if (!panel.hidden) {
			positionPanel();
		}
	});
	window.addEventListener('scroll', function () {
		if (!panel.hidden) {
			positionPanel();
		}
	}, true);
	var form = input.closest('form');
	if (form) {
		form.addEventListener('submit', function (e) { e.preventDefault(); });
	}
})();
