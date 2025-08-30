-- Database setup script for iNotes CRUD application
-- Run this script in your MySQL/phpMyAdmin to create the required database and table

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS inotes;

-- Use the database
USE inotes;

-- Create notes table with proper column names (no spaces)
CREATE TABLE IF NOT EXISTS notes (
    sno INT AUTO_INCREMENT PRIMARY KEY,
    note_title VARCHAR(255) NOT NULL,
    note_description TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data (optional)
INSERT INTO notes (note_title, note_description) VALUES 
('Welcome Note', 'Welcome to iNotes! This is your first note.'),
('Sample Note', 'This is a sample note to get you started.');

-- Verify the table structure
DESCRIBE notes;
