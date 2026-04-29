<?php

function escape($data) {
    if (is_array($data)) {
        return array_map('escape', $data);
    }
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}