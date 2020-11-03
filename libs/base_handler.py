#!/usr/bin/env python
# -*-coding:utf-8-*-

import jwt
from tornado.web import HTTPError
from websdk.base_handler import BaseHandler as SDKBaseHandler


class BaseHandler(SDKBaseHandler):
    def __init__(self, *args, **kwargs):
        super(BaseHandler, self).__init__(*args, **kwargs)

    def prepare(self):
        self.xsrf_token

        self.is_superuser = self.is_super
