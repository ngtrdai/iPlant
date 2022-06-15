package com.svute.iplant;

import android.os.Parcel;
import android.os.Parcelable;

import java.util.ArrayList;

public class UserIplant implements Parcelable {
    private String userAcc;
    private String userName;
    private String userPass;
    private int numIplant;
    private ArrayList<String> iplantList;
    private String userImage;

    public UserIplant(){}
    public UserIplant(String userAcc, String userName, String userPass,String userImage, int numIplant, ArrayList<String> iplantList) {
        this.userAcc = userAcc;
        this.userName = userName;
        this.userPass = userPass;
        this.numIplant = numIplant;
        this.iplantList = iplantList;
        this.userImage = userImage;
    }

    protected UserIplant(Parcel in) {
        userAcc = in.readString();
        userName = in.readString();
        userPass = in.readString();
        numIplant = in.readInt();
        iplantList = in.createStringArrayList();
        userImage = in.readString();
    }

    public static final Creator<UserIplant> CREATOR = new Creator<UserIplant>() {
        @Override
        public UserIplant createFromParcel(Parcel in) {
            return new UserIplant(in);
        }

        @Override
        public UserIplant[] newArray(int size) {
            return new UserIplant[size];
        }
    };

    public String getUserImage() {
        return userImage;
    }

    public void setUserImage(String userImage) {
        this.userImage = userImage;
    }

    public String getUserAcc() {
        return userAcc;
    }

    public void setUserAcc(String userAcc) {
        this.userAcc = userAcc;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getUserPass() {
        return userPass;
    }

    public void setUserPass(String userPass) {
        this.userPass = userPass;
    }

    public int getNumIplant() {
        return numIplant;
    }

    public void setNumIplant(int numIplant) {
        this.numIplant = numIplant;
    }

    public ArrayList<String> getIplantList() {
        return iplantList;
    }

    public void setIplantList(ArrayList<String> iplantList) {
        this.iplantList = iplantList;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int i) {
        parcel.writeString(userAcc);
        parcel.writeString(userName);
        parcel.writeString(userPass);
        parcel.writeInt(numIplant);
        parcel.writeStringList(iplantList);
        parcel.writeString(userImage);
    }
}
