document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchBiscuit');
    const suggestions = document.getElementById('searchSuggestions');
    const selects = document.querySelectorAll('.filter-select');

    // Gérer la recherche
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestions.classList.remove('visible');
            return;
        }

        searchTimeout = setTimeout(() => {
            const searchUrl = searchInput.getAttribute('data-search-url');
            fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestions.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.id}">
                                <span class="emoji">${item.emoji}</span>
                                <div class="details">
                                    <div class="name">${item.nom_biscuit}</div>
                                    <div class="saveur">${item.nom_saveur}</div>
                                </div>
                            </div>
                        `).join('');
                        suggestions.classList.add('visible');
                    } else {
                        suggestions.innerHTML = '<div class="suggestion-item" style="color: var(--ink-soft);">Aucun résultat trouvé</div>';
                        suggestions.classList.add('visible');
                    }
                })
                .catch(error => {
                    console.error('Erreur de recherche:', error);
                    suggestions.classList.remove('visible');
                });
        }, 300);
    });

    // Cacher les suggestions au clic ailleurs
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.classList.remove('visible');
        }
    });

    // Soumettre le formulaire lors de la sélection d'une suggestion
    suggestions.addEventListener('click', function(e) {
        const item = e.target.closest('.suggestion-item');
        if (item) {
            searchInput.value = item.querySelector('.name').textContent.trim();
            searchInput.closest('form').submit();
        }
    });

    // Gérer les filtres
    selects.forEach(select => {
        select.addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            
            // Mettre à jour les paramètres
            if (this.value) {
                params.set(this.name, this.value);
            } else {
                params.delete(this.name);
            }

            // Conserver la recherche si elle existe
            const search = searchInput.value.trim();
            if (search) {
                params.set('search', search);
            }

            // Recharger la page avec les filtres
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        });
    });
});