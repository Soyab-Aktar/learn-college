# it store like - > key : value
# unordered, mutable, cant add duplicate keys , 
info = {
  "name" : "Soyab",
  "rollNo" : 1,
  'age' : 22,
  'employed' : False,
  'hobbies' : ['coding','modelling','techy'],
  'Marks' : ('paper1',21, 'paper2',55),
  1 : False

}
null_dict = {}
student = {
  'name' : 'Soyab Aktar',
  'marks' : {
    'math' : 90,
    'Physics' : 99,
    'Bio': 89
  }
}
print(student)
print(student['marks']['math'])
info['name'] = 'Soyab Aktar'
info['codeName'] = 'EVO'
print(info)
print(info['name'])
print(info[1])
print(info['Marks'])
print(info['age'])

# Methods
print(info.keys())
print(info.values())
print(info.items())