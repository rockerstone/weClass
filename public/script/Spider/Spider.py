import requests
import login
import info
import course
import datebase
import sys

org = {}
stu = {}

if len(sys.argv) != 4:
    print('false 缺少参数')
    sys.exit()

org['code'] = sys.argv[1]
stu['id'] = sys.argv[2]
stu['pwd'] = sys.argv[3]
org = datebase.org_info(org)

session = requests.Session()
login.login(session, stu)
stu['info'] = info.information(session)
stu['course'] = course.course(session, org)
datebase.storage_data(org, stu)
print("true")
sys.exit()
