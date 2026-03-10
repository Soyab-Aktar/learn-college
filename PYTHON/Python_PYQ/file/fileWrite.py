file = open("student.dat",'w')

name = input("Enter your Name: ")
age = input("Enter your Age: ")
course = input("Enter your Course: ")

file.write("Name: " + name + "\n")
file.write("Age: " + age + "\n")
file.write("Course: " + course + "\n")

file.close()

print("Date Stored")