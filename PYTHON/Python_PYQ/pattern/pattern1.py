for i in range(5):

    # spaces
    for j in range(5 - i):
        print(" ", end=" ")

    num = 1

    # numbers
    for j in range(i + 1):
        print(num, end="   ")
        num = 1 - num   # toggle between 1 and 0

    print()