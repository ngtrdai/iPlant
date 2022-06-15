package com.svute.iplant.notification;

public class NotiModel {
    private String mTitle;
    private String mContent;
    private String mTime;
    private String mImage;

    public NotiModel(String mTitle, String mContent, String mTime, String mImage) {
        this.mTitle = mTitle;
        this.mContent = mContent;
        this.mTime = mTime;
        this.mImage = mImage;
    }

    public String getmTitle() {
        return mTitle;
    }

    public void setmTitle(String mTitle) {
        this.mTitle = mTitle;
    }

    public String getmContent() {
        return mContent;
    }

    public void setmContent(String mContent) {
        this.mContent = mContent;
    }

    public String getmTime() {
        return mTime;
    }

    public void setmTime(String mTime) {
        this.mTime = mTime;
    }

    public String getmImage() {
        return mImage;
    }

    public void setmImage(String mImage) {
        this.mImage = mImage;
    }
}
