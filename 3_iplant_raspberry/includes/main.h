/*
*   @file       main.h
*   @author     ngtrdai
*   @project    iplant
*   @website    https://iplant.svute.com
*   @date       31/05/2022
*   @LastUpdate 04/06/2022
*/

/*
*   KHAI BÁO THƯ VIỆN
*/
// Thư viện STD.
#include "stdio.h"
#include "stdlib.h"
#include "stdint.h"
#include "math.h"
#include "unistd.h"
#include "stdbool.h"
#include "time.h"
#include "string.h"

// Thư viện wiringPi.
#include "wiringPi.h"
#include "softPwm.h"

// Thư viện MYSQL
#include "mysql.h"

// Thư viện tự làm.
#include "./dADS1015.h"
#include "./dUltraSonic.h"
#include "./dLM75.h"
#include "./dBH1705.h"
#include "./dSHT30.h"

/*
*   DEFINE GPIO
*/
#define P_notiLED         	4
#define P_relayTuoiNuoc		1
#define P_relayDenQuangHop	6
#define P_btnTuoiNuoc		5

/*
*   KHAI BÁO CÁC BIẾN MẶC ĐỊNH, HẰNG SỐ, KIỂU DỮ LIỆU ĐỊNH NGHĨA.
*/
const char IMEI[10] = "iplant0001";     // Địa chỉ IMEI định danh cho từng chậu cây.

struct S_Sensors{
    uint8_t soilMoisture;
	float temperatureEnv;
	int lightSensor;
	char waterLevel[10];
} s_Sensors;

struct S_SetpointSensors{
    uint8_t soilMoisture;
	float temperatureEnv;
	int lightSensor;
} s_SetpointSensors;

/*
*   KHAI BÁO CÁC BIẾN CỜ
*/
bool isPump         = FALSE;                // Cờ tắt/bật tính năng tưới cây.
bool isLED          = FALSE;                // Cờ tắt/bật đèn tín hiệu.
bool isLEDUV		= FALSE;				// Cờ tắt/bật đèn quang hợp.
bool isUpdated      = FALSE;                // Cờ thông báo có tín hiệu điều khiển mới từ CSDL.
bool isFirstRun     = TRUE;                 // Cờ lần chạy đầu tiên của chương trình.
bool isUpdatedAuto  = FALSE;                // Cờ thông báo có tín hiệu thay đổi kịch bản auto.
bool isAutoTurnOn   = FALSE;                 // Cờ tắt/bật tính năng tự động.

/*
*   KHAI BÁO CÁC BIẾN ĐỊNH THỜI
*/
unsigned long timeRaSPrev = 0;
unsigned long timeRaSDelay = 5000;			// 30s đọc cảm biến và gửi dữ liệu 1 lần.

unsigned long timeTuoiNuocPrev = 0;
unsigned long timeTuoiNuocDelay = 5000;

/*
*   KHAI BÁO CÁC BIẾN LƯU TRỮ GIÁ TRỊ CẢM BIẾN
*/

float waterLevelRaw;
/*
*   KHAI BÁO CÁC BIẾN LƯU TRỮ GIÁ TRỊ ĐẶT
*/


/*
*   KHAI BÁO CẤU HÌNH CSDL MYSQL
*/
MYSQL *conn;
MYSQL_RES *res;
MYSQL_ROW row;

char *server = "188.166.181.100";
char *user = "iplant";
char *password = "3OJrCSbdpR5leDEF";
char *database = "iplant";

/*
*   KHAI BÁO CÂU THÔNG BÁO
*/
struct S_NotiText{
    char DaTuoiNuoc[200]; 
}s_NotiText = {"Đã được tưới nước."};


/*
*   CÁC HÀM KHỞI TẠO CHƯƠNG TRÌNH
*/
void InitGPIO();                // Khởi tạo GPIO.
void InitSensors();             // Khởi tạo cấu hình cảm biến.

/*
*   CÁC HÀM TÍNH NĂNG
*/
void TuoiNuoc();                // Bật tưới nước.
void ReadAllSensors();          // Đọc tất cả các giá trị của cảm biến.
void printBits(size_t const size, void const * const ptr);

/*
*   CHECK FLAGS
*/
void CheckFlags();              // Check cờ tưới nước và bật LED.
void CheckAlarm();          // Check cờ Alarm tưới nước.
void CheckIsUpdated();          // Check cờ IsUpdated, IsUpdatedAuto trong bảng Controls.
void CheckAuto();               // Check thoả mản điều kiện Auto.
/*
*   GET VALUES FROM DATABASE
*/
void GetWaterLevelPump();       // Lấy giá trị mực nước từ DB.
void GetAutoValue();            // Lấy giá trị thiết lập Auto.
/*
*   SEND TO DATABASE
*/
void SendSensorValuesToDB();    // Gửi các dữ liệu Sensor đến DB.        
void SendFlagAlarm(int id);     // Tắt cờ tưới nước trong bảng hẹn giờ.
void SendFlagIsPump();          // Tắt cờ tưới nước trong bảng Controls.
void SendUpdateNextDayAlarm(int id, char* dateNow, char* clockNow);

/*
*   INTERRUPT
*/
void HandleButton();            // Xử lí nút nhấn - Nút bật tắt đèn thông báo.

uint8_t map(int x, int in_min, int in_max, uint8_t out_min, uint8_t out_max);