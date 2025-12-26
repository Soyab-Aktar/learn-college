# Full Pyramid
rows = int(input("Enter Your Rows Count : "))

for i in range(rows +1):
  for s in range(rows - i -1):
    print(" ", end=' ')
  
  for j in range(2 * i -1):
    print("#",end=' ')
  print()