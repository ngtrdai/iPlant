package com.svute.iplant.alarm;

import android.content.Context;

public class AlarmModel {
    private int mYear;
    private String mDayMoth ;
    private String iplantName;
    private int swAuto;
    private String iplantImage;
    private String mHour;
    private String mMinute;
    private int lineRed;
    private int lineGreen;
    private int lineBlue;
    private int id;
    private int swWater;
    private int swUv;
    private Context contextAlarm;

    public AlarmModel(int id, String mDayMoth, String iplantName, String iplantImage, String mHour, String mMinute, int lineRed, int lineGreen, int lineBlue, int swWater, int swUv, int swAuto, Context contextAlarm) {
        this.mDayMoth = mDayMoth;
        this.iplantName = iplantName;
        this.iplantImage = iplantImage;
        this.mHour = mHour;
        this.mMinute = mMinute;
        this.lineRed = lineRed;
        this.lineGreen = lineGreen;
        this.lineBlue = lineBlue;
        this.id = id;
        this.swWater = swWater;
        this.swUv = swUv;
        this.swAuto = swAuto;
        this.contextAlarm = contextAlarm;
    }

    public Context getContextAlarm() {
        return contextAlarm;
    }

    public void setContextAlarm(Context contextAlarm) {
        this.contextAlarm = contextAlarm;
    }

    public int getSwWater() {
        return swWater;
    }

    public void setSwWater(int swWater) {
        this.swWater = swWater;
    }

    public int getSwUv() {
        return swUv;
    }

    public void setSwUv(int swUv) {
        this.swUv = swUv;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getmHour() {
        return mHour;
    }

    public void setmHour(String mHour) {
        this.mHour = mHour;
    }

    public String getmMinute() {
        return mMinute;
    }

    public void setmMinute(String mMinute) {
        this.mMinute = mMinute;
    }

    public int getmYear() {
        return mYear;
    }

    public void setmYear(int mYear) {
        this.mYear = mYear;
    }

    public String getmDayMoth() {
        return mDayMoth;
    }

    public void setmDayMoth(String mDayMoth) {
        this.mDayMoth = mDayMoth;
    }

    public String getIplantName() {
        return iplantName;
    }

    public void setIplantName(String iplantName) {
        this.iplantName = iplantName;
    }

    public int getSwAuto() {
        return swAuto;
    }

    public void setSwAuto(int swAuto) {
        this.swAuto = swAuto;
    }

    public String getIplantImage() {
        return iplantImage;
    }

    public void setIplantImage(String iplantImage) {
        this.iplantImage = iplantImage;
    }

    public int getLineRed() {
        return lineRed;
    }

    public void setLineRed(int lineRed) {
        this.lineRed = lineRed;
    }

    public int getLineGreen() {
        return lineGreen;
    }

    public void setLineGreen(int lineGreen) {
        this.lineGreen = lineGreen;
    }

    public int getLineBlue() {
        return lineBlue;
    }

    public void setLineBlue(int lineBlue) {
        this.lineBlue = lineBlue;
    }
}
