/*
*   @file       main.c
*   @author     ngtrdai
*   @project    iplant
*   @website    https://iplant.svute.com
*   @date       31/05/2022
*   @LastUpdate 14/06/2022
*/

#include "./includes/main.h"

int main(){
    InitGPIO();
    InitSensors();
    
    while(1){
        CheckAlarm();
        CheckIsUpdated();
        // printf("%x\n", isUpdated);

        if(isUpdated == TRUE || isFirstRun == TRUE){
            CheckFlags();
			//isFirstRun = FALSE;
        }

        if(isPump 	== TRUE) {TuoiNuoc();}
        if(isLED 	== TRUE) {digitalWrite(P_notiLED, HIGH);} else {digitalWrite(P_notiLED, LOW);}
		if(isLEDUV 	== TRUE) {digitalWrite(P_relayDenQuangHop, HIGH);} else {digitalWrite(P_relayDenQuangHop, LOW);}
		

        if(isUpdatedAuto == TRUE || isFirstRun == TRUE){
            GetAutoValue();
            isUpdatedAuto = FALSE;
            isFirstRun = FALSE;
            //printf("Giá trị đặt: Soil: %f - Temp: %f - Light: %f\n", s_SetpointSensors.soilMoisture, s_SetpointSensors.temperatureEnv, s_SetpointSensors.lightSensor);
        }
        
		if(isAutoTurnOn == TRUE){
			CheckAuto();
		}
		
        unsigned long timeRaSCurr = millis();
        if(timeRaSCurr - timeRaSPrev >= timeRaSDelay){
            ReadAllSensors();
            SendSensorValuesToDB();
			printf("Giá trị thực: Soil: %d - Temp: %f - Light: %d\n - Water: %f\n", s_Sensors.soilMoisture, s_Sensors.temperatureEnv, s_Sensors.lightSensor, waterLevelRaw);
            timeRaSPrev = timeRaSCurr;
        }
    }
    return 0;
}

/*
*   CÁC HÀM KHỞI TẠO CHƯƠNG TRÌNH
*/
void InitGPIO(){
    wiringPiSetup();
	
	// Khởi tạo OUT RELAY - TƯỚI NƯỚC
	pinMode(P_relayTuoiNuoc, OUTPUT);
	SendFlagIsPump();
	
	// Khởi tạo OUT RELAY - ĐÈN QUANG HỢP
	pinMode(P_relayDenQuangHop, OUTPUT);
	
	// Khởi tạo đèn Noti
	pinMode(P_notiLED, OUTPUT);
	
    // Khởi tạo ngắt nút nhấn (Chế độ Manual). -> Nút nhấn tưới nước.
	wiringPiISR(P_btnTuoiNuoc, INT_EDGE_FALLING, &HandleButton);

}
void InitSensors(){
    // Khởi tạo, cấu hình ADC.
    dINIT_ADS1015();
    dADS1015_SET_GAIN(GAIN_ONE);
	
    // Khởi tạo, cấu hình BH1705.
	dBH1705_INIT();
	
    // Khởi tạo, cấu hình dSHT30.
    dSHT30_INIT();
	
	// Khởi tạo UltraSonic
    dSONIC_INIT(25, 23);
}

/*
*   CÁC HÀM TÍNH NĂNG
*/
void TuoiNuoc(){
    // Sử dụng Delay để tắt bật Relay theo các mức độ.
    printf("Đã bật tưới nước.\n");
	digitalWrite(P_relayTuoiNuoc, HIGH);
    unsigned long timeTuoiNuocCurr = millis();
    //printf("Curr: %u - Prev: %u - Delay: %u.\n", timeTuoiNuocCurr, timeTuoiNuocPrev, timeTuoiNuocDelay);
    if((timeTuoiNuocCurr - timeTuoiNuocPrev) >= timeTuoiNuocDelay){		
		if(timeTuoiNuocPrev != 0){			
			timeTuoiNuocCurr = 0;
			digitalWrite(P_relayTuoiNuoc, LOW);
			SendFlagIsPump();
			printf("Đã tắt tưới cây\n");
		}
		timeTuoiNuocPrev = timeTuoiNuocCurr;
    }
}

