<?php
    namespace Roddy\Arkesel\v1;

    use Illuminate\Support\Facades\Http;
    use Roddy\Arkesel\traits\SmsLogics;

    class Sms
    {
        use SmsLogics;

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

        public function send()
        {
            return $this->validateAndSendSms();
        }

        public function schedule()
        {
            return $this->validateAndScheduleSms();
        }

        public function balance()
        {
            return $this->validateAndCheckBalance();
        }

    }
