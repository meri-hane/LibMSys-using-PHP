# Library Management System - Documentation


_This repository serves as a Final Project for PHP Database in CS Professional Elective 4 at Technological University of the Philippines - Manila_

## OVERVIEW

Welcome to the Library Management System! This system is designed to manage the operations of a library, including librarian management, member management, borrowing, and returning books. The system is built using PHP for the backend and MySQL for the database.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Features
This system provides different functionalities based on the account's role.
- **Admin**
  - ALL ACCESS
  - View dashboard
  - Can create, read, update, and delete records
  - View Books, Librarians, Memebers, and Transaction

- **Librarian**
  - View dashboard
  - Can create, read, and update records

- **Member**
  - Can only view the signed-in account information
  - Can view books

## Requirements
- Web server (e.g., Apache)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (for accessing the application)
- Editor (VS Code, Sublime Text, etc..)

## Installation
### Step 1: Clone the Repository
    ```bash
    git clone https://github.com/meri-hane/crud.git
    ```
### Step 2: Navigate to the Project Directory
    ```bash
    cd library-management-system
    ```
### Step 3: Set Up the Database
1. Open your MySQL command line or MySQL Workbench.
2. Create a new database:
    ```sql
    CREATE DATABASE library_db;
    ```
3. Import the database schema:
    ```bash
    mysql -u username -p library_db < database/schema.sql
    ```
### Step 4: Configure the Application
### Step 5: Start the Web Server
Ensure your web server is running and navigate to the project directory.

## System 

## Troubleshooting

### Common Issues
- **Database Connection Error**: Ensure your database credentials in `config.php` are correct.
- **Page Not Found**: Verify your server configuration and ensure the project directory is correctly set up.
- **Permission Errors**: Ensure the web server has appropriate permissions to read/write files in the project directory.

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request with your changes. Ensure your code follows the project's coding standards and includes appropriate tests.

## License
This project is licensed under the MIT License. See the `LICENSE` file for more details.

---

Thank you for using the Library Management System! If you have any questions or need further assistance, please contact us at support@example.com.



- ### **phpMyAdmin database tables**
![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a39e8bf2-0ddd-4c4c-91e8-4cc7ad306a89)


