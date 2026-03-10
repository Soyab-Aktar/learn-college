# Input
num = int(input("Enter a number: "))

a = 0
b = 1
found = False

while a <= num:
    if a == num:
        found = True
        break
    
    sum = a + b
    a = b
    b = sum

# Output
if found:
    print("Number is Fibonacci")
else:
    print("Number is not Fibonacci")