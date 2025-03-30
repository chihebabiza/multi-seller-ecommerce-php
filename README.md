# PHP Multi-Vendor Marketplace

## Overview

This is a PHP-based multi-vendor marketplace that allows multiple sellers to register, manage their products, and sell online. Buyers can browse products from different sellers, add them to their cart, and complete the purchase.

## Features

- **Seller Management**: Vendors can register, log in, and manage their products.
- **Product Management**: Sellers can add, edit, and delete their products.
- **Order Processing**: Customers can place orders, and sellers get notified.
- **Cart System**: Users can add multiple products from different sellers.
- **Admin Dashboard**: Manage users, products, and site settings.
- **Secure Authentication**: Secure login and registration system.
- **Payment Integration**: Supports online payments through various gateways.
- **User Reviews & Ratings**: Customers can leave reviews for products.
- **Responsive Design**: Fully responsive layout for mobile and desktop.

## Installation

1. Clone the repository or download the source files.
2. Import the `database.sql` file into your MySQL database.
3. Configure the database in `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'your_database');
   ```
4. Start the local server using XAMPP or any PHP environment.
5. Open your browser and navigate to `http://localhost/multi-vendor`.

## Requirements

- PHP 7.4 or later
- MySQL Database
- Apache Server or Nginx
- XAMPP/WAMP (for local development)

## Folder Structure

```
/ multi-vendor
|-- /admin          # Admin panel
|-- /seller         # Seller dashboard
|-- /customer       # Customer panel
|-- /includes       # Reusable functions and database connection
|-- /assets         # CSS, JS, and images
|-- /config.php     # Configuration file
|-- /index.php      # Homepage
|-- /login.php      # User login
|-- /register.php   # User registration
```

## Usage

- **Admin**: Can manage users, products, and settings.
- **Sellers**: Can upload and manage their products.
- **Customers**: Can browse products, add to cart, and place orders.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

Developed by Chiheb Abiza

## Contact

For any inquiries, feel free to reach out:

- Email: [chihababiza9@gmail.com](mailto\:chihababiza9@gmail.com)



## Contributing

Contributions are welcome! Feel free to submit a pull request or report issues.

## Acknowledgments

- [Bootstrap](https://getbootstrap.com/) for UI components.
- [FontAwesome](https://fontawesome.com/) for icons.

