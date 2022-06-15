#include "stdint.h"
#include "stdbool.h"
#include "wiringPi.h"
#include "wiringPiI2C.h"
#include "stdio.h"

#define SHT30_ADDRESS        0x44



void dSHT30_INIT();

float dSHT30_READ_VALUE();