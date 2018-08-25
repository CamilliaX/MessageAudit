<?php
/*
**入口文件
**分发请求
**加载所有用的的类
*/
include 'app/sql.php';
include 'app/Controller.php';
include 'app/App.php';
//设置中国时区
date_default_timezone_set("PRC");
App::run();