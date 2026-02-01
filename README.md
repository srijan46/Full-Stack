# Lost & Found System - Simple Version

A clean and simple PHP+MySQL lost and found management system.

## Features

✅ Full CRUD Operations
✅ PDO Database Connection (secure)
✅ Search with AJAX (live results)
✅ Advanced filters
✅ Admin panel
✅ Modern, unique design
✅ Mobile responsive
✅ Simple, readable code

## Installation

1. Copy the folder to your web server (e.g., `C:\xampp\htdocs\lostandfound`)

2. Run setup:
   - Open browser: `http://localhost/lostandfound/setup.php`
   - Wait for success message
   - **DELETE setup.php file**

3. Access the site:
   - Homepage: `http://localhost/lostandfound/`
   - Admin: `http://localhost/lostandfound/admin.php`

## Login

**Username:** admin
**Password:** admin123

## File Structure

```
lostandfound/
├── index.php           # Homepage
├── browse.php          # Browse with filters
├── search.php          # AJAX search
├── search_api.php      # Search API
├── report.php          # Report items
├── view.php            # View details
├── admin.php           # Admin panel
├── login.php           # Admin login
├── logout.php          # Logout
├── setup.php           # Database setup (DELETE after use)
├── css/
│   └── style.css       # Modern CSS
└── includes/
    └── db.php          # PDO connection
```

## Technologies

- PHP 7.4+
- MySQL (PDO)
- Vanilla JavaScript (AJAX)
- Pure CSS (no framework)

## Database

Tables: `items`, `users`

All queries use PDO prepared statements for security.

## Security Features

- PDO prepared statements (SQL injection prevention)
- htmlspecialchars() for XSS prevention
- Password hashing
- Session-based authentication

## Made by Students ✨

Simple, clean, and easy to understand!
