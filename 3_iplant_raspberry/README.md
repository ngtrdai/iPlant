Tác giả: [Nguyễn Trọng Đại](https://github.com/ngtrdai).
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
