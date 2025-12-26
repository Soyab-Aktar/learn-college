#  Left Half Pyramid Pattern
rows = int(input("Enter Your Rows Count : "))

for i in range(rows):
  for s in range(rows - i -1):
    print(" ", end=' ')
  
  for j in range(i + 1):
    print("#",end=' ')
  print()