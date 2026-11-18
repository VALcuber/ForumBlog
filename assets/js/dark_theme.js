/**
 * Theme switch in the user profile (block #themeSwitch).
 * The block is created dynamically by profile.js when SETTINGS is clicked,
 * so clicks are handled on document (event delegation), not on the buttons directly.
 */
(function () {
    var statusTimer = null;

    function currentTheme() {
        return document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    }

    function mark(theme) {
        var box = document.getElementById('themeSwitch');
        if (!box) {
            return;
        }
        box.querySelectorAll('.theme-btn').forEach(function (btn) {
            var active = btn.getAttribute('data-theme') === theme;
            btn.classList.toggle('active', active);
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    function say(text, clearAfter) {
        var status = document.querySelector('#themeSwitch .theme-status');
        if (!status) {
            return;
        }
        status.textContent = text;
        clearTimeout(statusTimer);
        if (clearAfter) {
            statusTimer = setTimeout(function () { status.textContent = ''; }, clearAfter);
        }
    }

    function apply(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        mark(theme);
    }

    // Capture phase: works even if some handler calls stopPropagation()
    document.addEventListener('click', function (e) {
        var btn = e.target.closest ? e.target.closest('.theme-btn') : null;
        if (!btn || !btn.closest('#themeSwitch')) {
            return;
        }

        var theme = btn.getAttribute('data-theme');
        var previous = currentTheme();
        if (theme === previous) {
            return;
        }

        apply(theme);
        say('Saving...');

        fetch('/user_profile', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: 'act=' + encodeURIComponent('Set theme') + '&theme=' + encodeURIComponent(theme)
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || !data.ok) {
                    throw new Error('not saved');
                }
                say('Saved', 2000);
            })
            .catch(function () {
                apply(previous); // not saved: go back so the page matches the database
                say('Could not save the theme', 4000);
            });
    }, true);

    // Highlight the active button when the block appears (after SETTINGS is clicked)
    document.addEventListener('DOMContentLoaded', function () {
        new MutationObserver(function () {
            mark(currentTheme());
        }).observe(document.body, { childList: true, subtree: true });
    });
})();