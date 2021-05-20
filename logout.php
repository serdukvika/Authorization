<?php
include_once "action.php";
if (session_destroy()) {
    header("Location: $home");
}