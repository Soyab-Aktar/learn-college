# Define two sets
X = {1, 2, 3, 4}
Y = {3, 4, 5, 6}

print("Set X:", X)
print("Set Y:", Y)

# 1️⃣ Union (All elements from both sets)
union_set = X | Y
print("\nUnion (X ∪ Y):", union_set)

# 2️⃣ Intersection (Common elements)
intersection_set = X & Y
print("Intersection (X ∩ Y):", intersection_set)

# 3️⃣ Difference (Elements in X but not in Y)
difference_XY = X - Y
print("Difference (X - Y):", difference_XY)

difference_YX = Y - X
print("Difference (Y - X):", difference_YX)

# 4️⃣ Symmetric Difference (Elements in either X or Y but NOT both)
symmetric_diff = X ^ Y
print("Symmetric Difference (X △ Y):", symmetric_diff)