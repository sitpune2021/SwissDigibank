<?php

return [
  [
    "label"=> "DESIGNATION",
    "name"=> "designation",
    "id"=> "designation",
    "type"=> "text",
    "required"=> false
  ],
  [
    "label"=> "CUSTOMER",
    "name"=> "member_id",
    "id"=> "member",
    "type"=> "select",
    "required"=> false,
    'dynamic' => true,
    'options_key' => 'member', // 👈 used to match controller data
  ],
  [
    "label"=> "DIRECTOR NAME",
    "name"=> "director_name",
    "id"=> "director_name",
    "type"=> "text",
    "required"=> true
  ],
  [
    "label"=> "DIN NO.",
    "name"=> "din_no",
    "id"=> "din_no",
    "type"=> "text",
    "required"=> true
  ],
  [
    "label"=> "APPOINTMENT DATE",
    "name"=> "appointment_date",
    "id"=> "date",
    "type"=> "text",
    "required"=> true
  ],
  [
    "label" => "RESIGNATION DATE",
    "name" => "resignation_date",
    "id" => "datem",
    "type" => "text",
    "required" => false
  ],  
  [
    "label"=> "SIGNATURE",
    "name"=> "signature",
    "id"=> "signature",
    "type"=> "file",
    "required"=> false,
    "accept"=> "image/*"
  ],
  [
    "label"=> "AUTHORIZED SIGNATORY",
    "name"=> "authorized_signatory",
    "id"=> "authorized_signatory",
    "type"=> "radio",
    "required"=> true,
    "default"=> "No",
    "options"=> [
      "Yes"=> "Yes",
      "No"=> "No"
    ]
  ]
];
