<?php

namespace WPBook\Includes;

class Activator {
    public static function activate() {
        flush_rewrite_rules();
    }
}
