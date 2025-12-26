# count = 0
while count <= 5:
  print("Hello Friends")
  count += 1

#! Q - Find Target
nums = (1,2,3,4,5,6,7,8)
target = int(input("Enter your target : "))
size = len(nums)
i = 0
find =False
while i < size:
  if(target == nums[i]):
    find = True
    break
  i+=1

if(find == True):
  print("Target Found")
else:
  print("Not Found")
  