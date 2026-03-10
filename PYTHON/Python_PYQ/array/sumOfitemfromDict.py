myDict = {"a":10, "b":20, "c":30, "d":40}

total = 0

for key in myDict:
    total = total + myDict[key]

print("Sum of all values:", total)