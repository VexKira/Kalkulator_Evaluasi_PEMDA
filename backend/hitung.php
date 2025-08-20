<?php
require_once('../dbcon.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    function clean($input){
        return preg_replace('/[^0-9]/', '', $input);
    }
    $inPAD      = clean($_POST['pad']);
    $inDAU      = clean($_POST['dau']);
    $inDAK      = clean($_POST['dak']);
    $inDBH      = clean($_POST['dbh']);
    $inMODAL    = clean($_POST['modal']);
    $inPEGAWAI  = clean($_POST['pegawai']);
    $inPDRB     = clean($_POST['pdrb']);
    $inPENDUDUK = clean($_POST['penduduk']);
    $inASN      = clean($_POST['asn']);
    $opJAWA     = isset($_POST['jawa']) ? clean($_POST['jawa']) : 0;
    $opPROV     = isset($_POST['prov']) ? clean($_POST['prov']) : 0;
    $opKAB      = isset($_POST['kab']) ? clean($_POST['kab']) : 0;
    $opKOTA     = isset($_POST['kota']) ? clean($_POST['kota']) : 0;

    $hasil = estimasi($inPAD, $inDAU, $inDAK, $inDBH, $inMODAL, $inPEGAWAI, $inPDRB, $inPENDUDUK, $inASN, $opJAWA, $opKAB, $opKOTA);
    header('Content-Type: application/json');
    echo json_encode($hasil, JSON_PRETTY_PRINT);

    $result = $conn->query("SELECT MAX(no) AS max_no FROM histori");
    $row = $result->fetch_assoc();
    $currentNo = $row['max_no'] ?? 0;
    $newNo = $currentNo + 1;
    $sql = "INSERT INTO histori(
        no, pendapatan_asli_daerah, dana_alokasi_umum, dana_alokasi_khusus, dana_bagi_hasil, 
        belanja_modal, belanja_pegawai, produk_domestik_regional_bruto, penduduk, 
        aparatur_sipil_negera, pulau_jawa, provinsi, kabupaten, kota, 
        estimasi_kerugian_negara, minimal_kerugian_negara, maksimal_kerugian_negara, 
        estimasi_temuan_bpk, minimal_temuan_bpk, maksimal_temuan_bpk, 
        estimasi_ipm, minimal_ipm, maksimal_ipm
    ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiiiiiiiiiiiiiiiii", 
        $newNo, $inPAD, $inDAU, $inDAK, $inDBH, 
        $inMODAL, $inPEGAWAI, $inPDRB, $inPENDUDUK, 
        $inASN, $opJAWA, $opPROV, $opKAB, $opKOTA, 
        $hasil['estKER'], $hasil['minKER'], $hasil['maxKER'], 
        $hasil['estKOR'], $hasil['minKOR'], $hasil['maxKOR'], 
        $hasil['estIPM'], $hasil['minIPM'], $hasil['maxIPM']
    );
    $stmt->execute();
    $stmt->close();
}

function estimasi($inPAD, $inDAU, $inDAK, $inDBH, $inMODAL, $inPEGAWAI, $inPDRB, $inPENDUDUK, $inASN, $opJAWA, $opKAB, $opKOTA){
    $inputs = [
        'PAD' => log($inPAD), 'DAU' => log($inDAU), 'DAK' => log($inDAK), 'DBH' => log($inDBH),
        'MODAL' => log($inMODAL), 'PEGAWAI' => log($inPEGAWAI), 'PDRB' => log($inPDRB), 'PENDUDUK' => log($inPENDUDUK),
        'ASN' => log($inASN), 'JAWA' => $opJAWA, 'KAB' => $opKAB, 'KOTA' => $opKOTA
    ];

    $koef = [
        'KER' => [
            'PAD' => 0.0355958, 'DAU' => -0.0020861, 'DAK' => -0.1876274, 'DBH' => 0.1950145,
            'MODAL' => -0.0758774, 'PEGAWAI' => -0.0552821, 'PDRB' => -0.011822, 'PENDUDUK' => 0.0291157,
            'ASN' => 0.0759321, 'JAWA' => -0.4262658, 'KAB' => -1.283362, 'KOTA' => -1.359692, 'KONS' => 24.42374
        ],
        'KOR' => [
            'PAD' => -0.3866108, 'DAU' => -0.0860471, 'DAK' => 1.766138, 'DBH' => -1.896064,
            'MODAL' => -0.6347315, 'PEGAWAI' => 0.9717361, 'PDRB' => 0.1455349, 'PENDUDUK' => -0.4403874,
            'ASN' => -0.3209535, 'JAWA' => 1.511002, 'KAB' => 21.24179, 'KOTA' => 19.33672, 'KONS' => -31.24917
        ],
        'IPM' => [
            'PAD' => 0.1732848, 'DAU' => 0.1720868, 'DAK' => 1.378899, 'DBH' => -1.256966,
            'MODAL' => -0.0443016, 'PEGAWAI' => 0.6418655, 'PDRB' => 0.2238759, 'PENDUDUK' => 0.2386605,
            'ASN' => 1.195269, 'JAWA' => -0.3470954, 'KAB' => 0.4314786, 'KOTA' => 9.997813, 'KONS' => 24.66283
        ]
    ];

    $hasil = [];
    foreach (['KER', 'KOR', 'IPM'] as $out){
        $sum = $koef[$out]['KONS'];
        foreach ($inputs as $key => $value) {
            $sum += $value * $koef[$out][$key];
        }

        if($out === 'KER'){
            $hasil["est$out"] = round(exp($sum));
            $hasil["min$out"] = round(exp($sum) * 0.95);
            $hasil["max$out"] = round(exp($sum) * 1.05);
        } elseif($out === 'KOR'){
            $hasil["est$out"] = round(-1 * $sum);
            $hasil["min$out"] = round(-1 * ($sum) * 0.95);
            $hasil["max$out"] = round(-1 * ($sum) * 1.05);
        } elseif($out === 'IPM'){
            $hasil["est$out"] = round($sum);
            $hasil["min$out"] = round($sum * 0.95);
            $hasil["max$out"] = round($sum * 1.05);
        }
    }
    return $hasil;
}
?>