<?php
    namespace Roddy\Arkesel\v2\traits;
    use Illuminate\Support\Facades\Http;

    trait VoiceLogics
    {
        private string $API_END_POINT_VOICE = "https://sms.arkesel.com/api/v2/sms/voice/send";
        private static $GUIDE_URL = "https://freddywhest.github.io/laravel-arskesel/";
        private static ?array $recipients = null;
        private static ?string $voice_file = null;
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

        final private static function recipients(array $recipients): self
        {
            self::$recipients = $recipients;
            return new self;
        }

        final private static function file(string $file): self
        {
            self::$voice_file = $file;
            return new self;
        }

        public function validateAndSendVoice()
        {
            if(self::$voice_file === null || !isset(self::$voice_file) || empty(self::$voice_file)){
                return throw new \Exception("file cannot be null or empty. Visit ".self::$GUIDE_URL." for guide.", 1);
            }else if(self::$recipients === null || !isset(self::$recipients)){
                return throw new \Exception("Recipients cannot be empty or null. Visit ".self::$GUIDE_URL." for guide.", 1);
            }
            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $this->API_END_POINT_VOICE,
                    CURLOPT_HTTPHEADER => ['api-key: '.self::$api_key],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query([
                        'recipients' => self::$recipients,
                        'voice_file' => new \CURLFILE(self::$voice_file),
                    ]),
                ]);

                $response = curl_exec($curl);

                curl_close($curl);

            } catch (\Throwable $th) {
                throw $th;
            }

            return (object) $response;

        }
    }