void ReadAllSensors(){
	waterLevelRaw = dSONIC_READ_DIS();
	if(waterLevelRaw >= 10) {
		sprintf(s_Sensors.waterLevel,"warning");
	}else if(waterLevelRaw < 10 && waterLevelRaw >= 7){
		sprintf(s_Sensors.waterLevel,"low");
	}else if(waterLevelRaw < 7 && waterLevelRaw >= 3){
		sprintf(s_Sensors.waterLevel,"medium");
	}else{
		sprintf(s_Sensors.waterLevel,"full");
	}
	s_Sensors.soilMoisture = map(dADS1015_READ_ADC(0), 0, 32752, 0, 100);
	s_Sensors.temperatureEnv = dSHT30_READ_VALUE();
	s_Sensors.lightSensor =  dBH1705_READ_VALUE();
}

/*
*   CHECK FLAGS
*/
void CheckIsUpdated(){
    conn = mysql_init(NULL);
    mysql_real_connect(conn,server,user,password,database,0,NULL,0); 
    char sql[200];
    sprintf(sql, "select is_updated, is_updated_auto from controls where imei='%s'", IMEI);
    mysql_query(conn,sql);
    res = mysql_store_result(conn); 
    row = mysql_fetch_row(res);
    // Check cờ is_updated có lên 1 hay chưa.
    if(atoi(row[0]) == 1){
      isUpdated = TRUE;
    }else{
      isUpdated = FALSE;
    }

    if(atoi(row[1]) == 1){
      isUpdatedAuto = TRUE;
    }else{
      isUpdatedAuto = FALSE;
    }
    // Cập nhật lại cờ is_updated và is_updated_auto.
    sprintf(sql, "update controls set is_updated = 0, is_updated_auto = 0 where imei='%s'", IMEI);
    mysql_query(conn,sql);

    mysql_free_result(res);
    mysql_close(conn);
}

void CheckFlags(){
    conn = mysql_init(NULL);
    mysql_real_connect(conn, server, user, password, database, 0, NULL, 0); 
    char sql[200];
    sprintf(sql, "select is_pump, is_led_noti, is_led_uv from controls where imei='%s'", IMEI);
    mysql_query(conn,sql);
    res = mysql_store_result(conn); 
    row = mysql_fetch_row(res);

    if(atoi(row[0]) == 1) {
      isPump = TRUE;
    }else{
      isPump = FALSE;
    }
    
    if(atoi(row[1]) == 1){
      isLED = TRUE;
    }else{
      isLED = FALSE;
    }
	
	if(atoi(row[2]) == 1){
      isLEDUV = TRUE;
    }else{
      isLEDUV = FALSE;
    }

    isUpdated = FALSE;
    
    mysql_free_result(res);
    mysql_close(conn);
}

void CheckAlarm(){
    // Kết nối với CSDL.
    conn = mysql_init(NULL);
    mysql_real_connect(conn, server, user, password, database, 0, NULL, 0); 
    char sql[200];
	time_t T = time(NULL);
	struct tm tm = *localtime(&T);
	
    
	char clockNow[8];
	sprintf(clockNow, "%02d:%02d:00", tm.tm_hour, tm.tm_min);
	char dateNow[10];
	sprintf(dateNow, "%04d-%02d-%02d", tm.tm_year + 1900, tm.tm_mon + 1, tm.tm_mday);
    sprintf(sql, "select id, flag, date_set, flag_pump, flag_uv, flag_loop from alarm where clock_set = '%s' and imei='%s' and date_set <= '%s' ORDER BY flag_loop DESC LIMIT 1", clockNow, IMEI, dateNow);
    // Test: select id, flag, date_set, flag_pump, flag_uv, flag_loop from alarm where clock_set = '10:35:00' and imei='4Hzknhw7P3' and date_set <= '2022-06-12' ORDER BY flag_loop DESC
	// Truy vấn time_set trong bản alarm.
    mysql_query(conn,sql);
    res = mysql_store_result(conn);
    row = mysql_fetch_row(res);
    if(mysql_fetch_lengths(res)>0){
		//printf("id=%s | flag=%s | date_set=%s | flag_pump=%s | flag_uv=%s | flag_loop=%s\n", row[0], row[1], row[2], row[3], row[4], row[5]);
		int id = atoi(row[0]);
		switch(atoi(row[5])){
			case 1:
				if(atoi(row[3]) == 1){
					isPump = TRUE;
				}
				if(atoi(row[4]) == 1){
					isLEDUV = TRUE;
				}			
				SendUpdateNextDayAlarm(id, dateNow, clockNow);
				break;
			case 0:
				if(atoi(row[1]) == 0){
					if(strcmp(row[2], dateNow) == 0){
						SendFlagAlarm(id);
						if(atoi(row[3]) == 1){
							isPump = TRUE;
						}
						if(atoi(row[4]) == 1){
							isLEDUV = TRUE;
						}			
					}
				}
				break;
		}    
    }
    // Đóng kết nối CSDL.
    mysql_free_result(res);
    mysql_close(conn);
}

