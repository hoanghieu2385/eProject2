document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const suggestionsList = document.createElement('ul');
    suggestionsList.className = 'suggestions-list';
    searchInput.parentNode.appendChild(suggestionsList);

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = this.value.trim();
            if (query.length > 0) {
                fetchSuggestions(query);
            } else {
                clearSuggestions();
            }
        }, 300);
    });

    function fetchSuggestions(query) {
        fetch(`../includes/search_suggestions.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySuggestions(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function displaySuggestions(suggestions) {
        clearSuggestions();
        suggestions.forEach(suggestion => {
            const li = document.createElement('li');
            li.className = 'suggestion-item';

            if (suggestion.type === 'album') {
                li.innerHTML = `
                    <a href="product-detail.php?id=${suggestion.id}" class="suggestion-link">
                        <div class="suggestion-image">
                            <img src="${suggestion.image}" alt="${suggestion.name}">
                        </div>
                        <div class="suggestion-info">
                            <div class="suggestion-name">${suggestion.name}</div>
                            <div class="suggestion-artist">${suggestion.artist}</div>
                            <div class="suggestion-price">$${suggestion.price}</div>
                        </div>
                    </a>
                `;
            } else if (suggestion.type === 'artist') {
                li.innerHTML = `
                    <a href="artist-detail.php?id=${suggestion.id}" class="suggestion-link">
                        <div class="suggestion-info">
                            <div class="suggestion-name">${suggestion.name}</div>
                            <div class="suggestion-type">Artist</div>
                        </div>
                    </a>
                `;
            }

            suggestionsList.appendChild(li);
        });
    }

    function clearSuggestions() {
        suggestionsList.innerHTML = '';
    }

    // Close suggestions when clicking outside
    document.addEventListener('click', function (event) {
        if (!searchInput.contains(event.target) && !suggestionsList.contains(event.target)) {
            clearSuggestions();
        }
    });
});