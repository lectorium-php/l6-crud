<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class Notifier
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(\Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function notify(string $sendTo, string $body = "<html><body>Hello</body></html>") {
        sleep(1);

        $this->logger->info("Notification", ['email' => $sendTo, 'body' => $body]);
//        $message = (new \Swift_Message('Hello Email'))
//            ->setFrom('send@example.com')
//            ->setTo($sendTo)
//            ->setBody(
//                "<html><body>Hello</body></html>",
//                'text/html'
//            )
//        ;
//
//        $this->mailer->send($message);
    }
}