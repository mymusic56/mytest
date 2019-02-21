<?php
require 'Observable.php';
require 'Observer.php';
require 'observableImpl/Order.php';
require 'observerImpl/Email.php';
require 'observerImpl/Log.php';
require 'observerImpl/Message.php';

$email = new Email();
$log = new Log();
$message = new Message();

$order = new Order();
$order->attach($email);
$order->attach($log);
$order->attach($message);
$order->addOrder();