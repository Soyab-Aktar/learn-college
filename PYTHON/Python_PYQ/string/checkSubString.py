# Input string
main_string = input("Enter main string: ")
sub_string = input("Enter substring: ")

found = False

# Loop through main string
for i in range(len(main_string) - len(sub_string) + 1):
    match = True
    
    for j in range(len(sub_string)):
        if main_string[i + j] != sub_string[j]:
            match = False
            break
    
    if match:
        found = True
        break

# Output
if found:
    print("Substring is present")
else:
    print("Substring is not present")