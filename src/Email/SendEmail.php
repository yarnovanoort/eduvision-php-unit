<?php
namespace Phpunittest\Email;

/**
 * Class SendEmail
 * @package Phpunittest\Email
 */
class SendEmail {

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param string $from
     */
    public static function sendEmail($to, $subject, $message, $from = "")
    {
        if (strlen($from) == 0)
            $from = getenv('SMTP_FROM');

        $transport = \Swift_SmtpTransport::newInstance(getenv('SMTP_HOST'), getenv('SMTP_PORT'))
            ->setUsername(getenv('SMTP_USER'))
            ->setPassword(getenv('SMTP_PASS'));

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($message, 'text/html');

        $mailer->send($message);
    }
}
