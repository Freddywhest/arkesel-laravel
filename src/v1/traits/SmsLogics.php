<?php
    namespace Roddy\Arkesel\v1\traits;
    use Illuminate\Support\Facades\Http;
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

        final private function validateAndSendSms()
        {
            if((self::$recipient === null && self::$recipient === null) || (!isset(self::$recipient) && !isset(self::$recipients))){
                return throw new \Exception("Recipient or recipients not set or it is null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipient !== null && empty(self::$recipient)){
                return throw new \Exception("Recipient cannot be empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients !== null && !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$from === null || !isset(self::$from) || empty(self::$from)){
                return throw new \Exception("From cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            try {
                $requestData = Http::get($this->API_END_POINT, [
                    "action" => "send-sms",
                    "api_key" => self::$api_key,
                    "to" => self::$recipients !== null ? implode(",", self::$recipients) : self::$recipient,
                    "from" => self::$from,
                    "sms" => self::$message
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndScheduleSms()
        {
            if((self::$recipient === null && self::$recipient === null) || (!isset(self::$recipient) && !isset(self::$recipients))){
                return throw new \Exception("Recipient or recipients not set or it is null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipient !== null && empty(self::$recipient)){
                return throw new \Exception("Recipient cannot be empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients !== null && !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$from === null || !isset(self::$from) || empty(self::$from)){
                return throw new \Exception("From cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            if($this->validateDate(self::$date) === false){
                return throw new \Exception("Set your schedule in the format dd-mm-yyyy hh:mm AM/PM as suggested by Arkesel docs [https://developers.arkesel.com/#tag/SMS-V1/operation/send_schedule_sms_v1]", 1);
            }

            try {
                $requestData = Http::get($this->API_END_POINT, [
                    "action" => "send-sms",
                    "api_key" => self::$api_key,
                    "to" => self::$recipients !== null ? implode(",", self::$recipients) : self::$recipient,
                    "from" => self::$from,
                    "sms" => self::$message,
                    "schedule" => self::$date
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndCheckBalance()
        {

            try {
                $requestData = Http::get($this->API_END_POINT, [
                    "action" => "check-balance",
                    "api_key" => self::$api_key,
                    "response" => "json",
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }
    }
