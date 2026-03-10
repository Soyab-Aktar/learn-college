a = int(input("Enter first number: "))
b = int(input("Enter second number: "))

# store original values for LCM
x = a
y = b

# Euclidean algorithm for GCD
while b != 0:
    temp = b
    b = a % b
    a = temp

gcd = a

# LCM formula
lcm = (x * y) // gcd

print("GCD =", gcd)
print("LCM =", lcm)