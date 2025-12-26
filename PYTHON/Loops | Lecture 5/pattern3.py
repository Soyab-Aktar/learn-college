# Inverted Left Half Pyramid Pattern
rows = int(input("Enter Your Rows Count : "))

for i in range(rows):
  # Print Spaces
  for s in range(i):
    print(" ", end=' ')
  
  # Print #
  for j in range(rows - i):
    print("#",end=' ')
  print()