/**
 * Category blacklist for the "add content" form (modal #forum_blog_formModal).
 *
 * While a user types a NEW category name, the name is compared with the list of forbidden names
 * (Admin panel -> Settings -> Category Blacklist). If it matches, the field is marked as invalid
 * and the submit button is disabled. This is only a convenience for the user: the same check
 * is repeated on the server (Model::isCategoryBlacklisted), so it can not be bypassed.
 */
(function () {
  'use strict';

  // Must stay identical to Model::normalizeCategoryName() on the server
  function normalizeName(value) {
    return String(value || '')
        .toLowerCase()
        .replace(/\u0451/g, '\u0435')   // cyrillic yo -> ye
        .replace(/\s+/g, ' ')
        .trim();
  }

  document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('category-form');
    var select = document.getElementById('category-select');
    var input = document.getElementById('category-input');

    if (!form || !select || !input) {
      return;
    }

    var submitBtn = form.querySelector('input[type="submit"]');

    var blacklist = [];
    try {
      blacklist = JSON.parse(form.getAttribute('data-category-blacklist') || '[]');
    } catch (e) {
      blacklist = [];
    }
    blacklist = blacklist.map(normalizeName).filter(Boolean);

    // Message under the field (Bootstrap shows it when the input has .is-invalid)
    var feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = 'This category name is not allowed.';
    input.parentNode.insertBefore(feedback, input.nextSibling);

    function isForbidden() {
      // An existing category is chosen from the list: nothing is being created
      if (select.value !== '') {
        return false;
      }
      var name = normalizeName(input.value);
      return name !== '' && blacklist.indexOf(name) !== -1;
    }

    function check() {
      var forbidden = isForbidden();
      input.classList.toggle('is-invalid', forbidden);
      if (submitBtn) {
        submitBtn.disabled = forbidden; // also blocks sending the form with Enter
      }
      return forbidden;
    }

    input.addEventListener('input', check);
    select.addEventListener('change', check);

    // Safety net in case the button was re-enabled by something else
    form.addEventListener('submit', function (event) {
      if (check()) {
        event.preventDefault();
      }
    });

    // index.js resets the fields when the modal opens; this handler is registered after it,
    // so it runs after the reset and clears a stale "invalid" state.
    // The handler must NOT return a value: jQuery treats "return false" as preventDefault(),
    // which would cancel the opening of the modal.
    if (window.jQuery) {
      window.jQuery('#forum_blog_formModal').on('show.bs.modal', function () {
        check();
      });
    }

    check();
  });
})();