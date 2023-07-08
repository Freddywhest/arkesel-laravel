<?php
    namespace Roddy\Arkesel\traits;
    trait SmsLogics
    {
        private static ?string $api_key = null;
        private static ?string $recipient = null;
        private static ?array $recipients = null;
        private static ?string $from = null;
        private static ?\DateTime $date = null;
        private static ?string $message = null;
        private $API_END_POINT = "https://sms.arkesel.com/sms/api";
        private static $GUIDE_URL = "https://sms.arkesel.com/sms/api";
        public function __construct()
        {
            if(!env("ARKESEL_API_KEY") || env("ARKESEL_API_KEY") === null){
                throw new \Exception("ARKESEL_API_KEY not found in .env file", 1);
                return;
            }else if(empty(env("ARKESEL_API_KEY"))){
                throw new \Exception("ARKESEL_API_KEY does not exist .env file or it is empty/null", 1);
                return;
            }

           self::$api_key = env("ARKESEL_API_KEY");
        }

        final private function validateDate($date, $format = 'd-m-Y h:m A'): bool
        {
            $d = \DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }

        final public static function recipient(string $recipient): self
        {
            self::$recipient = $recipient;
            return new self;
        }

        final public static function recipients(array $recipients): self
        {
            self::$recipients = $recipients;
            return new self;
        }

        final public static function from($from): self
        {
            self::$from = $from;
            return new self;
        }

        final public static function message($message): self
        {
            self::$message = $message;
            return new self;
        }

        final public static function date(\DateTime $date): self
        {
            self::$date = $date;
            return new self;
        }
    }
