<?php

namespace ZfMetal\Security;

return array_merge_recursive(
    include 'router.config.php',
    include 'options.config.php',
    include 'controller.config.php',
    include 'services.config.php'

);