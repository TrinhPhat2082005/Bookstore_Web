<?php

class Security
{

    public static function generateCSRFToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token)
    {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    public static function csrfField()
    {
        $token = self::generateCSRFToken();
        echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public static function sanitizeHTML($html)
    {
        if (empty($html)) return '';

        $allowed_tags = '<p><a><b><i><u><strong><em><ul><li><ol><h1><h2><h3><h4><h5><h6><br><hr><img><blockquote><code><pre><table><thead><tbody><tr><th><td>';
        
        $sanitized = strip_tags($html, $allowed_tags);

        $sanitized = preg_replace('/on\w+="[^"]*"/i', '', $sanitized);
        $sanitized = preg_replace('/javascript:[^"]*/i', '', $sanitized);

        return $sanitized;
    }


    public static function xssClean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::xssClean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
}
