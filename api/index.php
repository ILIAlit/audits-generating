<?php

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}
putenv('VIEW_COMPILED_PATH=/tmp/views');

require __DIR__.'/../public/index.php';
