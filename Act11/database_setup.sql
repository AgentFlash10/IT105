-- ========================================
-- PRODUCT INVENTORY SYSTEM - DATABASE SETUP
-- ========================================
-- This file contains the complete SQL setup for the inventory system
-- Run these commands in phpMyAdmin or MySQL command line

-- ========================================
-- STEP 1: CREATE DATABASE
-- ========================================
CREATE DATABASE IF NOT EXISTS inventory_system;
USE inventory_system;

-- ========================================
-- STEP 2: CREATE PRODUCTS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS products (
    id VARCHAR(32) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    category VARCHAR(100),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_category (category),
    INDEX idx_date_added (date_added)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- STEP 3: INSERT SAMPLE DATA (OPTIONAL)
-- ========================================
INSERT INTO products (id, name, price, quantity, category) VALUES
('sample1', 'Laptop Computer', 999.99, 15, 'Electronics'),
('sample2', 'Wireless Mouse', 25.50, 50, 'Electronics'),
('sample3', 'Programming Book', 45.00, 20, 'Books'),
('sample4', 'Coffee Mug', 12.99, 100, 'Home & Garden'),
('sample5', 'Running Shoes', 89.99, 30, 'Sports');

-- ========================================
-- STEP 4: VERIFY SETUP
-- ========================================
-- Check if table was created successfully
SHOW TABLES;

-- Check table structure
DESCRIBE products;

-- Check sample data
SELECT * FROM products;

-- ========================================
-- MANUAL SETUP INSTRUCTIONS
-- ========================================

/*
SETUP INSTRUCTIONS FOR MANUAL DATABASE CREATION:

1. OPEN PHPMYADMIN:
   - Start XAMPP/WAMP
   - Open browser and go to: http://localhost/phpmyadmin
   - Login with username: root, password: (leave empty)

2. CREATE DATABASE:
   - Click "New" on the left sidebar
   - Enter "inventory_system" as database name
   - Click "Create"

3. CREATE TABLE:
   - Select the "inventory_system" database
   - Click "SQL" tab
   - Copy and paste the CREATE TABLE command above
   - Click "Go"

4. VERIFY SETUP:
   - You should see the "products" table in the left sidebar
   - Click on it to see the table structure

ALTERNATIVE: COMMAND LINE SETUP

1. Open MySQL command line:
   mysql -u root -p

2. Run the SQL commands above one by one

TROUBLESHOOTING:

- If you get "Access denied" error:
  - Make sure MySQL service is running in XAMPP/WAMP
  - Check if username/password are correct
  - Try connecting as root without password

- If database already exists:
  - The CREATE DATABASE IF NOT EXISTS will skip creation
  - You can proceed directly to table creation

- If table already exists:
  - The CREATE TABLE IF NOT EXISTS will skip creation
  - You can start using the application immediately
*/ 