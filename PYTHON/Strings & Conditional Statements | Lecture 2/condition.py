# if
age = 21
if(age > 18):
  print("You can buy")

# if elif else
num = 5
if(num > 5):
  print("Num is greater than 5")
elif(num < 5):
  print("Num is less than 5")
else:
  print("Num is equal to 5")

# example
marks = int(input("Enter Student Marks : "))
if(marks >= 90):
  grade = 'A'
elif(marks >= 80 and marks <90):
  grade = 'B'
elif(marks >= 70 and marks < 80):
  grade = 'C'
else:
  grade = 'D'

print("Student grade is : ", grade)