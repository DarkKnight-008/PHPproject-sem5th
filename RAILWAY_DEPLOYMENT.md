# Railway.app Deployment Guide for iNotes CRUD

## Prerequisites

1. **Railway Account**: Sign up at [railway.app](https://railway.app)
2. **GitHub Account**: Your project should be in a GitHub repository
3. **MySQL Database**: You'll need to add a MySQL service in Railway

## Step-by-Step Deployment

### 1. Prepare Your Repository

Ensure your project is pushed to GitHub with these files:
- `index.php`
- `process.php`
- `db.php`
- `config.php`
- `railway.json`
- `Procfile`
- `.htaccess` (optional for Railway)

### 2. Create Railway Project

1. **Login to Railway** and click "New Project"
2. **Choose "Deploy from GitHub repo"**
3. **Select your repository** containing the iNotes CRUD project
4. **Wait for initial build** (this may take a few minutes)

### 3. Add MySQL Database Service

1. **In your Railway project**, click "New Service"
2. **Choose "Database"** → "MySQL"
3. **Wait for MySQL to be provisioned**
4. **Note down the connection details** (you'll need these for environment variables)

### 4. Configure Environment Variables

In your Railway project, go to the **Variables** tab and add these environment variables:

#### Required Environment Variables:

```bash
# Database Configuration
DB_HOST=your_mysql_host_from_railway
DB_USERNAME=your_mysql_username_from_railway
DB_PASSWORD=your_mysql_password_from_railway
DB_NAME=your_mysql_database_name_from_railway

# Application Settings
DEBUG_MODE=false
RAILWAY_ENVIRONMENT=production
```

#### How to Get Database Values:

1. **Click on your MySQL service** in Railway
2. **Go to "Connect" tab**
3. **Copy the values from the connection string**:
   - `DB_HOST`: The hostname (usually ends with `.railway.app`)
   - `DB_USERNAME`: The username
   - `DB_PASSWORD`: The password
   - `DB_NAME`: The database name

### 5. Set Up Database

1. **Go to your MySQL service** in Railway
2. **Click "Query" tab**
3. **Run the database setup script** (copy from `setup_database.sql`):

```sql
-- Create notes table with proper column names (no spaces)
CREATE TABLE IF NOT EXISTS notes (
    sno INT AUTO_INCREMENT PRIMARY KEY,
    note_title VARCHAR(255) NOT NULL,
    note_description TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data (optional)
INSERT INTO notes (note_title, note_description) VALUES 
('Welcome Note', 'Welcome to iNotes! This is your first note.'),
('Sample Note', 'This is a sample note to get you started.');
```

### 6. Deploy and Test

1. **Railway will automatically redeploy** when you push changes to GitHub
2. **Check the deployment logs** for any errors
3. **Visit your app URL** (Railway will provide this)
4. **Test all CRUD operations**:
   - Create a note
   - Edit a note
   - Delete a note
   - View notes

## Environment Variables Reference

| Variable | Description | Required | Example |
|----------|-------------|----------|---------|
| `DB_HOST` | MySQL hostname | Yes | `containers-us-west-123.railway.app` |
| `DB_USERNAME` | MySQL username | Yes | `root` |
| `DB_PASSWORD` | MySQL password | Yes | `your_password_here` |
| `DB_NAME` | MySQL database name | Yes | `railway` |
| `DEBUG_MODE` | Enable debug mode | No | `false` |
| `RAILWAY_ENVIRONMENT` | Identify Railway deployment | No | `production` |

## Railway-Specific Features

### Automatic Deployments
- Railway automatically deploys when you push to your main branch
- You can also trigger manual deployments from the dashboard

### Health Checks
- Railway will monitor your app at the root path (`/`)
- If health checks fail, Railway will restart your service

### Scaling
- Railway can automatically scale your app based on traffic
- You can also manually adjust the number of instances

### Custom Domains
- Railway provides a default domain (e.g., `your-app.railway.app`)
- You can add custom domains in the settings

## Troubleshooting

### Common Issues:

1. **Build Failures**:
   - Check Railway build logs
   - Ensure all required files are in your repository
   - Verify `railway.json` syntax

2. **Database Connection Issues**:
   - Verify environment variables are set correctly
   - Check if MySQL service is running
   - Ensure database and table exist

3. **App Not Starting**:
   - Check deployment logs
   - Verify `Procfile` is correct
   - Ensure PHP is available in the build

### Debug Mode:

To enable debug mode temporarily:
```bash
DEBUG_MODE=true
```

This will show detailed error messages (remember to set it back to `false` in production).

## Monitoring and Logs

1. **View logs** in the Railway dashboard
2. **Monitor performance** and resource usage
3. **Set up alerts** for failures
4. **Check health status** regularly

## Security Considerations

1. **Environment Variables**: Never commit sensitive data to your repository
2. **Database Access**: Railway MySQL is only accessible from your app
3. **HTTPS**: Railway automatically provides HTTPS
4. **Updates**: Keep your dependencies updated

## Cost Optimization

1. **Free Tier**: Railway offers a generous free tier
2. **Resource Limits**: Monitor your usage to stay within limits
3. **Auto-scaling**: Use auto-scaling to optimize costs

## Support

If you encounter issues:
1. Check Railway documentation
2. Review build and deployment logs
3. Verify environment variables
4. Test database connectivity
5. Contact Railway support if needed

## Success Checklist

- [ ] Project deployed to Railway
- [ ] MySQL service added and configured
- [ ] Environment variables set correctly
- [ ] Database table created
- [ ] App accessible via Railway URL
- [ ] All CRUD operations working
- [ ] Debug mode disabled for production
- [ ] Custom domain configured (optional)

Your iNotes CRUD application should now be successfully deployed on Railway! 🚀
