# Create and write data to file
file = open("data.txt", "w")
file.write("Hello World\n")
file.write("Python File Handling\n")
file.write("This is Practical Exam Practice 123!\n")
file.close()

# Read file
file = open("data.txt", "r")
content = file.read()
file.close()

print("File Content:\n", content)

# Initialize counters
lineCount = 0
wordCount = 0
charCount = 0
vowelCount = 0
digitCount = 0
alphaCount = 0
upperCount = 0
lowerCount = 0
specialCount = 0

vowels = "aeiouAEIOU"

# Count lines
file = open("data.txt", "r")
lines = file.readlines()
lineCount = len(lines)
file.close()

# Process characters
for ch in content:
    charCount += 1

    if ch in vowels:
        vowelCount += 1

    if ch.isdigit():
        digitCount += 1

    elif ch.isalpha():
        alphaCount += 1

        if ch.isupper():
            upperCount += 1
        elif ch.islower():
            lowerCount += 1

    elif not ch.isspace():
        specialCount += 1

# Count words
words = content.split()
wordCount = len(words)

# Display counts
print("Lines:", lineCount)
print("Words:", wordCount)
print("Characters:", charCount)
print("Vowels:", vowelCount)
print("Digits:", digitCount)
print("Alphabets:", alphaCount)
print("Uppercase letters:", upperCount)
print("Lowercase letters:", lowerCount)
print("Special characters:", specialCount)

# Copy file
source = open("data.txt", "r")
destination = open("copy.txt", "w")

destination.write(source.read())

source.close()
destination.close()

print("File copied successfully.")

# Display uppercase content
print("\nFile content in uppercase:")
print(content.upper())