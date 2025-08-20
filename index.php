<!DOCTYPE html>
<html lang="en">
    <?php include "../head.php";?>
    <body>
        <div class="main">
            <h1 class="text-center py-2">SELAMAT DATANG DI KALKULATOR EVALUASI PEMDA</h1>
            <p class="intro">
                Kalkulator ini bertujuan untuk menghitung berapa besar tingkat kemungkinan korupsi di provinsi, kabupaten, dan kota terutama 
                di pulau Jawa.</br></br> 
                Kalkulator ini akan menghitung 9 elemen input yaitu pendapatan asli daerah, dana alokasi umum, dana alokasi khusus, dana bagi hasil, 
                belanja modal, belanja pegawai, produk domestik regional bruto, jumlah penduduk, dan jumlah aparatur sipil negara dengan pilihan 
                wilayahnya yang terdiri dari pulau jawa, provinsi, kabupaten, dan kota.</br></br>
                Hasil inputan akan dihitung dengan nilai parsial yang sudah diteliti, dan hasilnya akan menampilkan 3 komponen yaitu kerugian 
                negara dari korupsi, temuan badan pemeriksa keuangan atas korupsi, dan indeks pembangunan manusia yang komponen tersebut 
                masing-masing memiliki hasil estimasi, minimum dan maksimum.</br></br>
                <a href="#" data-bs-toggle="modal" data-bs-target="#contoh">Klik di sini untuk melihat bagaimana cara perhitungannya</a>
            </p>
            <div class="row mx-auto">
                <button type="button" class="butn" onclick="location.href='../frontend/kalkulator.php'">Mulai</button>
            </div>
        </div>

        <div class="modal fade" id="contoh" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="guideModalLabel">Panduan Perhitungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Cara untuk mengetahui jika suatu wilayah melakukan korupsi dengan kalkulator ini adalah sebagai berikut:</br>
                            Jika pada wilayah kabupaten mendapatkan kerugian negara dari korupsi dengan:</br>
                            Nilai estimasi = 2.462.741.236</br>
                            Nilai minimum  = 2.339.604.175</br>
                            Nilai maksimum = 2.585.878.298</br></br>
                            Untuk mengetahui bahwa wilayah kabupaten tersebut adalah dengan cara mencari nilai terdekat dengan nilai estimasi seperti:</br>
                            Nilai minimum  = 2.462.741.236 - 2.339.604.175 = 123.137.061</br>
                            Nilai maksimum = 2.585.878.298 - 2.462.741.236 = 123.137.062</br></br>
                            Dari hasil pengurangan nilai estimasi dengan nilai minimum dan maksimum di atas, dapat dilihat bahwa nilai minimum mendekati
                            nilai estimasi dan bisa disimpulkan bahwa wilayah kabupaten tersebut tidak pernah melakukan korupsi.</br>
                            Cara ini juga berlaku untuk temuan badan pemeriksa keuangan atas korupsi dan indeks pembangunan manusia.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="butn" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>