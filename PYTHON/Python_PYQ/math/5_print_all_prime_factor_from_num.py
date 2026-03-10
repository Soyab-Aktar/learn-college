# Write a program that prints all prime factors of a given number.

def print_prime_factors(n):
    # Step 1: Handle factor 2 separately
    while n % 2 == 0:
        print(2)
        n = n // 2

    # Step 2: Check odd numbers from 3 to √n
    i = 3
    while i * i <= n:
        while n % i == 0:
            print(i)
            n = n // i
        i += 2

    # Step 3: If remaining n is > 2, it is prime
    if n > 2:
        print(n)


# Take input
num = int(input("Enter a number: "))

print("Prime factors are:")
print_prime_factors(num)