# Create class Height
class Height:

    # Constructor
    def __init__(self, feet=0, inches=0):
        self.feet = feet
        self.inches = inches

    # Function to read height
    def read(self):
        self.feet = int(input("Enter feet: "))
        self.inches = int(input("Enter inches: "))

    # Function to display height
    def display(self):
        print(self.feet, "feet", self.inches, "inches")

    # Function to add two heights
    def add(self, h1, h2):
        self.feet = h1.feet + h2.feet
        self.inches = h1.inches + h2.inches

        # Convert inches if >=12
        if self.inches >= 12:
            self.feet += self.inches // 12
            self.inches = self.inches % 12

    # Function to subtract two heights
    def subtract(self, h1, h2):
        total1 = h1.feet * 12 + h1.inches
        total2 = h2.feet * 12 + h2.inches

        diff = total1 - total2

        self.feet = diff // 12
        self.inches = diff % 12


# Create objects
h1 = Height()
h2 = Height()
result = Height()

while True:

    print("\nMENU")
    print("1. Read Heights")
    print("2. Display Heights")
    print("3. Add Heights")
    print("4. Subtract Heights")
    print("5. Exit")

    choice = int(input("Enter choice: "))

    if choice == 1:
        print("Enter first height")
        h1.read()

        print("Enter second height")
        h2.read()

    elif choice == 2:
        print("Height 1:")
        h1.display()

        print("Height 2:")
        h2.display()

    elif choice == 3:
        result.add(h1, h2)
        print("Addition of heights:")
        result.display()

    elif choice == 4:
        result.subtract(h1, h2)
        print("Subtraction of heights:")
        result.display()

    elif choice == 5:
        break

    else:
        print("Invalid choice")