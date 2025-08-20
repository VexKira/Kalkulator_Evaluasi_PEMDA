<!DOCTYPE html>
<html lang="en">
    <?php include "../head.php";?>

    <body>
        <?php include "../navbar.php";?>
        <div class="kalku">
            <div class="row">
            <h1 class="text-center my-2">KALKULATOR EVALUASI PEMDA</h1>
                <div class="coldata">
                    <h2 class="text-center">DATA</h2>
                    <form class="row" action="../backend/hitung.php" method="POST" id="formdata">
                        <div class="col-4">
                            <label>Pendapatan Asli Daerah</label>
                            <input class="form-control" placeholder="Rupiah" name="pad" >
                            <small class="text-danger d-none" id="error-pad">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Dana Alokasi Umum</label>
                            <input class="form-control" placeholder="Rupiah" name="dau" >
                            <small class="text-danger d-none" id="error-dau">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Dana Alokasi Khusus</label>
                            <input class="form-control" placeholder="Rupiah" name="dak" >
                            <small class="text-danger d-none" id="error-dak">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Dana Bagi Hasil</label>
                            <input class="form-control" placeholder="Rupiah" name="dbh" >
                            <small class="text-danger d-none" id="error-dbh">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Belanja Modal</label>
                            <input class="form-control" placeholder="Rupiah" name="modal" >
                            <small class="text-danger d-none" id="error-modal">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Belanja Pegawai</label>
                            <input class="form-control" placeholder="Rupiah" name="pegawai" >
                            <small class="text-danger d-none" id="error-pegawai">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Produk Domestik Regional Bruto</label>
                            <input class="form-control" placeholder="Rupiah/kapita" name="pdrb" >
                            <small class="text-danger d-none" id="error-pdrb">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Jumlah Penduduk</label>
                            <input class="form-control" placeholder="Jiwa" name="penduduk" >
                            <small class="text-danger d-none" id="error-penduduk">*Data masih kosong.</small>
                        </div>
                        <div class="col-4">
                            <label>Jumlah Aparatur Sipil Negara</label>
                            <input class="form-control" placeholder="Jiwa" name="asn" >
                            <small class="text-danger d-none" id="error-asn">*Data masih kosong.</small>
                        </div>
                        <div class="col">
                            <label>Pulau Jawa</label>
                            <input class="form-check-input" type="checkbox" name="jawa" value="1">
                        </div>
                        <div class="col">
                            <label>Provinsi</label>
                            <input class="form-check-input" type="checkbox" name="prov" value="1">
                        </div>
                        <div class="col">
                            <label>Kabupaten</label>
                            <input class="form-check-input" type="checkbox" name="kab" value="1">
                        </div>
                        <div class="col">
                            <label>Kota</label>
                            <input class="form-check-input" type="checkbox" name="kota" value="1">
                        </div>
                        
                        <div>
                            <button type="button" class="butn" onclick="resetForm()">Reset</button>
                            <button type="submit" class="butn">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="colhasil">
                    <h2 class="text-center">HASIL</h2>
                    <div class="col">
                        <h5>Kerugian Negara Dari Korupsi</h5>
                        <div class="row">
                            <div class="col-4">
                                <h6>Estimasi</h6>
                                <input class="fhasil" id="estKER" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Minimum</h6>
                                <input class="fhasil" id="minKER" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Maksimum</h6>
                                <input class="fhasil" id="maxKER" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h5>Temuan Badan Pemeriksa Keuangan Atas Korupsi</h5>
                        <div class="row">
                            <div class="col-4">
                                <h6>Estimasi</h6>
                                <input class="fhasil" id="estKOR" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Minimum</h6>
                                <input class="fhasil" id="minKOR" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Maksimum</h6>
                                <input class="fhasil" id="maxKOR" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h5>Indeks Pembangunan Manusia</h5>
                        <div class="row">
                            <div class="col-4">
                                <h6>Estimasi</h6>
                                <input class="fhasil" id="estIPM" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Minimum</h6>
                                <input class="fhasil" id="minIPM" disabled>
                            </div>
                            <div class="col-4">
                                <h6>Maksimum</h6>
                                <input class="fhasil" id="maxIPM" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row mx-auto">
                <button type="button" class="butn" onclick="location.href='riwayat.php'">Histori</button>
            </div>
        </div>
    </body>
</html>

