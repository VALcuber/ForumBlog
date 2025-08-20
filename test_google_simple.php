<?php
/**
 * Simple Google OAuth Test Page
 * This page helps test the basic OAuth flow without requiring full Google setup
 */

// Include configuration
require_once 'conf/google_oauth.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Google OAuth Test</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>";
echo "</head>";
echo "<body class='bg-light'>";

echo "<div class='container mt-5'>";
echo "<div class='row justify-content-center'>";
echo "<div class='col-md-8'>";

echo "<div class='card'>";
echo "<div class='card-header bg-primary text-white'>";
echo "<h3><i class='fab fa-google'></i> Google OAuth Test Page</h3>";
echo "</div>";
echo "<div class='card-body'>";

// Test 1: Configuration Check
echo "<h4>1. Configuration Status</h4>";
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<tr><td>GOOGLE_CLIENT_ID</td><td>" . (defined('GOOGLE_CLIENT_ID') ? '✓ Defined' : '✗ Not defined') . "</td></tr>";
echo "<tr><td>GOOGLE_CLIENT_SECRET</td><td>" . (defined('GOOGLE_CLIENT_SECRET') ? '✓ Defined' : '✗ Not defined') . "</td></tr>";
echo "<tr><td>GOOGLE_REDIRECT_URI</td><td>" . (defined('GOOGLE_REDIRECT_URI') ? '✓ Defined' : '✗ Not defined') . "</td></tr>";
echo "</table>";
echo "</div>";

// Test 2: Credential Values
echo "<h4 class='mt-4'>2. Credential Values</h4>";
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<tr><td>Client ID</td><td>" . (GOOGLE_CLIENT_ID === 'YOUR_GOOGLE_CLIENT_ID' ? '<span class="text-danger">✗ Still placeholder</span>' : '<span class="text-success">✓ Custom value</span>') . "</td></tr>";
echo "<tr><td>Client Secret</td><td>" . (GOOGLE_CLIENT_SECRET === 'YOUR_GOOGLE_CLIENT_SECRET' ? '<span class="text-danger">✗ Still placeholder</span>' : '<span class="text-success">✓ Custom value</span>') . "</td></tr>";
echo "<tr><td>Redirect URI</td><td>" . (GOOGLE_REDIRECT_URI === 'http://yourdomain.com/google-callback' ? '<span class="text-danger">✗ Still placeholder</span>' : '<span class="text-success">✓ Custom value</span>') . "</td></tr>";
echo "</table>";
echo "</div>";

// Test 3: OAuth URL Generation
echo "<h4 class='mt-4'>3. OAuth URL Generation</h4>";
if (defined('GOOGLE_CLIENT_ID') && defined('GOOGLE_REDIRECT_URI')) {
    $params = [
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'scope' => 'email profile',
        'response_type' => 'code',
        'access_type' => 'offline'
    ];
    
    $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    echo "<div class='alert alert-success'>";
    echo "<strong>✓ OAuth URL generated successfully</strong><br>";
    echo "<small class='text-muted'>" . htmlspecialchars($authUrl) . "</small>";
    echo "</div>";
    
    // Test button
    if (GOOGLE_CLIENT_ID !== 'YOUR_GOOGLE_CLIENT_ID') {
        echo "<a href='$authUrl' class='btn btn-success btn-lg' target='_blank'>";
        echo "<i class='fab fa-google'></i> Test Google OAuth Flow";
        echo "</a>";
    } else {
        echo "<div class='alert alert-warning'>";
        echo "<strong>⚠ Cannot test OAuth flow</strong> - Please update credentials first";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>✗ Cannot generate OAuth URL - missing configuration</div>";
}

// Test 4: Quick Setup Instructions
echo "<h4 class='mt-4'>4. Quick Setup</h4>";
echo "<div class='alert alert-info'>";
echo "<h5>To enable Google OAuth:</h5>";
echo "<ol>";
echo "<li>Go to <a href='https://console.cloud.google.com/' target='_blank'>Google Cloud Console</a></li>";
echo "<li>Create a new project or select existing</li>";
echo "<li>Enable Google+ API</li>";
echo "<li>Go to 'Credentials' → 'Create Credentials' → 'OAuth 2.0 Client IDs'</li>";
echo "<li>Set redirect URI to: <code>http://local  host/forumblog/google-callback</code></li>";
echo "<li>Copy Client ID and Client Secret</li>";
echo "<li>Update <code>conf/google_oauth.php</code></li>";
echo "</ol>";
echo "</div>";

// Test 5: Current Status
echo "<h4 class='mt-4'>5. Current Status</h4>";
if (GOOGLE_CLIENT_ID === 'YOUR_GOOGLE_CLIENT_ID') {
    echo "<div class='alert alert-warning'>";
    echo "<strong>⚠ Setup Required</strong> - Google OAuth is not configured yet";
    echo "</div>";
} else {
    echo "<div class='alert alert-success'>";
    echo "<strong>✓ Ready to Test</strong> - Google OAuth appears to be configured";
    echo "</div>";
}

echo "</div>"; // card-body
echo "</div>"; // card

echo "<div class='text-center mt-3'>";
echo "<a href='/' class='btn btn-secondary'>← Back to Home</a>";
echo " <a href='test_google_oauth.php' class='btn btn-primary'>Full Test Page</a>";
echo "</div>";

echo "</div>"; // col
echo "</div>"; // row
echo "</div>"; // container

echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>";
echo "</body>";
echo "</html>";
?> 