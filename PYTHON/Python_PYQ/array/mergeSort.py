def mergeSort(arr):

    if len(arr) > 1:   # base condition

        mid = len(arr)//2
        left = arr[:mid]
        right = arr[mid:]

        mergeSort(left)
        mergeSort(right)

        i = j = k = 0

        while i < len(left) and j < len(right):
            if left[i] < right[j]:
                arr[k] = left[i]
                i += 1
            else:
                arr[k] = right[j]
                j += 1
            k += 1
        
        while i < len(left):
            arr[k] = left[i]
            i += 1
            k += 1
        
        while j < len(right):
            arr[k] = right[j]
            j += 1
            k += 1


# Take 10 integers from user
numbers = []

for i in range(10):
    num = int(input("Enter number: "))
    numbers.append(num)

# Call merge sort
mergeSort(numbers)

# Print sorted list
print("Sorted list:", numbers)