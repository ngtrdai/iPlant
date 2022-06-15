/*
*   @file dUltraSonic.h
*   @author trtrvi
*   @project iplant
*   @website https://iplant.svute.com
*   @date 04/06/2022
*/

#include "stdio.h"
#include "stdint.h"
#include "wiringPi.h"
#include "time.h"

clock_t clock(void);
void dSONIC_INIT(int trig, int echo);
float dSONIC_READ_DIS();
