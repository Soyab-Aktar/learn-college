# Function 1: Matrix Subtraction
def subtract_matrix(A, B):
    rows = len(A)
    cols = len(A[0])

    # Check if dimensions match
    if rows != len(B) or cols != len(B[0]):
        return "Subtraction not possible (different dimensions)"

    result = []

    for i in range(rows):
        row = []
        for j in range(cols):
            row.append(A[i][j] - B[i][j])
        result.append(row)

    return result


# Function 2: Matrix Multiplication
def multiply_matrix(A, B):
    rows_A = len(A)
    cols_A = len(A[0])
    rows_B = len(B)
    cols_B = len(B[0])

    # Check multiplication condition
    if cols_A != rows_B:
        return "Multiplication not possible"

    result = []

    for i in range(rows_A):
        row = []
        for j in range(cols_B):
            sum_value = 0
            for k in range(cols_A):
                sum_value += A[i][k] * B[k][j]
            row.append(sum_value)
        result.append(row)

    return result


# Example Matrices
A = [
    [1, 2],
    [3, 4]
]

B = [
    [5, 6],
    [7, 8]
]

print("Matrix A:")
for row in A:
    print(row)

print("\nMatrix B:")
for row in B:
    print(row)

# Subtraction
print("\nSubtraction (A - B):")
sub_result = subtract_matrix(A, B)
for row in sub_result:
    print(row)

# Multiplication
print("\nMultiplication (A × B):")
mul_result = multiply_matrix(A, B)
for row in mul_result:
    print(row)