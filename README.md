# Jama Lagbe

Jama Lagbe is an online clothing marketplace designed to facilitate the buying and selling of clothing items. It allows users to list their clothing for sale, browse available items, and complete transactions securely.

## Features

- **User Authentication**: Secure login and registration system.
- **List Clothing Items**: Users can upload images, add descriptions, and set prices for their clothing.
- **Browse & Search**: Buyers can filter and search for clothing items based on categories, conditions, and prices.
- **Transactions**: Secure handling of transactions with records maintained in the database.
- **Admin Panel**: Admins have permission to view and delete clothing items and review transactions.

## Technologies Used

- **Backend**: PHP (with MySQLi for database connection)
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Authentication**: Email-based login

## Database Schema

### Users Table
- `user_email` (Primary Key)
- `username`
- `password`
- `phone`
- `address`

### ClothingItems Table
- `item_id` (Primary Key)
- `user_email` (Foreign Key referencing Users table)
- `title`
- `description`
- `category`
- `conditions`
- `price`
- `available_for`
- `date_added`
- `status`

### Transactions Table
- `transaction_id` (Primary Key)
- `item_id` (Foreign Key referencing ClothingItems table)
- `date`
- `buyer_email`
- `transaction_type`

### Admin Table
- `admin_id` (Primary Key)
- `email`
- `password`
- `permissions`

## Installation Guide

1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/jama-lagbe.git
   ```
2. Set up the database using the provided SQL script.
3. Configure the database connection in `Connection.php`.
4. Start a local server (e.g., XAMPP, WAMP) and place the project in the `htdocs` folder.
5. Open the application in a browser.

## Usage
- Register/Login to the system.
- List clothing items for sale.
- Browse and search available clothing.
- Purchase clothing and track transactions.
- Admins can manage listings and monitor transactions.

## Future Improvements
- Implement a messaging system for buyers and sellers.
- Add image uploads for clothing items.
- Improve UI/UX with a modern design.
- Integrate payment gateway for seamless transactions.

## License
This project is open-source and free to use under the MIT License.

