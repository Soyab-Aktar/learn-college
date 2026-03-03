# Has a dictionary containing names of students and a list of their marks in 4 subjects.
# Creates another dictionary that stores student names and their total marks.
# Finds the student who topped the exam (highest total marks).

# Step 1: Dictionary with student names and 4 subject marks
students = {
    "Aman": [85, 90, 88, 92],
    "Riya": [78, 82, 80, 79],
    "Karan": [90, 91, 89, 94],
    "Neha": [88, 84, 91, 87]
}

print("Student Marks:")
for name, marks in students.items():
    print(name, ":", marks)

# Step 2: Create dictionary with total marks
total_marks = {}

for name, marks in students.items():
    total_marks[name] = sum(marks)

print("\nTotal Marks:")
for name, total in total_marks.items():
    print(name, ":", total)

# Step 3: Find topper
topper = max(total_marks, key=total_marks.get)

print("\nTopper of the exam is:", topper)
print("Total Marks:", total_marks[topper])