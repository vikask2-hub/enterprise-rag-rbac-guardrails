<?php

return [
    'default_city' => 'mumbai',
    'default_category' => 'digital-marketing-agencies',
    'search_cache_minutes' => 360,
    'email_cache_days' => 7,
    'email_request_concurrency' => 5,

    'cities' => [
        'ahmedabad' => ['label' => 'Ahmedabad', 'areas' => ['Navrangpura', 'Prahlad Nagar', 'Satellite', 'SG Highway']],
        'bengaluru' => ['label' => 'Bengaluru', 'areas' => ['Indiranagar', 'Koramangala', 'Whitefield', 'HSR Layout']],
        'chennai' => ['label' => 'Chennai', 'areas' => ['T. Nagar', 'Anna Nagar', 'Adyar', 'Guindy']],
        'delhi' => ['label' => 'Delhi', 'areas' => ['Connaught Place', 'Saket', 'Nehru Place', 'Dwarka']],
        'hyderabad' => ['label' => 'Hyderabad', 'areas' => ['HITEC City', 'Banjara Hills', 'Gachibowli', 'Jubilee Hills']],
        'jaipur' => ['label' => 'Jaipur', 'areas' => ['C-Scheme', 'Malviya Nagar', 'Vaishali Nagar', 'Mansarovar']],
        'kolkata' => ['label' => 'Kolkata', 'areas' => ['Salt Lake', 'Park Street', 'New Town', 'Ballygunge']],
        'mumbai' => ['label' => 'Mumbai', 'areas' => ['Andheri East', 'Bandra West', 'Lower Parel', 'Powai']],
        'pune' => ['label' => 'Pune', 'areas' => ['Baner', 'Koregaon Park', 'Kharadi', 'Hinjawadi']],
        'surat' => ['label' => 'Surat', 'areas' => ['Vesu', 'Adajan', 'Ring Road', 'Piplod']],
    ],

    'categories' => [
        'cafes' => ['label' => 'Cafes', 'type' => 'cafe'],
        'dentists' => ['label' => 'Dentists', 'type' => 'dentist'],
        'digital-marketing-agencies' => ['label' => 'Digital Marketing Agencies', 'type' => 'marketing_agency'],
        'gyms' => ['label' => 'Gyms & Fitness Centres', 'type' => 'gym'],
        'hotels' => ['label' => 'Hotels', 'type' => 'hotel'],
        'interior-designers' => ['label' => 'Interior Designers', 'type' => 'interior_designer'],
        'logistics-companies' => ['label' => 'Logistics Companies', 'type' => 'transportation_service'],
        'manufacturers' => ['label' => 'Manufacturers', 'type' => 'manufacturer'],
        'real-estate-agencies' => ['label' => 'Real Estate Agencies', 'type' => 'real_estate_agency'],
        'restaurants' => ['label' => 'Restaurants', 'type' => 'restaurant'],
        'schools' => ['label' => 'Schools', 'type' => 'school'],
        'software-companies' => ['label' => 'Software Companies', 'type' => 'software_company'],
    ],
];
