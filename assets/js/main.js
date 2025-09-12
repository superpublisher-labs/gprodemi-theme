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
        menu.removeEventListener('animationend', hideMenu); // remove listener antigo
        menu.classList.remove('animate-slide-lr-in');
        menu.classList.add('animate-slide-lr-out');
        menu.addEventListener('animationend', hideMenu, { once: true });
    }

    menuBtn.addEventListener('click', openMenu);
    closeMenuBtn.addEventListener('click', closeMenu);

    // BUSCA
    const searchBtn = document.querySelector('#search-btn');
    const search = document.querySelector('#search');
    let searchOpen = false;

    function hideSearch() {
        search.classList.add('hidden');
    }

    searchBtn.addEventListener('click', () => {
        search.removeEventListener('animationend', hideSearch); // remove listener antigo

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