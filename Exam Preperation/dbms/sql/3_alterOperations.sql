-- Add single column
ALTER TABLE students
ADD email VARCHAR(100);

-- Add multiple columns
ALTER TABLE students
ADD (
  phone VARCHAR(15),
  address VARCHAR(100)
);

-- Add column as FIRST position
ALTER TABLE students
ADD roll_no INT FIRST;


-- Add column AFTER specific column
ALTER TABLE students
ADD phone VARCHAR(15) AFTER name;


-- Rename column (Modern MySQL)
ALTER TABLE students
RENAME COLUMN name TO full_name;


-- Modify datatype only (name stays same)
ALTER TABLE students
MODIFY age BIGINT;


-- Drop column
ALTER TABLE students
DROP COLUMN email;


-- Add Primary Key
ALTER TABLE students
ADD PRIMARY KEY (id);


-- Drop Primary Key
ALTER TABLE students
DROP PRIMARY KEY;


-- Add Unique constraint
ALTER TABLE students
ADD UNIQUE (email);


-- Drop Unique constraint
ALTER TABLE students
DROP INDEX email;


-- Add Foreign Key
ALTER TABLE orders
ADD CONSTRAINT fk_student
FOREIGN KEY (student_id)
REFERENCES students(id);


-- Drop Foreign Key
ALTER TABLE orders
DROP FOREIGN KEY fk_student;


-- Rename table (using ALTER)
ALTER TABLE students
RENAME TO student_details;


-- Add DEFAULT value
ALTER TABLE students
ALTER age SET DEFAULT 18;


-- Remove DEFAULT value
ALTER TABLE students
ALTER age DROP DEFAULT;
