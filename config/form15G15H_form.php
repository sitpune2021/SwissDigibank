<?php

return [
    [
        'label' => 'Member',
        'name' => 'member',
        'id' => 'member',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Financial Year',
        'name' => 'financial_year',
        'id' => 'date',
        'type' => 'text', // or 'select' if it's a dropdown
        'required' => true,
    ],
    [
        'label' => 'Upload Form 15G/15H',
        'name' => 'form_15g_15h',
        'id' => 'form_15g_15h',
        'type' => 'file',
        'required' => true,
    ],
];
