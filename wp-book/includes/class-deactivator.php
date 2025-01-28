<?php

namespace WPBook\Includes;

class Deactivator {
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
