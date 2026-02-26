-- INSERT
INSERT INTO students (name, email, age, city)
VALUES ('Rahul', 'rahul@gmail.com', 20, 'Kolkata');
--
INSERT INTO students (name, email, age, city)
VALUES 
('Aman', 'aman@gmail.com', 22, 'Delhi'),
('Riya', 'riya@gmail.com', 19, 'Mumbai');

-- READ
SELECT * FROM students;
SELECT name, age FROM students;

--UPDATE
UPDATE students
SET city = 'Chennai'
WHERE id = 1;
--
UPDATE students
SET age = 23,
    city = 'Pune'
WHERE id = 2;

--DELETE
DELETE FROM students
WHERE id = 3;
--
TRUNCATE TABLE students;
--  Deletes all rows
--  Resets AUTO_INCREMENT
--  Faster than DELETE