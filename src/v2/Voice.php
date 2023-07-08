<?php
    namespace Roddy\Arkesel\v2;

use Roddy\Arkesel\v2\traits\VoiceLogics;

    class Voice
    {
        use VoiceLogics;
        public function send()
        {
            return $this->validateAndSendVoice();
        }
    }
