<?php

namespace App\Services;

use App\Messages\MessageInterface;
use PHPMailer\PHPMailer\PHPMailer;

class EMailService
{
    private static ?EMailService $instance = null;

    private PHPMailer $mailer;

    private ?string $senderName = null;

    private function __construct()
    {
        $this->mailer = new PHPMailer(true);
        //$this->mailer->SMTPDebug = $config['debug'] ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['username'];
        $this->mailer->Password = $_ENV['password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = (int)$_ENV['port'];
        $this->senderName = $_ENV['sender'];
    }

    public function sendMail(MessageInterface $message): bool
    {
        try {
            $data = $message->getData();
            $this->mailer->setFrom($data['from'], $this->senderName);
            $to = $data['to'];

            if (is_array($to)) {
                foreach ($to as $email) {
                    $this->mailer->addAddress($email);
                }
            } else {
                $this->mailer->addAddress($to);
            }

            if (isset($data['cc'])) {
                $cc = $data['cc'];
                if ($cc) {
                    $this->mailer->addCC($cc);
                }
            }

            if (isset($data['bcc'])) {
                $bcc = $data['bcc'];
                if ($bcc) {
                    $this->mailer->addBCC($bcc);
                }
            }

            if (isset($data['replyTo'])) {
                $replyTo = $data['replyTo'];
                if ($replyTo) {
                    $this->mailer->addReplyTo($replyTo);
                }
            }

            $this->mailer->Subject = $data['subject'];
            $this->mailer->Body = $data['body'];
            $this->mailer->ContentType = 'text/html; charset=UTF-8';

            $this->mailer->send();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __wakeup()
    {
    }

    public function __clone()
    {
    }
}