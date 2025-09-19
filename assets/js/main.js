document.addEventListener("DOMContentLoaded", () => {
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    // MENU MOBILE
    const menu = document.querySelector('#mobile-menu');
    const menuBtn = document.querySelector('#mobile-menu-btn');
    const closeMenuBtn = document.querySelector('#close-mobile-menu');

    function openMenu() {
        menu.removeEventListener('animationend', hideMenu); // remove listener antigo
        menu.classList.remove('hidden', 'animate-slide-lr-out');
        menu.classList.add('animate-slide-lr-in');
    }

    function hideMenu() {
        menu.classList.add('hidden');
    }

    function closeMenu() {
        menu.removeEventListener('animationend', hideMenu);
        menu.classList.remove('animate-slide-lr-in');
        menu.classList.add('animate-slide-lr-out');
        menu.addEventListener('animationend', hideMenu, { once: true });
    }

    menuBtn.addEventListener('click', openMenu);
    closeMenuBtn.addEventListener('click', closeMenu);

    const searchBtn = document.querySelector('#search-btn');
    const search = document.querySelector('#search');
    let searchOpen = false;

    function hideSearch() {
        search.classList.add('hidden');
    }

    searchBtn.addEventListener('click', () => {
        search.removeEventListener('animationend', hideSearch);

        if (!searchOpen) {
            search.classList.remove('hidden', 'animate-slide-up');
            search.classList.add('animate-slide-down');
            searchOpen = true;
        } else {
            search.classList.remove('animate-slide-down');
            search.classList.add('animate-slide-up');
            search.addEventListener('animationend', hideSearch, { once: true });
            searchOpen = false;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    if (document.body.classList.contains('wp-admin') || (window.wp && window.wp.customize)) {
        return;
    }

    const siteOrigin = window.location.origin;
    const params = new URLSearchParams(window.location.search);
    params.delete('s');

    if ([...params].length === 0) return;

    const queryString = params.toString();

    function updateLink(link) {
        try {
            const url = new URL(link.href, siteOrigin);

            if (url.origin === siteOrigin) {
                const existingParams = new URLSearchParams(url.search);
                params.forEach((value, key) => {
                    existingParams.set(key, value);
                });
                url.search = existingParams.toString();
                link.href = url.toString();
            }
        } catch (e) {
            console.error(e);
        }
    }

    function updateForm(form) {
        form.querySelectorAll('input.keep-param').forEach(el => el.remove());

        params.forEach((value, key) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            input.classList.add('keep-param');
            form.appendChild(input);
        });
    }

    function runUpdates() {
        document.querySelectorAll('a:not([data-gprodemi-processed])').forEach(link => {
            updateLink(link);
            link.setAttribute('data-gprodemi-processed', 'true');
        });
        document.querySelectorAll('form:not([data-gprodemi-processed])').forEach(form => {
            updateForm(form);
            form.setAttribute('data-gprodemi-processed', 'true');
        });
    }

    runUpdates();

    const observer = new MutationObserver(runUpdates);
    observer.observe(document.body, { childList: true, subtree: true });
});
