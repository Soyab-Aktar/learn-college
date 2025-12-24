nums = [1,2,3,2,1]
nums2 = nums.copy()
nums2.reverse()
if(nums == nums2):
  print("It is a palindrome")
else:
  print("Not a Palindrome")


grades = ['c','d','a','a','b','b','a']
print(grades.count('a'))