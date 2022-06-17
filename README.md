# **IoT in Mechatronics - Embedded System**
---
<p align="center" style="font-size: 30px; font-weight: bold">
  iPlant Project - Chậu cây IoT
</p>
<p align="center">
  <img 
    width="300"
    height="300"
    src="https://iplant.svute.com/public/images/iPlant_logo.svg"
  >
</p>

---

# Mục lục:
1. [Thông tin môn học](#thông-tin-môn-học)
2. [Thông tin đề tài](#thông-tin-đề-tài)
3. [Phần cứng](#phần-cứng)
   1. [Thiết bị và linh kiện sử dụng](#thiết-bị-và-linh-kiện-sử-dụng)
   3. [Sơ đồ nguyên lý](#sơ-đồ-nguyên-lý)
   4. [Sơ đồ PCB](#sơ-đồ-pcb)
4. [Phần mềm](#phần-mềm)
   1. [Website](#website)
   3. [Ứng dụng Android](#ứng-dụng-android)
   4. [Nhúng Raspberry Pi](#nhúng-raspberry-pi)
5. [Sản phẩm thực tế](#sản-phẩm-thực-tế)
   1. [Hình ảnh](#hình-ảnh)
   2. [Demo sản phẩm](#demo-sản-phẩm)
7. [Liên kết](#liên-kết)
8. [Đóng góp](#contributing)

# Thông tin môn học:
  
* **Môn học:** IoT in Mechatronics - Embedded System
* **Giảng viên:** TS. Bùi Hà Đức
* **Thành viên:**
```
1. Nguyễn Trọng Đại 		- 19146146 		- @ngtrdai.
2. Lê Phan Văn Việt		- 19146302 		- @ogarta
3. Trần Triệu Vĩ 		- 19146301 		- @trantrieuvi.
```
# Thông tin đề tài
**iPlant** - Chậy cây IoT là sản phẩm cuối kỳ của môn học **IoT** và **Lập trình nhúng**. 

**iPlant** có thể giám sát các thông số của chậu cây, điều khiển tưới nước - bật đèn hỗ trợ cây quang hợp tự động hoặc được lên lịch trước thông qua Website và ứng dụng trên hệ điều hành Android.

# Phần cứng

[Altium Project](https://github.com/ngtrdai/iPlant/tree/master/4_iplant_schematic) - Được thực hiện bởi [Trần Triệu Vĩ](https://github.com/trantrieuvi).

## Thiết bị và linh kiện sử dụng

| | | |
|:-------------------------:|:-------------------------:|:-------------------------:|
|<a href="https://www.cytrontech.vn/c-raspberry-pi-main-board/c-raspberry-pi-zero/p-raspberry-pi-zero-w"><img src="https://static.cytron.io/image/cache/catalog/products/RPI-ZERO-W/RPI-ZERO-W-512x512.JPG"></a> Raspberry Pi Zero W|<a href="https://icdayroi.com/cam-bien-nhiet-do-do-am-gy-sht30-d-giao-tiep-i2c"><img src="https://thietbidiennhaxuong.net/wp-content/uploads/2021/04/cam-bien-do-am-nhiet-do-khong-khi-sht30.jpg?v=1617980444"></a> Cảm biến nhiệt độ, độ ẩm GY-SHT30-D|<a href="https://icdayroi.com/cam-bien-do-am-dat-dau-do-chong-an-mon"><img src="https://bizweb.dktcdn.net/thumb/large/100/190/540/products/cam-bien-do-am-dat-dau-do-chong-an-mon.jpg"></a> Cảm biến độ ẩm đất đầu dò chống ăn mòn|
|<a href="https://icdayroi.com/ads1115-analog-digital-converter-16-bit"><img src="https://ae01.alicdn.com/kf/HTB1cmWWriCYBuNkHFCcq6AHtVXaz/ADS1015-ADC-Si-u-Nh-12-Ch-nh-X-c-ADC-M-un-Ban-Ph-t.jpg_Q90.jpg_.webp"></a> ADS1015|<a href="https://icdayroi.com/cam-bien-cuong-do-anh-sang-gy-302-bh1750"><img src="https://bizweb.dktcdn.net/thumb/large/100/190/540/products/cam-bien-cuong-do-anh-sang-bh1750.jpg?v=1511800901530"></a> Cảm biến cường độ ánh sáng GY-302 BH1750|<a href="https://icdayroi.com/cam-bien-sieu-am-hc-sr04"><img src="https://bizweb.dktcdn.net/thumb/large/100/190/540/products/hc-sr04.jpg?v=1490768336557"></a> Cảm biến siêu âm HC-SR04|
|<a href="https://icdayroi.com/module-1-relay-5v-kich-muc-cao"><img src="https://bizweb.dktcdn.net/thumb/large/100/190/540/products/module-1-relay-5v-kich-muc-cao-jpeg.jpg?v=1626234579137"></a> Module 1 relay 5V kích mức cao|<a href="https://icdayroi.com/bom-chim-mini"><img src="https://bizweb.dktcdn.net/thumb/large/100/190/540/products/bom-chim-mini.jpg?v=1518258534140"></a> Bơm chìm mini|<a href=""><img src="https://icons.veryicon.com/png/o/miscellaneous/small-green-icon/more-118.png"></a> LED, Đèn, Nút nhấn, Công tắc|

## Sơ đồ nguyên lý

<p align="center">
  <img 
    width="600"
    height="600"
    src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/SoDoNguyenLi.jpg"
  >
</p>

## Sơ đồ PCB

<p align="center">
  <img 
    width="600"
    height="600"
    src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/SoDo_PCB.jpg"
  >
</p>

<p align="center">
  <img 
    width="600"
    height="600"
    src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Mach_MatTruoc.jpg"
  >
</p>

<p align="center">
  <img 
    width="600"
    height="600"
    src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Mach_MatSau.jpg"
  >
</p>

# Phần mềm

Phần mềm của iPlant gồm 4 phần chính: Cơ sở dữ liệu, Website, ứng dụng Android và phần lập trình nhúng dưới Raspberry.

## Cơ sở dữ liệu
Cơ sở dữ liệu iPlant: [File SQL Backup](https://github.com/ngtrdai/iPlant/tree/master/1_iplant_web/2_Database).

Cơ sở dữ liệu iPlant được xây dựng theo mối quan hệ N-N, một người dùng có thể có nhiều cậu cây, và một chậu cây có thể được tới nối bởi nhiều người.

Mỗi chậu cây hay iPlant được định danh bằng một IMEI.
![Bảng dữ liệu mỗi quan hệ của các bảng trong CSDL](https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/CoSoDuLieu.svg "Bảng quan hệ trong CSDL")

## Website

Website iPlant được xây dựng dựa trên mô hình MVC với ngôn ngữ lập trình chính là PHP.

Source code Website: [Source Code](https://github.com/ngtrdai/iPlant/tree/master/1_iplant_web/1_SourceCode).

![Giao diện Website](https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/GiaoDienWebsite.svg "Giao diện website")

- **Chức năng của Web:**
	- **Người dùng**
		- Thêm/Sửa/Xoá chậu cây bằng IMEI.
		- Giám sát các thông số từ cảm biến ở chậu cây. Vẽ đồ thị và hiển thị số trực quan.
		- Điều khiển đèn hỗ trợ quang hợp, máy bơm nước và đèn LED thông báo.
		- Điều khiển tự động - Cho phép chỉnh sửa các giá trị đặt để iPlant hoạt động tự động.
		- Hẹn giờ tưới cây, bật đèn quang hợp - Cho phép lặp lại hằng ngày.
		- Hiển thị thông báo khi chậu cây được tưới nước, bật đèn.
	- **Quản trị viên**
		- Quản lý người dùng: Thêm/Xoá/Sửa/Cài đặt phân quyền.
		- Quản lý chậy cây: Thêm/Xoá/Sửa.
		- Cho phép tạo chậu cây mới hàng loạt phục vụ cho quá trình sản xuất.	 		

## Ứng dụng Android

Source code Android: [Source Code](https://github.com/ngtrdai/iPlant/tree/master/2_iplant_app).

Ứng dụng Android được thực hiện bởi: [Lê Phan Văn Việt](https://github.com/ogarta).

### Đăng nhập và Đăng ký tài khoản

Khi đăng nhập thông tin tài khoản sẽ được lưu lại để tự đông đăng nhập lần tiếp theo.

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_DangNhap_1.jpg"
>
	
<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_DangKy_1.jpg"
></p>

### Trang chủ
	
Trang chủ show toàn bộ cây người dùng sở hữu, show các thông số trạng thái hiện tại của chậu cây.

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_TrangChu_1.jpg"
></p>

Khi nhấn vào vào các chậu cây sẽ đưa ra biểu đồ thông số theo thời gian thực và có thể bật tắt tưới, đèn led vị trí, đèn UV bằng tay.

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_ChiTiet_1.jpg">
</p>

### Thêm - Xoá - Sửa chậu cây.

#### Thêm chậu cây bằng 2 cách

- Quét mã QR
- Nhập IMEI

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_ThemChau_1.jpg"
></p>

#### Xoá chậy cây

Vuốt sang trái để để xoá chậu cây.

#### Đổi tên và ảnh đại diện của chậu cây

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_DoiTen_1.jpg"
></p>

### Cài đặt kịch bản (Auto) tưới cây

Kịch bản tưới cây sẽ được tạo mặc định và có thể khởi động chạy ở chế độ auto. Người dùng có thể thay đổi được kịch bản (Kịch bản mỗi cây chỉ có một).

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_Auto_1.jpg"
></p>

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_Auto_2.jpg"
></p>

### Cài đặt thời gian tưới và chiếu cây

Thời gian tưới cây sẽ bao gồm thời gian ngày thực hiện công việc tưới cây hoặc chiếu sáng hoặc cả 2.

Có chế độ hằng ngày (Mỗi cây có thể có nhiều thời gian thực hiện công việc).

<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_Alarm_1.jpg"
>
</p>
<p align="center">
<img 
width="300"
height="600"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/Andoird_Alarm_2.jpg"
>
</p>

## Nhúng Raspberry PI
Source code nhúng: [Source Code](https://github.com/ngtrdai/iPlant/tree/master/3_iplant_raspberry).

### Cấu trúc file
    .
    ├── includes                   # Thư mục chứ các file header.
    │   ├── dADS1015.h	       # File header của Module ADC ADS1015.
    │   ├── dBH1705.h              # File header của Module cảm biến cường độ sáng BH1705.
    │   └── dLM75.h                # File header của Module cảm biến nhiệt độ LM75.
    │   └── dSHT30.h               # File header của Module cảm biến nhiệt độ, độ ẩm SHT30.
    │   └── dUltraSonic.h          # File header của Module đo khoảng cách bằng UltraSonic.
    │   └── main.h                 # File header của chương trình chính.
    ├── dADS1015.c                 # Source code của Module ADC ADS1015.
    ├── dBH1705.c                  # Source code của Module cảm biến cường độ sáng BH1705.
    ├── dLM75.c                    # Source code của Module cảm biến nhiệt độ LM75.
    ├── dSHT30.c                   # Source code của Module cảm biến nhiệt độ, độ ẩm SHT30.
    ├── dUltraSonic.c              # Source code của Module đo khoảng cách bằng UltraSonic.
    └── main.c		       # Source code chương trình chính.

> Cảm biến LM75 không được sử dụng vì đã đổi sang sử dụng SHT30 vì trùng địa chỉ I2C 🥲.

# Sản phẩm thực tế

## Hình ảnh
<p align="center">
<img 
width="396"
height="529"
src="https://github.com/ngtrdai/iPlant/blob/master/5_iplant_images/AnhChauCay_HoanChinh.jpg"
></p>

## Demo sản phẩm
Truy cập vào [iPlant WEBSITE](https://iplant.svute.com) hoặc tải [Android APP](https://github.com/ngtrdai/iPlant/releases/download/v1.0.0/iPlant_V1.0.apk)

- Tài khoản ADMIN:
	- Username: admin
	- Password: 123123
- Tài khoản USER:
	- Username: user
	- Password: 123123  
	
# Liên kết
[Website](https://iplant.svute.com)

[Github - iPlant Website Repo](https://github.com/ngtrdai/iplant-web)

[Github - iPlant Raspberry Pi Repo](https://github.com/ngtrdai/iplant-raspberry)

[Github - iPlant Android App  Repo](https://github.com/ogarta/Iplant_android_app)

# Contributing
Cảm ơn các thành viên đã cùng hoàn thành Project.
- [Nguyễn Trọng Đại](https://github.com/ngtrdai), ``ngtrdai@svute.com``
- [Lê Phan Văn Việt](https://github.com/ogarta) ``ogata@svute.com``
- [Trần Triệu Vĩ](https://github.com/trantrieuvi) ``trtrvi@svute.com``

