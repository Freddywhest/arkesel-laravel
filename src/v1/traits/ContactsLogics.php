<?php
    namespace Roddy\Arkesel\v1\traits;
    trait ContactLogics
    {
        private static ?string $api_key = null;
        private static ?string $phone_book = null;
        private static ?string $phone_number = null;
        private static ?string $first_name = null;
        private static ?string $last_name = null;
        private static ?string $email = null;
        private static ?string $company = null;
        private $API_END_POINT = "https://sms.arkesel.com/contacts/api";
        private static $GUIDE_URL = "https://sms.arkesel.com/contacts/api";
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

        final public static function phoneBook(string $phoneBook): self
        {
            self::$phone_book = $phoneBook;
            return new self;
        }

        final public static function phoneNumber(string $phoneNumber): self
        {
            self::$phone_number = $phoneNumber;
            return new self;
        }

        final public static function firstName(?string $firstName): self
        {
            self::$first_name = $firstName;
            return new self;
        }

        final public static function lastName(?string $lastName): self
        {
            self::$last_name = $lastName;
            return new self;
        }

        final public static function email(?string $email): self
        {
            self::$email = $email;
            return new self;
        }

        final public static function company(?string $company): self
        {
            self::$company = $company;
            return new self;
        }
    }
