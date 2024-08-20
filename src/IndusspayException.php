<?php

namespace Primeinduss\Common;

use Exception;

class IndusspayException extends Exception {
    public function __construct($messageOrCause = null) {
        if (is_string($messageOrCause)) {
            parent::__construct($messageOrCause);
        } elseif ($messageOrCause instanceof Exception) {
            parent::__construct($messageOrCause->getMessage());
            $this->file = $messageOrCause->getFile();
            $this->line = $messageOrCause->getLine();
            $this->trace = $messageOrCause->getTrace();
        } else {
            parent::__construct();
        }

        $this->name = "IndusspayException";
    }
}
