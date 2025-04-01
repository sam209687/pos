export function initializeSearch(inputSelector, itemsSelector) {
    const searchInput = document.querySelector(inputSelector);
    const items = document.querySelectorAll(itemsSelector);

    searchInput?.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}
