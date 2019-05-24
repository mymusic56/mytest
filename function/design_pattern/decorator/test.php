<?php
require 'EmailBody.php';
require 'EmailBodyDecorator.php';
require 'impl/RaiseSalaryEmail.php';
require 'impl/NewYearEmail.php';
require 'impl/SpringFestivalEmail.php';

/*
 * 装饰器模式：
 *  1.在原来功能的基础上增加新的功能
 *  2.当不需要运行此功能的时候就直接去掉
 *  3.下面是以发送邮件举例
 * 其他应用场景： 现时活动规则计算
 */

/**
 * 【正常】发送邮件
 * 输出： 公司准备为您加薪50%。
 */
$emailRaiseSalary = new RaiseSalaryEmail();
$emailRaiseSalary->body();
var_dump('-------------------------------------------');

/**
 * 发送有【元旦】祝福的邮件
 * 输出： 元旦快乐！公司准备为您加薪50%。
 */
$emailNewYear = new NewYearEmail($emailRaiseSalary);
$emailNewYear->body();

var_dump('-------------------------------------------');
/**
 * 发送有【春节】祝福的邮件
 * 输出： 春节快乐！公司准备为您加薪50%。
 */
$emailSpring = new SpringFestivalEmail($emailRaiseSalary);
$emailSpring->body();
var_dump('-------------------------------------------');

/**
 * 发送同时有【元旦】和【春节】祝福的邮件
 * 输出： 春节快乐！元旦快乐！公司准备为您加薪50%。
 */
$emailTwo = new SpringFestivalEmail($emailNewYear);
$emailTwo->body();