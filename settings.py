#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Contact : 191715030@qq.com
Author  : shenshuo
Date    : 2019年5月6日
Desc    : 配置文件
"""

import os
from websdk.consts import const

ROOT_DIR = os.path.dirname(__file__)
debug = True
xsrf_cookies = False
expire_seconds = 365 * 24 * 60 * 60
cookie_secret = os.getenv('COOKIE_SECRET', '61oETzKXQAGaYdkL5gEmGeJJFuYh7EQnp2X6TP1o/Vo=')

tgapitoken = "1063249430:AAFjdQYajKzIX70RgYZnMv8Y0zIVtpqZ-ps"
tggroupid = "-403702424"

try:
    from local_settings import *
except:
    pass

settings = dict(
    debug=debug,
    xsrf_cookies=xsrf_cookies,
    cookie_secret=cookie_secret,
    expire_seconds=expire_seconds,
    app_name='smstotg',
    tgapitoken=tgapitoken,
    tggroupid=tggroupid
)
