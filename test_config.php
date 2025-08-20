<?php
/**
 * Simple configuration test
 */

echo "<h1>Configuration Test</h1>";

// Test 1: Check if file exists
echo "<h2>1. File Check</h2>";
$configFile = 'conf/google_oauth.php';
if (file_exists($configFile)) {
    echo "<p>✓ Configuration file exists: $configFile</p>";
} else {
    echo "<p>✗ Configuration file not found: $configFile</p>";
    exit;
}

// Test 2: Try to include the file
echo "<h2>2. File Include</h2>";
try {
    require_once $configFile;
    echo "<p>✓ Configuration file included successfully</p>";
} catch (Exception $e) {
    echo "<p>✗ Error including file: " . $e->getMessage() . "</p>";
    exit;
}

// Test 3: Check if constants are defined
echo "<h2>3. Constants Check</h2>";
$constants = [
    'GOOGLE_CLIENT_ID',
    'GOOGLE_CLIENT_SECRET', 
    'GOOGLE_REDIRECT_URI',
    'GOOGLE_AUTH_URL',
    'GOOGLE_TOKEN_URL',
    'GOOGLE_USERINFO_URL',
    'GOOGLE_SCOPES'
];

foreach ($constants as $constant) {
    if (defined($constant)) {
        echo "<p>✓ $constant: " . constant($constant) . "</p>";
    } else {
        echo "<p>✗ $constant: Not defined</p>";
    }
}

// Test 4: Check if values are not placeholder
echo "<h2>4. Credential Values</h2>";
if (defined('GOOGLE_CLIENT_ID') && GOOGLE_CLIENT_ID === 'YOUR_GOOGLE_CLIENT_ID') {
    echo "<p>⚠ GOOGLE_CLIENT_ID is still placeholder</p>";
} else {
    echo "<p>✓ GOOGLE_CLIENT_ID has custom value</p>";
}

if (defined('GOOGLE_CLIENT_SECRET') && GOOGLE_CLIENT_SECRET === 'YOUR_GOOGLE_CLIENT_SECRET') {
    echo "<p>⚠ GOOGLE_CLIENT_SECRET is still placeholder</p>";
} else {
    echo "<p>✓ GOOGLE_CLIENT_SECRET has custom value</p>";
}

// Test 5: Generate OAuth URL
echo "<h2>5. OAuth URL Test</h2>";
if (defined('GOOGLE_CLIENT_ID') && defined('GOOGLE_REDIRECT_URI')) {
    $params = [
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'scope' => 'email profile',
        'response_type' => 'code',
        'access_type' => 'offline'
    ];
    
    $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    echo "<p>✓ OAuth URL generated:</p>";
    echo "<p><code>" . htmlspecialchars($authUrl) . "</code></p>";
} else {
    echo "<p>✗ Cannot generate OAuth URL</p>";
}

echo "<hr>";
echo "<p><a href='/forumblog'>← Back to home</a></p>";
?> 