-- Create students table with all major constraints
CREATE TABLE students (
  id INT PRIMARY KEY AUTO_INCREMENT,     -- Primary key + auto increment
  name VARCHAR(50) NOT NULL,             -- Cannot be NULL
  email VARCHAR(100) UNIQUE,             -- Unique value
  age INT CHECK (age >= 18),             -- Check condition
  city VARCHAR(50) DEFAULT 'Unknown'     -- Default value
);

-- Create courses table
CREATE TABLE courses (
  course_id INT PRIMARY KEY AUTO_INCREMENT,
  course_name VARCHAR(100) NOT NULL,
  course_fee DECIMAL(8,2) NOT NULL
);

-- Create enrollments table with foreign keys
CREATE TABLE enrollments (
  enroll_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  enroll_date DATE,

  FOREIGN KEY (student_id) REFERENCES students(id),
  FOREIGN KEY (course_id) REFERENCES courses(course_id)
);


