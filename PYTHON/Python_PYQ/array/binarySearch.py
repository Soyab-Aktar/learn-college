def binarySearch(myList,target):
  left = 0
  right = listSize -1

  while left <= right:
    mid = (right +left)//2
    if target < myList[mid]:
      right = mid-1
    elif target > myList[mid]:
      left = mid +1
    else:
      return True
  
  return False
  


myList = [1,2,3,4,5,6,7,8,9]
listSize = len(myList);

target = int(input("Enter your target : "))

if binarySearch(myList,target):
  print("Target Found")
else:
  print("Not Found")
