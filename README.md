# Library Management System - Documentation


_This repository serves as a Final Project for PHP Database in CS Professional Elective 4 at Technological University of the Philippines - Manila_

## OVERVIEW

Welcome to the Library Management System! This system is designed to manage the operations of a library, including librarian management, member management, borrowing, and returning books. The system is built using PHP for the backend and MySQL for the database.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Structure](#database-structure)
- [Usage](#usage)
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
    ```sh
    git clone https://github.com/meri-hane/crud.git
    ```
Step 2: Navigate to the Project Directory


## USAGE

1. Clone the repository:

2. Install `XAMPP`.
3. (Optional) Install `MySQL` and `MySQL Workbench` and create a user account.
4. Start `Apache` and `MySQL` in `XAMPP`.
5. Log in to `phpMyAdmin` using `localhost/phpmyadmin`.
6. Install the `PHP Server` extension in VS Code.
7. In `index.php`, select `PHP Server: Serve Project`.

## DATABASE SCHEMA AND TASK

- **Task:**
  - Design a database schema to store information about students, advisors, departments, and courses.
  - Establish relationships to represent academic advising.
    
- **Solution Database Schema:**
  - **users**
    - user_id (Primary Key)
    - password (varchar)
    - role (enum: 'admin', 'registrar', 'student', 'advisor')

  - **student**
    - student_id (Primary Key)
    - advisor_id (Foreign Key Reference to `advisor_id` in `advisor` table)
    - user_id (Foreign Key Reference to `user_id` in `users` table)
    - first_name (varchar)
    - last_name (varchar)
    - assigned_sex (enum: 'Male', 'Female')

  - **advisor**
    - advisor_id (Primary Key)
    - department_id (Foreign Key Reference to `department_id` in `department` table)
    - user_id (Foreign Key Reference to `user_id` in `users` table)
    - first_name (varchar)
    - last_name (varchar)
    - assigned_sex (enum: 'Male', 'Female')

  - **department**
    - department_id (Primary Key)
    - department_name (varchar)
    - course_id (Foreign Key Reference to `course_id` in `course` table)
    - location (varchar)

  - **course**
    - course_id (Primary Key)
    - course_name (varchar)
    - credits (int)

- ## SCREENSHOTS

- ### **phpMyAdmin database tables**
![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a39e8bf2-0ddd-4c4c-91e8-4cc7ad306a89)


