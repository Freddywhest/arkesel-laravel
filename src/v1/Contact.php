<?php
    namespace Roddy\Arkesel\v1;

    use Illuminate\Support\Facades\Http;
    use Roddy\Arkesel\v1\traits\ContactLogics;

    class Contact
    {
        use ContactLogics;

        public function save()
        {
            if(self::$phone_book === null || !isset(self::$phone_book) || empty(self::$phone_book)){
                return throw new \Exception("phoneBook should not be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$phone_number === null || !isset(self::$phone_number) || empty(self::$phone_number)){
                return throw new \Exception("phoneNumber should not be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }

            try {
                $requestData = Http::get($this->API_END_POINT, [
                    "action" => "subscribe-us",
                    "api_key" => self::$api_key,
                    "phone_book" => self::$phone_book,
                    "phone_number" => self::$phone_number,
                    "first_name" => self::$first_name,
                    "last_name" => self::$last_name,
                    "email" => self::$email,
                    "company" => self::$company
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

            $response = json_decode($requestData);
            return (object) $response;
        }

    }
