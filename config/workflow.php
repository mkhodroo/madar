<?php

return [
    'caseStartValue' => 1000,
    'patterns' => [
        'customer_workshop_or_ceo_name',
        'customer_city',
        'customer_mobile',
        'device_name',
        'creator_name',
        'part_name',
        'mapa_serial',
        'case_name',
    ],
    'inboxStatus' => [
        'new' => ['label' => 'new', 'color' => 'primary', 'type' => 'open'],
        'opened' => ['label' => 'opened', 'color' => 'secondary', 'type' => 'open'],
        'inProgress' => ['label' => 'inProgress', 'color' => 'warning', 'type' => 'open'],
        'draft' => ['label' => 'draft', 'color' => 'info', 'type' => 'open'],
        'canceled' => ['label' => 'canceled', 'color' => 'danger', 'type' => 'close'],
        'done' => ['label' => 'done', 'color' => 'success', 'type' => 'close'],
        'doneByOther' => ['label' => 'doneByOther', 'color' => 'success', 'type' => 'close']
    ],
    'caseStatus' => [
        'inProgress' => ['label' => 'inProgress', 'color' => 'primary', 'key' => 'inProgress'],
        'done' => ['label' => 'done', 'color' => 'warning', 'key' => 'done'],
        'canceled' => ['label' => 'canceled', 'color' => 'danger', 'key' => 'canceled'],
    ]
];
