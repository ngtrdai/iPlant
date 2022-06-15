package com.svute.iplant.home;

import java.io.Serializable;

public class IplantModel implements Serializable {
    private String imeiIplant;
    private String nameIplant;
    private String sensorSoil;
    private String sensorTemp;
    private String sensorLight;
    private String sensorWater;
    private String imgIplant;

    public IplantModel(String imeiIplant) {
        this.imeiIplant = imeiIplant;
    }

    public IplantModel(String imeiIplant, String nameIplant, String imgIplant, String sensorSoil, String sensorTemp, String sensorLight, String sensorWater) {
        this.imgIplant = imgIplant;
        this.sensorSoil = sensorSoil;
        this.sensorTemp = sensorTemp;
        this.sensorLight = sensorLight;
        this.sensorWater = sensorWater;
        this.nameIplant = nameIplant;
        this.imeiIplant = imeiIplant;
    }

    public String getImeiIplant() {
        return imeiIplant;
    }

    public void setImeiIplant(String imeiIplant) {
        this.imeiIplant = imeiIplant;
    }

    public String getImgIplant() {
        return imgIplant;
    }

    public void setImgIplant(String imgIplant) {
        this.imgIplant = imgIplant;
    }

    public String getNameIplant() {
        return nameIplant;
    }

    public void setNameIplant(String nameIplant) {
        this.nameIplant = nameIplant;
    }

    public String getSensorSoil() {
        return sensorSoil;
    }

    public void setSensorSoil(String sensorSoil) {
        this.sensorSoil = sensorSoil;
    }

    public String getSensorTemp() {
        return sensorTemp;
    }

    public void setSensorTemp(String sensorTemp) {
        this.sensorTemp = sensorTemp;
    }

    public String getSensorLight() {
        return sensorLight;
    }

    public void setSensorLight(String sensorLight) {
        this.sensorLight = sensorLight;
    }

    public String getSensorWater() {
        return sensorWater;
    }

    public void setSensorWater(String sensorWater) {
        this.sensorWater = sensorWater;
    }
}
