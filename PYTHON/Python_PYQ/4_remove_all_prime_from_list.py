# Write a program to Remove all prime numbers from a list.

myList = [1,2,3,4,5,6,7,8,9,10]

i = 0
while i < len(myList):
    number = myList[i]

    if number > 1:
        isPrime = True
        for j in range(2, int(number ** 0.5) + 1):
            if number % j == 0:
                isPrime = False
                break

        if isPrime:
            myList.pop(i)
            continue  # stay at same index
    i += 1

print(myList)