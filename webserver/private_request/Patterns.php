<?php
    namespace private_request;

    class Patterns {
        const EMAIL = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
        const INT = "/^\d+$/";
        const USERNAME = "/^\w+$/";
    }
?>