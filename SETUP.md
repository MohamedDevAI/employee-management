# Quick Setup Guide

## Step 1: Start Laragon

1. Open **Laragon** application
2. Click the **Start All** button to start Apache and MySQL

## Step 2: Create Database

1. In Laragon Control Panel, click **Database** button (opens phpMyAdmin in your browser)
2. Click **New** on the left sidebar or click the **+** icon
3. Enter database name: `employee_management`
4. Click **Create**
5. Now import the schema:
   - Click on the new database `employee_management`
   - Go to **Import** tab
   - Click **Choose File** and select: `c:\laragon\www\employee-management\database\schema.sql`
   - Click **Import**

**OR run SQL directly:**
1. Click on `employee_management` database
2. Go to **SQL** tab
3. Paste the SQL from `database/schema.sql`
4. Click **Go**

## Step 3: Verify Database Connection

Edit `config/Database.php` - usually no changes needed for Laragon:

```php
private $host = 'localhost';
private $db_name = 'employee_management';
private $user = 'root';
private $password = '';  // Empty password for Laragon
```

## Step 4: Access the Application

Open your browser and go to:
```
http://localhost/employee-management/
```

You should see the Employee Management dashboard!

## Step 5: Start Using

### Add an Employee
1. Click **Add Employee** button
2. Fill in the form:
   - Employee ID (e.g., EMP001)
   - Punch ID (e.g., P001)
   - Name (e.g., John Doe)
   - Iqama ID (Saudi ID number)
   - Nationality
   - Other optional fields
3. Click **Add Employee**

### Check In/Out
1. Go to **Attendance** page (in navbar)
2. Enter Employee ID
3. Click **Check In** to record entry
4. Click **Check Out** to record exit
5. Records update automatically with timestamps and work hours

### Edit Employee
1. In employees list, click **Edit** button for any employee
2. Or click on any field to edit inline
3. Changes save automatically

### Delete Employee
1. Click **Delete** button
2. Confirm deletion
3. Employee is soft-deleted (hidden but recoverable)

## Troubleshooting

### "Connection refused" error
- ✅ Check Laragon is running (green play button)
- ✅ Check MySQL is running in Laragon
- ✅ Restart Laragon

### "Database not found" error
- ✅ Import schema.sql to phpMyAdmin
- ✅ Check database name is exactly `employee_management`

### Page shows blank or no data
- ✅ Open browser Developer Tools (F12)
- ✅ Check Console tab for JavaScript errors
- ✅ Verify API files exist in `public/api/` folder

### Can't modify files
- ✅ Check file permissions
- ✅ Run VS Code as Administrator if editing files

## File Locations Reference

- **Database schema:** `database/schema.sql`
- **Database config:** `config/Database.php`
- **Models:** `app/Models/`
- **Controllers:** `app/Controllers/`
- **Views:** `app/Views/`
- **API endpoints:** `public/api/`
- **CSS/JS:** `public/css/` and `public/js/`

## Next Steps

1. ✅ Add test employees
2. ✅ Test check-in/out functionality
3. ✅ Try inline editing
4. ✅ Test search and pagination
5. ✅ Customize styling if needed (edit `public/css/style.css`)

## Features Checklist

- ✅ Add employees
- ✅ List employees with pagination
- ✅ Search employees
- ✅ Edit employee inline
- ✅ Soft delete employees
- ✅ Check-in/check-out
- ✅ Attendance tracking
- ✅ Responsive design

Enjoy your employee management system! 🎉
