const navWrap = document.querySelector('.navbar-wrap');

window.addEventListener('scroll', () => {
    if (navWrap) {
        navWrap.classList.toggle('scrolled', window.scrollY > 20);
    }
});

const hamburgerBtn = document.getElementById('hamburger-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (hamburgerBtn && mobileMenu) {
    hamburgerBtn.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.contains('menu-open');
        if (isOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu || e.target === mobileMenu.querySelector('.absolute')) {
            closeMobileMenu();
        }
    });

    mobileMenu.querySelectorAll('.mobile-nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            closeMobileMenu();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu.classList.contains('menu-open')) {
            closeMobileMenu();
        }
    });
}

function openMobileMenu() {
    mobileMenu.classList.add('menu-open');
    hamburgerBtn.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    mobileMenu.classList.remove('menu-open');
    hamburgerBtn.classList.remove('active');
    document.body.style.overflow = '';
}
