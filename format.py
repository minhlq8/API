import json
import calendar
import sys
import dateutil.parser as parser
from datetime import datetime, timedelta, timezone

projectKey = sys.argv[1]
convertDate = dict((month, index) for index, month in enumerate(calendar.month_abbr) if month)

file = open("/var/www/html/log/output","r")

input_dict = json.loads(file.read())

file.close()

total=dict()
measures = []
alert = []
for i in input_dict:
	date = str(parser.parse(input_dict[i]['Report']['ScanDate']))
	date = datetime.fromisoformat(date)
	tz = timezone(timedelta(hours=7))
	new_time = date.astimezone(tz).isoformat()
	for j in input_dict[i]['Report']['Sites']['Alerts']['AlertItem']:
		# print(j)
		# quit()
		if('list' in str(type(j['Item']))):
			alert.append({**dict(Alert = str(j['Alert'])),**dict(Desc = str(j['Desc'])),**dict(Evidence = str(j["Item"][0]['Evidence'])),**dict(URI = str(j['Item'][0]['URI'])),**dict(RiskDesc = str(j['RiskDesc'])),**dict(CWEID = str(j['CWEID'])),**dict(ItemCount = str(j['ItemCount'])),**dict(Solution = str(j['Solution']))})
		else:
			alert.append({**dict(Alert = str(j['Alert'])),**dict(Desc = str(j['Desc'])),**dict(Evidence = str(j["Item"]['Evidence'])),**dict(URI = str(j['Item']['URI'])),**dict(RiskDesc = str(j['RiskDesc'])),**dict(CWEID = str(j['CWEID'])),**dict(ItemCount = str(j['ItemCount'])),**dict(Solution = str(j['Solution']))})
		# print("Alerts:", j['Alert'])
		# print("RiskDesc:", j['RiskDesc'])
		# print("CWEID:", j['CWEID'])
		# print("ItemCount:", j['ItemCount'])
	measures.append({**{"projectKey":projectKey},**{'scanDate':str(new_time)},**{'Alerts':alert}})

total['measures']=measures
final = json.dumps(total,indent=1)

file = open("/var/www/html/log/output","w")

file.write(final)

file.close()
