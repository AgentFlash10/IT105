<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory System</title>
    
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
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Product Inventory System</h1>
            <p>Manage your products with ease using PHP and JSON</p>
        </div>

        <div class="content">
            <?php
            // ========================================
            // PHP BACKEND LOGIC - CORE FUNCTIONALITY
            // ========================================
            
            // Define the JSON file name where inventory data will be stored
            // This file will be created automatically when the first product is added
            $jsonFile = 'inventory.json';
            
            /**
             * FUNCTION: loadInventory()
             * PURPOSE: Load existing inventory data from JSON file
             * RETURNS: Array of products or empty array if file doesn't exist
             * 
             * This function:
             * 1. Checks if the JSON file exists
             * 2. Reads the file contents
             * 3. Decodes JSON to PHP array
             * 4. Returns empty array if file doesn't exist or is invalid
             */
            function loadInventory() {
                global $jsonFile;
                if (file_exists($jsonFile)) {
                    $data = file_get_contents($jsonFile);
                    return json_decode($data, true) ?: [];
                }
                return [];
            }

            /**
             * FUNCTION: saveInventory($inventory)
             * PURPOSE: Save inventory array to JSON file
             * PARAMETERS: $inventory - Array of products to save
             * 
             * This function:
             * 1. Takes the inventory array
             * 2. Encodes it to JSON with pretty formatting
             * 3. Writes it to the JSON file
             * 4. JSON_PRETTY_PRINT makes the JSON file human-readable
             */
            function saveInventory($inventory) {
                global $jsonFile;
                file_put_contents($jsonFile, json_encode($inventory, JSON_PRETTY_PRINT));
            }

            // ========================================
            // FORM PROCESSING - Handle POST requests
            // ========================================
            
            // Check if this is a POST request (form submission)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Load current inventory before making changes
                $inventory = loadInventory();
                
                // Check if an action is specified in the form
                if (isset($_POST['action'])) {
                    // Use switch statement to handle different form actions
                    switch ($_POST['action']) {
                        
                        // CASE: Add new product
                        case 'add':
                            // Validate that required fields are not empty
                            if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {
                                // Create new product array with all necessary data
                                $newProduct = [
                                    'id' => uniqid(),                    // Generate unique ID
                                    'name' => trim($_POST['name']),      // Remove whitespace
                                    'price' => floatval($_POST['price']), // Convert to float
                                    'quantity' => intval($_POST['quantity']), // Convert to integer
                                    'category' => trim($_POST['category']),   // Remove whitespace
                                    'date_added' => date('Y-m-d H:i:s')  // Current timestamp
                                ];
                                
                                // Add new product to inventory array
                                $inventory[] = $newProduct;
                                
                                // Save updated inventory to JSON file
                                saveInventory($inventory);
                                
                                // Set success message
                                $message = "Product added successfully!";
                                $messageType = "success";
                            } else {
                                // Set error message if required fields are empty
                                $message = "Please fill in all required fields!";
                                $messageType = "error";
                            }
                            break;

                        // CASE: Update product quantity
                        case 'update':
                            // Check if product ID and new quantity are provided
                            if (isset($_POST['id']) && isset($_POST['quantity'])) {
                                // Loop through inventory to find the product by ID
                                foreach ($inventory as &$product) {
                                    if ($product['id'] === $_POST['id']) {
                                        // Update the quantity (convert to integer)
                                        $product['quantity'] = intval($_POST['quantity']);
                                        break; // Exit loop once product is found
                                    }
                                }
                                
                                // Save updated inventory to JSON file
                                saveInventory($inventory);
                                
                                // Set success message
                                $message = "Stock updated successfully!";
                                $messageType = "success";
                            }
                            break;

                        // CASE: Delete product
                        case 'delete':
                            // Check if product ID is provided
                            if (isset($_POST['id'])) {
                                // Filter out the product with matching ID
                                // array_filter keeps only products that don't match the ID
                                $inventory = array_filter($inventory, function($product) {
                                    return $product['id'] !== $_POST['id'];
                                });
                                
                                // Save updated inventory to JSON file
                                saveInventory($inventory);
                                
                                // Set success message
                                $message = "Product deleted successfully!";
                                $messageType = "success";
                            }
                            break;
                    }
                }
            }

            // ========================================
            // DATA LOADING AND PROCESSING
            // ========================================
            
            // Load current inventory from JSON file
            // This happens on every page load to get the latest data
            $inventory = loadInventory();

            // ========================================
            // SEARCH AND FILTER FUNCTIONALITY
            // ========================================
            
            // Get search parameters from URL (GET request)
            // trim() removes whitespace from the beginning and end
            $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
            $searchCategory = isset($_GET['category']) ? trim($_GET['category']) : '';
            
            // Start with all inventory items
            $filteredInventory = $inventory;
            
            // Apply search filters if search terms are provided
            if (!empty($searchTerm) || !empty($searchCategory)) {
                // Use array_filter to keep only products that match search criteria
                $filteredInventory = array_filter($inventory, function($product) use ($searchTerm, $searchCategory) {
                    // Check if product name contains search term (case-insensitive)
                    $nameMatch = empty($searchTerm) || stripos($product['name'], $searchTerm) !== false;
                    
                    // Check if product category matches selected category
                    $categoryMatch = empty($searchCategory) || $product['category'] === $searchCategory;
                    
                    // Return true only if both conditions are met
                    return $nameMatch && $categoryMatch;
                });
            }

            // ========================================
            // STATISTICS CALCULATION
            // ========================================
            
            // Calculate total number of products
            $totalProducts = count($inventory);
            
            // Calculate total inventory value (price * quantity for each product)
            $totalValue = array_sum(array_map(function($product) {
                return $product['price'] * $product['quantity'];
            }, $inventory));
            
            // Count products with low stock (less than 10 items)
            $lowStock = count(array_filter($inventory, function($product) {
                return $product['quantity'] < 10;
            }));
            
            // Get unique categories from inventory
            $categories = array_unique(array_column($inventory, 'category'));
            ?>

            <!-- ======================================== -->
            <!-- USER INTERFACE - HTML OUTPUT SECTION -->
            <!-- ======================================== -->
            
            <!-- Display success/error messages if they exist -->
            <?php if (isset($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- ======================================== -->
            <!-- STATISTICS DASHBOARD -->
            <!-- ======================================== -->
            <!-- This section displays key metrics about the inventory -->
            <div class="stats">
                <!-- Total Products Card -->
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalProducts; ?></div>
                    <div class="stat-label">Total Products</div>
                </div>
                <!-- Total Value Card -->
                <div class="stat-card">
                    <div class="stat-number">$<?php echo number_format($totalValue, 2); ?></div>
                    <div class="stat-label">Total Value</div>
                </div>
                <!-- Low Stock Items Card -->
                <div class="stat-card">
                    <div class="stat-number"><?php echo $lowStock; ?></div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
                <!-- Categories Card -->
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($categories); ?></div>
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
                                <!-- Dynamically populate categories from existing inventory -->
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
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        <?php if (empty($filteredInventory)): ?>
                            <!-- Display message when no products are found -->
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                                    <?php echo empty($inventory) ? 'No products in inventory. Add your first product above!' : 'No products match your search criteria.'; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <!-- Loop through each product in the filtered inventory -->
                            <?php foreach ($filteredInventory as $product): ?>
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

            <!-- ======================================== -->
            <!-- JSON DATA DISPLAY SECTION -->
            <!-- ======================================== -->
            <!-- This section shows the raw JSON data for educational purposes -->
            <div class="form-section">
                <h2>📄 JSON Data Structure</h2>
                <p>Below is the raw JSON data stored in the inventory file:</p>
                <!-- Display the JSON file contents in a formatted pre tag -->
                <pre style="background: #f8f9fa; padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 12px;">
                    <?php 
                    // Check if JSON file exists and display its contents
                    // If file doesn't exist, show "No data yet"
                    echo file_exists($jsonFile) ? htmlspecialchars(file_get_contents($jsonFile)) : 'No data yet'; 
                    ?>
                </pre>
            </div>
        </div>
    </div>
</body>
</html>
