<?php
    namespace Roddy\Arkesel\v1;
    use Roddy\Arkesel\v1\traits\SmsLogics;

    class Sms
    {
        use SmsLogics;

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
