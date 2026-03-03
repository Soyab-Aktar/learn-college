# User Defined Stack Implementation

stack = []   # Empty list to store stack elements

# Push operation
def push():
    element = int(input("Enter element to push: "))
    stack.append(element)
    print(element, "pushed into stack")


# Pop operation
def pop():
    if len(stack) == 0:
        print("Stack Underflow! Stack is empty.")
    else:
        removed = stack.pop()
        print(removed, "popped from stack")


# Peek operation
def peek():
    if len(stack) == 0:
        print("Stack is empty.")
    else:
        print("Top element is:", stack[-1])


# Display operation
def display():
    if len(stack) == 0:
        print("Stack is empty.")
    else:
        print("Stack elements (Top to Bottom):")
        for i in range(len(stack) - 1, -1, -1):
            print(stack[i])


# Menu
while True:
    print("\n--- STACK MENU ---")
    print("1. Push")
    print("2. Pop")
    print("3. Peek")
    print("4. Display")
    print("5. Exit")

    choice = int(input("Enter your choice: "))

    if choice == 1:
        push()
    elif choice == 2:
        pop()
    elif choice == 3:
        peek()
    elif choice == 4:
        display()
    elif choice == 5:
        print("Exiting program...")
        break
    else:
        print("Invalid choice! Try again.")