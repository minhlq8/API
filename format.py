import json
import calendar
import sys
import dateutil.parser as parser
from datetime import datetime, timedelta, timezone
import time
import os

projectKey = sys.argv[1]

convertDate = dict((month, index) for index, month in enumerate(calendar.month_abbr) if month)
if not os.path.exists("/var/www/html/log/"+projectKey+"/instances"):
	os.mkdir("/var/www/html/log/"+projectKey+"/instances")

file = open("/var/www/html/log/output","r")
input_dict = json.loads(file.read())
file.close()
total=dict()
measures = []
alert = []

for i in input_dict:
	date = str(parser.parse(input_dict[i]['@generated']))
	date = datetime.fromisoformat(date)
	tz = timezone(timedelta(hours=7))
	new_time = date.astimezone(tz).isoformat()
	timeStamp=str(int(time.mktime(date.timetuple())))
	count=0
	create=False
	if not os.path.exists("/var/www/html/log/"+projectKey+"/instances/"+timeStamp):
		os.mkdir("/var/www/html/log/"+projectKey+"/instances/"+timeStamp)
		create=True
	for j in input_dict[i]['site'][0]['alerts']:
		count+=1
		if create:
			instances = json.dumps(j["instances"],indent=1)
			file = open("/var/www/html/log/"+projectKey+"/instances/"+timeStamp+"/"+str(count),"w")
			file.write(instances)
			file.close()
		alert.append({**dict(alert = str(j['alert'])),**dict(riskdesc = str(j['riskdesc']).split()[0].replace("High","3").replace("Medium","2").replace("Low","1").replace("Informational","0")),**dict(desc = str(j['desc']).replace("<p>","").replace("</p>","")),**dict(count = str(j['count'])),**dict(solution = str(j['solution']).replace("<p>","").replace("</p>","")),**dict(cweid = str(j['cweid'])),**dict(instances = "http://54.199.43.255/api/getInstances.php?projectKey="+projectKey+"&file="+timeStamp+"&id="+str(count))})
	create=False
	measures.append({**{"projectKey":projectKey},**{'scanDate':str(new_time),**{"alerts":alert}}})

total['measures']=measures
final = json.dumps(total,indent=1)

file = open("/var/www/html/log/output","w")

file.write(final)

file.close()

