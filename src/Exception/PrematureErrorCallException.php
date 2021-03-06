<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 10/17/18
 * Time: 8:03 PM
 */

namespace GreenTea\Phypes\Exception;


use GreenTea\Phypes\Validator\Error;

class PrematureErrorCallException extends \Exception
{
    public function __construct()
    {
        // Do not allow error messages to be displayed before validating
        parent::__construct("Attempting to get error message before validation.",
            Error::PREMATURE_CALL_TO_METHOD);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}