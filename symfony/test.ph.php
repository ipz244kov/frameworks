<?php
$ch = curl_init('http://127.0.0.1:8001/api/subjects');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'name' => 'Компонентне програмування',
    'description' => 'Вивчення Symfony та Laravel фреймворків',
    'credits' => 5
]));

echo curl_exec($ch);
curl_close($ch);
