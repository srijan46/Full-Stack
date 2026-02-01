<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Lost & Found</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="index.php" class="logo">🔍 Lost & Found</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse.php">Browse</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="report.php">Report Item</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Search Items</h1>

        <div class="card">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search by title, description, or location...">
                <button class="btn btn-primary" onclick="search()">Search</button>
            </div>

            <div class="filters">
                <div>
                    <label>Type</label>
                    <select id="typeFilter">
                        <option value="">All</option>
                        <option value="lost">Lost</option>
                        <option value="found">Found</option>
                    </select>
                </div>
                <div>
                    <label>Category</label>
                    <select id="categoryFilter">
                        <option value="">All</option>
                        <option>Electronics</option>
                        <option>Accessories</option>
                        <option>Bags</option>
                        <option>Clothing</option>
                        <option>Documents</option>
                        <option>Books</option>
                    </select>
                </div>
                <div>
                    <label>Date From</label>
                    <input type="date" id="dateFrom">
                </div>
                <div>
                    <label>Date To</label>
                    <input type="date" id="dateTo">
                </div>
            </div>
        </div>

        <div id="results"></div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Lost & Found System. Made by Students.</p>
    </footer>

    <script>
        // Search on load
        search();

        // Search on enter
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if(e.key === 'Enter') search();
        });

        // Live search
        let timer;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(search, 500);
        });

        // Filter changes
        document.getElementById('typeFilter').addEventListener('change', search);
        document.getElementById('categoryFilter').addEventListener('change', search);
        document.getElementById('dateFrom').addEventListener('change', search);
        document.getElementById('dateTo').addEventListener('change', search);

        function search() {
            const query = document.getElementById('searchInput').value;
            const type = document.getElementById('typeFilter').value;
            const category = document.getElementById('categoryFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            fetch('search_api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `q=${query}&type=${type}&category=${category}&from=${dateFrom}&to=${dateTo}`
            })
            .then(res => res.json())
            .then(data => {
                const results = document.getElementById('results');
                if(data.length === 0) {
                    results.innerHTML = '<div class="card text-center"><h3>No results found</h3></div>';
                    return;
                }
                
                results.innerHTML = '<div class="grid">' + data.map(item => `
                    <div class="item-card">
                        <span class="badge badge-${item.item_type}">${item.item_type.toUpperCase()}</span>
                        <h3>${item.title}</h3>
                        <p><strong>Category:</strong> ${item.category}</p>
                        <p><strong>Location:</strong> ${item.location}</p>
                        <p><strong>Date:</strong> ${new Date(item.date_reported).toLocaleDateString()}</p>
                        <p>${item.description.substring(0, 100)}...</p>
                        <a href="view.php?id=${item.id}" class="btn btn-primary" style="margin-top: 1rem;">View</a>
                    </div>
                `).join('') + '</div>';
            });
        }
    </script>
</body>
</html>
