import time
from bs4 import BeautifulSoup
import rsa_encrypt
import sys


def login(session, stu):
    time_now = int(time.time())
    session.headers.update({
        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        'Accept-Encoding': 'gzip, deflate, br',
        'Accept-Language': 'zh-CN,zh;q=0.9,en;q=0.8,ja;q=0.7',
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0',
        'X-Requested-With': 'XMLHttpRequest',
        'Connection': 'keep-alive',
        'Content-Length': '0',
        'Host': 'jwgl.njtech.edu.cn',
        'Referer': 'https://jwgl.njtech.edu.cn/',
        'Upgrade-Insecure-Requests': '1'
    })
    # print(time_now)

    # 准备publickey
    url = 'https://jwgl.njtech.edu.cn/xtgl/login_getPublicKey.html?time=' + str(time_now)
    r = session.get(url)
    publickey = r.json()

    # 准备csrftoken
    url = 'https://jwgl.njtech.edu.cn/xtgl/login_slogin.html?language=zh_CN&_t=' + str(time_now)
    r = session.get(url)
    r.encoding = r.apparent_encoding
    soup = BeautifulSoup(r.text, 'html.parser')
    csrftoken = soup.find('input', attrs={'id': 'csrftoken'}).attrs['value']
    # print(csrftoken)

    # 准备密码
    # print(publickey['modulus'])
    # print(publickey['exponent'])
    rsacode = rsa_encrypt.rsa_encrypt(publickey['modulus'], publickey['exponent'], stu['pwd'])
    # print(rsacode)

    try:
        url = 'https://jwgl.njtech.edu.cn/xtgl/login_slogin.html?time=' + str(time_now)
        data = {
            'csrftoken': csrftoken,
            'mm': rsacode,
            'mm': rsacode,
            'yhm': stu['id']
        }
        result = session.post(url, data=data)
        if '用户名或密码不正确' in result.text:
            print("false 用户名或密码错误")
            sys.exit()
    except:
        print("false 未知错误，请联系网站管理员")
        sys.exit()
