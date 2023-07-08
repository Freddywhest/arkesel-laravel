<?php
    namespace Roddy\Arkesel\v2;

    use Roddy\Arkesel\v2\traits\ContactLogics;

    class Contact
    {
        use ContactLogics;

        public function create()
        {
            return $this->validateAndCreate();
        }

        public function add()
        {
            return $this->validateAndAdd();
        }

        public function sendMessage()
        {
            return $this->validateAndSendMesage();
        }
    }
