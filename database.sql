CREATE DATABASE IF NOT EXISTS field_assist;
USE field_assist;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(10) NOT NULL UNIQUE,
    role ENUM('admin', 'field_agent') DEFAULT 'field_agent',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    location_name VARCHAR(255),
    completed_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert a default admin and an agent user
-- Using fake 10 digit numbers
INSERT IGNORE INTO users (phone_number, role) VALUES 
('0000000000', 'admin'),
('1234567890', 'field_agent');

CREATE TABLE IF NOT EXISTS sales_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_date DATE,
    salesman VARCHAR(255),
    item_number VARCHAR(100),
    shop_name VARCHAR(255),
    product VARCHAR(255),
    units INT,
    unit_price DECIMAL(10, 2),
    sales_amount DECIMAL(10, 2),
    totals DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (sale_date, salesman, item_number, shop_name, product, units)
);
