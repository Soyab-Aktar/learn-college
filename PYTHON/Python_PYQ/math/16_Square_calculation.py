# Create class Square
class Square:

    # Constructor to initialize side
    def __init__(self, side):
        self.side = side

    # Method to calculate area
    def area(self):
        return self.side * self.side

    # Method to calculate perimeter
    def perimeter(self):
        return 4 * self.side


# Take input from user
s = int(input("Enter side of square: "))

# Create object
sq = Square(s)

# Display results
print("Area of square:", sq.area())
print("Perimeter of square:", sq.perimeter())