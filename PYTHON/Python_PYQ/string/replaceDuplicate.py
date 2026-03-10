text = input("Enter a sentence: ")

words = text.split()

seen = []
result = []

for word in words:
    if word in seen:
        result.append("duplicate")
    else:
        result.append(word)
        seen.append(word)

output = ""

for w in result:
    output = output + w + " "

print("Result:", output)