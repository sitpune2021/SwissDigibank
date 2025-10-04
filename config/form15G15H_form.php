<?php

return [
  [

    [
      'name' => 'financial_year',
      'label' => 'FINANCIAL YEAR',
      'type' => 'select',
      'required' => true,
      'dynamic' => true, // ← Tells Blade to use dynamicOptions
      'options_key' => 'financial_year', // ← Must match the key sent from controller
    ],


    [
      'name' => 'form_15_upload',
      'label' => 'UPLOAD FORM 15G/15H',
      'type' => 'file',
      'id' => 'form_15_upload',
      'required' => true,
    ]
  ]
];
