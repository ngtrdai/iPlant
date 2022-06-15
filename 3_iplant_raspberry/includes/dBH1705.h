#include "wiringPiI2C.h"
#include "stdio.h"
#include "stdint.h"
#include "wiringPi.h"
#include "time.h"

#define BH1705_ADDRESS              0x23

#define BH1750_POWER_DOWN           0x00
#define BH1750_POWER_ON             0x01
#define BH1750_RESET                0x07

#define BH1750_DEFAULT_MTREG        69
#define BH1750_MTREG_MIN            31
#define BH1750_MTREG_MAX            254

typedef enum{
    UNCONFIGURED = 0,
    CONTINUOUS_HIGH_RES_MODE        = 0x10,
    CONTINUOUS_HIGH_RES_MODE_2      = 0x11,
    CONTINUOUS_LOW_RES_MODE         = 0x13,
    ONE_TIME_HIGH_RES_MODE          = 0x20,
    ONE_TIME_HIGH_RES_MODE_2        = 0x21,
    ONE_TIME_LOW_RES_MODE           = 0x23
} dBH1075_MODE;

void dBH1705_INIT();
int dBH1705_READ_VALUE();
