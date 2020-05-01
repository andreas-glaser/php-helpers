<?php

namespace AndreasGlaser\Helpers;

use Traversable;

/**
 * Class EmailHelper.
 */
class EmailHelper
{
    /**
     * Cleans email address into a nice unique array.
     *
     * @param $emails
     *
     * @return array
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
     * Validated email address.
     *
     * @param $email
     *
     * @return bool
     */
    public static function isValid($email)
    {
        return (bool)\filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
