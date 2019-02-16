import mysql.connector
import sys


def org_info(org):
    try:
        mydb = mysql.connector.connect(
            host="192.168.50.210",  # 数据库主机地址
            port=3306,
            user="root",  # 数据库用户名
            passwd="@@Sl19981026",  # 数据库密码
            database="course"
        )
        mycursor = mydb.cursor()

        sql = "SELECT id,year,term FROM org WHERE code='" + org['code'] + "'"
        mycursor.execute(sql)
        data = mycursor.fetchone()
        org['id'] = data[0]
        org['year'] = data[1]
        org['term'] = data[2]
        return org
    except:
        print("false 组织代码不存在")
        sys.exit()


def storage_data(org, stu):
    try:
        mydb = mysql.connector.connect(
            host="192.168.50.210",  # 数据库主机地址
            port=3306,
            user="root",  # 数据库用户名
            passwd="@@Sl19981026",  # 数据库密码
            database="course"
        )
        mycursor = mydb.cursor()

        # 存入个人信息
        sql = "DELETE FROM personnel WHERE stuid='"+stu['info']['stuid']+"' AND org_id='"+str(org['id'])+"'"
        mycursor.execute(sql)

        sql = "INSERT INTO personnel (org_id,stuid,name,college,major,class) VALUES "
        sql += "('"+str(org['id'])+"','"+stu['info']['stuid']+"','"+stu['info']['name']+"','"+stu['info']['college']+"','"+stu['info']['major']+"','"+stu['info']['class']+"')"
        mycursor.execute(sql)

        # 存入课程表
        sql = "DELETE FROM course WHERE stuid='" + stu['info']['stuid'] + "'"
        mycursor.execute(sql)

        for lesson in stu['course']:
            sql = "INSERT INTO course (stuid,name,day,time_start,time_end,week) VALUES "
            sql += "('" + lesson['stuid'] + "','" + lesson['name'] + "'," + lesson['day'] + \
                   "," + lesson['time_start'] + "," + lesson['time_end'] + \
                   ",'" + lesson['week'] + "')"
            mycursor.execute(sql)
    except:
        print("false 未知错误，请联系网站管理员")
        sys.exit()
