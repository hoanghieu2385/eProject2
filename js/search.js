document.getElementById('search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const query = document.getElementById('search').value;
    
    fetch(`search.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';
            
            if (data.length === 0) {
                resultsContainer.innerHTML = '<p>No results found</p>';
                return;
            }
            
            const resultsList = document.createElement('ul');
            data.forEach(item => {
                const listItem = document.createElement('li');
                const link = document.createElement('a');
                link.href = `product.php?id=${item.id}`;
                link.textContent = item.name;
                listItem.appendChild(link);
                resultsList.appendChild(listItem);
            });
            resultsContainer.appendChild(resultsList);
        })
        .catch(error => console.error('Error fetching search results:', error));
});
