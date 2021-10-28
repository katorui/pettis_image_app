<?php

function xss($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
