class Complex:
    
    def __init__(self, real, imag):
        self.real = real
        self.imag = imag

    # operator overloading for +
    def __add__(self, other):
        r = self.real + other.real
        i = self.imag + other.imag
        return Complex(r, i)
    

    def display(self):
        print(self.real, "+", self.imag, "i")


# creating objects
c1 = Complex(2, 3)
c2 = Complex(4, 5)

# using overloaded + operator
c3 = c1 + c2

print("First Complex Number:")
c1.display()

print("Second Complex Number:")
c2.display()

print("Sum of Complex Numbers:")
c3.display()