void CheckAuto(){
    if(s_Sensors.soilMoisture <= s_SetpointSensors.soilMoisture) {TuoiNuoc();}
    if(s_Sensors.lightSensor <= s_SetpointSensors.lightSensor) {isLEDUV = TRUE;}else{isLEDUV = FALSE;}
}

/*
*   GET VALUES FROM DATABASE
*/
void GetWaterLevelPump(){
    if(isPump == FALSE){
        // Kết nối cơ sở dữ liệu
        
        // Lấy giá trị Level trong bản pump.

        // Đóng kết nối CSDL
    }    
}

void GetAutoValue(){
    conn = mysql_init(NULL);
    mysql_real_connect(conn,server,user,password,database,0,NULL,0); 
    char sql[200];
    sprintf(sql, "select soil_moisture, temperature_env, light_sensor, status from auto where imei='%s'", IMEI);
    mysql_query(conn,sql);
    res = mysql_store_result(conn);
    row = mysql_fetch_row(res);
    if(atoi(row[3]) == 1){
        isAutoTurnOn = TRUE;
        s_SetpointSensors.soilMoisture = atoi(row[0]);
        s_SetpointSensors.temperatureEnv = atof(row[1]);
        s_SetpointSensors.lightSensor = atoi(row[2]);
    }
	if(atoi(row[3]) == 0){
		isAutoTurnOn = FALSE;
    }
    mysql_free_result(res);
    mysql_close(conn);      
}

/*
*   SEND TO DATABASE
*/
void SendSensorValuesToDB(){
    // Kết nối cơ sở dữ liệu
	conn = mysql_init(NULL);
    mysql_real_connect(conn,server,user,password,database,0,NULL,0); 
    char sql[200];    
    // Gửi dữ liệu Sensors.
    sprintf(sql, "insert into sensors (soil_moisture, temperature_env, light_sensor, water_level, imei) values (%d, %2f, %d, '%s', '%s')",s_Sensors.soilMoisture,s_Sensors.temperatureEnv, s_Sensors.lightSensor, s_Sensors.waterLevel , IMEI);
	
    // Đóng kết nối CSDL
	mysql_query(conn,sql);
	printf("Test\n");
	mysql_close(conn);
}

void SendFlagAlarm(int id){
    char sql[200];
    sprintf(sql, "update alarm set status='Đã tưới nước', flag=1 where id=%d", id);
    mysql_query(conn,sql);
}

void SendUpdateNextDayAlarm(int id, char* dateNow, char* clockNow){
	char sql[200];
	char nextDay[20];
	sprintf(nextDay, "%s %s", dateNow, clockNow);
	printf("%s\n",nextDay);
    sprintf(sql, "update alarm set time_set=date_add('%s', interval 1 day), date_set=date_add('%s', interval 1 day), clock_set='%s' where id=%d", nextDay, dateNow, clockNow, id);
    mysql_query(conn,sql);
}

void SendFlagIsPump(){
    conn = mysql_init(NULL);
    mysql_real_connect(conn,server,user,password,database,0,NULL,0); 
    char sql[200];
    sprintf(sql, "update controls set is_pump = 0 where imei='%s'", IMEI);
    isPump = FALSE;
    mysql_query(conn,sql);
    sprintf(sql, "insert into notification (imei, title, content, status) values ('%s', 'Tưới nước', '%s', 0)", IMEI, s_NotiText.DaTuoiNuoc);
    mysql_query(conn,sql);
	mysql_close(conn);
}


/*
*   INTERRUPT
*/
void HandleButton(){
	isPump = TRUE;
}

/*
*   HÀM HỖ TRỢ
*/

uint8_t map(int x, int in_min, int in_max, uint8_t out_min, uint8_t out_max){
    return 100 - ((x -in_min) * (out_max - out_min) / (in_max - in_min) + out_min);
}