<script>
    const inputs = document.querySelectorAll('input[name="pad"], input[name="dau"], input[name="dak"], input[name="dbh"], input[name="modal"], input[name="pegawai"], input[name="pdrb"], input[name="penduduk"], input[name="asn"]');
    inputs.forEach(input => {
        input.addEventListener('input', function(){
            let val = this.value.replace(/[^\d]/g, '');
            if(!isNaN(val)){
                this.value = new Intl.NumberFormat('id-ID').format(val);
            }
        });
    });

    function ribuan(value){
        return new Intl.NumberFormat('id-ID').format(value);
    }

    const cbProvinsi  = document.querySelector('input[name="prov"]');
    const cbKabupaten = document.querySelector('input[name="kab"]');
    const cbKota      = document.querySelector('input[name="kota"]');
    function cbFiltering(){
        cbProvinsi.disabled  = true;
        cbKabupaten.disabled = true;
        cbKota.disabled      = true;

        cbProvinsi.disabled  = false;
        cbKabupaten.disabled = false;
        cbKota.disabled      = false;

        const updatecb = () => {
            if (cbProvinsi.checked) {
                cbKabupaten.disabled = true;
                cbKabupaten.checked  = false;
                cbKota.disabled      = true;
                cbKota.checked       = false;
            } else if (cbKabupaten.checked) {
                cbProvinsi.disabled  = true;
                cbProvinsi.checked   = false;
                cbKota.disabled      = true;
                cbKota.checked       = false;
            } else if (cbKota.checked) {
                cbProvinsi.disabled  = true;
                cbProvinsi.checked   = false;
                cbKabupaten.disabled = true;
                cbKabupaten.checked  = false;
            } else {
                cbProvinsi.disabled  = false;
                cbKabupaten.disabled = false;
                cbKota.disabled      = false;
            }
        };
        cbProvinsi.addEventListener('change', updatecb);
        cbKabupaten.addEventListener('change', updatecb);
        cbKota.addEventListener('change', updatecb);
    }
    document.addEventListener('DOMContentLoaded', cbFiltering);

    function resetForm(){
        document.getElementById("formdata").reset();
        document.getElementById("estKER").value = "";
        document.getElementById("minKER").value = "";
        document.getElementById("maxKER").value = "";
        document.getElementById("estKOR").value = "";
        document.getElementById("minKOR").value = "";
        document.getElementById("maxKOR").value = "";
        document.getElementById("estIPM").value = "";
        document.getElementById("minIPM").value = "";
        document.getElementById("maxIPM").value = "";
        
        document.querySelectorAll('.text-danger').forEach(error => {
            error.classList.add('d-none');
        });

        cbProvinsi.checked  = false;
        cbKabupaten.checked = false;
        cbKota.checked      = false;
        
        cbProvinsi.disabled  = false;
        cbKabupaten.disabled = false;
        cbKota.disabled      = false;
    }

    document.querySelector('#formdata').addEventListener('submit', function(event){
        event.preventDefault();
        let isValid = true;
        const inputs = document.querySelectorAll('input[name="pad"], input[name="dau"], input[name="dak"], input[name="dbh"], input[name="modal"], input[name="pegawai"], input[name="pdrb"], input[name="penduduk"], input[name="asn"]');
        const formData = new FormData();

        inputs.forEach(input => {
            const errorElement = document.getElementById(`error-${input.name}`);
            const value = input.value.replace(/[^\d]/g, '');
            
            if (!value || parseInt(value) === 0) {
                isValid = false;
                errorElement.classList.remove('d-none');
            } else{
                errorElement.classList.add('d-none');
                formData.append(input.name, value);
            }
        });

        const checkboxes = ['jawa', 'prov', 'kab', 'kota'];
        checkboxes.forEach(name => {
            const checkbox = document.querySelector(`input[name="${name}"]`);
            formData.append(name, checkbox.checked ? '1' : '0');
        });

        if(isValid){
            fetch('../backend/hitung.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data){
                    document.querySelector('#estKER').value = ribuan(data.estKER);
                    document.querySelector('#minKER').value = ribuan(data.minKER);
                    document.querySelector('#maxKER').value = ribuan(data.maxKER);

                    document.querySelector('#estKOR').value = ribuan(data.estKOR);
                    document.querySelector('#minKOR').value = ribuan(data.minKOR);
                    document.querySelector('#maxKOR').value = ribuan(data.maxKOR);

                    document.querySelector('#estIPM').value = ribuan(data.estIPM);
                    document.querySelector('#minIPM').value = ribuan(data.minIPM);
                    document.querySelector('#maxIPM').value = ribuan(data.maxIPM);
                } else {
                    alert('Tidak ada data yang diterima dari server.');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat mengirim data ke server.');
            });
        }
    });
</script>