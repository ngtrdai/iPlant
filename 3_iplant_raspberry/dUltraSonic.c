/*
*   @file dUltraSonic.c
*   @author trtrvi
*   @project iplant
*   @website https://iplant.svute.com
*   @date 04/06/2022
*/

#include "./includes/dUltraSonic.h"

uint8_t dSONIC_TRIG;
uint8_t dSONIC_ECHO;

void dSONIC_INIT(int trig, int echo){
    dSONIC_TRIG = trig;
    dSONIC_ECHO = echo;
    pinMode(dSONIC_TRIG, OUTPUT);
    pinMode(dSONIC_ECHO, INPUT);
}
float dSONIC_READ_DIS(){
    clock_t timeStart, timeEnd;
    float khoangCach;
    digitalWrite(dSONIC_TRIG, LOW);
    delayMicroseconds(2);
    digitalWrite(dSONIC_TRIG, HIGH);
    delayMicroseconds(2);
    digitalWrite(dSONIC_TRIG, LOW);
    while(digitalRead(dSONIC_ECHO)==0)
    {
        timeStart = clock();
    }
    while(digitalRead(dSONIC_ECHO)==1)
    {
        timeEnd = clock();
		if((timeEnd - timeStart) > 1000){
			break;
		}
    }
	
    khoangCach = (float)(timeEnd - timeStart)/CLOCKS_PER_SEC*17000.0;
    return khoangCach;
}

