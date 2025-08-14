<?php

return [
  [
    // [
    //   'name' => 'member_id',
    //   'label' => 'Member',
    //   'type' => 'select',
    //   'id' => 'member',
    //   'required' => true,
    //   'dynamic' => true,
    //   'options_key' => 'member'
    // ],
    // [
    //   'name' => 'promoter_id',
    //   'label' => 'promoter',
    //   'type' => 'select',
    //   'id' => 'promoter',
    //   'required' => true,
    //   'dynamic' => true,
    //   'options_key' => 'promoter'
    // ],
    [
      'name' => 'financial_year',
      'label' => 'Financial Year',
      'type' => 'select',
      'required' => true,
      'dynamic' => true, // ← Tells Blade to use dynamicOptions
      'options_key' => 'financial_year', // ← Must match the key sent from controller
    ],


    [
      'name' => 'form_15_upload',
      'label' => 'Upload Form 15G/15H',
      'type' => 'file',
      'id' => 'form_15_upload',
      'required' => true,
    ]
  ]
];
