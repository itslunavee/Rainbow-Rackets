-- Create the database
CREATE DATABASE IF NOT EXISTS rainbow_rackets;
USE rainbow_rackets;

-- Users Table
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  gender VARCHAR(50),                         -- Optional gender identity
  status ENUM('unverified', 'verified', 'admin') DEFAULT 'unverified',
  total_points INT DEFAULT 0,                 -- Cached sum of all points
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events Table
CREATE TABLE events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  event_date DATE NOT NULL,
  event_type VARCHAR(50) NOT NULL,            -- e.g., "Singles Tournament"
  location VARCHAR(100) NOT NULL,
  description TEXT,
  created_by INT,                             -- Admin who created the event
  FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Participants Table (Links users to events)
CREATE TABLE participants (
  participant_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  user_id INT,
  rsvp_status ENUM('attending', 'not_attending') DEFAULT 'not_attending',
  FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Points Table (Tracks points per event)
CREATE TABLE points (
  point_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  event_id INT,
  points INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

