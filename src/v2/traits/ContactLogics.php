<?php
    namespace Roddy\Arkesel\v2\traits;

use Illuminate\Support\Facades\Http;

    trait ContactLogics
    {
        private string $API_END_POINT_GROUPS = "https://sms.arkesel.com/api/v2/contacts/groups";
        private string $API_END_POINT_CONTACTS = "https://sms.arkesel.com/api/v2/contacts";
        private string $API_END_POINT_CONTACT_GROUP = "https://sms.arkesel.com/api/v2/sms/send/contact-group";
        private static $GUIDE_URL = "https://sms.arkesel.com/sms/api";
        private static ?string $group_name = null;
        private static ?array $contacts = null;
        private static ?string $sender = null;
        private static ?string $message = null;
        private static ?string $api_key = null;

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

        final private static function groupName(string $groupName): self
        {
            self::$group_name = $groupName;
            return new self;
        }

        final private static function contacts(array $contacts): self
        {
            self::$contacts = $contacts;
            return new self;
        }

        final private static function sender(string $sender): self
        {
            self::$sender = $sender;
            return new self;
        }

        final private static function message(string $message): self
        {
            self::$message = $message;
            return new self;
        }

        public function validateAndCreate()
        {
            if(self::$group_name === null || !isset(self::$group_name) || empty(self::$group_name)){
                return throw new \Exception("Group name [groupName] cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            $requestData = Http::withHeaders([
                'Accept' => 'application/json',
                'api-key' => self::$api_key
                ])->post($this->API_END_POINT_GROUPS, [
                        'group_name' => self::$group_name
                ]);

            $response = json_decode($requestData);
            return (object) $response;
        }

        public function validateAndAdd()
        {
            if(self::$group_name === null || !isset(self::$group_name) || empty(self::$group_name)){
                return throw new \Exception("Group name [groupName] cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$contacts === null || !isset(self::$contacts) || empty(self::$contacts)){
                return throw new \Exception("contacts cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            $requestData = Http::withHeader('api-key', self::$api_key)
                            ->post($this->API_END_POINT_CONTACTS, [
                                'group_name' => self::$group_name,
                                'contacts' => self::$contacts
                            ]);

            $response = json_decode($requestData);
            return (object) $response;
        }

        public function validateAndSendMesage()
        {
            if(self::$sender === null || !isset(self::$sender) || empty(self::$sender)){
                return throw new \Exception("Sender cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$group_name === null || !isset(self::$group_name) || empty(self::$group_name)){
                return throw new \Exception("Group name [groupName] cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$message === null){
                return throw new \Exception("Message is not set. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            $requestData = Http::withHeader('api-key', self::$api_key)
                            ->post($this->API_END_POINT_CONTACT_GROUP, [
                                'sender' => self::$sender,
                                'message' => self::$message,
                                'group_name' => self::$group_name
                            ]);

            $response = json_decode($requestData);
            return (object) $response;
        }
    }
