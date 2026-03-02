# Write a program that reads a set of words from the user
# and prints those words that start with the character ‘I’ 
# and end with the character ‘A’.

mySet = {'Soyab','IreaA','InexA','inextta'}

for word in mySet:
    if word[0] == 'I' and word[-1] == 'A':
        print(word)
