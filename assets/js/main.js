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

document.addEventListener('DOMContentLoaded', function() {
    // PARAMETROS URL
    const siteOrigin = window.location.origin;
    const params = new URLSearchParams(window.location.search);
    params.delete('s');

    if ([...params].length === 0) return;

    const queryString = params.toString();

    function updateLink(link) {
        try {
            const url = new URL(link.href, siteOrigin);

            if (url.origin === siteOrigin) {
                url.search = queryString;
                link.href = url.toString();
            }
        } catch (e) {
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

    document.querySelectorAll('a').forEach(updateLink);
    document.querySelectorAll('form').forEach(updateForm);

    const observer = new MutationObserver(() => {
        document.querySelectorAll('a').forEach(updateLink);
        document.querySelectorAll('form').forEach(updateForm);
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
