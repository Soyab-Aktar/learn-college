# Input number
num = int(input("Enter a number: "))

temp = num
sum = 0

while temp > 0:
    digit = temp % 10
    sum = sum + digit**3
    temp = temp // 10

# Check
if sum == num:
    print("Armstrong number")
else:
    print("Not an Armstrong number")