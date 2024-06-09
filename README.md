# Library Management System - Documentation


_This repository serves as a Final Project for PHP Database in CS Professional Elective 4 at Technological University of the Philippines - Manila_

## OVERVIEW

Welcome to the Library Management System! This system is designed to manage the operations of a library, including librarian management, member management, borrowing, and returning books. The system is built using PHP for the backend and MySQL for the database.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [System](#system)
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
  - Can view books and transactions

## Requirements
- Web server (e.g., Apache)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (for accessing the application)
- Editor (VS Code, Sublime Text, etc..)

## Installation
### Step 1: Clone the Repository: git clone https://github.com/meri-hane/crud.git
 
### Step 2: Navigate to the Project Directory

### Step 3: Set Up the Database
1. Open your MySQL command line or MySQL Workbench.
2. Create a new database:
    ```sql
    CREATE DATABASE crud;
    ```
### Step 4: Configure the Application
### Step 5: Start the Web Server
Ensure your web server is running and navigate to the project directory.

## System 

### Admin
![Screenshot from 2024-06-09 23-33-34](https://github.com/meri-hane/crud/assets/92614961/b376d19d-b21e-4b53-960a-c16dcee3008d)
### Library
![Screenshot from 2024-06-09 23-39-41](https://github.com/meri-hane/crud/assets/92614961/b1c67658-912a-45c8-a3d8-99edfdde5c94)
![Screenshot from 2024-06-09 23-39-51](https://github.com/meri-hane/crud/assets/92614961/6956b4ba-1db1-4910-979e-d18b360fc228)

### Member
![Screenshot from 2024-06-09 23-40-10](https://github.com/meri-hane/crud/assets/92614961/17eb8084-5fa7-4cad-bf4b-b6cfa2d2b6d0)
![Uploading Screenshot from 2024-06-09 23-40-16.png…]()

### Guest
![Screenshot from 2024-06-09 23-39-05](https://github.com/meri-hane/crud/assets/92614961/b8993a22-1cd3-4f6b-89f8-f10e9668c7d9)

## Troubleshooting

### Common Issues
- **Database Connection Error**: Ensure your database credentials are correct.
- **Page Not Found**: Verify your server configuration and ensure the project directory is correctly set up.
- **Permission Errors**: Ensure the web server has appropriate permissions to read/write files in the project directory.

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request with your changes. Ensure your code follows the project's coding standards and includes appropriate tests.

## License
This project is licensed under the MIT License. See the `LICENSE` file for more details.

---

Thank you for using the Library Management System! If you have any questions or need further assistance, please contact me at janecalulang@gmail.com





