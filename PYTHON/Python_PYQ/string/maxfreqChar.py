text = input("Enter a string: ")

frequency = {}

# Count frequency of each character
for char in text:
    if char in frequency:
        frequency[char] = frequency[char] + 1
    else:
        frequency[char] = 1

maxCharacter = ""
maxCount = 0

# Find character with maximum frequency
for char in frequency:
    if frequency[char] > maxCount:
        maxCount = frequency[char]
        maxCharacter = char

print("Character with highest frequency:", maxCharacter)
print("Frequency:", maxCount)