#include "./includes/dLM75.h"

int I2C_LM75;

void dLM75_INIT(){
    I2C_LM75 = wiringPiI2CSetup(LM75_ADDRESS);
}

float dLM75_GET_TEMP(){
    uint16_t regTempurature = wiringPiI2CReadReg16(I2C_LM75, LM75_TEMP_REGISTER);
    return dLM75_DATA_TO_FLOAT(regTempurature);
}

float dLM75_DATA_TO_FLOAT(uint16_t regTempurature){
    uint8_t msb, lsb;
    msb = regTempurature & 0x00FF;
    lsb = (regTempurature & 0xFF00) >> 8;
    int8_t temperature0 = (int8_t) msb;
    int8_t temperature1 = (lsb & 0x80) >> 7;
    float temperature = temperature0 + 0.5 * temperature1;
    return temperature;
}