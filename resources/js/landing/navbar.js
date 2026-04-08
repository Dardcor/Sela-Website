const navWrap = document.querySelector('.navbar-wrap');

window.addEventListener('scroll', () => {
    if (navWrap) {
        navWrap.classList.toggle('scrolled', window.scrollY > 20);
    }
});
