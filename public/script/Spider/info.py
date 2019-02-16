from bs4 import BeautifulSoup
import sys


def information(session):
    url = 'https://jwgl.njtech.edu.cn/xsxxxggl/xsgrxxwh_cxXsgrxx.html?gnmkdm=N100801&layout=default'
    data = {}

    try:
        info = session.get(url)
        info.encoding = info.apparent_encoding
        soup = BeautifulSoup(info.text, 'html.parser')
        data['stuid'] = soup.find(id='col_xh').find(class_="form-control-static").string
        data['name'] = soup.find(id='col_xm').find(class_="form-control-static").string
        data['college'] = soup.find(id='col_jg_id').find(class_="form-control-static").string
        data['college'] = data['college'] .replace("\t", "").replace("\n", "").replace("\r", "")
        data['major'] = soup.find(id='col_zyh_id').find(class_="form-control-static").string
        data['major'] = data['major'].replace("\t", "").replace("\n", "").replace("\r", "")
        data['class'] = soup.find(id='col_bh_id').find(class_="form-control-static").string
        data['class'] = data['class'].replace("\t", "").replace("\n", "").replace("\r", "")
        return data
    except:
        print("false 未知错误，请联系网站管理员")
        sys.exit()
