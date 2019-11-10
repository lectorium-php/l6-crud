<?php


namespace App\Service;


class Notifier
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify($sendTo) {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($sendTo)
            ->setBody(
                "<html><body>Hello</body></html>",
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}