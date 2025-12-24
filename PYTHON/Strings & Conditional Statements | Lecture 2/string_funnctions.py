str = "i am a coder"

# Check that is it end with that give string or char
# if yes so it will return True else False
print(str.endswith('er'));
print(str.endswith('et'));

#Capitalizes 1st Char
print(str.capitalize())

#Replace all occurrences of old string
myMsg = "Hello Friends, Whats app!!"
print(myMsg.replace("e","X"))
print(myMsg.replace("Friends","X"))

#Return 1st index of 1st occurence
newStr = "i am studying python form ownSelf"
print(newStr.find("o"))
print(newStr.find("python"))
print(newStr.find("Q")) #-1 ==> not exist

# count
print(newStr.count("o"))



