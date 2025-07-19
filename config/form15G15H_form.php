<?php

return [
 $formFields = [
    [
        'name' => 'member',
        'label' => 'Member',
        'type' => 'select',
        'required' => true,
        'dynamic' => true,
        'options_key' => 'members'
    ],
    [
        'name' => 'financial_year',
        'label' => 'Financial Year',
        'type' => 'date',
        'required' => true,
    ],
    [
        'name' => 'form_15_upload',
        'label' => 'Upload Form 15G/15H',
        'type' => 'file',
        'required' => true,
    ]
 ]
];
