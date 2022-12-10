#fieldName,fieldType,fieldCommentはスプレッドシートからコピペ

fieldNames = '''after_introduction
_iming_of_switching
monthly_lower_limit
monthly_upper_limit
annual_lower_limit
age_upper_limit
bonuses_treatment
holidays_vacations
introduction_others'''

fieldTypes = '''VARCHAR
VARCHAR
VARCHAR
VARCHAR
VARCHAR
VARCHAR
VARCHAR
VARCHAR
TEXT'''

fieldComments = '''紹介後
直接雇用切替時期
月収例（下限）
月収例（上限）
年収例（下限）
年齢（上限）
賞与等・待遇
休日・休暇
その他'''

requireds = '''x
x
x
x
x
x
x
x
x
'''

fieldNames_n = fieldNames.split('\n')
fieldTypes_n = fieldTypes.split('\n')
fieldComments_n = fieldComments.split('\n')
requireds_n = requireds.split('\n')

data = ''
for i in range(len(fieldNames_n)):
  fieldName = fieldNames_n[i]
  fieldComment = fieldComments_n[i]
  if fieldTypes_n[i] == 'VARCHAR':
    fieldType = 'string'
  elif fieldTypes_n[i] == 'TEXT':
    fieldType = 'text'

  data += "$table->" + fieldType + "('" + fieldName + "')->comment('" + fieldComment + "')"

  if requireds_n[i] == 'x':
    data += '->nullable()'

  data += ';\n'

print(data)

#$table->string('item')->comment('項目（1:求人情報更新/編集, 2:掲載完了, 3:再掲載, 4:非公開, 5:その他）');
