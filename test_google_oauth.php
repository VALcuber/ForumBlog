<?php
/**
 * Test file for Google OAuth integration
 * This file helps verify that your Google OAuth setup is working correctly
 */

// Include configuration
require_once 'conf/google_oauth.php';

echo "<h1>Google OAuth Configuration Test</h1>";

// Test 1: Check if constants are defined
echo "<h2>1. Configuration Constants</h2>";
echo "<ul>";
echo "<li>GOOGLE_CLIENT_ID: " . (defined('GOOGLE_CLIENT_ID') ? '✓ Defined' : '✗ Not defined') . "</li>";
echo "<li>GOOGLE_CLIENT_SECRET: " . (defined('GOOGLE_CLIENT_SECRET') ? '✓ Defined' : '✗ Not defined') . "</li>";
echo "<li>GOOGLE_REDIRECT_URI: " . (defined('GOOGLE_REDIRECT_URI') ? '✓ Defined' : '✗ Not defined') . "</li>";
echo "</ul>";

// Test 2: Check if values are not placeholder
echo "<h2>2. Configuration Values</h2>";
echo "<ul>";
echo "<li>Client ID: " . (GOOGLE_CLIENT_ID === 'YOUR_GOOGLE_CLIENT_ID' ? '✗ Still placeholder' : '✓ Custom value') . "</li>";
echo "<li>Client Secret: " . (GOOGLE_CLIENT_SECRET === 'YOUR_GOOGLE_CLIENT_SECRET' ? '✗ Still placeholder' : '✓ Custom value') . "</li>";
echo "<li>Redirect URI: " . (GOOGLE_REDIRECT_URI === 'http://yourdomain.com/google-callback' ? '✗ Still placeholder' : '✓ Custom value') . "</li>";
echo "</ul>";

// Test 3: Check cURL extension
echo "<h2>3. PHP Extensions</h2>";
echo "<ul>";
echo "<li>cURL Extension: " . (extension_loaded('curl') ? '✓ Enabled' : '✗ Not enabled') . "</li>";
echo "<li>PDO Extension: " . (extension_loaded('pdo') ? '✓ Enabled' : '✗ Not enabled') . "</li>";
echo "<li>PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✓ Enabled' : '✗ Not enabled') . "</li>";
echo "</ul>";

// Test 4: Check database connection
echo "<h2>4. Database Connection</h2>";
try {
    require_once 'conf/db.php';
    $db = DB::connToDB();
    echo "<p>✓ Database connection successful</p>";
    
    // Check if google_id column exists
    $stmt = $db->prepare("SHOW COLUMNS FROM users LIKE 'google_id'");
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($result) {
        echo "<p>✓ google_id column exists in users table</p>";
    } else {
        echo "<p>✗ google_id column not found in users table</p>";
        echo "<p>Run the update_database.sql script to add it.</p>";
    }
    
} catch (Exception $e) {
    echo "<p>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test 5: Generate OAuth URL
echo "<h2>5. OAuth URL Generation</h2>";
if (defined('GOOGLE_CLIENT_ID') && defined('GOOGLE_REDIRECT_URI')) {
    $params = [
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'scope' => 'email profile',
        'response_type' => 'code',
        'access_type' => 'offline'
    ];
    
    $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    echo "<p>✓ OAuth URL generated successfully</p>";
    echo "<p><strong>Test URL:</strong> <a href='$authUrl' target='_blank'>Click here to test Google OAuth</a></p>";
} else {
    echo "<p>✗ Cannot generate OAuth URL - missing configuration</p>";
}

// Test 6: Security Check
echo "<h2>6. Security Check</h2>";
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
echo "<p>HTTPS: " . ($isHttps ? '✓ Enabled' : '⚠ Not enabled (required for production)') . "</p>";

// Test 7: Next Steps
echo "<h2>7. Next Steps</h2>";
echo "<ol>";
echo "<li>Update the configuration in conf/google_oauth.php with your actual Google credentials</li>";
echo "<li>Run the update_database.sql script to update your database</li>";
echo "<li>Test the OAuth flow by clicking the test URL above</li>";
echo "<li>Check that users are created/updated in your database</li>";
echo "</ol>";

echo "<h2>8. Troubleshooting</h2>";
echo "<p>If you encounter issues:</p>";
echo "<ul>";
echo "<li>Check the browser console for JavaScript errors</li>";
echo "<li>Check your PHP error logs</li>";
echo "<li>Verify your Google Cloud Console settings</li>";
echo "<li>Ensure redirect URIs match exactly</li>";
echo "</ul>";

echo "<hr>";
echo "<p><em>This test file should be removed in production for security reasons.</em></p>";
?> 