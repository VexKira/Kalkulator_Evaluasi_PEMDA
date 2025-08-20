<?php
require_once('../dbcon.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Semua';
$query = "SELECT * FROM histori";
if($filter !== 'Semua'){
    if($filter == 'Pulau Jawa'){
        $query .= " WHERE pulau_jawa = 1 AND provinsi = 0 AND kabupaten = 0 AND kota = 0";
    } elseif($filter == 'Provinsi'){
        $query .= " WHERE provinsi = 1 AND pulau_jawa = 1";
    } elseif($filter == 'Kabupaten'){
        $query .= " WHERE kabupaten = 1 AND pulau_jawa = 1";
    } elseif($filter == 'Kota'){
        $query .= " WHERE kota = 1 AND pulau_jawa = 1";
    } elseif($filter == 'Luar Pulau Jawa'){
        $query .= " WHERE pulau_jawa = 0 AND provinsi = 0 AND kabupaten = 0 AND kota = 0";
    } elseif($filter == 'Provinsi Luar Pulau Jawa'){
        $query .= " WHERE provinsi = 1 AND pulau_jawa = 0";
    } elseif($filter == 'Kabupaten Luar Pulau Jawa'){
        $query .= " WHERE kabupaten = 1 AND pulau_jawa = 0";
    } elseif($filter == 'Kota Luar Pulau Jawa'){
        $query .= " WHERE kota = 1 AND pulau_jawa = 0";
    }
}
$result = $conn->query($query);
$data = [
    'kerugian' => ['minimal' => [], 'maksimal' => []],
    'bpk'      => ['minimal' => [], 'maksimal' => []],
    'ipm'      => ['minimal' => [], 'maksimal' => []],
    'averages' => [
        'kerugian' => ['minimal' => 0, 'maksimal' => 0],
        'bpk'      => ['minimal' => 0, 'maksimal' => 0],
        'ipm'      => ['minimal' => 0, 'maksimal' => 0]
    ]
];

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $data['kerugian']['minimal'][]  = $row['minimal_kerugian_negara'];
        $data['kerugian']['maksimal'][] = $row['maksimal_kerugian_negara'];
        $data['bpk']['minimal'][]       = $row['minimal_temuan_bpk'];
        $data['bpk']['maksimal'][]      = $row['maksimal_temuan_bpk'];
        $data['ipm']['minimal'][]       = $row['minimal_ipm'];
        $data['ipm']['maksimal'][]      = $row['maksimal_ipm'];
    }
    foreach(['kerugian', 'bpk', 'ipm'] as $key){
        $data['averages'][$key]['minimal'] = count($data[$key]['minimal']) > 0 
            ? array_sum($data[$key]['minimal']) / count($data[$key]['minimal']) 
            : 0;
        $data['averages'][$key]['maksimal'] = count($data[$key]['maksimal']) > 0 
            ? array_sum($data[$key]['maksimal']) / count($data[$key]['maksimal']) 
            : 0;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>