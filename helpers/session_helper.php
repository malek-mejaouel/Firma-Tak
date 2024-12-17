<?php
class Flash {
    public static function set($key, $message, $class = 'info') {
        $_SESSION[$key] = ['message' => $message, 'class' => $class];
    }

    public static function display($key) {
        if (isset($_SESSION[$key])) {
            $flash = $_SESSION[$key];
            echo '<p class="' . $flash['class'] . '">' . $flash['message'] . '</p>';
            unset($_SESSION[$key]);
        }
    }
}
?>