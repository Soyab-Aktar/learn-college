x = int(input("Enter value of x: "))

sum_series = 0

for n in range(1, 11):   # 10 terms
    term = (x ** n) / n
    
    if n % 2 == 0:
        sum_series = sum_series - term
    else:
        sum_series = sum_series + term

print("Sum of series =", sum_series)