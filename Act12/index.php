<?php
session_start();

// ========================================
// DATABASE CONFIGURATION
// ========================================

// Database connection parameters
$host = 'localhost';
$dbname = 'inventory_system';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

// Try to connect to the specific database
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Check if it's a "database doesn't exist" error
    if (strpos($e->getMessage(), 'Unknown database') !== false) {
        // Show database setup instructions
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Database Setup Required - Product Inventory System</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    padding: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .setup-container {
                    max-width: 800px;
                    background: white;
                    border-radius: 15px;
                    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                
                .header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                
                .header h1 {
                    font-size: 2.5em;
                    margin-bottom: 10px;
                }
                
                .content {
                    padding: 30px;
                }
                
                .alert {
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    color: #856404;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                }
                
                .setup-steps {
                    background: #f8f9fa;
                    padding: 25px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                }
                
                .setup-steps h3 {
                    color: #495057;
                    margin-bottom: 15px;
                }
                
                .setup-steps ol {
                    padding-left: 20px;
                }
                
                .setup-steps li {
                    margin-bottom: 10px;
                    line-height: 1.6;
                }
                
                .code-block {
                    background: #2d3748;
                    color: #e2e8f0;
                    padding: 15px;
                    border-radius: 8px;
                    font-family: 'Courier New', monospace;
                    font-size: 14px;
                    margin: 10px 0;
                    overflow-x: auto;
                }
                
                .btn {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 12px 25px;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: 600;
                    text-decoration: none;
                    display: inline-block;
                    margin: 5px;
                    transition: transform 0.2s ease;
                }
                
                .btn:hover {
                    transform: translateY(-2px);
                }
                
                .btn-secondary {
                    background: #6c757d;
                }
                
                .file-info {
                    background: #e3f2fd;
                    border: 1px solid #bbdefb;
                    color: #1565c0;
                    padding: 15px;
                    border-radius: 8px;
                    margin: 15px 0;
                }
            </style>
        </head>
        <body>
            <div class="setup-container">
                <div class="header">
                    <h1>🗄️ Database Setup Required</h1>
                    <p>Product Inventory System with User Management</p>
                </div>
                
                <div class="content">
                    <div class="alert">
                        <strong>⚠️ Database Not Found:</strong> The database 'inventory_system' does not exist. 
                        Please follow the setup instructions below to create the required database and tables.
                    </div>
                    
                    <div class="setup-steps">
                        <h3>📋 Setup Instructions</h3>
                        <ol>
                            <li><strong>Start XAMPP/WAMP:</strong> Make sure MySQL service is running</li>
                            <li><strong>Open phpMyAdmin:</strong> Go to <code>http://localhost/phpmyadmin</code></li>
                            <li><strong>Login:</strong> Use username: <code>root</code>, password: (leave empty)</li>
                            <li><strong>Create Database:</strong> Click "New" and create database named <code>inventory_system</code></li>
                            <li><strong>Import SQL File:</strong> Select the database, go to "Import" tab, and upload <code>database_setup.sql</code></li>
                            <li><strong>Verify Setup:</strong> You should see "products" and "users" tables created</li>
                        </ol>
                    </div>
                    
                    <div class="file-info">
                        <strong>📄 SQL File Location:</strong> <code>Act12/database_setup.sql</code><br>
                        <strong>🔐 Default Login:</strong> admin / admin123
                    </div>
                    
                    <div style="text-align: center; margin-top: 30px;">
                        <a href="index.php" class="btn">🔄 Refresh Page</a>
                        <a href="database_setup.sql" class="btn btn-secondary" download>📥 Download SQL File</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit; // Stop execution here
    } else {
        // Other database connection errors
        die("Database connection failed: " . $e->getMessage() . "<br><br>
        <strong>Setup Instructions:</strong><br>
        1. Make sure XAMPP/WAMP MySQL service is running<br>
        2. Check if username and password are correct<br>
        3. Verify MySQL is accessible on localhost");
    }
}

// ========================================
// USER AUTHENTICATION FUNCTIONS
// ========================================

/**
 * FUNCTION: handleLogin($pdo)
 * PURPOSE: Handle user login
 */
function handleLogin($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $login_username = trim($_POST['username']);
        $login_password = $_POST['password'];
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND is_active = 1');
        $stmt->execute([$login_username]);
        $user = $stmt->fetch();
        if ($user && password_verify($login_password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?')->execute([$user['id']]);
            header('Location: index.php');
            exit;
        } else {
            return 'Invalid username or password.';
        }
    }
    return '';
}

/**
 * FUNCTION: handleLogout()
 * PURPOSE: Handle user logout
 */
function handleLogout() {
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

/**
 * FUNCTION: getAllUsers($pdo)
 * PURPOSE: Get all users (admin only)
 */
function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

/**
 * FUNCTION: addUser($pdo, $user_data)
 * PURPOSE: Add new user (admin only)
 */
function addUser($pdo, $user_data) {
    try {
        $password_hash = password_hash($user_data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password_hash, full_name, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $user_data['username'],
            $user_data['email'],
            $password_hash,
            $user_data['full_name'],
            $user_data['role']
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

// ========================================
// DATABASE OPERATIONS - CORE FUNCTIONS
// ========================================

/**
 * FUNCTION: getAllProducts()
 * PURPOSE: Get all products from database
 * RETURNS: Array of products
 */
function getAllProducts($pdo) {
    $stmt = $pdo->query("SELECT p.*, u.username as created_by_name FROM products p LEFT JOIN users u ON p.created_by = u.id ORDER BY p.date_added DESC");
    return $stmt->fetchAll();
}

/**
 * FUNCTION: addProduct($pdo, $product)
 * PURPOSE: Add new product to database
 * PARAMETERS: $pdo - Database connection, $product - Product data array
 * RETURNS: Boolean success status
 */
function addProduct($pdo, $product) {
    try {
        $sql = "INSERT INTO products (id, name, price, quantity, category, created_by) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $product['id'],
            $product['name'],
            $product['price'],
            $product['quantity'],
            $product['category'],
            $_SESSION['user_id'] ?? null
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * FUNCTION: updateProductQuantity($pdo, $id, $quantity)
 * PURPOSE: Update product quantity in database
 * PARAMETERS: $pdo - Database connection, $id - Product ID, $quantity - New quantity
 * RETURNS: Boolean success status
 */
function updateProductQuantity($pdo, $id, $quantity) {
    try {
        $sql = "UPDATE products SET quantity = ?, updated_by = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$quantity, $_SESSION['user_id'] ?? null, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * FUNCTION: deleteProduct($pdo, $id)
 * PURPOSE: Delete product from database
 * PARAMETERS: $pdo - Database connection, $id - Product ID
 * RETURNS: Boolean success status
 */
function deleteProduct($pdo, $id) {
    try {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * FUNCTION: searchProducts($pdo, $searchTerm, $category)
 * PURPOSE: Search products by name and category
 * PARAMETERS: $pdo - Database connection, $searchTerm - Search text, $category - Category filter
 * RETURNS: Array of matching products
 */
function searchProducts($pdo, $searchTerm, $category) {
    $sql = "SELECT p.*, u.username as created_by_name FROM products p LEFT JOIN users u ON p.created_by = u.id WHERE 1=1";
    $params = [];
    
    if (!empty($searchTerm)) {
        $sql .= " AND p.name LIKE ?";
        $params[] = "%$searchTerm%";
    }
    
    if (!empty($category)) {
        $sql .= " AND p.category = ?";
        $params[] = $category;
    }
    
    $sql .= " ORDER BY p.date_added DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * FUNCTION: getStatistics($pdo)
 * PURPOSE: Get inventory statistics
 * RETURNS: Array with statistics data
 */
function getStatistics($pdo) {
    $stats = [];
    
    // Total products
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
    $stats['totalProducts'] = $stmt->fetch()['total'];
    
    // Total value
    $stmt = $pdo->query("SELECT SUM(price * quantity) as total_value FROM products");
    $result = $stmt->fetch();
    $stats['totalValue'] = $result['total_value'] ?: 0;
    
    // Low stock items
    $stmt = $pdo->query("SELECT COUNT(*) as low_stock FROM products WHERE quantity < 10");
    $stats['lowStock'] = $stmt->fetch()['low_stock'];
    
    // Categories
    $stmt = $pdo->query("SELECT COUNT(DISTINCT category) as categories FROM products WHERE category IS NOT NULL AND category != ''");
    $stats['categories'] = $stmt->fetch()['categories'];
    
    return $stats;
}

/**
 * FUNCTION: getCategories($pdo)
 * PURPOSE: Get unique categories from database
 * RETURNS: Array of unique categories
 */
function getCategories($pdo) {
    $stmt = $pdo->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// ========================================
// AUTHENTICATION AND SESSION HANDLING
// ========================================

// Handle logout
handleLogout();

// Handle login
$login_error = handleLogin($pdo);

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// ========================================
// FORM PROCESSING - Handle POST requests
// ========================================

if ($is_logged_in && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {
                    $newProduct = [
                        'id' => uniqid(),
                        'name' => trim($_POST['name']),
                        'price' => floatval($_POST['price']),
                        'quantity' => intval($_POST['quantity']),
                        'category' => trim($_POST['category'])
                    ];
                    
                    if (addProduct($pdo, $newProduct)) {
                        $message = "Product added successfully!";
                        $messageType = "success";
                    } else {
                        $message = "Error adding product to database!";
                        $messageType = "error";
                    }
                } else {
                    $message = "Please fill in all required fields!";
                    $messageType = "error";
                }
                break;

            case 'update':
                if (isset($_POST['id']) && isset($_POST['quantity'])) {
                    if (updateProductQuantity($pdo, $_POST['id'], intval($_POST['quantity']))) {
                        $message = "Stock updated successfully!";
                        $messageType = "success";
                    } else {
                        $message = "Error updating stock!";
                        $messageType = "error";
                    }
                }
                break;

            case 'delete':
                if (isset($_POST['id'])) {
                    if (deleteProduct($pdo, $_POST['id'])) {
                        $message = "Product deleted successfully!";
                        $messageType = "success";
                    } else {
                        $message = "Error deleting product!";
                        $messageType = "error";
                    }
                }
                break;

            case 'add_user':
                if (($_SESSION['role'] ?? '') === 'admin') {
                    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['full_name'])) {
                        $newUser = [
                            'username' => trim($_POST['username']),
                            'email' => trim($_POST['email']),
                            'password' => $_POST['password'],
                            'full_name' => trim($_POST['full_name']),
                            'role' => $_POST['role'] ?? 'user'
                        ];
                        
                        if (addUser($pdo, $newUser)) {
                            $message = "User added successfully!";
                            $messageType = "success";
                        } else {
                            $message = "Error adding user!";
                            $messageType = "error";
                        }
                    } else {
                        $message = "Please fill in all required fields!";
                        $messageType = "error";
                    }
                }
                break;
        }
    }
}

// ========================================
// DATA LOADING AND PROCESSING
// ========================================

if ($is_logged_in) {
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $searchCategory = isset($_GET['category']) ? trim($_GET['category']) : '';
    
    if (!empty($searchTerm) || !empty($searchCategory)) {
        $inventory = searchProducts($pdo, $searchTerm, $searchCategory);
    } else {
        $inventory = getAllProducts($pdo);
    }

    $stats = getStatistics($pdo);
    $categories = getCategories($pdo);
    
    if (($_SESSION['role'] ?? '') === 'admin') {
        $users = getAllUsers($pdo);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory System with User Management</title>
    
    <!-- CSS STYLES - This section contains all the styling for the application -->
    <style>
        /* CSS Reset - Removes default browser styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling with gradient background */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        /* Main container that holds the entire application */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Header section with gradient background */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        /* User info in header */
        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: right;
        }

        .user-info .username {
            font-weight: bold;
            font-size: 1.1em;
        }

        .user-info .role {
            opacity: 0.8;
            font-size: 0.9em;
        }

        .logout-link {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
        }

        .logout-link:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Login container */
        .login-container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Main content area */
        .content {
            padding: 30px;
        }

        /* Form sections styling */
        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }

        .form-section h2 {
            color: #495057;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        /* Grid layout for form fields */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Individual form group styling */
        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }

        /* Input and select field styling */
        .form-group input, .form-group select {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        /* Focus state for form inputs */
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Button styling with gradient background */
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: transform 0.2s ease;
        }

        /* Hover effect for buttons */
        .btn:hover {
            transform: translateY(-2px);
        }

        /* Different button color variants */
        .btn-secondary {
            background: #6c757d;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-success {
            background: #28a745;
        }

        /* Search section styling */
        .search-section {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        /* Grid layout for search form */
        .search-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 15px;
            align-items: end;
        }

        /* Table container styling */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Inventory table styling */
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table header styling */
        .inventory-table th {
            background: #495057;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        /* Table cell styling */
        .inventory-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
        }

        /* Hover effect for table rows */
        .inventory-table tr:hover {
            background: #f8f9fa;
        }

        /* Stock level color coding */
        .stock-low {
            color: #dc3545;
            font-weight: bold;
        }

        .stock-medium {
            color: #ffc107;
            font-weight: bold;
        }

        .stock-high {
            color: #28a745;
            font-weight: bold;
        }

        /* Action buttons container */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        /* Small button variant */
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Message styling for success/error notifications */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Statistics cards grid layout */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Individual stat card styling */
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            opacity: 0.9;
        }

        /* Database info section */
        .db-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Navigation tabs */
        .nav-tabs {
            display: flex;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 20px;
        }

        .nav-tab {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
        }

        .nav-tab.active {
            border-bottom-color: #667eea;
            color: #667eea;
            font-weight: bold;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .error {
            color: #dc3545;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php if (!$is_logged_in): ?>
        <!-- LOGIN FORM -->
        <div class="login-container">
            <h2>🔐 Login to Inventory System</h2>
            <?php if ($login_error): ?><div class="error"><?php echo $login_error; ?></div><?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
            <div style="margin-top: 20px; text-align: center; color: #6c757d; font-size: 14px;">
                <p><strong>Default Login Credentials:</strong></p>
                <p>Admin: admin / admin123</p>
                <p>Manager: manager / admin123</p>
                <p>User: user / admin123</p>
            </div>
        </div>
    <?php else: ?>
        <!-- MAIN APPLICATION -->
        <div class="container">
            <div class="header">
                <div class="user-info">
                    <div class="username"><?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'User'); ?></div>
                    <div class="role"><?php echo ucfirst($_SESSION['role'] ?? 'user'); ?></div>
                    <a href="?action=logout" class="logout-link">Logout</a>
                </div>
                <h1>📦 Product Inventory System with User Management</h1>
                <p>Manage your products with ease using PHP and MySQL Database</p>
            </div>

            <div class="content">
                <!-- Display success/error messages if they exist -->
                <?php if (isset($message)): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Database Connection Info -->
                <div class="db-info">
                    <strong>🗄️ Database Status:</strong> Connected to MySQL database 'inventory_system' 
                    | <strong>Products:</strong> <?php echo $stats['totalProducts']; ?> 
                    | <strong>Total Value:</strong> $<?php echo number_format($stats['totalValue'], 2); ?>
                    | <strong>Logged in as:</strong> <?php echo htmlspecialchars($_SESSION['username'] ?? 'Unknown'); ?> (<?php echo ucfirst($_SESSION['role'] ?? 'user'); ?>)
                </div>

                <!-- Navigation Tabs -->
                <div class="nav-tabs">
                    <button class="nav-tab active" onclick="showTab('inventory')">📦 Inventory</button>
                    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                        <button class="nav-tab" onclick="showTab('users')">👥 User Management</button>
                    <?php endif; ?>
                </div>

                <!-- Inventory Tab -->
                <div id="inventory-tab" class="tab-content active">
                    <!-- ======================================== -->
                    <!-- STATISTICS DASHBOARD -->
                    <!-- ======================================== -->
                    <!-- This section displays key metrics about the inventory -->
                    <div class="stats">
                        <!-- Total Products Card -->
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['totalProducts']; ?></div>
                            <div class="stat-label">Total Products</div>
                        </div>
                        <!-- Total Value Card -->
                        <div class="stat-card">
                            <div class="stat-number">$<?php echo number_format($stats['totalValue'], 2); ?></div>
                            <div class="stat-label">Total Value</div>
                        </div>
                        <!-- Low Stock Items Card -->
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['lowStock']; ?></div>
                            <div class="stat-label">Low Stock Items</div>
                        </div>
                        <!-- Categories Card -->
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['categories']; ?></div>
                            <div class="stat-label">Categories</div>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- ADD PRODUCT FORM -->
                    <!-- ======================================== -->
                    <!-- This form allows users to add new products to the inventory -->
                    <div class="form-section">
                        <h2>➕ Add New Product</h2>
                        <!-- POST method sends data to the same page for processing -->
                        <form method="POST">
                            <!-- Hidden field to identify the form action -->
                            <input type="hidden" name="action" value="add">
                            
                            <!-- Form fields arranged in a responsive grid -->
                            <div class="form-grid">
                                <!-- Product Name Field -->
                                <div class="form-group">
                                    <label for="name">Product Name *</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <!-- Price Field -->
                                <div class="form-group">
                                    <label for="price">Price ($) *</label>
                                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                                </div>
                                <!-- Quantity Field -->
                                <div class="form-group">
                                    <label for="quantity">Quantity *</label>
                                    <input type="number" id="quantity" name="quantity" min="0" required>
                                </div>
                                <!-- Category Dropdown -->
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select id="category" name="category">
                                        <option value="">Select Category</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Clothing">Clothing</option>
                                        <option value="Books">Books</option>
                                        <option value="Home & Garden">Home & Garden</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Food & Beverages">Food & Beverages</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit button to add the product -->
                            <button type="submit" class="btn">Add Product</button>
                        </form>
                    </div>

                    <!-- ======================================== -->
                    <!-- SEARCH AND FILTER SECTION -->
                    <!-- ======================================== -->
                    <!-- This section allows users to search and filter products -->
                    <div class="search-section">
                        <h2>🔍 Search Products</h2>
                        <!-- GET method for search (doesn't modify data) -->
                        <form method="GET">
                            <div class="search-grid">
                                <!-- Search by Name Field -->
                                <div class="form-group">
                                    <label for="search">Search by Name</label>
                                    <!-- htmlspecialchars() prevents XSS attacks -->
                                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Enter product name...">
                                </div>
                                <!-- Category Filter Dropdown -->
                                <div class="form-group">
                                    <label for="category_filter">Filter by Category</label>
                                    <select id="category_filter" name="category">
                                        <option value="">All Categories</option>
                                        <!-- Dynamically populate categories from database -->
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $searchCategory === $category ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Search button -->
                                <button type="submit" class="btn">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- ======================================== -->
                    <!-- INVENTORY TABLE DISPLAY -->
                    <!-- ======================================== -->
                    <!-- This table displays all products in the inventory -->
                    <div class="table-container">
                        <table class="inventory-table">
                            <!-- Table Header -->
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Value</th>
                                    <th>Created By</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody>
                                <?php if (empty($inventory)): ?>
                                    <!-- Display message when no products are found -->
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                            <?php 
                                            $totalProducts = $stats['totalProducts'];
                                            echo $totalProducts == 0 ? 'No products in inventory. Add your first product above!' : 'No products match your search criteria.'; 
                                            ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <!-- Loop through each product in the filtered inventory -->
                                    <?php foreach ($inventory as $product): ?>
                                        <tr>
                                            <!-- Product Name (bold text) -->
                                            <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                            
                                            <!-- Product Category -->
                                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                                            
                                            <!-- Product Price (formatted with 2 decimal places) -->
                                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                                            
                                            <!-- Product Quantity with color coding -->
                                            <td>
                                                <span class="<?php 
                                                    // Color coding based on stock levels:
                                                    // Red for low stock (< 10), Yellow for medium (10-49), Green for high (50+)
                                                    echo $product['quantity'] < 10 ? 'stock-low' : 
                                                        ($product['quantity'] < 50 ? 'stock-medium' : 'stock-high'); 
                                                ?>">
                                                    <?php echo $product['quantity']; ?>
                                                </span>
                                            </td>
                                            
                                            <!-- Total Value (price * quantity) -->
                                            <td>$<?php echo number_format($product['price'] * $product['quantity'], 2); ?></td>
                                            
                                            <!-- Created By -->
                                            <td><?php echo htmlspecialchars($product['created_by_name'] ?? 'Unknown'); ?></td>
                                            
                                            <!-- Date Added (formatted for readability) -->
                                            <td><?php echo date('M j, Y', strtotime($product['date_added'])); ?></td>
                                            
                                            <!-- Action Buttons -->
                                            <td>
                                                <div class="action-buttons">
                                                    <!-- Update Quantity Form -->
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="update">
                                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                        <!-- Inline quantity input field -->
                                                        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="0" style="width: 60px; padding: 4px; margin-right: 5px;">
                                                        <button type="submit" class="btn btn-small btn-success">Update</button>
                                                    </form>
                                                    
                                                    <!-- Delete Product Form -->
                                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User Management Tab (Admin Only) -->
                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <div id="users-tab" class="tab-content">
                        <div class="form-section">
                            <h2>➕ Add New User</h2>
                            <form method="POST">
                                <input type="hidden" name="action" value="add_user">
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="new_username">Username *</label>
                                        <input type="text" id="new_username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_email">Email *</label>
                                        <input type="email" id="new_email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Password *</label>
                                        <input type="password" id="new_password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_full_name">Full Name *</label>
                                        <input type="text" id="new_full_name" name="full_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_role">Role</label>
                                        <select id="new_role" name="role">
                                            <option value="user">User</option>
                                            <option value="manager">Manager</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn">Add User</button>
                            </form>
                        </div>

                        <div class="table-container">
                            <h2>👥 User List</h2>
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <span style="
                                                    padding: 4px 8px; 
                                                    border-radius: 4px; 
                                                    font-size: 12px; 
                                                    font-weight: bold;
                                                    background: <?php echo $user['role'] === 'admin' ? '#dc3545' : ($user['role'] === 'manager' ? '#ffc107' : '#28a745'); ?>;
                                                    color: white;
                                                ">
                                                    <?php echo ucfirst($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span style="color: <?php echo $user['is_active'] ? '#28a745' : '#dc3545'; ?>; font-weight: bold;">
                                                    <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $user['last_login'] ? date('M j, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <script>
            function showTab(tabName) {
                // Hide all tab contents
                const tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Remove active class from all tabs
                const tabs = document.querySelectorAll('.nav-tab');
                tabs.forEach(tab => tab.classList.remove('active'));
                
                // Show selected tab content
                document.getElementById(tabName + '-tab').classList.add('active');
                
                // Add active class to clicked tab
                event.target.classList.add('active');
            }
        </script>
    <?php endif; ?>
</body>
</html> 