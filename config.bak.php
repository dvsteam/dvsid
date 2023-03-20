<?php
$Sys_config["debug"] = true;
$Sys_config["enable_register"] = true;
$Sys_config["db_host"] = "localhost";
$Sys_config["db_user"] = "root";
$Sys_config["db_password"] = "123456";
$Sys_config["db_database"] = "appleid_auto";

$Sys_config["apiurl"] = "http://auto.dbsteam.net"; // 站点地址，无需斜杠结尾
$Sys_config["apikey"] = "dvsteam1122"; // API密钥
$Sys_config["webdriver_url"] = "http://auto.dvsteam.net:4444"; // webdriver地址，需要带端口
$Sys_config["enable_proxy_pool"] = false; // 是否启用代理池
$Sys_config["proxy_auto_disable"] = false; // 当后端报告代理不可用时，是否自动禁用该代理
$Sys_config["task_headless"] = false; // 是否启用任务后台运行，即不显示浏览器窗口
$Sys_config["proxy_list"] = ["http", "socks5", "http+url", "socks5+url"]; // 代理类型列表

// 是否启用Telegram Bot. 用于通知账号解锁情况. 留空则不启用
$Sys_config["telegram_bot_token"] = "";
$Sys_config["telegram_bot_chatid"] = "";
