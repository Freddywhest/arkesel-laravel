<?php
    namespace Roddy\Arkesel\v2\traits;

use Illuminate\Support\Facades\Http;

    trait SmsLogics
    {
        private string $API_END_POINT = "https://sms.arkesel.com/api/v2/sms/send";
        private string $API_END_POINT_WITH_TEMPLATE = "https://sms.arkesel.com/api/v2/sms/template/send";
        private string $API_END_POINT_BALANCE = "https://sms.arkesel.com/api/v2/clients/balance-details";
        private string $API_END_POINT_SMS_DETAILS = "https://sms.arkesel.com/api/v2/sms";
        private static $GUIDE_URL = "https://freddywhest.github.io/laravel-arskesel/";
        private static ?string $api_key = null;
        private static ?string $callbackUrl = null;
        private static ?string $sender = null;
        private static ?string $recipients = null;
        private static ?string $message = null;
        private static ?string $scheduled_date = null;
        private static ?string $smsId = null;
        private static ?bool $sandbox = null;

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

        final private static function callbackUrl(string $callbackUrl): self
        {
            self::$callbackUrl = $callbackUrl;
            return new self;
        }

        final private static function sender(string $sender): self
        {
            self::$sender = $sender;
            return new self;
        }

        final private static function recipients(array $recipients): self
        {
            self::$recipients = $recipients;
            return new self;
        }

        final private static function message(string $message): self
        {
            self::$message = $message;
            return new self;
        }

        final private static function date(string $date): self
        {
            self::$scheduled_date = $date;
            return new self;
        }

        final private static function sandbox(bool $sandbox): self
        {
            self::$sandbox = $sandbox;
            return new self;
        }

        final public static function id(string $smsId): self
        {
            self::$smsId = $smsId;
            return new self;
        }


        final private function validateDate($date, $format = 'd-m-Y h:m A'): bool
        {
            $d = \DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }

        final private function validateAndSendSms()
        {
            if(self::$sender === null || !isset(self::$sender) || empty(self::$sender)){
                return throw new \Exception("Sender cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients === null || !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            if(self::$callbackUrl !== null && isset(self::$callbackUrl) && !empty(self::$callbackUrl)){
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl,
                                        'sandbox' => true
                    ]);
                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl
                                    ]);
                }
            }else{
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'sandbox' => true
                    ]);
                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients
                                    ]);

                }
            }


            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndSendSmsWithTemplate()
        {
            if(self::$sender === null || !isset(self::$sender) || empty(self::$sender)){
                return throw new \Exception("Sender cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients === null || !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            if(self::$callbackUrl !== null && isset(self::$callbackUrl) && !empty(self::$callbackUrl)){
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT_WITH_TEMPLATE, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl,
                                        'sandbox' => true
                    ]);
                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT_WITH_TEMPLATE, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl
                                    ]);
                }
            }else{
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT_WITH_TEMPLATE, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'sandbox' => true
                    ]);
                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT_WITH_TEMPLATE, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients
                                    ]);

                }
            }


            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndScheduleSms()
        {
            if(self::$sender === null || !isset(self::$sender) || empty(self::$sender)){
                return throw new \Exception("Sender cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients === null || !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            if($this->validateDate(self::$scheduled_date) === false){
                return throw new \Exception("Set your schedule in the format 'yyyy-mm-dd hh:mm AM/PM' or 'Y-m-d H:i A' e.g. '2021-03-17 07:00 AM' as suggested by Arkesel docs [https://developers.arkesel.com/#tag/SMS-V2/operation/send_sms]", 1);
            }

            if(self::$callbackUrl !== null && isset(self::$callbackUrl) && !empty(self::$callbackUrl)){
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl,
                                        'scheduled_date' => self::$scheduled_date,
                                        'sandbox' => true
                                    ]);

                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'callback_url' => self::$callbackUrl,
                                        'scheduled_date' => self::$scheduled_date
                                    ]);
                }
            }else{
                if(self::$sandbox !==  null && self::$sandbox !== false && isset(self::$sandbox) && !empty(self::$sandbox)){
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients,
                                        'sandbox' => true
                                    ]);
                }else{
                    $requestData = Http::withHeader('api-key', self::$api_key)
                                    ->post($this->API_END_POINT, [
                                        'sender' => self::$sender,
                                        'message' => self::$message,
                                        'recipients' => self::$recipients
                                    ]);
                }
            }


            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndCheckBalance()
        {

            try {
                $requestData = Http::withHeader('api-key', self::$api_key)->get($this->API_END_POINT_BALANCE);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }

        final private function validateAndGetSmsDetails()
        {
            if(self::$smsId === null || !isset(self::$smsId) || empty(self::$smsId)){
                return throw new \Exception("id of sms cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            try {
                $requestData = Http::withHeader('api-key', self::$api_key)->get($this->API_END_POINT_SMS_DETAILS.'/'.self::$smsId);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }
    }
