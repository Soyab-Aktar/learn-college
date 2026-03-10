rows = 2
cols = 3

matrix = [
    [1, 2, 3],
    [4, 5, 6]
]

transpose = []

# Step 1: Transpose
for j in range(cols):
    new_row = []
    for i in range(rows):
        new_row.append(matrix[i][j])
    transpose.append(new_row)

# Step 2: Reverse each row
for i in range(len(transpose)):
    transpose[i].reverse()

print("Rotated matrix:")
for row in transpose:
    print(row)