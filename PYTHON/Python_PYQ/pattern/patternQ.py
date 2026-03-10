rows = 4

for i in range(rows+1):
    
    for j in range(1, i + 1):
        
        if j == 1 or j == i:
            print(1, end="")
        else:
            print(i-1, end="")
            
    print()