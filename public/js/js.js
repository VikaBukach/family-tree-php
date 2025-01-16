document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-surname');

    function filterCards() {
        const query = searchInput.value.trim().toLowerCase(); // запит користувача
        const cards = document.querySelectorAll('.card');// динамічно отрим усі картки

        cards.forEach(card => {


            const surnameEl = card.querySelector('.list-group-item');// ел з прізвищем
            if (surnameEl) {
                const surname = surnameEl.textContent.trim().toLowerCase();
                if (surname.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    searchInput.addEventListener('input', filterCards);  // подія для пошукового поля

    // перевіряємо, якщо катки додаю динамічно
    const container = document.querySelector('.container');
    const observer = new MutationObserver(filterCards); // спостерігач за змінами у DOM

    observer.observe(container, {childList: true, subtree: true}); // стеже за додаванням чи видаленням карток
});
