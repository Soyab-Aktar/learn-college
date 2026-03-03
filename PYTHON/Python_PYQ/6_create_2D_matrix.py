# Taking rows and columns input
rows = int(input("Enter number of rows: "))
cols = int(input("Enter number of columns: "))

matrix = []   # Empty list to store rows

# Outer loop → rows
for i in range(rows):
    row = []   # Create a new row
    
    # Inner loop → columns
    for j in range(cols):
        value = int(input(f"Enter element at position ({i},{j}): "))
        row.append(value)
    
    matrix.append(row)   # Add row to matrix

print("Matrix is:")
for r in matrix:
    print(r)