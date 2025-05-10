<?php

namespace AndreasGlaser\Helpers;

use Traversable;

/**
 * EmailHelper provides utility methods for working with email addresses.
 * 
 * This class contains methods for validating and cleaning email addresses,
 * with support for handling multiple email addresses in various formats
 * and delimiters.
 */
class EmailHelper
{
    /**
     * Cleans and normalizes email addresses from various input formats.
     *
     * This method can handle:
     * - Single email addresses
     * - Arrays of email addresses
     * - Strings containing multiple email addresses separated by delimiters
     * - Nested arrays or traversable objects containing email addresses
     *
     * @param mixed $emails The email addresses to clean
     * @param array $delimiters Array of delimiters to split multiple emails (default: [',', '|', ';'])
     *
     * @return array Array of unique, valid email addresses
     */
    public static function clean($emails, array $delimiters = [',', '|', ';'])
    {
        $cleanedEmails = [];

        if (\is_array($emails) || $emails instanceof Traversable) {
            foreach ($emails as $email) {
                if (\is_array($email) || $email instanceof Traversable) {
                    $cleanedEmails = \array_merge($cleanedEmails, self::clean($email, $delimiters));
                }
            }
        } else {
            $emails = [$emails];
        }

        foreach ($emails as $email) {
            if (!empty($delimiters)) {
                foreach ($delimiters as $separator) {
                    foreach (\explode($separator, $email) as $emailSeparated) {
                        $emailSeparated = \trim($emailSeparated);
                        if (self::isValid($emailSeparated)) {
                            $cleanedEmails[] = $emailSeparated;
                        }
                    }
                }
            } else {
                $email = \trim($email);
                if (self::isValid($email)) {
                    $cleanedEmails[] = $email;
                }
            }
        }

        return \array_unique($cleanedEmails);
    }

    /**
     * Validates an email address format.
     *
     * @param string $email The email address to validate
     *
     * @return bool True if the email address is valid
     */
    public static function isValid($email)
    {
        return (bool)\filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
