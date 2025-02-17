CREATE DATABASE digitalteam_timesheet;
USE digitalteam_timesheet;

-- User Table (Renamed from Employees)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(255) NOT NULL,
    userEmail VARCHAR(255) UNIQUE NOT NULL,
    employeeId VARCHAR(50) UNIQUE NOT NULL
);

-- Timesheet Table (Updated Foreign Key)
CREATE TABLE timesheet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL,
    task_Name VARCHAR(255) NOT NULL,
    hours_Utilized INT NOT NULL,
    task_Day VARCHAR(255) NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES user(employeeId) ON DELETE CASCADE
);

-- Admin Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
