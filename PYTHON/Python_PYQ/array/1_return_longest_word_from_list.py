# Write a Program that takes a list of words and returns the length of the longest one
myList = []
listSize = int(input("Enter the length of the list : "))

for i in range(listSize):
  data = input("Enter your Text : ")
  myList.append(data)

maxLength = 0
maxIndex = 0
 
for i in range(listSize):
  currentLen = len(myList[i])
  if currentLen > maxLength:
    maxIndex = i
    maxLength = currentLen
  
print(myList)
print("Maximum Length on the list is : ",maxLength)
print("Maximum Length - Value on the list is : ",myList[maxIndex])