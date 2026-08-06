// HOLISTICS — shared front-end behavior
document.addEventListener('DOMContentLoaded', function () {

  // Footer year
  document.querySelectorAll('[data-year]').forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });

  // Mobile nav toggle
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.querySelector('.main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
      var expanded = nav.classList.contains('open');
      toggle.setAttribute('aria-expanded', expanded);
    });
    nav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { nav.classList.remove('open'); });
    });
  }

  // Hero slider (home page)
  var slides = document.querySelectorAll('.hero-slide');
  if (slides.length) {
    var dotsWrap = document.querySelector('.slider-dots');
    var current = 0;
    var timer;

    function goTo(i) {
      slides[current].classList.remove('active');
      if (dotsWrap) dotsWrap.children[current].classList.remove('active');
      current = (i + slides.length) % slides.length;
      slides[current].classList.add('active');
      if (dotsWrap) dotsWrap.children[current].classList.add('active');
    }

    if (dotsWrap) {
      slides.forEach(function (_, i) {
        var b = document.createElement('button');
        if (i === 0) b.classList.add('active');
        b.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        b.addEventListener('click', function () { goTo(i); restart(); });
        dotsWrap.appendChild(b);
      });
    }

    document.querySelectorAll('.slider-arrow.next').forEach(function (btn) {
      btn.addEventListener('click', function () { goTo(current + 1); restart(); });
    });
    document.querySelectorAll('.slider-arrow.prev').forEach(function (btn) {
      btn.addEventListener('click', function () { goTo(current - 1); restart(); });
    });

    function restart() {
      clearInterval(timer);
      timer = setInterval(function () { goTo(current + 1); }, 6000);
    }
    restart();
  }

  // Team filter (specialty + search)
  var teamGrid = document.querySelector('[data-team-grid]');
  if (teamGrid) {
    var cards = Array.from(teamGrid.querySelectorAll('.team-card'));
    var chips = document.querySelectorAll('.filter-chips button');
    var searchInput = document.querySelector('[data-team-search]');
    var noResults = document.querySelector('.no-results');
    var activeSpecialty = 'all';

    function applyFilter() {
      var q = (searchInput && searchInput.value || '').trim().toLowerCase();
      var visibleCount = 0;
      cards.forEach(function (card) {
        var specialty = card.getAttribute('data-specialty');
        var name = card.getAttribute('data-name').toLowerCase();
        var matchesSpecialty = activeSpecialty === 'all' || specialty === activeSpecialty;
        var matchesSearch = !q || name.indexOf(q) !== -1;
        var show = matchesSpecialty && matchesSearch;
        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });
      if (noResults) noResults.classList.toggle('show', visibleCount === 0);
    }

    chips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        chips.forEach(function (c) { c.classList.remove('active'); });
        chip.classList.add('active');
        activeSpecialty = chip.getAttribute('data-specialty');
        applyFilter();
      });
    });
    if (searchInput) searchInput.addEventListener('input', applyFilter);
  }

  // Contact / inquiry form now posts to the real Laravel route
  // (see resources/views/pages/contact.blade.php) — no JS interception
  // needed. This block just shows a friendlier per-field validation
  // message if any Laravel validation errors were flashed to the page.
});
