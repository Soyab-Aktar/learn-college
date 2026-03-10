def fibonacci_series(n):
    fib_dict = {0: 0, 1: 1}

    for i in range(2, n):
        fib_dict[i] = fib_dict[i - 1] + fib_dict[i - 2]

    return fib_dict


num = int(input("Enter number of terms: "))
result = fibonacci_series(num)

print("Fibonacci series:")
for i in range(num):
    print(result[i], end=" ")