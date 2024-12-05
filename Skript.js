// Анимация появления элементов при скролле
document.addEventListener('DOMContentLoaded', function() {
    // Функция для плавного появления элементов
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.1 });

    // Добавляем наблюдение за всеми элементами, которые должны анимироваться
    const animateElements = document.querySelectorAll('.plugin-card, .gallery-item, .server-description, .image-container');
    animateElements.forEach(element => {
        observer.observe(element);
    });

    // Анимация модального окна авторизации
    const modal = document.getElementById('authModal');
    const authButton = document.getElementById('authButton');
    const closeBtn = document.querySelector('.close');

    if (authButton) {
        authButton.addEventListener('click', () => {
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        });
    }

    // Закрытие модального окна при клике вне его
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    });



});

// Переключение табов в форме авторизации
function showTab(tabName) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const tabs = document.querySelectorAll('.tab-btn');

    if (tabName === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        tabs[0].classList.add('active');
        tabs[1].classList.remove('active');
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        tabs[0].classList.remove('active');
        tabs[1].classList.add('active');
    }
}

