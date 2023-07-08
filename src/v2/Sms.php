<?php
    namespace Roddy\Arkesel\v2;

use Roddy\Arkesel\v2\traits\SmsLogics;

    class Sms
    {
        use SmsLogics;

        public function send()
        {
            return $this->validateAndSendSms();
        }

        public function sendWithTemplate()
        {
            return $this->validateAndSendSmsWithTemplate();
        }

        public function schedule()
        {
            return $this->validateAndScheduleSms();
        }

        public function balance()
        {
            return $this->validateAndCheckBalance();
        }

        public function get()
        {
            return $this->validateAndGetSmsDetails();
        }
    }
