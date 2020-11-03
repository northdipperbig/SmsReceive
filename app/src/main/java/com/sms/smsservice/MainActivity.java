package com.sms.smsservice;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.telephony.SubscriptionInfo;
import android.telephony.SubscriptionManager;
import android.util.Log;
import android.widget.TextView;

import java.util.List;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onStart() {
        super.onStart();
        Log.d("sms-service", "onStart: MainActivity");
    }

    @Override
    protected void onStop() {
        super.onStop();
        Log.d("sms-service", "onStop: MainActivity");
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        Log.d("sms-service", "onDestroy: MainActivity");
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Log.d("sms-service", "onCreate: MainActivity");
        TextView textView = (TextView) findViewById(R.id.textview);
        textView.setText("Watting......");
    }
}