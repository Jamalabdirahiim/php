-- Database: techpulse_bit29

CREATE DATABASE IF NOT EXISTS techpulse_bit29;
USE techpulse_bit29;

-- Table to store user information (Attendees/Editors)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    image VARCHAR(255) DEFAULT 'default.png',
    user_type ENUM('Admin', 'User') NOT NULL DEFAULT 'User',
    status ENUM('Active', 'Not Active') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Site Content (News/Reviews)
CREATE TABLE IF NOT EXISTS site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_name VARCHAR(50) NOT NULL UNIQUE, 
    title VARCHAR(100),
    content TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for Feedback/Inquiries
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert DEFAULT Content (Tech Theme)
INSERT INTO site_content (section_name, title, content) VALUES
('Hero', 'The Future of Tech is Here', 'Explore in-depth reviews of the latest AI accelerators, VR headsets, and quantum computing breakthroughs. Join our community of innovators.'),
('About', 'About TechPulse', 'TechPulse is the premier destination for tech enthusiasts. We bridge the gap between complex engineering and consumer electronics.'),
('Footer', 'Contact & Copyright', 'Silicon Valley Hub, CA | +1 555-0199 | editor@techpulse.io')
ON DUPLICATE KEY UPDATE content = VALUES(content);
