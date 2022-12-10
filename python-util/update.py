#inputは編集画面からPOSTした$requestをdd()でブラウザに表示したものをコピペ

input = '''user_id=>2
company_type=>1
job_number=>pa-1134
handling_office=>1
business_type=>1
customer_id=>1
type_contract=>1
recruitment_number=>0
company_name=>i
company_address=>i
company_others=>i
ordering_business=>i
order_details=>i
measures_existence=>1
counter_measures=>i
Invoice_unit_price_1=>i
billing_unit_1=>1
profit_rate_1=>u
billing_information_1=>u
Invoice_unit_price_2=>u
billing_unit_2=>2
profit_rate_2=>u
billing_information_2=>u
Invoice_unit_price_3=>u
billing_unit_3=>1
profit_rate_3=>k
billing_information_3=>k
employment_insurance=>1
social_insurance=>1
payment_unit_price_1=>k
payment_unit_1=>1
carfare_1=>k
carfare_payment_1=>1
carfare_payment_remarks_1=>k
payment_unit_price_2=>k
payment_unit_2=>1
carfare_2=>k
carfare_payment_2=>2
carfare_payment_remarks_2=>k
payment_unit_price_3=>k
carfare_payment_3=>1
carfare_3=>k
carfare_payment_remarks_3=>p
scheduled_period=>p
expected_end_date=>2022-12-02
period_remarks=>p
holiday=>2
long_vacation=>1
holiday_remarks=>p
working_hours_1=>p
actual_working_hours_1=>p
break_time_1=>pn
overtime=>n
working_hours_remarks=>n
working_hours_2=>n
actual_working_hours_2=>nn
break_time_2=>n
working_hours_3=>n
actual_working_hours_3=>n
break_time_3=>n
nearest_station=>n
travel_time_station=>n
nearest_bus_stop=>n
travel_time_bus_stop=>n
commuting_by_car=>1
traffic_commuting_remarks=>b
parking=>1
posting_site=>1
status=>1
order_date=>2022-12-23'''

input_n = input.split('\n')
input_n_arrow = []
for i in input_n:
  input_n_arrow.append(i.split('=>'))

#$jobOffer->company_type = $request->input('company_type');

data = ''
for j in input_n_arrow:
  data += '$jobOffer->' + j[0] + "= $request->input('" + j[0] + "');" + '\n'

print(data)