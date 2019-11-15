<?php


namespace App\Service;


use Swift_Mailer;

class Notify
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $sendFrom;

    public function __construct(Swift_Mailer $mailer, string $sendFrom)
    {
        $this->mailer = $mailer;
        $this->sendFrom = $sendFrom;
    }

    public function notify(string $sendTo)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($this->sendFrom)
            ->setTo($sendTo)
            ->setBody(
                "<html><body>Hello</body></html>",
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}