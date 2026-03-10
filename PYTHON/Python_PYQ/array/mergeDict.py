# Create first dictionary
dict1 = {"a": 10, "b": 20}

# Create second dictionary
dict2 = {"c": 30, "d": 40}

# Create empty dictionary for result
merged_dict = {}

# Copy items from first dictionary
for key in dict1:
    merged_dict[key] = dict1[key]

# Copy items from second dictionary
for key in dict2:
    merged_dict[key] = dict2[key]

# Print merged dictionary
print("Merged Dictionary 2:", merged_dict)