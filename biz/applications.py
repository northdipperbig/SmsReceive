#!/usr/bin/env python
# -*-coding:utf-8-*-
"""
Author : shenshuo
date   : 2019年5月6日
role   : Application
"""

import json
from websdk.application import Application as myApplication
from libs.base_handler import BaseHandler
from tornado.web import HTTPError
from biz.handlers.sms_to_telegram import smstotg_urls

class NotFoundHandler(BaseHandler):
    def get(self, *args, **kwargs):
        raise HTTPError(
            status_code=404,
            reason="Invalid resource path."
        )

all_urls = [
    (r"(.*)", NotFoundHandler)
]

class Application(myApplication):
    def __init__(self, **settings):
        urls = []
        urls.extend(smstotg_urls)
        urls.extend(all_urls)
        super(Application, self).__init__(urls, **settings)

if __name__ == '__main__':
    pass
