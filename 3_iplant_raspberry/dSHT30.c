#include "./includes/dSHT30.h"
int I2C_SHT30;
void dSHT30_INIT(){
	I2C_SHT30 = wiringPiI2CSetup(SHT30_ADDRESS);
	
}

float dSHT30_READ_VALUE(){
	char config[2] = {0};
	config[0] = 0x2C;
	config[1] = 0x06;
	write(I2C_SHT30, config, 2);
	sleep(1);
	char data[6] = {0};
	read(I2C_SHT30, data, 6);
	int temp = (data[0] * 256 + data[1]);
	float cTemp = -45 + (175 * temp / 65535.0);
	
	return cTemp;
}