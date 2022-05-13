<?php

trait ObserverTrait {
    protected array $observers = [];

    public function addObserver(Users $observer)
    {
        if(!in_array($observer, $this->observers)) {
            $this->observers[] = $observer;
        }
    }

    public function removeObserver(Users $observer)
    {
        foreach ($this->observers as $k=>$oneObserver) {
            if( $observer === $oneObserver) {
                unset($this->observers[$k]);
                break;
            }
        }
    }

    public function notify($vacancy)
    {
        foreach ($this->observers as $oneObserver) {
            $oneObserver->getNotifyMethod()->handle($vacancy);
        }
    }
}

interface ObserverInterface {
    public function handle(string $vacancy);
}

class NotifyEmail implements ObserverInterface {

    public function handle(string $vacancy)
    {
        echo "MailTo: Новая вакансия - " . $vacancy . PHP_EOL;
    }
}

class NotifySMS implements ObserverInterface {

    public function handle(string $vacancy)
    {
        echo "SMSTo: Новая вакансия - " . $vacancy . PHP_EOL;
    }
}

class Vacancies
{
    use ObserverTrait;

    private array $vacancies = [];

    public function addVacancy(string $vacancyTitle){
        $this->vacancies[] = $vacancyTitle;
        $this->notify($vacancyTitle);
    }

}

class Users {

    private string $username;
    private ObserverInterface $notifyMethod;

    public function __construct(string $username, ObserverInterface $notifyMethod)
    {
        $this->username = $username;
        $this->notifyMethod = $notifyMethod;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getNotifyMethod(): ObserverInterface
    {
        return $this->notifyMethod;
    }

    public function subscribe(Vacancies $vacanciesObj)
    {
        $vacanciesObj->addObserver($this);
    }

    public function unsubscribe(Vacancies $vacanciesObj)
    {
        $vacanciesObj->removeObserver($this);
    }
}

$vacancies = new Vacancies();
$vasiliy = new Users("Василий", new NotifyEmail());
$vasiliy->subscribe($vacancies);
$ivan = new Users("Иван", new NotifySMS());
$ivan->subscribe($vacancies);

$vacancies->addVacancy("Google");

$vasiliy->unsubscribe($vacancies);
$vacancies->addVacancy("Yandex");