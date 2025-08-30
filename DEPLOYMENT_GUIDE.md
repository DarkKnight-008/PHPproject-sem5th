# iNotes CRUD Application - Deployment Guide

## Issues Fixed

The following issues that were causing the "Bad Gateway" error have been resolved:

1. **Database column names**: Changed from `note title` and `note description` to `note_title` and `note_description`
2. **Error handling**: Added proper error handling for database operations
3. **Configuration management**: Created a centralized configuration system
4. **Security**: Added .htaccess file with security headers and file protection

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- Web server (Apache/Nginx)
- mod_rewrite enabled (for Apache)

## Step-by-Step Deployment

### 1. Database Setup

1. **Access your MySQL server** (phpMyAdmin, MySQL Workbench, or command line)
2. **Run the database setup script**:
   ```sql
   -- Copy and paste the contents of setup_database.sql
   -- Or import the file directly in phpMyAdmin
   ```

### 2. Configuration

1. **Edit `config.php`** with your database credentials:
   ```php
   define('DB_HOST', 'your_database_host');
   define('DB_USERNAME', 'your_database_username');
   define('DB_PASSWORD', 'your_database_password');
   define('DB_NAME', 'inotes');
   ```

2. **For production deployment**:
   - Set `DEBUG_MODE` to `false`
   - Update database credentials for your production server
   - Ensure proper file permissions

### 3. File Permissions

Set appropriate file permissions:
```bash
# For Linux/Unix servers
chmod 644 *.php
chmod 644 .htaccess
chmod 755 ./
```

### 4. Web Server Configuration

#### Apache Configuration
Ensure these modules are enabled:
- mod_rewrite
- mod_headers
- mod_deflate
- mod_expires

#### Nginx Configuration
If using Nginx, add this to your server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

### 5. Testing

1. **Test database connection** by visiting your application
2. **Check error logs** if issues persist:
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`
   - PHP: Check your PHP error log location

## Common Issues and Solutions

### Bad Gateway (502) Error

**Causes:**
- Database connection failure
- PHP syntax errors
- Missing PHP extensions
- Incorrect file permissions

**Solutions:**
1. Verify database credentials in `config.php`
2. Check PHP error logs
3. Ensure MySQL service is running
4. Verify PHP mysqli extension is enabled

### Database Connection Issues

**Check:**
1. Database server is running
2. Credentials are correct
3. Database exists
4. User has proper permissions

**Test connection:**
```php
<?php
$conn = mysqli_connect('host', 'user', 'pass', 'database');
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
} else {
    echo "Connection successful!";
}
?>
```

### File Not Found (404) Error

**Check:**
1. .htaccess file is present
2. mod_rewrite is enabled
3. File permissions are correct
4. Document root is set correctly

## Production Deployment Checklist

- [ ] Set `DEBUG_MODE` to `false`
- [ ] Update database credentials for production
- [ ] Set proper file permissions
- [ ] Enable HTTPS (recommended)
- [ ] Configure backup strategy
- [ ] Set up monitoring
- [ ] Test all CRUD operations
- [ ] Verify security headers

## Security Considerations

1. **Database**: Use strong passwords and limit user permissions
2. **Files**: Protect `config.php` and `db.php` from direct access
3. **HTTPS**: Enable SSL/TLS in production
4. **Updates**: Keep PHP and MySQL updated
5. **Backups**: Regular database and file backups

## Support

If you continue to experience issues:

1. Check your web server error logs
2. Verify PHP error reporting is enabled
3. Test database connectivity separately
4. Ensure all required PHP extensions are installed

## File Structure After Deployment

```
your_project/
├── index.php          # Main application file
├── process.php        # CRUD operations handler
├── db.php            # Database connection (protected)
├── config.php        # Configuration file (protected)
├── .htaccess         # Server configuration
├── setup_database.sql # Database setup script
└── DEPLOYMENT_GUIDE.md # This file
```

## Testing Your Deployment

1. **Create a note**: Fill out the form and submit
2. **Edit a note**: Click edit button and modify
3. **Delete a note**: Click delete button and confirm
4. **View notes**: Ensure the table displays correctly

If all operations work, your deployment is successful!
