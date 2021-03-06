<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

class PasswordValidator extends AbstractValidator
{
    /**
     * Check if the password has a diverse character type set for a strong-enough password
     * Uppercase, lowercase combo etc.
     * @param string $password
     * @return bool
     */
    private function hasMultiCharTypes(string $password): bool
    {
        $differentCharacterTypes = 0;
        // Lowercase
        if (preg_match('/[a-z]/', $password)) {
            $differentCharacterTypes++;
        }

        // Upper case
        if (preg_match('/[A-Z]/', $password)) {
            $differentCharacterTypes++;
        }

        //Check for numbers
        if (preg_match('/[\d]/', $password)) {
            $differentCharacterTypes++;
        }

        //Check for anything that's not a word aka special characters
        if (preg_match('/[\W]/', $password)) {
            $differentCharacterTypes++;
        }
        return $differentCharacterTypes > 2;
    }

    /**
     * Standard password length check
     * @param string $password
     * @param int $minSize
     * @return bool
     */
    private function isLongEnough(string $password, int $minSize) : bool
    {
        return strlen($password) >= $minSize ;
    }

    /**
     * Validate the password based on different imposing conditions
     * Implement your own password validator if you want a more custom set of rules
     * This set of rules should work for a lot of general use cases
     * @param $password
     * @param array $options
     * @return bool
     */
    public function isValid($password, $options = []): bool
    {
        $this->validated = true;

        if (!$this->isLongEnough($password, 8)) {
            $this->errorCode = Error::PASSWORD_TOO_SMALL;
            $this->error = 'The password is not at least 8 characters long';
            return false;
        }

        if (!$this->hasMultiCharTypes($password)) {
            $this->errorCode = Error::PASSWORD_NOT_MULTI_CHARACTER;
            $this->error = 'The password does not contain at least 3 of these character types:' .
                ' lower case, upper case, numeric and special characters';
            return false;
        }

        $this->error = $this->errorCode = null;
        return true;
    }
}