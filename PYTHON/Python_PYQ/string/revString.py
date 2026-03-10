# Input
text = input("Enter a string: ")

reverse_text = ""

# Traverse from last index to first
for i in range(len(text)-1, -1, -1):
    reverse_text = reverse_text + text[i]

# Output
print("Reversed string:", reverse_text)