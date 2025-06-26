# Kenn India Inventory Management System

A user-friendly Inventory Management System built for Kenn India to manage products, categories, stock, suppliers, and users through a secure and centralized dashboard.

![Dashboard Screenshot](assets/ss.png)

## Features

- Product Management: Add, update, delete products with details and images.
- Category Management: Organize products into categories.
- Stock Monitoring: Real-time inventory tracking with alerts.
- Supplier Management: Manage supplier details for procurement.
- Role-Based Access: Admin and staff user management.
- Dashboard Analytics: Overview of stock, categories, and user activity.
- Authentication: Secure login with session management.

## Tech Stack

- Frontend: HTML, CSS, JavaScript, Bootstrap
- Backend: PHP (Core PHP)
- Database: MySQL
- UI: AdminLTE Template

## Setup Instructions

### Prerequisites

- PHP ≥ 7.2
- MySQL Server
- Local server environment like XAMPP, WAMP, or LAMP

### Steps to Run

1. Clone or download this repository.

2. Copy the project folder into your local server directory (e.g., `htdocs` in XAMPP).

3. Start Apache and MySQL via XAMPP.

4. Open phpMyAdmin and create a new database (e.g., `inventory_db`).

5. Import the SQL file provided in the project folder (`inventory_db.sql`).

6. Configure your database credentials in `includes/db.php`.

7. Open your browser and go to:  
   `http://localhost/kenn-india-inventory-management`

## Screenshot

![Dashboard](assets/ss.png)

## Future Enhancements

- Add barcode scanner integration
- Generate PDF reports for stock and sales
- Improve mobile responsiveness
- Migrate to a modern PHP framework like Laravel

## License

This project is intended for educational and demonstration purposes.
