<?php

return [

    // Member Address
    'CUSTOMER_CORRESPONDENCE_ADDRESS' => [
        [
            'label' => 'ADDRESS LINE 1',
            'name' => 'member_address_line_1',
            'id' => 'address_line_1',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'ADDRESS LINE 2',
            'name' => 'member_address_line_2',
            'id' => 'address_line_2',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'PARA',
            'name' => 'member_address_para',
            'id' => 'para',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'WARD',
            'name' => 'member_address_ward',
            'id' => 'ward',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'PANCHAYAT',
            'name' => 'member_address_panchayat',
            'id' => 'panchayat',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'AREA',
            'name' => 'member_address_area',
            'id' => 'area',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'LANDMARK',
            'name' => 'member_address_landmark',
            'id' => 'landmark',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'CITY/DISTRICT',
            'name' => 'member_address_city_district',
            'id' => 'city_district',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'STATE',
            'name' => 'member_address_state',
            'id' => 'stateDropdown',
            'type' => 'select',
            'required' => true,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'PINCODE',
            'name' => 'member_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => true,
        ],
        [
            'label' => 'COUNTRY',
            'name' => 'member_address_country',
            'id' => 'country',
            'type' => 'text',
            'required' => true,
        ],

    ],

    // Permanent Address
    'CUSTOMER_PERMANENT_ADDRESS' => [
        [
            'label' => 'ADDRESS',
            'name' => 'member_address_address',
            'id' => 'address',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'CITY',
            'name' => 'member_perm_address_city',
            'id' => 'city',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'STATE',
            'name' => 'member_perm_address_state',
            'id' => 'state',
            'type' => 'select',
            'required' => false,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'PINCODE',
            'name' => 'member_perm_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => false,
        ],
    ],

    // GPS Location
    'CUSTOMER_ADDRESS_GPS_LOCATION' => [
        [
            'label' => 'LOCATION LATITUDE',
            'name' => 'member_gps_location_latitude',
            'id' => 'location_latitude',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'LOCATION LONGITUDE',
            'name' => 'member_gps_location_longitude',
            'id' => 'location_longitude',
            'type' => 'number',
            'required' => false,
        ],
    ],
];
