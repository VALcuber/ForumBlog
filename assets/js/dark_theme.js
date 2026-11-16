/**
 * Theme switch in the user profile (templates/user_profile.tpl, block #themeSwitch).
 * The new theme is applied at once and saved in the database (users.theme) in the background.
 */
document.addEventListener('DOMContentLoaded', function () {
    var box = document.getElementById('themeSwitch');
    if (!box) {
        return;
    }

    var buttons = box.querySelectorAll('.theme-btn');
    var status = box.querySelector('.theme-status');
    var current = box.getAttribute('data-current') === 'light' ? 'light' : 'dark';
    var statusTimer = null;

    function mark(theme) {
        buttons.forEach(function (btn) {
            var active = btn.getAttribute('data-theme') === theme;
            btn.classList.toggle('active', active);
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    function apply(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        mark(theme);
    }

    function say(text, clearAfter) {
        if (!status) {
            return;
        }
        status.textContent = text;
        clearTimeout(statusTimer);
        if (clearAfter) {
            statusTimer = setTimeout(function () { status.textContent = ''; }, clearAfter);
        }
    }

    mark(current);

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var theme = btn.getAttribute('data-theme');
            if (theme === current) {
                return;
            }

            var previous = current;
            current = theme;
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
                    // Not saved: go back to the previous theme so the page matches the database
                    current = previous;
                    apply(previous);
                    say('Could not save the theme', 4000);
                });
        });
    });
});