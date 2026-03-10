# Create class Complex
class Complex:

    # Constructor
    def __init__(self, real=0, imag=0):
        self.real = real
        self.imag = imag

    # Function to read complex number
    def read(self):
        self.real = int(input("Enter real part: "))
        self.imag = int(input("Enter imaginary part: "))

    # Function to display complex number
    def display(self):
        print(self.real, "+", self.imag, "i")

    # Function to add two complex numbers
    def add(self, c1, c2):
        self.real = c1.real + c2.real
        self.imag = c1.imag + c2.imag

    # Function to multiply two complex numbers
    def multiply(self, c1, c2):
        self.real = (c1.real * c2.real) - (c1.imag * c2.imag)
        self.imag = (c1.real * c2.imag) + (c1.imag * c2.real)


# Create objects
c1 = Complex()
c2 = Complex()
result = Complex()

while True:

    print("\nMENU")
    print("1. Read Complex Numbers")
    print("2. Display Complex Numbers")
    print("3. Add Complex Numbers")
    print("4. Multiply Complex Numbers")
    print("5. Exit")

    choice = int(input("Enter choice: "))

    if choice == 1:
        print("Enter first complex number")
        c1.read()

        print("Enter second complex number")
        c2.read()

    elif choice == 2:
        print("First complex number:")
        c1.display()

        print("Second complex number:")
        c2.display()

    elif choice == 3:
        result.add(c1, c2)
        print("Addition Result:")
        result.display()

    elif choice == 4:
        result.multiply(c1, c2)
        print("Multiplication Result:")
        result.display()

    elif choice == 5:
        break

    else:
        print("Invalid choice")