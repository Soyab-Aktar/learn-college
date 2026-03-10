# Transpose 2D matrix
rows = 2
cols = 3

matrix = [
    [1, 2, 3],
    [4, 5, 6]
]

# Create empty transpose matrix (3 x 2)
transpose = []

for j in range(cols):          # new rows = old columns
    new_row = []
    for i in range(rows):      # new columns = old rows
        new_row.append(matrix[i][j])
    transpose.append(new_row)

print("Transpose matrix:")
for row in transpose:
    print(row)