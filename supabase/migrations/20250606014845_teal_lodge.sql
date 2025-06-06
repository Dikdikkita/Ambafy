/*
  # Initial Database Schema for Ambafy

  1. New Tables
    - `users`: Stores user account information
      - `id` (int, primary key, auto increment)
      - `username` (varchar, unique)
      - `email` (varchar, unique)
      - `password` (varchar)
      - `created_at` (timestamp)
    
    - `songs`: Stores music information
      - `id` (int, primary key, auto increment)
      - `title` (varchar)
      - `artist` (varchar)
      - `album` (varchar)
      - `genre` (varchar)
      - `file_path` (varchar)
      - `cover_path` (varchar)
      - `uploaded_by` (int, foreign key to users)
      - `created_at` (timestamp)
    
    - `favorites`: Stores user's favorite songs
      - `id` (int, primary key, auto increment)
      - `user_id` (int, foreign key to users)
      - `song_id` (int, foreign key to songs)
      - `created_at` (timestamp)

  2. Indexes
    - Added indexes on frequently searched columns
    - Added foreign key constraints for data integrity
*/

-- Create the database
CREATE DATABASE IF NOT EXISTS ambafy;
USE ambafy;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create songs table
CREATE TABLE IF NOT EXISTS songs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    album VARCHAR(100),
    genre VARCHAR(50),
    file_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255) NOT NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

-- Create favorites table
CREATE TABLE IF NOT EXISTS favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    song_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (song_id) REFERENCES songs(id),
    UNIQUE KEY unique_favorite (user_id, song_id)
);

-- Create indexes for better query performance
CREATE INDEX idx_songs_title ON songs(title);
CREATE INDEX idx_songs_artist ON songs(artist);
CREATE INDEX idx_songs_album ON songs(album);
CREATE INDEX idx_songs_genre ON songs(genre);