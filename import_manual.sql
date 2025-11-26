-- Script untuk membuat database dan mengimpor data
CREATE DATABASE IF NOT EXISTS sippres CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sippres;

-- Import struktur dan data dari file sippres.sql
SOURCE public/sippres.sql;