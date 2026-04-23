-- Create Database
CREATE DATABASE IF NOT EXISTS pms_db;
USE pms_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Realistic Citizens/Resident Table
CREATE TABLE IF NOT EXISTS citizens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    father_name VARCHAR(100),
    aadhar_no VARCHAR(12) UNIQUE,
    voter_id VARCHAR(20) UNIQUE,
    phone VARCHAR(15),
    gender ENUM('Male', 'Female', 'Other'),
    dob DATE,
    category ENUM('General', 'OBC', 'SC', 'ST'),
    occupation VARCHAR(100),
    income_annual DECIMAL(10,2),
    -- Address Details
    house_no VARCHAR(20),
    ward_no VARCHAR(10),
    village VARCHAR(50) DEFAULT 'Gram Panchayat',
    block VARCHAR(50),
    district VARCHAR(50),
    family_id VARCHAR(20), -- Samagra ID or Parivar Register No
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Applications Table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_type VARCHAR(50) NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    application_data TEXT, 
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Taxes Table
CREATE TABLE IF NOT EXISTS taxes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tax_type VARCHAR(50),
    amount DECIMAL(10,2),
    status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid',
    due_date DATE,
    paid_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert Dummy Admin for testing
INSERT INTO users (name, email, password, role) VALUES 
('System Admin', 'admin@panchayat.com', 'admin123', 'admin');
