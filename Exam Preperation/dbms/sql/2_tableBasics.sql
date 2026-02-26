-- Create Table
CREATE TABLE students (
  id INT PRIMARY KEY,
  name VARCHAR(50),
  age INT
);

-- Read Tables
SHOW TABLES;

-- Show Structure of Table
DESCRIBE students;

-- Read table data
SELECT * FROM students;

-- Rename Table
RENAME TABLE students TO student_details;

-- Delete Table
DROP TABLE student_details;

