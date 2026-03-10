# Create a list of numbers from 10 to 50
numbers = list(range(10, 51))   # 51 is used because range stops before the last value

# Traverse the list and remove numbers divisible by both 3 and 7
for num in numbers[:]:          # numbers[:] creates a copy of the list
    if num % 3 == 0 and num % 7 == 0:   # check if divisible by 3 and 7
        numbers.remove(num)     # remove that number from the list

# Print the final list
print(numbers)