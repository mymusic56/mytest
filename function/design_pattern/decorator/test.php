<?php
//require 'EmailBody.php';

/**
 * 【正常】发送邮件
 * 输出： 公司准备为您加薪50%。
 */
$email = new MainEmail();
$email->body();

/**
 * 发送有【元旦】祝福的邮件
 * 输出： 元旦快乐！公司准备为您加薪50%。
 */
$emailNewYear = new NewYearEmail($email);
$emailNewYear->body();

/**
 * 发送有【春节】祝福的邮件
 * 输出： 春节快乐！公司准备为您加薪50%。
 */
$emailSpring = new SpringFestivalEmail($email);
$emailSpring->body();

/**
 * 发送同时有【元旦】和【春节】祝福的邮件
 * 输出： 春节快乐！元旦快乐！公司准备为您加薪50%。
 */
$emailTwo = new SpringFestivalEmail($emailNewYear);
$emailTwo->body();