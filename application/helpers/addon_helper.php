<?php 

if (!function_exists("create_response")) {
  function create_response() {
    $response = new stdClass();
    $response->success = FALSE;
    $response->message = "Unknown failure!";
    $response->data = [];
    $response->found = FALSE;

    return $response;
  }
}