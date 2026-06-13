# Project Structure Documentation

## Overview

This is a professional PHP Employee Management System built with:
- **MVC Architecture** - Separation of concerns for clean code
- **MySQL Database** - Relational database with proper indexing
- **Bootstrap 5 UI** - Responsive and modern design
- **RESTful API** - JSON endpoints for data operations

---

## 📁 Directory Structure

```
employee-management/
│
├── 📄 index.php
│   └── Entry point - redirects to employees view
│
├── 📄 README.md
│   └── Full documentation
│
├── 📄 SETUP.md
│   └── Quick setup guide (START HERE!)
│
├── 📁 config/
│   └── Database.php
│       └── Database connection class (PDO)
│       └── Configure credentials here if needed
│
├── 📁 database/
│   └── schema.sql
│       └── SQL database schema
│       └── Import this to create tables
│
├── 📁 app/
│   │
│   ├── 📁 Models/
│   │   ├── Employee.php
│   │   │   └── CRUD operations for employees
│   │   │   └── Methods: getAll(), getById(), create(), update(), softDelete()
│   │   │
│   │   └── Attendance.php
│   │       └── Attendance operations
│   │       └── Methods: checkIn(), checkOut(), getByEmployeeId()
│   │
│   ├── 📁 Controllers/
│   │   ├── EmployeeController.php
│   │   │   └── Handles employee requests
│   │   │   └── Methods: index(), store(), update(), delete(), restore()
│   │   │
│   │   └── AttendanceController.php
│   │       └── Handles attendance requests
│   │       └── Methods: checkIn(), checkOut(), getTodayStatus()
│   │
│   └── 📁 Views/
│       ├── header.php
│       │   └── Navigation bar
│       │
│       ├── footer.php
│       │   └── Footer and script imports
│       │
│       ├── employees.php
│       │   └── Employees list page
│       │   └── Add/Edit employee modals
│       │
│       └── attendance.php
│           └── Attendance tracking page
│           └── Quick check-in/out interface
│
├── 📁 public/
│   │
│   ├── 📁 api/
│   │   ├── employees.php
│   │   │   └── API endpoints for employees
│   │   │   └── Actions: list, show, search, create, update, delete
│   │   │
│   │   └── attendance.php
│   │       └── API endpoints for attendance
│   │       └── Actions: list, check_in, check_out, today
│   │
│   ├── 📁 css/
│   │   └── style.css
│   │       └── Custom styling
│   │       └── Bootstrap 5 customization
│   │       └── Responsive design rules
│   │
│   └── 📁 js/
│       ├── employees.js
│       │   └── Employee list functionality
│       │   └── Add/Edit/Delete operations
│       │   └── Search and pagination
│       │   └── Inline editing
│       │
│       └── attendance.js
│           └── Attendance tracking functionality
│           └── Check-in/out operations
│           └── Real-time record display
```

---

## 🔄 Data Flow

### Adding an Employee
1. User fills form in `employees.php`
2. JavaScript (`employees.js`) sends POST request to `public/api/employees.php`
3. `EmployeeController` receives request and calls `Employee->create()`
4. `Employee` model inserts data into database
5. Response sent back as JSON
6. JavaScript updates table with new employee

### Check-in/Out Process
1. User enters Employee ID in `attendance.php`
2. JavaScript sends POST to `public/api/attendance.php`
3. `AttendanceController` calls `Attendance->checkIn()` or `Attendance->checkOut()`
4. Database records timestamp and calculates work hours
5. Response confirms success
6. Attendance list updates in real-time

### Edit Employee Inline
1. User clicks on a table cell (e.g., department)
2. Cell converts to input field
3. User types new value and presses Enter
4. JavaScript sends update request
5. Field saves and reverts to text display
6. No page refresh needed

---

## 🗄️ Database Schema

### employees Table
```sql
id (INT)                    -- Primary key, auto-increment
employee_id (VARCHAR)       -- Unique employee number
punch_id (VARCHAR)          -- Unique punch card ID
employee_name (VARCHAR)     -- Full name
iqama_id (VARCHAR)          -- Saudi Iqama ID
nationality (VARCHAR)       -- Country of origin
email (VARCHAR)             -- Email address
phone (VARCHAR)             -- Phone number
department (VARCHAR)        -- Department assignment
position (VARCHAR)          -- Job title
hire_date (DATE)            -- Employment start date
salary (DECIMAL)            -- Monthly salary
created_at (TIMESTAMP)      -- Record creation time
updated_at (TIMESTAMP)      -- Last modification time
deleted_at (TIMESTAMP)      -- Soft delete timestamp
is_deleted (BOOLEAN)        -- Deletion flag (0=active, 1=deleted)
```

### attendance Table
```sql
id (INT)                    -- Primary key, auto-increment
employee_id (INT)           -- Foreign key to employees.id
check_in_time (DATETIME)    -- Clock-in timestamp
check_out_time (DATETIME)   -- Clock-out timestamp (nullable)
work_hours (DECIMAL)        -- Calculated hours worked
notes (VARCHAR)             -- Any additional notes
created_at (TIMESTAMP)      -- Record creation time
updated_at (TIMESTAMP)      -- Last modification time
```

