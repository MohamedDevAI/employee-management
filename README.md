# Employee Management System

A comprehensive PHP-based employee management system with attendance tracking, built with a clean MVC architecture.

## Features

**Employee Management**
- Add new employees with complete details
- List all employees with pagination
- Search employees by name, ID, iqama, or email
- Inline editing for employee details
- Soft delete functionality (reversible)
- Employee fields: ID, Punch ID, Name, Iqama ID, Nationality, Email, Phone, Department, Position, Hire Date, Salary

**Attendance Tracking**
- Separate check-in/check-out table
- Quick check-in/out with employee ID
- Track work hours automatically
- View attendance history by date range
- Real-time attendance records

**Database**
- Well-structured MySQL database with proper relationships
- Two main tables: `employees` and `attendance`
- Soft delete support with `deleted_at` timestamp
- Proper indexing for performance

**Design**
- Clean, modern UI with Bootstrap 5
- Responsive design for mobile and desktop
- Intuitive navigation
- Professional styling with custom CSS

## Project Structure

```
employee-management/
├── app/
│   ├── Models/
│   │   ├── Employee.php          # Employee model with CRUD operations
│   │   └── Attendance.php        # Attendance model
│   ├── Controllers/
│   │   ├── EmployeeController.php
│   │   └── AttendanceController.php
│   └── Views/
│       ├── employees.php         # Employee list and management
│       ├── attendance.php        # Attendance tracking
│       ├── header.php
│       └── footer.php
├── config/
│   └── Database.php              # Database connection class
├── database/
│   └── schema.sql                # Database schema (run this first!)
├── public/
│   ├── api/
│   │   ├── employees.php         # API endpoints for employees
│   │   └── attendance.php        # API endpoints for attendance
│   ├── css/
│   │   └── style.css            # Custom styles
│   └── js/
│       ├── employees.js         # Employee management JS
│       └── attendance.js        # Attendance management JS
├── index.php                     # Entry point
└── README.md
```

## Setup Instructions

### 1. Create Database

1. Open Laragon Control Panel
2. Click "Database" button (opens phpMyAdmin)
3. Create a new database named `employee_management`
4. Go to SQL tab and import the schema from `database/schema.sql`

**Or run this SQL directly:**

```sql
CREATE DATABASE employee_management;
USE employee_management;

-- Import from database/schema.sql file
```

### 2. Configure Database Connection

Edit `config/Database.php` and update credentials if needed:

```php
private $host = 'localhost';
private $db_name = 'employee_management';
private $user = 'root';
private $password = '';  // Usually empty in Laragon
```

### 3. Access the Application

1. Start Laragon
2. Navigate to: `http://localhost/employee-management/`

## How to Use

### Employee Management

**Add Employee:**
- Click "Add Employee" button
- Fill in all required fields
- Click "Add Employee"

**List Employees:**
- All employees are displayed in a table
- Use search box to find specific employees
- View pagination at the bottom

**Edit Employee (Inline):**
- Click on any field (Department, Position, Email, Phone) to edit
- Press Enter to save or Escape to cancel
- Or use Edit button to open full edit modal

**Delete Employee:**
- Click Delete button
- Confirm deletion
- Employee is soft-deleted (can be restored from database if needed)

### Attendance Tracking

**Quick Check-in/out:**
- Go to Attendance page
- Enter Employee ID
- Click "Check In" or "Check Out"
- Records update automatically

**View Attendance:**
- Recent attendance records displayed in table
- Shows check-in time, check-out time, and work hours
- Status badge indicates if employee is currently checked in

## Database Schema

### Employees Table
- `id` - Primary key
- `employee_id` - Unique employee identifier
- `punch_id` - Unique punch card ID
- `employee_name` - Full name
- `iqama_id` - Saudi Iqama ID
- `nationality` - Employee nationality
- `email` - Email address
- `phone` - Phone number
- `department` - Department name
- `position` - Job position
- `hire_date` - Hire date
- `salary` - Salary amount
- `is_deleted` - Soft delete flag (0 = active, 1 = deleted)
- `deleted_at` - Deletion timestamp
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Attendance Table
- `id` - Primary key
- `employee_id` - Foreign key to employees
- `check_in_time` - Check-in datetime
- `check_out_time` - Check-out datetime (nullable)
- `work_hours` - Calculated work hours
- `notes` - Additional notes
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Key Features Explained

### Soft Delete
Employees are not permanently deleted. Instead, a `deleted_at` timestamp is set and `is_deleted` flag is set to true. This allows for recovery if needed.

### Inline Editing
Click on employee fields to edit them directly without opening a modal. Perfect for quick updates.

### Attendance Tracking
Separate table structure keeps attendance records independent from employee data, allowing for historical data analysis.

### Responsive Design
The application works seamlessly on desktop, tablet, and mobile devices.

## Tips & Best Practices

1. **Always backup your database** before making major changes
2. **Use Search** feature to find employees quickly
3. **Check Attendance daily** to ensure accurate records
4. **Use unique values** for Employee ID, Punch ID, and Iqama ID
5. **Soft deleted employees** are hidden from the main list but data is retained

## Troubleshooting

**Database Connection Error:**
- Check if MySQL is running in Laragon
- Verify credentials in `config/Database.php`
- Ensure database exists

**Employees not loading:**
- Check browser console for errors (F12)
- Verify database tables are created
- Check file permissions

**API endpoints not working:**
- Verify `.php` files are in `public/api/` folder
- Check Laragon Apache is running
- Clear browser cache

## Technologies Used

- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript (ES6)
- **Framework/Library:** Bootstrap 5, PDO

## License

Free to use and modify.

---

For more help or customization, consult the code comments in each file. 
