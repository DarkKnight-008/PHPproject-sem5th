<?php
// Test database connection file
// Use this to verify your database setup before deploying

echo "<h2>Database Connection Test</h2>";

// Test 1: Basic PHP functionality
echo "<h3>Test 1: PHP Basic Functionality</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "mysqli extension loaded: " . (extension_loaded('mysqli') ? 'Yes' : 'No') . "<br>";
echo "pdo_mysql extension loaded: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "<br>";

// Test 2: Configuration file
echo "<h3>Test 2: Configuration File</h3>";
if (file_exists('config.php')) {
    echo "config.php exists: Yes<br>";
    require_once 'config.php';
    echo "DB_HOST: " . DB_HOST . "<br>";
    echo "DB_USERNAME: " . DB_USERNAME . "<br>";
    echo "DB_NAME: " . DB_NAME . "<br>";
} else {
    echo "config.php exists: No<br>";
    die("Configuration file not found!");
}

// Test 3: Database connection
echo "<h3>Test 3: Database Connection</h3>";
try {
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if (!$conn) {
        echo "Connection failed: " . mysqli_connect_error() . "<br>";
        echo "Error number: " . mysqli_connect_errno() . "<br>";
    } else {
        echo "Connection successful!<br>";
        echo "Server info: " . mysqli_get_server_info($conn) . "<br>";
        
        // Test 4: Table existence
        echo "<h3>Test 4: Table Structure</h3>";
        $result = $conn->query("SHOW TABLES LIKE 'notes'");
        if ($result && $result->num_rows > 0) {
            echo "Table 'notes' exists: Yes<br>";
            
            // Check table structure
            $structure = $conn->query("DESCRIBE notes");
            if ($structure) {
                echo "<h4>Table Structure:</h4>";
                echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
                while ($row = $structure->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Field'] . "</td>";
                    echo "<td>" . $row['Type'] . "</td>";
                    echo "<td>" . $row['Null'] . "</td>";
                    echo "<td>" . $row['Key'] . "</td>";
                    echo "<td>" . $row['Default'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            // Check record count
            $count = $conn->query("SELECT COUNT(*) as total FROM notes");
            if ($count) {
                $row = $count->fetch_assoc();
                echo "Total records in notes table: " . $row['total'] . "<br>";
            }
        } else {
            echo "Table 'notes' exists: No<br>";
            echo "You need to run the setup_database.sql script first!<br>";
        }
        
        mysqli_close($conn);
    }
} catch (Exception $e) {
    echo "Exception occurred: " . $e->getMessage() . "<br>";
}

// Test 5: File permissions
echo "<h3>Test 5: File Permissions</h3>";
$files = ['index.php', 'process.php', 'db.php', 'config.php', '.htaccess'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "$file: " . (is_readable($file) ? 'Readable' : 'Not readable') . 
             ", " . (is_writable($file) ? 'Writable' : 'Not writable') . "<br>";
    } else {
        echo "$file: Not found<br>";
    }
}

echo "<h3>Test Complete!</h3>";
echo "If you see any errors above, please fix them before deploying.<br>";
echo "If all tests pass, your application should work correctly.";
?>