---

## 🔐 Key Design Features

### 1. **Soft Delete**
- Employees marked as deleted but not removed from DB
- `is_deleted = true` and `deleted_at` timestamp set
- Can be restored if needed
- Implementation: All queries check `WHERE is_deleted = FALSE`

### 2. **Separate Attendance Table**
- Attendance records independent from employee data
- Allows historical tracking
- Multiple check-in/out records per employee per day
- Foreign key relationship maintains data integrity

### 3. **Inline Editing**
- Click any editable field to modify
- Saves without page refresh
- Provides better user experience
- Fields: department, position, email, phone

### 4. **Pagination**
- Employees listed 10 per page
- Previous/Next navigation
- Page numbers displayed
- Improves performance with large datasets

### 5. **Search Functionality**
- Search by: name, employee ID, punch ID, iqama ID, email
- Real-time filtering
- No pagination when searching

### 6. **Work Hours Calculation**
- Automatic calculation: `TIMESTAMPDIFF(HOUR, check_in_time, check_out_time)`
- Stored in database for reports
- Displayed in attendance list

---

## 🚀 API Endpoints

### Employee API
```
GET  /public/api/employees.php?action=list&page=1       -- Get employees
GET  /public/api/employees.php?action=show&id=1         -- Get single employee
GET  /public/api/employees.php?action=search&q=keyword  -- Search employees
POST /public/api/employees.php?action=create            -- Add employee
POST /public/api/employees.php?action=update            -- Update employee
POST /public/api/employees.php?action=delete            -- Soft delete
POST /public/api/employees.php?action=restore           -- Restore deleted
```

### Attendance API
```
GET  /public/api/attendance.php?action=list             -- Get all records
GET  /public/api/attendance.php?action=today&emp=id     -- Today's record
GET  /public/api/attendance.php?action=by_employee&id=1 -- Employee history
POST /public/api/attendance.php?action=check_in         -- Record check-in
POST /public/api/attendance.php?action=check_out        -- Record check-out
```

---

## 📝 Code Examples

### Add Employee (Models/Employee.php)
```php
public function create() {
    $query = "INSERT INTO employees 
              (employee_id, punch_id, employee_name, iqama_id, nationality, ...)
              VALUES (?, ?, ?, ?, ?, ...)";
    // Prepared statement execution
}
```

### Soft Delete (Models/Employee.php)
```php
public function softDelete($id) {
    $query = "UPDATE employees 
              SET is_deleted = TRUE, deleted_at = NOW() 
              WHERE id = ?";
}
```

### Check-in (Models/Attendance.php)
```php
public function checkIn() {
    $query = "INSERT INTO attendance (employee_id, check_in_time)
              VALUES (?, NOW())";
}
```

---

## 🎨 Styling

### CSS Organization (`public/css/style.css`)
- CSS Variables for colors
- Responsive breakpoints (768px, 1024px)
- Bootstrap 5 customization
- Animations and transitions
- Dark/light theme support

### Bootstrap Classes Used
- `.container` - Max width wrapper
- `.table`, `.table-hover` - Responsive tables
- `.btn`, `.btn-primary`, `.btn-danger` - Button styles
- `.modal`, `.modal-dialog` - Modal dialogs
- `.form-control`, `.form-label` - Form styling
- `.badge`, `.alert` - Status indicators

---

## 📦 Dependencies

### Backend
- PHP 7.4+ (or higher)
- MySQL 5.7+ (or MariaDB)
- PDO Extension (for database access)

### Frontend
- Bootstrap 5.3.0 (CDN)
- Bootstrap Icons 1.10.0 (CDN)
- Vanilla JavaScript (ES6)

---

## 🔍 Debugging Tips

### Enable PHP Errors
Add to top of `config/Database.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Check Browser Console
- Press F12 in browser
- Go to Console tab
- Look for JavaScript errors or network issues

### Check Laragon Logs
- Laragon Control Panel → Logs
- View Apache and MySQL error logs

### Test API Directly
- Visit: `http://localhost/employee-management/public/api/employees.php?action=list`
- Should return JSON response

---

## 🚦 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| "Database connection error" | Check MySQL is running, verify credentials |
| "No employees showing" | Import schema.sql, check database exists |
| "API returning blank" | Check public/api/ files exist |
| "Inline edit not saving" | Check browser console for JS errors |
| "Pagination not working" | Verify page parameter in URL |
| "Search returning nothing" | Check searchable fields in model |

---

## 📋 Development Checklist

- [x] Database schema created
- [x] Models with CRUD operations
- [x] Controllers handling requests
- [x] API endpoints implemented
- [x] Views/UI created
- [x] CSS styling applied
- [x] JavaScript functionality added
- [x] Soft delete implemented
- [x] Inline editing enabled
- [x] Search functionality added
- [x] Pagination implemented
- [x] Attendance tracking added
- [x] Responsive design applied

---

**Project Complete and Ready to Use! 🎉**

For detailed setup instructions, see [SETUP.md](SETUP.md)
