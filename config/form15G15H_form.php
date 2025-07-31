<?php

return [
  [
    [
        'name' => 'member_id',
        'label' => 'Member',
        'type' => 'select',
         'id'=>'member',
        'required' => true,
        'dynamic' => true,
        'options_key' => 'member'
    ],
    [
        'name' => 'financial_year',
        'label' => 'Financial Year',
         'type' => 'select',
        'required' => true,
        'options' => [
       'FY 2025 - 2026' => 'FY 2025-2026',
        'FY 2024 - 2025' => 'FY 2024-2025',
        'FY 2023 - 2024' => 'FY 2023-2024',
        'FY 2022 - 2023' => 'FY 2022-2023',
        'FY 2021 - 2022' => 'FY 2021-2022',
    ],
    ],
    [
        'name' => 'form_15_upload',
        'label' => 'Upload Form 15G/15H',
        'type' => 'file',
        'id'=>'form_15_upload',
        'required' => true,
    ]
 ]
];
