# Personal Task Manager Pro

This is a simple but powerful task management system built using the MVC (Model-View-Controller) architecture. It allows users to create, manage, and organize tasks by categories, with features like search, sorting, and reporting.

## Setup Instructions

### Requirements
- XAMPP (or similar package with PHP and MySQL)
- Web browser
- Internet connection (for some CSS/JS libraries)

### Installation Steps

1. **Install XAMPP**
   - Download XAMPP
   - Start the Apache and MySQL services from the XAMPP Control Panel

2. **Create the Database**
   - Open your web browser and navigate to http://localhost/phpmyadmin
   - Click on "New" in the left sidebar to create a new database
   - Name the database `taskmanager` and select `utf8mb4_general_ci` as the collation
   - Click "Create"

3. **Import Database Structure** (if provided)
   - In phpMyAdmin, select the `taskmanager` database
   - Click on the "Import" tab
   - Click "Choose File" and select the database.sql file from the project
   - Click "Go" to import the database structure

4. **Copy Project Files**
   - Download and extract the ZIP file from GitHub
   - Copy all files to the XAMPP htdocs folder:
     - Windows: `C:\xampp\htdocs\mvcproject`
     - macOS: `/Applications/XAMPP/htdocs/mvcproject`
     - Linux: `/opt/lampp/htdocs/mvcproject`

5. **Configure Database Connection**
   - Open the file `config/database.php` in a text editor
   - Update the database credentials if needed (default values should be):
     ```php
     $host = 'localhost';
     $dbname = 'taskmanager';
     $username = 'root';
     $password = '';
     ```

6. **Access the Application**
   - Open your web browser and navigate to http://localhost/mvcproject
   - You should see the login/registration page of the application

## Usage Guide

### Registration and Login

1. **Register a New Account**
   - Click on the "Register" link on the login page
   - Fill in your details (username, email, password)
   - Click "Register" to create your account

2. **Login to Your Account**
   - Enter your username/email and password on the login page
   - Click "Login" to access your dashboard

### Managing Tasks

1. **Create a New Task**
   - From the dashboard, click on "Add task" button
   - Fill in the task details (name, description, deadline, priority)
   - Select a category (or create a new one)
   - Click "Save" to add the task

2. **View Tasks**
   - All your tasks are displayed on the dashboard
   - Tasks are organized by categories and priority
   - Completed tasks may appear differently from active tasks

3. **Edit a Task**
   - Click on the "Edit" button next to any task
   - Modify the task details as needed
   - Click "Save" to update the task

4. **Mark a Task as Done**
   - Click the checkbox or "Done" button next to a task
   - The task will be marked as completed and may move to a completed tasks section

5. **Delete a Task**
   - Click on the "Delete" button next to any task
   - Confirm deletion when prompted
   - The task will be permanently removed

### Managing Categories

1. **Create a New Category**
   - Navigate to the "Categories" section
   - Click "Add category"
   - Enter a name and optional description
   - Click "Save" to create the category

2. **Edit a Category**
   - In the "Categories" section, click "Edit" next to any category
   - Modify the details as needed
   - Click "Save" to update

3. **Delete a Category**
   - In the "Categories" section, click "Delete" next to any category
   - Confirm deletion when prompted
   - Note: Deleting a category might affect tasks assigned to it

### Search and Filter

1. **Search for Tasks**
   - Use the search bar at the top of the dashboard
   - Enter keywords related to task title or description
   - Press Enter or click the search icon
   - Results will display tasks matching your search criteria

2. **Filter Tasks**
   - Use the filter options (category, priority, completion status)
   - Select the desired filters
   - The task list will update to show only matching tasks

3. **Sort Tasks**
   - Click on column headers (if available) to sort tasks
   - Toggle between ascending and descending order
   - Sort by due date, priority, or alphabetically by title

### Viewing Reports

1. **Access Reports**
   - Navigate to the "Reports" section from the main menu
   - Select the type of report you want to view (task completion, category distribution, etc.)

2. **Export CSV**
   - Navigate to the "Tasks" section from the main menu
   - Click "Export CSV" button
   - Save the file to your computer

## Features List

### Authentication
- User registration with validation
- Secure login with password hashing
- Password reset functionality
- Session management

### Task Management
- Create new tasks with name, description, deadline, and priority
- Edit existing tasks
- Mark tasks as complete/incomplete
- Delete tasks with confirmation
- Set due dates with calendar picker
- Assign priority levels (High, Medium, Low)

### Category Management
- Create custom categories for organizing tasks
- Edit category details
- Delete categories
- Assign tasks to specific categories

### Search and Filter
- Search tasks by keyword
- Filter tasks by category
- Filter tasks by completion status
- Filter tasks by priority level
- Filter tasks by deadline

### Reporting
- Task completion statistics
- Category distribution reports
- Overdue tasks reporting

### User Interface
- Responsive design for desktop and mobile
- Intuitive navigation
- Color-coded priority indicators
- Visual progress indicators

### Data Management
- Sorting tasks by different attributes
- Bulk operations (delete, mark complete)
- Data validation to prevent errors

## Troubleshooting

- **Application not loading**: Verify that Apache and MySQL services are running in XAMPP Control Panel
- **Database connection errors**: Check that database credentials in config file match your setup
- **Permission issues**: Ensure proper read/write permissions for the application folders
- **Registration fails**: Make sure the database structure is correctly imported

## Support

Smykovska Anna 55947
