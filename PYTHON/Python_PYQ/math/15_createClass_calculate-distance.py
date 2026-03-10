import math   # Import math module to use sqrt()

# Create class Point
class Point:
    
    # Constructor to initialize x and y coordinates
    def __init__(self, x, y):
        self.x = x
        self.y = y


# Create two objects of Point class
p1 = Point(2, 3)
p2 = Point(7, 9)

# Calculate distance between the two points
distance = math.sqrt((p2.x - p1.x)**2 + (p2.y - p1.y)**2)

# Print result
print("Distance between two points:", distance)