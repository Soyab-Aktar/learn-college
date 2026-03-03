# Write a program to count the number of even and odd numbers present in a given list
myList = [1,2,3,4,5,6,7,8,9,10,11,12,13]

oddCount = 0
evenCount = 0

for i in myList:
  if i%2 == 0:
    evenCount += 1
  else:
    oddCount +=1

print("Odd numbers are :",oddCount)
print("Even numbers are :",evenCount)