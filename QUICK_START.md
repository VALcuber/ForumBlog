# 🚀 Quick Start: Google OAuth in 5 Minutes

## Immediate Steps

### 1. Get Google Credentials (2 min)
- Go to [Google Cloud Console](https://console.cloud.google.com/)
- Create new project or select existing
- Enable Google+ API
- Go to "Credentials" → "Create Credentials" → "OAuth 2.0 Client IDs"
- Set redirect URI: `http://forumblog/google-callback` (for your domain)
- Copy **Client ID** and **Client Secret**

### 2. Update Configuration (1 min)
Edit `conf/google_oauth.php`:
```php
define('GOOGLE_CLIENT_ID', '123456789-abcdef.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'GOCSPX-your_secret_here');
define('GOOGLE_REDIRECT_URI', 'http://localhost/forumblog/google-callback');
```

### 3. Update Database (1 min)
Run this SQL in your database:
```sql
ALTER TABLE `users` ADD COLUMN `google_id` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;
```

### 4. Test (1 min)
- Visit `http://localhost/forumblog/test_google_oauth.php`
- Click "Sign in with Google" on your site
- Complete OAuth flow

## ✅ What You Get

- **Google Login Button** in login/registration forms
- **Automatic User Creation** when new users sign in
- **Account Linking** for existing users
- **Secure OAuth 2.0** implementation
- **Mobile Responsive** design

## 🔧 Troubleshooting

- **"redirect_uri_mismatch"** → Check redirect URI in Google Console
- **"invalid_client"** → Verify Client ID/Secret
- **Database errors** → Run the SQL script above
- **cURL errors** → Enable cURL extension in PHP

## 📚 Full Documentation

- **Setup Guide**: `GOOGLE_OAUTH_SETUP.md`
- **README**: `README_GOOGLE_OAUTH.md`
- **Test File**: `test_google_oauth.php`

---

**Need Help?** Check the detailed setup guide in `GOOGLE_OAUTH_SETUP.md` 