#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Contact : northdipperbig@gmail.com
Author  : North Star
Date    : 2020.11.1
Desc    :  主控制
"""
import json
import re
import telegram
from sqlalchemy import or_
from libs.base_handler import BaseHandler
from websdk.base_handler import LivenessProbe
from websdk.configs import configs
from tornado.web import HTTPError



def check_contain_chinese(check_str):
    for ch in check_str:
        if u'\u4e00' <= ch <= u'\u9fff':
            return True
    return False


def is_ip(ip):
    # p = re.compile('^((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$')

    p = re.compile('^(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|[1-9])\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)$')
    if p.match(ip):
        return True
    else:
        return False


def is_domain(domain):
    domain_regex = re.compile(r'(?:[A-Z0-9_](?:[A-Z0-9-_]{0,247}[A-Z0-9])?\.)+(?:[A-Z]{2,6}|[A-Z0-9-]{2,}(?<!-))\Z',
                              re.IGNORECASE)
    return True if domain_regex.match(domain) else False

class SmsSendHandler(BaseHandler):
    def get(self, *args, **kwargs):
        raise HTTPError(
            status_code=404,
            reason="Invalid resource path."
        )

    def post(self, *args, **kwargs):
        pd = self.request.body
        if pd == b'':
            self.write(dict(code=1, msg='Access error'))
        else:
            try:
                data = json.loads(pd.decode("utf-8"))
                fr = data.get('Fr', None)
                to = data.get('To', None)
                msg = data.get('Msg', None)
                rtime = data.get('Rtime', None)
                tgbot = telegram.Bot(configs["tgapitoken"])
                groupid = configs["tggroupid"]
                tgmsg = """发送号码: {}
接收号码: {}
接收时间: {}
短信内容:
  {}
""".format(fr, to, msg)
                tgbot.send_message(groupid, tgmsg)
                self.write(dict(code=0, msg='Messsage send success...'))
            except:
                self.write(dict(code=2, msg='Access error'))

smstotg_urls = [
    (r"/v1/smssend", SmsSendHandler)
]
