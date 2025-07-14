<?php



return [

  [

    "label"=> "Designation",

    "name"=> "designation",

    "id"=> "designation",

    "type"=> "text",

    "required"=> true

  ],

  [

    "label"=> "Member",

    "name"=> "member_id",

    "id"=> "member",

    "type"=> "select",

    "required"=> true,

    'dynamic' => true,

    'options_key' => 'member', // 👈 used to match controller data

  ],

  [

    "label"=> "Director Name",

    "name"=> "director_name",

    "id"=> "director_name",

    "type"=> "text",

    "required"=> true

  ],

  [

    "label"=> "DIN No",

    "name"=> "din_no",

    "id"=> "din_no",

    "type"=> "text",

    "required"=> true

  ],

  [

    "label"=> "Appointment Date",

    "name"=> "appointment_date",

    "id"=> "date",

    "type"=> "text",

    "required"=> true

  ],

  [

    "label"=> "Resignation Date",

    "name"=> "resignation_date",

    "id"=> "date2",

    "type"=> "text",

    "required"=> true

  ],

  [

    "label"=> "Signature",

    "name"=> "signature",

    "id"=> "signature",

    "type"=> "file",

    "required"=> true,

    "accept"=> "image/*"

  ],

  [

    "label"=> "Authorized Signatory",

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

