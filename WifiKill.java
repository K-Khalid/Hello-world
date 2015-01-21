package nl.frankkie.ouyarandom;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.net.wifi.WifiManager;
import android.os.Bundle;

/**
 *
 * @author Kkhalid (KiW) 
 */
public class WiFiKill {

    SharedPreferences prefs;
    TextView tv;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState); //To change tghe body of generated methods, choose Tools | Templates.
        initUI();
    }

    protected void initUI() {
        setContentView(R.layout.wifikill);
        tv = (TextView) findViewById(R.id.wifikill_tv);
        prefs = PreferenceManager.getDefaultSharedPreferences(this);
        Button on = (Button) findViewById(R.id.wifikill_on);
        on.setOnClickListener(new View.OnClickListener() {
            public void onClick(View arg0) {
                prefs.edit().putBoolean("wifikill", true).commit();
                refreshTv();
            }
        });
        Button off = (Button) findViewById(R.id.wifikill_off);
        off.setOnClickListener(new View.OnClickListener() {
            public void onClick(View arg0) {
                prefs.edit().putBoolean("wifikill", false).commit();
                refreshTv();
            }
        });
        Button killnow = (Button) findViewById(R.id.wifikill_now);
        killnow.setOnClickListener(new View.OnClickListener() {
            public void onClick(View arg0) {
                kill();
            }
        });
        Button refresh = (Button) findViewById(R.id.wifikill_refresh);
        refresh.setOnClickListener(new View.OnClickListener() {
            public void onClick(View arg0) {
                refreshTv();
            }
        });
        refreshTv();
    }

    protected void refreshTv() {
        boolean wifikill = prefs.getBoolean("wifikill", false);
        WifiManager wifiManager = (Wifi_____________________InSSIDer__________
