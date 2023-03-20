<?php
$Sys_config["debug"] = true;
$Sys_config["enable_register"] = true;
$Sys_config["db_host"] = "localhost";
$Sys_config["db_user"] = "root";
$Sys_config["db_password"] = "123456";
$Sys_config["db_database"] = "appleid_auto";

$Sys_config["apiurl"] = "http://auto.dbsteam.net"; // địa chỉ trang web, không cần dấu gạch chéo
$Sys_config["apikey"] = "dvsteam1122"; // Khóa API
$Sys_config["webdriver_url"] = "http://auto.dvsteam.net:4444"; // địa chỉ webdriver, cần có cổng
$Sys_config["enable_proxy_pool"] = false; // Có bật nhóm proxy hay không
$Sys_config["proxy_auto_disable"] = false; // Có tự động tắt proxy khi phụ trợ báo cáo rằng proxy không khả dụng
$Sys_config["task_headless"] = false; // Có cho phép tác vụ chạy ngầm hay không, nghĩa là không hiển thị cửa sổ trình duyệt
$Sys_config["proxy_list"] = ["http", "socks5", "http+url", "socks5+url"]; // danh sách các loại proxy

// Có bật Telegram Bot hay không. Nó được sử dụng để thông báo trạng thái mở khóa tài khoản. Để trống để tắt
$Sys_config["telegram_bot_token"] = "";
$Sys_config["telegram_bot_chatid"] = "";
