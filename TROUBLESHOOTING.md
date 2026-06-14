# 🔧 Troubleshooting Guide - Employee Not Adding to Database

## Quick Fix (3 Steps)

### Step 1: Run Automated Setup
1. Open browser and go to: **`http://localhost/employee-management/setup-database.php`**
2. This will automatically create the database and tables
3. You should see green ✓ checkmarks for each step

### Step 2: Verify Connection
1. Visit: **`http://localhost/employee-management/test-connection.php`**
2. Check if all tests show ✓ green checkmarks
3. If any show ✗, follow the instructions below

### Step 3: Try Adding Employee Again
1. Go to: `http://localhost/employee-management/`
2. Click "Add Employee"
3. Fill in the form and click "Add Employee"
4. Should see success message

---

## Common Issues & Solutions

### ❌ Issue: Database Not Found

**Symptoms:**
- Setup page shows: "Database 'employee_management' DOES NOT EXIST"
- Employees page shows blank
- No error message

**Solution:**
1. Run the automated setup: `http://localhost/employee-management/setup-database.php`
2. This will create the database automatically

**Alternative (Manual via phpMyAdmin):**
1. Open Laragon Control Panel
2. Click **Database** button
3. In phpMyAdmin, click **New**
4. Enter: `employee_management`
5. Click **Create**
6. Select the database
7. Go to **Import** tab
8. Choose: `database/schema.sql`
9. Click **Import**

---

### ❌ Issue: MySQL Connection Error

**Symptoms:**
- "Connection Error: SQLSTATE[HY000]"
- "Connection refused"
- Test page shows red ✗

**Causes & Solutions:**

**1. MySQL not running:**
- Open Laragon Control Panel
- Make sure **Start All** button shows green ✓
- If not, click **Start All**
- Wait 5 seconds and refresh page

**2. Wrong credentials:**
- Edit: `config/Database.php`
- Verify these values:
  ```php
  private $host = 'localhost';        // ← Correct for Laragon
  private $db_name = 'employee_management';
  private $user = 'root';             // ← Standard for Laragon
  private $password = '';             // ← Empty for Laragon (no password)
  ```

**3. Database not created:**
- Run: `http://localhost/employee-management/setup-database.php`

---

### ❌ Issue: Employees Table Not Found

**Symptoms:**
- Test page says: "No tables found in database"
- "Table 'employee_management.employees' doesn't exist"

**Solution:**
1. Run setup script: `http://localhost/employee-management/setup-database.php`
2. This creates all required tables automatically

**Manual way:**
1. Open phpMyAdmin
2. Select `employee_management` database
3. Go to **SQL** tab
4. Copy entire contents of `database/schema.sql`
5. Paste in SQL editor
6. Click **Go**

---

### ❌ Issue: Employee Added But Not Showing

**Symptoms:**
- No error message when adding employee
- But employee doesn't appear in list
- Database not checked

**Solutions:**

1. **Check browser console for errors:**
   - Press **F12** in browser
   - Go to **Console** tab
   - Look for red error messages
   - Report the error

2. **Check API response:**
   - Open browser console (F12)
   - Go to **Network** tab
   - Click "Add Employee"
   - Look for request to `api/employees.php`
   - Click it and view response
   - Check if response shows error

3. **Verify database:**
   - Run: `http://localhost/employee-management/test-connection.php`
   - Check if it shows employees table
   - Check if "Current Employees" count is correct

---

## Step-by-Step Verification

Follow these steps in order to debug the issue:

### ✓ Step 1: Laragon Status
- [ ] Laragon Control Panel open
- [ ] **Start All** button shows green ✓ or is already running
- [ ] MySQL is running (green indicator)
- [ ] Apache is running (green indicator)

### ✓ Step 2: Database Creation
- [ ] Visit: `http://localhost/employee-management/setup-database.php`
- [ ] All steps show green ✓ checkmarks
- [ ] If any show ✗, note the error

### ✓ Step 3: Connection Test
- [ ] Visit: `http://localhost/employee-management/test-connection.php`
- [ ] All checks pass (green ✓)
- [ ] Database exists
- [ ] Tables exist
- [ ] Shows current employee count

### ✓ Step 4: Application Access
- [ ] Visit: `http://localhost/employee-management/`
- [ ] Page loads without errors
- [ ] Navbar visible
- [ ] Employee list loads (may be empty initially)

### ✓ Step 5: Add Employee
- [ ] Click "Add Employee" button
- [ ] Modal opens
- [ ] Fill in all fields:
  - Employee ID: EMP001
  - Punch ID: P001
  - Name: Test Employee
  - Iqama ID: 1234567890
  - Nationality: Saudi
  - Other fields optional
- [ ] Click "Add Employee"
- [ ] See success message

### ✓ Step 6: Verify in Database
- [ ] Open phpMyAdmin
- [ ] Select `employee_management` database
- [ ] Click `employees` table
- [ ] Should see your new employee record

---

## Browser Developer Tools Guide

### Check for JavaScript Errors:
1. Press **F12** to open Developer Tools
2. Click **Console** tab
3. Look for red error messages
4. Note any messages starting with "Error:" or "Uncaught"

### Check API Response:
1. Press **F12** to open Developer Tools
2. Click **Network** tab
3. Keep console open
4. Click "Add Employee" in app
5. Look for request to `api/employees.php`
6. Click on it
7. Click **Response** tab
8. Check if response shows `"success": true` or error message

### Check Network Issues:
1. Press **F12** to open Developer Tools
2. Click **Network** tab
3. Reload page
4. Look for red requests (failed requests)
5. Failed requests show connection problems

---

## File Structure Verification

Make sure your project folder looks like this:

```
✓ employee-management/
  ✓ app/
    ✓ Models/
      ✓ Employee.php
      ✓ Attendance.php
    ✓ Controllers/
      ✓ EmployeeController.php
      ✓ AttendanceController.php
    ✓ Views/
      ✓ employees.php
      ✓ attendance.php
  ✓ config/
    ✓ Database.php
  ✓ database/
    ✓ schema.sql
  ✓ public/
    ✓ api/
      ✓ employees.php
      ✓ attendance.php
    ✓ css/
      ✓ style.css
    ✓ js/
      ✓ employees.js
      ✓ attendance.js
  ✓ setup-database.php
  ✓ test-connection.php
  ✓ index.php
  ✓ README.md
```

---

## If Still Not Working

### Collect Debug Information:
1. Run: `http://localhost/employee-management/test-connection.php`
2. Take screenshot of results
3. Run: `http://localhost/employee-management/setup-database.php`
4. Take screenshot of results
5. Open browser console (F12)
6. Try adding employee
7. Take screenshot of any error messages

### Check MySQL Logs:
1. Open Laragon Control Panel
2. Click **Logs** button
3. Look for MySQL errors
4. Report any error messages

### Restart Everything:
1. Close the application in browser
2. Click **Stop All** in Laragon
3. Wait 10 seconds
4. Click **Start All** in Laragon
5. Wait 10 seconds
6. Try again from Step 1

---

## Quick Links

- **Setup Database:** http://localhost/employee-management/setup-database.php
- **Test Connection:** http://localhost/employee-management/test-connection.php
- **Application:** http://localhost/employee-management/
- **phpMyAdmin:** http://localhost/phpmyadmin

---

**Still having issues?** Check that:
1. ✓ Laragon is fully running (Start All)
2. ✓ Database exists: `employee_management`
3. ✓ Tables exist: `employees` and `attendance`
4. ✓ Config has correct credentials
5. ✓ No JavaScript errors in browser console
6. ✓ API endpoints return valid JSON
