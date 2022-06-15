#include "stdint.h"
#include "stdbool.h"
#include "wiringPi.h"
#include "wiringPiI2C.h"
#include "stdio.h"

#define LM75_ADDRESS        0x49

#define LM75_TEMP_REGISTER  0x00

void dLM75_INIT();
float dLM75_GET_TEMP();
float dLM75_DATA_TO_FLOAT(uint16_t regTempurature);