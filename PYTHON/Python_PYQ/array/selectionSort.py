# Selection Sort Program

# Create empty list
numbers = []

# Take 10 integers from user
for i in range(10):
    num = int(input("Enter number: "))
    numbers.append(num)

# Selection Sort
for i in range(len(numbers)):
    min_index = i
    for j in range(i+1, len(numbers)):
        if numbers[j] < numbers[min_index]:
            min_index = j
    numbers[i],numbers[min_index] = numbers[min_index],numbers[i] 

# Print sorted list
print("Sorted list:", numbers)