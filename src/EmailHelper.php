<?php

namespace AndreasGlaser\Helpers;

use Traversable;

class EmailHelper
{
    /**
     * Cleans email address into a nice unique array.
     */
    public static function clean($emails, array $delimiters = [',', '|', ';']): array
    {
        $cleanedEmails = [];

        if (true === \is_array($emails) || $emails instanceof Traversable) {
            foreach ($emails as $email) {
                if (true === \is_array($email) || $email instanceof Traversable) {
                    $cleanedEmails = array_merge($cleanedEmails, self::clean($email, $delimiters));
                }
            }
        } else {
            $emails = [$emails];
        }

        foreach ($emails as $email) {
            if (!empty($delimiters)) {
                foreach ($delimiters as $separator) {
                    foreach (explode($separator, $email) as $emailSeparated) {
                        $emailSeparated = trim($emailSeparated);
                        if (self::isValid($emailSeparated)) {
                            $cleanedEmails[] = $emailSeparated;
                        }
                    }
                }
            } else {
                $email = trim($email);
                if (self::isValid($email)) {
                    $cleanedEmails[] = $email;
                }
            }
        }

        return array_unique($cleanedEmails);
    }

    /**
     * Validated email address.
     */
    public static function isValid(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
