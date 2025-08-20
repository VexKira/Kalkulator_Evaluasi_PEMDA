<?php
require_once('../dbcon.php');

function reorderNo($conn) {
    $query = "SET @row_number = 0; 
              UPDATE histori 
              SET no = (@row_number := @row_number + 1) 
              ORDER BY no ASC;";
    $conn->multi_query($query);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['delrow']) && $_POST['delrow'] == 1){
        $no = $_POST['id'];
        $query = "DELETE FROM histori WHERE no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $no);
        $stmt->execute();
        reorderNo($conn);
        header('Location: riwayat.php');
    } elseif(isset($_POST['hapus']) && $_POST['hapus'] == 2){
        $conn->query("DELETE FROM histori");
        reorderNo($conn);
    } elseif(isset($_POST['donlod']) && $_POST['donlod'] == 3){
        include '../backend/excel.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "../head.php";?>

    <body>
        <?php include "../navbar.php";?>
        <div class="laporan">
            <div class="row mt-2 mb-4 px-3">
                <h1 class="text-center">RIWAYAT KALKULATOR EVALUASI PEMDA</h1>
                <div class="coltable">
                    <div class="histori">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Pendapatan Asli Daerah</th>
                                    <th scope="col">Dana Alokasi Umum</th>
                                    <th scope="col">Dana Alokasi Khusus</th>
                                    <th scope="col">Dana Bagi Hasil</th>
                                    <th scope="col">Belanja Modal</th>
                                    <th scope="col">Belanja Pegawai</th>
                                    <th scope="col">Produk Domestik Regional Bruto</th>
                                    <th scope="col">Penduduk</th>
                                    <th scope="col">Aparatur Sipil Negara</th>
                                    <th scope="col">Pulau Jawa</th>
                                    <th scope="col">Provinsi</th>
                                    <th scope="col">Kabupaten</th>
                                    <th scope="col">Kota</th>
                                    <th scope="col">Estimasi Kerugian Negara</th>
                                    <th scope="col">Minimal Kerugian Negara</th>
                                    <th scope="col">Maksimal Kerugian Negara</th>
                                    <th scope="col">Estimasi Temuan BPK</th>
                                    <th scope="col">Minimal Temuan BPK</th>
                                    <th scope="col">Maksimal Temuan BPK</th>
                                    <th scope="col">Estimasi IPM</th>
                                    <th scope="col">Minimal IPM</th>
                                    <th scope="col">Maksimal IPM</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
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
                                $query .= " ORDER BY no ASC";
                                
                                $result = $conn->query($query);
                                if ($result->num_rows > 0){
                                    $no = 1;
                                    while($row = $result->fetch_assoc()){
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>" . number_format($row['pendapatan_asli_daerah'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['dana_alokasi_umum'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['dana_alokasi_khusus'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['dana_bagi_hasil'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['belanja_modal'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['belanja_pegawai'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['produk_domestik_regional_bruto'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['penduduk'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['aparatur_sipil_negera'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['pulau_jawa'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['provinsi'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['kabupaten'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['kota'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['estimasi_kerugian_negara'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['minimal_kerugian_negara'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['maksimal_kerugian_negara'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['estimasi_temuan_bpk'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['minimal_temuan_bpk'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['maksimal_temuan_bpk'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['estimasi_ipm'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['minimal_ipm'], 0, ',', '.') . "</td>
                                                <td>" . number_format($row['maksimal_ipm'], 0, ',', '.') . "</td>
                                                <td>
                                                    <form method='post'>
                                                        <input type='hidden' name='id' value='{$row['no']}'>
                                                        <button type='submit' name='delrow' value='1' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">x</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        $no++;
                                    }
                                } else{
                                    echo "<tr><td colspan='23'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="coltabton">
                    <form method="POST">
                        <button type="submit" class="butn" name="hapus" value="2">Clear</button>
                        <button type="submit" class="butn" name="donlod" value="3">Download</button>
                    </form>
                    <div class="dropdown">
                        <button class="butn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Search
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Semua')">Semua</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Pulau_Jawa')">Pulau Jawa</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Provinsi')">Provinsi</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Kabupaten')">Kabupaten</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Kota')">Kota</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Luar Pulau Jawa')">Luar Pulau Jawa</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Provinsi Luar Pulau Jawa')">Provinsi (Luar Pulau Jawa)</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Kabupaten Luar Pulau Jawa')">Kabupaten (Luar Pulau Jawa)</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortFilter('Kota Luar Pulau Jawa')">Kota (Luar Pulau Jawa)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row mx-auto">
                <h1 class="text-center">Evaluasi Filter Data <?php echo htmlspecialchars($filter);?></h1>
                <div class="chart-container">
                    <canvas id="kerugianChart" class="chartStyle"></canvas>
                    <canvas id="bpkChart" class="chartStyle"></canvas>
                    <canvas id="ipmChart" class="chartStyle"></canvas>
                </div>
            </div>
            
            <div class="row mx-auto">
                <button type="button" class="butn" onclick="location.href='kalkulator.php'">Kalkulator</button>
            </div>
        </div>
    </body>
</html>

<script>
function sortFilter(filter){
    const url = new URL(window.location.href);
    url.searchParams.set('filter', filter);
    window.location.href = url.toString();
}

async function fetchData(filter){
    const response = await fetch(`../backend/dataChart.php?filter=${filter}`);
    return await response.json();
}

let kerugianChart = null;
let bpkChart = null;
let ipmChart = null;
function createChart(ctx, labels, averages, title){
    if(ctx.chart){
        ctx.chart.destroy();
    }

    ctx.chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Minimal',
                    data: [averages.minimal],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                },
                {
                    label: 'Maksimal',
                    data: [averages.maksimal],
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: title,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
    return ctx.chart;
}

async function initCharts(filter = 'Semua'){
    const data = await fetchData(filter);
    const labels = ['Data Rata-Rata'];

    console.log(`Averages ${filter}:`, data.averages);
    if(kerugianChart) kerugianChart.destroy();
    if(bpkChart) bpkChart.destroy();
    if(ipmChart) ipmChart.destroy();

    const kerugianCtx = document.getElementById('kerugianChart').getContext('2d');
    kerugianChart = createChart(kerugianCtx, labels, data.averages.kerugian, 'Kerugian Negara Dari Korupsi');

    const bpkCtx = document.getElementById('bpkChart').getContext('2d');
    bpkChart = createChart(bpkCtx, labels, data.averages.bpk, 'Temuan BPK Atas Korupsi');

    const ipmCtx = document.getElementById('ipmChart').getContext('2d');
    ipmChart = createChart(ipmCtx, labels, data.averages.ipm, 'Indeks Pembangunan Manusia');
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const filter = urlParams.get('filter') || 'Semua';
    initCharts(filter);
});
</script>