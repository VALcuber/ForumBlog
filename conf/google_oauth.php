<?php

// Google OAuth 2.0 Configuration
// Replace these values with your actual Google OAuth credentials

// Your Google OAuth Client ID (from Google Cloud Console)
define('GOOGLE_CLIENT_ID', '');

// Your Google OAuth Client Secret (from Google Cloud Console)
define('GOOGLE_CLIENT_SECRET', '');

// Redirect URI (must match what you set in Google Cloud Console)
// Using forum-blog domain (requires hosts file: 127.0.0.1 forum-blog)
define('GOOGLE_REDIRECT_URI', 'http://localhost/google-callback');

// Google OAuth endpoints
define('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo');

// Scopes for user data access
define('GOOGLE_SCOPES', 'email profile');

// Where to redirect the user in your app after successful login/logout
// Use your working local domain so static assets resolve correctly
define('GOOGLE_AFTER_LOGIN_URL', 'http://localhost/');

// Error messages
define('GOOGLE_ERROR_NO_CODE', 'Authorization code not received from Google');
define('GOOGLE_ERROR_NO_TOKEN', 'Failed to get access token from Google');
define('GOOGLE_ERROR_NO_USERINFO', 'Failed to get user information from Google');

// Instructions for setup:
// 1. Go to https://console.cloud.google.com/
// 2. Select your project: "My First Project" (ID: zinc-strategy-469013-r8)
// 3. Go to APIs & Services → Credentials
// 4. Edit your OAuth 2.0 Client ID
// 5. Set redirect URI to: http://localhost/forumblog/google-callback
// 6. Configure hosts file: 127.0.0.1 forum-blog
// 7. Test with: http://localhost/forumblog/google-login 