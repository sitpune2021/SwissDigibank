<?php

return [

    // Member Address
    'Member_Correspondence_Address' => [
        [
            'label' => 'Address Line 1',
            'name' => 'member_address_line_1',
            'id' => 'address_line_1',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Address Line 2',
            'name' => 'member_address_line_2',
            'id' => 'address_line_2',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Para',
            'name' => 'member_address_para',
            'id' => 'para',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Ward',
            'name' => 'member_address_ward',
            'id' => 'ward',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Panchayat',
            'name' => 'member_address_panchayat',
            'id' => 'panchayat',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Area',
            'name' => 'member_address_area',
            'id' => 'area',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Landmark',
            'name' => 'member_address_landmark',
            'id' => 'landmark',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'City/ District',
            'name' => 'member_address_city_district',
            'id' => 'city_district',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'State',
            'name' => 'member_address_state',
            'id' => 'stateDropdown',
            'type' => 'select',
            'required' => true,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'Pincode',
            'name' => 'member_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => true,
        ],
        [
            'label' => 'Country',
            'name' => 'member_address_country',
            'id' => 'country',
            'type' => 'text',
            'required' => true,
        ],

    ],

    // Permanent Address
    'member_permanent_address' => [
        [
            'label' => 'Address',
            'name' => 'member_address_address',
            'id' => 'address',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'City',
            'name' => 'member_perm_address_city',
            'id' => 'city',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'State',
            'name' => 'member_perm_address_state',
            'id' => 'state',
            'type' => 'select',
            'required' => false,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'Pincode',
            'name' => 'member_perm_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => false,
        ],
    ],

    // GPS Location
    'member_address_gps_location' => [
        [
            'label' => 'Location Latitude',
            'name' => 'member_gps_location_latitude',
            'id' => 'location_latitude',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Location Longitude',
            'name' => 'member_gps_location_longitude',
            'id' => 'location_longitude',
            'type' => 'number',
            'required' => false,
        ],
    ],
];
