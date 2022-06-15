package com.svute.iplant.control;

import android.content.Context;

public class ControlModel {
    private String nameIplant;
    private String mImgage;
    private int mSensorSoil;
    private int mSensorLight;
    private int mSensorTemp;
    private int mTougle;
    private String imei;
    private Context contextControl;

    public ControlModel(String nameIplant, String mImgage, int mSensorSoil, int mSensorLight, int mSensorTemp, int mTougle, String imei, Context context) {
        this.nameIplant = nameIplant;
        this.mImgage = mImgage;
        this.mSensorSoil = mSensorSoil;
        this.mSensorLight = mSensorLight;
        this.mSensorTemp = mSensorTemp;
        this.mTougle = mTougle;
        this.imei = imei;
        this.contextControl = context;
    }

    public Context getContextControl() {
        return contextControl;
    }

    public void setContextControl(Context contextControl) {
        this.contextControl = contextControl;
    }

    public String getImei() {
        return imei;
    }

    public void setImei(String imei) {
        this.imei = imei;
    }

    public String getmImgage() {
        return mImgage;
    }

    public void setmImgage(String mImgage) {
        this.mImgage = mImgage;
    }

    public int getmSensorSoil() {
        return mSensorSoil;
    }

    public void setmSensorSoil(int mSensorSoil) {
        this.mSensorSoil = mSensorSoil;
    }

    public int getmSensorLight() {
        return mSensorLight;
    }

    public void setmSensorLight(int mSensorLight) {
        this.mSensorLight = mSensorLight;
    }

    public int getmSensorTemp() {
        return mSensorTemp;
    }

    public void setmSensorTemp(int mSensorTemp) {
        this.mSensorTemp = mSensorTemp;
    }

    public int getmTougle() {
        return mTougle;
    }

    public void setmTougle(int mTougle) {
        this.mTougle = mTougle;
    }

    public String getNameIplant() {
        return nameIplant;
    }

    public void setNameIplant(String nameIplant) {
        this.nameIplant = nameIplant;
    }
}
