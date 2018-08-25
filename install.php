<?php
  $db_user='root';
  $db_pwd='toor';
  $table='test1';
  $re=mysqli_connect('localhost',$db_user,$db_pwd,$table);
  if(!$re)die('连接失败');
  mysqli_query($re,"set character set 'UTF-8'");
  //mysqli_query($re,"CREATE DATABASE `blog`");
  $all_table=array();
  $all_table[]="CREATE TABLE `$table`.`message` ( 
               `id` INT(16) NOT NULL AUTO_INCREMENT ,
               `user_name` VARCHAR(25) NOT NULL ,
               `date` VARCHAR(12) NOT NULL ,
               `view` INT(11) DEFAULT '0',
               `content` TEXT NOT NULL ,
               PRIMARY KEY (`id`) ,
               INDEX(`id`)) ;";
  $all_table[]="CREATE TABLE `$table`.`user` ( 
               `id` INT(16) NOT NULL AUTO_INCREMENT ,
               `name` VARCHAR(25) NOT NULL ,
               `pwd` VARCHAR(12) NOT NULL ,
               PRIMARY KEY (`id`) ,
               INDEX(`id`)) ;";
//遍历数组
  foreach ($all_table as $key => $value) {
    mysqli_query($re,$value);
  }
  if(mysqli_query($re,"INSERT INTO `user` (`id`, `name`, `pwd`) VALUES ('1', 'admin', '123456')")){
    echo '安装成功';
  }else{
    echo '失败';
  }
