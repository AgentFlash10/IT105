# Product Inventory System - MySQL Version

A complete inventory management system built with PHP and MySQL, featuring a modern responsive interface.

## 🚀 Features

- **Add/Edit/Delete Products**: Full CRUD operations
- **Search & Filter**: By product name and category
- **Real-time Statistics**: Total products, value, low stock alerts
- **Responsive Design**: Works on all devices
- **Database-driven**: MySQL backend with proper indexing
- **Security**: SQL injection prevention with prepared statements

## 📋 Prerequisites

- **XAMPP** or **WAMP** server
- **PHP 7.4+** with PDO extension
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Web browser**

## 🛠️ Installation & Setup

### Method 1: Automatic Setup (Recommended)

1. **Start XAMPP/WAMP**
   - Start Apache and MySQL services
   - Make sure both services are running (green status)

2. **Place Files**
   - Copy `index.php` to your web server directory
   - Example: `C:\xampp\htdocs\Act11\`

3. **Access Application**
   - Open browser and go to: `http://localhost/Act11/`
   - The system will automatically create the database and tables

### Method 2: Manual Database Setup

If automatic setup fails, follow these steps:

1. **Open phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin`
   - Login with username: `root`, password: (leave empty)

2. **Create Database**
   ```sql
   CREATE DATABASE inventory_system;
   ```

3. **Create Table**
   ```sql
   USE inventory_system;
   
   CREATE TABLE products (
       id VARCHAR(32) PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       price DECIMAL(10,2) NOT NULL,
       quantity INT NOT NULL DEFAULT 0,
       category VARCHAR(100),
       date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       INDEX idx_name (name),
       INDEX idx_category (category),
       INDEX idx_date_added (date_added)
   );
   ```

4. **Import SQL File (Alternative)**
   - In phpMyAdmin, select the `inventory_system` database
   - Click "Import" tab
   - Choose `database_setup.sql` file
   - Click "Go"

## 🔧 Configuration

### Database Settings

Edit the database configuration in `index.php`:

```php
$host = 'localhost';           // Database host
$dbname = 'inventory_system';  // Database name
$username = 'root';           // Database username
$password = '';               // Database password
```

### Default Credentials

- **Username**: `root`
- **Password**: (empty)
- **Host**: `localhost`
- **Database**: `inventory_system`

## 📊 Database Structure

### Products Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | VARCHAR(32) | Primary key, unique identifier |
| `name` | VARCHAR(255) | Product name |
| `price` | DECIMAL(10,2) | Product price |
| `quantity` | INT | Stock quantity |
| `category` | VARCHAR(100) | Product category |
| `date_added` | TIMESTAMP | Auto-generated timestamp |

### Indexes

- `idx_name` - For fast product name searches
- `idx_category` - For fast category filtering
- `idx_date_added` - For date-based sorting

## 🚨 Troubleshooting

### Common Issues

1. **"Database connection failed"**
   - Make sure MySQL service is running
   - Check username/password in configuration
   - Verify MySQL is accessible on localhost

2. **"Access denied" error**
   - Try connecting as root without password
   - Check MySQL user permissions
   - Restart MySQL service

3. **"Unknown database" error**
   - The system will create the database automatically
   - If it fails, create manually using phpMyAdmin
   - Check MySQL user has CREATE privileges

4. **Page not loading**
   - Make sure Apache service is running
   - Check file permissions
   - Verify PHP is properly configured

### Error Logs

Check these locations for error logs:
- **XAMPP**: `C:\xampp\apache\logs\error.log`
- **WAMP**: `C:\wamp\logs\apache_error.log`
- **PHP Errors**: Check browser console (F12)

## 📱 Usage

1. **Add Products**: Fill the form and click "Add Product"
2. **Search Products**: Use the search bar and category filter
3. **Update Stock**: Change quantity in the table and click "Update"
4. **Delete Products**: Click "Delete" button (with confirmation)
5. **View Statistics**: Check the dashboard cards for real-time stats

## 🔒 Security Features

- **SQL Injection Prevention**: Prepared statements
- **XSS Prevention**: `htmlspecialchars()` output encoding
- **Input Validation**: Server-side validation
- **Error Handling**: Graceful error messages

## 📈 Performance

- **Database Indexes**: Optimized for fast searches
- **Prepared Statements**: Efficient query execution
- **Responsive Design**: Fast loading on all devices
- **Minimal Dependencies**: No external libraries required

## 🎯 Sample Data

The system includes sample products for testing:
- Laptop Computer ($999.99, 15 units, Electronics)
- Wireless Mouse ($25.50, 50 units, Electronics)
- Programming Book ($45.00, 20 units, Books)
- Coffee Mug ($12.99, 100 units, Home & Garden)
- Running Shoes ($89.99, 30 units, Sports)

## 📝 License

This project is for educational purposes. Feel free to modify and use as needed.

## 🤝 Support

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify all prerequisites are met
3. Check error logs for specific error messages
4. Ensure proper file permissions

---