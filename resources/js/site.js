import './bootstrap';

const onReady = (callback) => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
    } else {
        callback();
    }
};

onReady(() => {
    const menuTrigger = document.querySelector('[data-site-menu-trigger]');
    const menuPanel = document.querySelector('[data-site-menu-panel]');

    if (menuTrigger && menuPanel) {
        menuPanel.classList.add('hidden');
        menuTrigger.setAttribute('aria-expanded', 'false');

        const toggleMenu = () => {
            const isOpen = menuTrigger.getAttribute('aria-expanded') === 'true';
            const nextIsOpen = !isOpen;
            menuTrigger.setAttribute('aria-expanded', nextIsOpen ? 'true' : 'false');
            menuPanel.classList.toggle('hidden', !nextIsOpen);
        };

        menuTrigger.addEventListener('click', (event) => {
            event.preventDefault();
            toggleMenu();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                menuTrigger.setAttribute('aria-expanded', 'false');
                menuPanel.classList.add('hidden');
            }
        });

        menuPanel.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener('click', () => {
                menuTrigger.setAttribute('aria-expanded', 'false');
                menuPanel.classList.add('hidden');
            });
        });
    }

    const newsletterForm = document.querySelector('[data-site-newsletter]');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const emailInput = newsletterForm.querySelector('input[type="email"]');
            const submitButton = newsletterForm.querySelector('button[type="submit"]');

            if (!emailInput || !submitButton) {
                return;
            }

            const email = (emailInput.value || '').trim();

            if (!email) {
                emailInput.focus();
                return;
            }

            const originalLabel = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = 'Enviando...';

            window.setTimeout(() => {
                submitButton.innerHTML = 'Inscrição recebida!';
                emailInput.value = '';

                window.setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalLabel;
                }, 2500);
            }, 900);
        });
    }
});
