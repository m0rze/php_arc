<?php

interface NotifyInterface
{
    public function send();
}

class Notify implements NotifyInterface
{

    protected $notifier;

    public function __construct(NotifyInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function send()
    {
        $this->notifier->send();
    }
}

class SMSNotify implements NotifyInterface
{

    public function send()
    {
        return "Sended by SMS";
    }
}

class EmailNotify extends Notify
{
    public function send()
    {
        return $this->notifier->send() . PHP_EOL . "Sended by Email";
    }
}

class ChromeNotify extends Notify
{
    public function send()
    {
        echo $this->notifier->send() . PHP_EOL . "Sended by Chrome";
    }
}

$sms = new SMSNotify();
$notify = new ChromeNotify(new EmailNotify(new SMSNotify()));
$notify->send();