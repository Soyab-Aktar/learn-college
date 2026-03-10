a = int(input("Enter first number: "))
b = int(input("Enter second number: "))
c = int(input("Enter third number: "))

# function to find GCD of two numbers
def gcd(x,y):
  while y != 0:
    temp = y
    y = x % y
    x = temp

# GCD of three numbers
gcd_ab = gcd(a, b)
gcd_abc = gcd(gcd_ab, c)

# LCM formula
lcm_ab = (a * b) // gcd_ab
lcm_abc = (lcm_ab * c) // gcd(lcm_ab, c)

print("GCD =", gcd_abc)
print("LCM =", lcm_abc)