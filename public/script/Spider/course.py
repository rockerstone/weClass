import sys


def course(session, org):

    if org['term'] == 1:
        org['term'] = 3
    elif org['term'] == 2:
        org['term'] = 12

    data = []
    url = 'https://jwgl.njtech.edu.cn/kbcx/xskbcx_cxXsKb.html?gnmkdm=N2151'

    try:
        form_data = {
            'xnm': org['year'],
            'xqm': org['term'],
        }
        lesson = session.post(url, data=form_data)
        lesson = lesson.json()
    except:
        print("false 未知错误，请联系网站管理员")
        sys.exit()

    stuid = lesson['xsxx']['XH']
    for item in lesson['kbList']:
        data.append({
            'stuid': stuid,
            'name': item['kcmc'],
            'day': item['xqj'],
            'time': item['jcs'],
            'week': item['zcd']
        })
    # print(str(data))
    data = standardise(data)
    if len(data) == 0:
        print("false 当前学期课表为空，请联系管理员修改")
        sys.exit()
    return data


def standardise(data):
    for lesson in data:
        # time
        lesson['time_start'] = lesson['time'].split("-")[0]
        lesson['time_end'] = lesson['time'].split("-")[1]
        lesson.pop("time")

        # week
        week = ""
        week_str = lesson['week']
        week_str = week_str.replace("周", "")
        week_str = week_str.split(",")
        for sub_week_str in week_str:
            if sub_week_str.find("(双)") != -1 or sub_week_str.find("(单)") != -1:
                step = 2
            else:
                step = 1
            sub_week_str = sub_week_str.replace("(双)", "")
            sub_week_str = sub_week_str.replace("(单)", "")
            sub_week_str = sub_week_str.split("-")
            first = int(sub_week_str[0])
            last = int(sub_week_str[len(sub_week_str)-1])
            # print("MIN"+str(first)+" MAX"+str(last))
            for i in range(first, last+1, step):
                week += str(i)+","
        # week = week.rstrip(",")
        lesson['week'] = week
        # print(str(lesson))
    return data
