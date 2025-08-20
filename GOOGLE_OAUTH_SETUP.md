# Google OAuth 2.0 Integration Setup Guide

## Overview
This guide explains how to set up Google OAuth 2.0 authentication for your ForumBlog project.

## Prerequisites
- Google account
- Access to Google Cloud Console
- PHP with cURL extension enabled
- HTTPS enabled on your domain (required by Google)

## Step 1: Create Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API and Google OAuth2 API

## Step 2: Configure OAuth Consent Screen

1. Go to "APIs & Services" > "OAuth consent screen"
2. Choose "External" user type
3. Fill in required information:
   - App name: Your forum/blog name
   - User support email: Your email
   - Developer contact information: Your email
4. Add scopes: `email` and `profile`
5. Add test users if needed

## Step 3: Create OAuth 2.0 Credentials

1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "OAuth 2.0 Client IDs"
3. Choose "Web application"
4. Set authorized redirect URIs:
   - `http://localhost/forumblog/google-callback` (for your domain)
5. Copy the Client ID and Client Secret

## Step 4: Update Configuration

1. Open `conf/google_oauth.php`
2. Replace placeholder values:
   ```php
   define('GOOGLE_CLIENT_ID', 'YOUR_ACTUAL_CLIENT_ID');
   define('GOOGLE_CLIENT_SECRET', 'YOUR_ACTUAL_CLIENT_SECRET');
   define('GOOGLE_REDIRECT_URI', 'http://localhost/google-callback');
   ```

## Step 5: Update Database

1. Run the SQL script `update_database.sql` to add the `google_id` field
2. Or manually execute:
   ```sql
   ALTER TABLE `users` ADD COLUMN `google_id` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;
   ALTER TABLE `users` ADD INDEX `idx_google_id` (`google_id`);
   ```

## Step 6: Test the Integration

1. Visit your site and click "Sign in with Google"
2. You should be redirected to Google's consent screen
3. After authorization, you'll be redirected back to your site
4. Check if user is created/updated in the database

## Security Considerations

1. **HTTPS Required**: Google OAuth requires HTTPS in production
2. **Client Secret**: Never expose your client secret in client-side code
3. **State Parameter**: Consider adding CSRF protection with state parameter
4. **Token Validation**: Always validate tokens on the server side

## Troubleshooting

### Common Issues:

1. **"redirect_uri_mismatch"**: Check if redirect URI matches exactly in Google Console
2. **"invalid_client"**: Verify Client ID and Secret are correct
3. **"access_denied"**: User may have cancelled the authorization
4. **cURL errors**: Ensure cURL extension is enabled in PHP

### Debug Steps:

1. Check browser console for JavaScript errors
2. Check PHP error logs
3. Verify database connection and table structure
4. Test with Google's OAuth 2.0 Playground

## Files Modified/Created

- `controllers/GoogleAuthController.php` - Main OAuth controller
- `conf/google_oauth.php` - Configuration file
- `conf/db.php` - Database schema update
- `conf/router.php` - New routes added
- `templates/footer.tpl` - UI buttons added
- `update_database.sql` - Database update script

## Next Steps

1. Add error handling and user feedback
2. Implement refresh token logic for long-term access
3. Add user profile picture from Google
4. Consider adding other OAuth providers (Facebook, GitHub, etc.)
5. Add account linking (connect existing account to Google)

## Support

If you encounter issues:
1. Check Google Cloud Console for API quotas and errors
2. Verify all configuration values are correct
3. Ensure your domain is properly configured
4. Test with a simple OAuth flow first 