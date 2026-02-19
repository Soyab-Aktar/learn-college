myList = [1,2,3,4,5,6,7,8,9,10]

result = []

for number in myList:
    if number <= 1:
        result.append(number)
        continue

    isPrime = True

    for i in range(2, int(number ** 0.5) + 1):
        if number % i == 0:
            isPrime = False
            break

    if not isPrime:
        result.append(number)

print(result)
