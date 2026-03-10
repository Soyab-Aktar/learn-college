# Create two sets
A = set()
B = set()

# Input elements for set A
n1 = int(input("Enter number of elements for set A: "))
for i in range(n1):
    val = int(input("Enter element: "))
    A.add(val)

# Input elements for set B
n2 = int(input("Enter number of elements for set B: "))
for i in range(n2):
    val = int(input("Enter element: "))
    B.add(val)

print("Set A:", A)
print("Set B:", B)

# Demonstrate add()
x = int(input("Enter element to add in set A: "))
A.add(x)
print("After add():", A)

# Demonstrate remove()
y = int(input("Enter element to remove from set A: "))
A.remove(y)
print("After remove():", A)

# Demonstrate discard()
z = int(input("Enter element to discard from set A: "))
A.discard(z)
print("After discard():", A)

# Demonstrate pop()
removed = A.pop()
print("Element removed using pop():", removed)
print("Set A after pop():", A)