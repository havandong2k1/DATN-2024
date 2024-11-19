<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'your-email@gmail.com';  // Your Gmail email address
    public string $fromName   = 'HaVanDong';        // Your name or your website name
    public string $SMTPHost   = 'smtp.gmail.com';
    public string $SMTPUser   = 'your-email@gmail.com';  // Your Gmail email address
    public string $SMTPPass   = 'your-app-password';     // App password (use environment variables for security)
    public int $SMTPPort      = 587;
    public string $SMTPCrypto = 'tls';
    public string $mailType   = 'html';
    public string $charset    = 'UTF-8';
    public bool $wordWrap     = true;
    public int $wrapChars     = 76;
    public bool $validate     = false;
    public int $priority      = 3;
    public string $CRLF       = "\r\n";
    public string $newline    = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize  = 200;
    public bool $DSN          = false;
}
