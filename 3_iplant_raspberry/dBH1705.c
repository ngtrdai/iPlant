#include "./includes/dBH1705.h"

int I2C_DH1705;

void dBH1705_INIT(){
    I2C_DH1705 = wiringPiI2CSetup(BH1705_ADDRESS);
}

int dBH1705_READ_VALUE(){
	wiringPiI2CWrite(I2C_DH1705, 0x10);
	sleep(1);
	
	int word = wiringPiI2CReadReg16(I2C_DH1705, 0x00);
	int lux = ((word&0xff00)>>8)|((word&0x00ff)<<8);
	
	return lux;
}