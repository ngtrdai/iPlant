#include "./includes/dADS1015.h"

int I2C_ADS1015;
adsGain_t dADS1015_GAIN;
uint8_t dADS1015_CON_DELAY;
uint8_t   dADS1015_BIT_SHIFT;
void dINIT_ADS1015(){
    I2C_ADS1015 = wiringPiI2CSetup(ADS1015_ADDRESS);
}

uint16_t dADS1015_READ_ADC(uint8_t channel){
    if(channel > 3){return 0;}
    uint16_t config =   ADS1015_REG_CONFIG_CQUE_NONE    |
                        ADS1015_REG_CONFIG_CLAT_NONLAT  |
                        ADS1015_REG_CONFIG_CPOL_ACTVLOW |
                        ADS1015_REG_CONFIG_CMODE_TRAD   |
                        ADS1015_REG_CONFIG_DR_1600SPS   |
                        ADS1015_REG_CONFIG_MODE_SINGLE;
    
    // Set PGA/voltage range
    config |= dADS1015_GAIN;

    switch (channel)
    {
        case (0):
        config |= ADS1015_REG_CONFIG_MUX_SINGLE_0;
        break;
        case (1):
        config |= ADS1015_REG_CONFIG_MUX_SINGLE_1;
        break;
        case (2):
        config |= ADS1015_REG_CONFIG_MUX_SINGLE_2;
        break;
        case (3):
        config |= ADS1015_REG_CONFIG_MUX_SINGLE_3;
        break;
    }
    config |= ADS1015_REG_CONFIG_OS_SINGLE;
    wiringPiI2CWriteReg16(I2C_ADS1015, ADS1015_REG_POINTER_CONFIG, (config>>8) | (config<<8));
    usleep(1000*dADS1015_CON_DELAY);

    return dADS1015_READ_REGISTER(ADS1015_REG_POINTER_CONVERT) >> dADS1015_BIT_SHIFT;  
}

uint16_t dADS1015_READ_REGISTER(uint8_t reg){
    wiringPiI2CWrite(I2C_ADS1015, ADS1015_REG_POINTER_CONVERT);
    uint16_t reading = wiringPiI2CReadReg16(I2C_ADS1015, reg);
    reading = (reading>>8) | (reading<<8);
    return reading;
}

void dADS1015_SET_GAIN(adsGain_t gain){
    dADS1015_GAIN = gain;
}