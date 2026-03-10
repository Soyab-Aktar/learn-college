myDict = {"b": 20, "a": 10, "d": 40, "c": 30}

keys = list(myDict.keys())

# Bubble sort on keys
for i in range(len(keys)):
    for j in range(len(keys)-i-1):
        if keys[j] > keys[j+1]:
            keys[j], keys[j+1] = keys[j+1], keys[j]

# print sorted dictionary
for k in keys:
    print(k, ":", myDict[k])

# myDict = {"b": 20, "a": 10, "d": 40, "c": 30}

# items = list(myDict.items())

# for i in range(len(items)):
#     for j in range(len(items)-i-1):
#         if items[j][1] > items[j+1][1]:
#             items[j], items[j+1] = items[j+1], items[j]

# for k,v in items:
#     print(k, ":", v)