<?php
// Konfigurasi MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan encoding UTF-8
$conn->set_charset("utf8");

// Proses Update Pilihan
if (isset($_POST['action']) && $_POST['action'] === 'update_option') {
    $nama_pasar = $conn->real_escape_string($_POST['nama_pasar']);
    $pilihan = $conn->real_escape_string($_POST['pilihan']);
    $update_sql = "UPDATE pasar SET pilihan = '$pilihan' WHERE nama_pasar = '$nama_pasar'";

    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Memperbarui Pilihan</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f0f2f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                overflow: hidden;
            }
            .loading-container {
                text-align: center;
                background-color: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                max-width: 400px;
                width: 100%;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 5px solid #3498db;
                border-top: 5px solid #2ecc71;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }
            .message {
                color: #2c3e50;
                font-size: 18px;
                margin-bottom: 20px;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class='loading-container'>
            <div class='spinner'></div>
            <div class='message'>Memperbarui Pilihan Pasar...</div>
        </div>
        <script>
            setTimeout(function() {
    ";
    if ($conn->query($update_sql) === TRUE) {
        echo "
                window.location.href = 'index.php?status=success&message=Pilihan+berhasil+diperbarui';
            }, 1500);
        </script>
    </body>
    </html>
        ";
    } else {
        echo "
                window.location.href = 'index.php?status=error&message=" . urlencode($conn->error) . "';
            }, 1500);
        </script>
    </body>
    </html>
        ";
    }
    exit();
}

// Proses Tambah Pasar Baru
if (isset($_POST['action']) && $_POST['action'] === 'add_pasar') {
    $nama_pasar = $conn->real_escape_string($_POST['nama_pasar']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);

    if (!empty($nama_pasar) && !empty($latitude) && !empty($longitude)) {
        $add_sql = "INSERT INTO pasar (nama_pasar, latitude, longitude) VALUES ('$nama_pasar', '$latitude', '$longitude')";
        
        // Tampilkan halaman loading
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Menambahkan Pasar Baru</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f0f2f5;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    overflow: hidden;
                }
                .loading-container {
                    text-align: center;
                    background-color: white;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                    max-width: 400px;
                    width: 100%;
                }
                .spinner {
                    width: 50px;
                    height: 50px;
                    border: 5px solid #3498db;
                    border-top: 5px solid #2ecc71;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 20px;
                }
                .message {
                    color: #2c3e50;
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        </head>
        <body>
            <div class='loading-container'>
                <div class='spinner'></div>
                <div class='message'>Menambahkan Pasar Baru...</div>
            </div>
            <script>
                setTimeout(function() {
        ";
        
        // Eksekusi query
        if ($conn->query($add_sql) === TRUE) {
            echo "
                    window.location.href = 'index.php?status=success&message=Pasar+berhasil+ditambahkan';
                }, 1500);
            </script>
        </body>
        </html>
            ";
        } else {
            echo "
                    window.location.href = 'index.php?status=error&message=" . urlencode($conn->error) . "';
                }, 1500);
            </script>
        </body>
        </html>
            ";
        }
        exit();
    } else {
        // Jika data tidak lengkap
        echo "<script>
            alert('Semua field harus diisi');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}

// Proses Hapus Pasar
if (isset($_POST['action']) && $_POST['action'] === 'delete_pasar') {
    $stmt = $conn->prepare("DELETE FROM pasar WHERE nama_pasar = ?");
    $nama_pasar = $conn->real_escape_string($_POST['nama_pasar']);
    $stmt->bind_param("s", $nama_pasar);

    // Tampilkan halaman loading
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Menghapus Pasar</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f0f2f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                overflow: hidden;
            }
            .loading-container {
                text-align: center;
                background-color: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                max-width: 400px;
                width: 100%;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 5px solid #e74c3c;
                border-top: 5px solid #c0392b;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }
            .message {
                color: #2c3e50;
                font-size: 18px;
                margin-bottom: 20px;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class='loading-container'>
            <div class='spinner'></div>
            <div class='message'>Menghapus Pasar...</div>
        </div>
        <script>
            setTimeout(function() {
    ";

    try {
        if ($stmt->execute()) {
            echo "
                window.location.href = 'index.php?status=success&message=Pasar+berhasil+dihapus';
                }, 1500);
            </script>
        </body>
        </html>
            ";
        } else {
            echo "
                window.location.href = 'index.php?status=error&message=" . urlencode($stmt->error) . "';
                }, 1500);
            </script>
        </body>
        </html>
            ";
        }
        $stmt->close();
    } catch (Exception $e) {
        echo "
            window.location.href = 'index.php?status=error&message=" . urlencode($e->getMessage()) . "';
            }, 1500);
        </script>
        </body>
        </html>
        ";
    }
    exit();
}

// Mengambil data dari tabel 'pasar'
$sql = "SELECT * FROM pasar";
$result = $conn->query($sql);
$locations = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    $result->data_seek(0);
}

// Statistik opsi pasar
$statistik_sql = "SELECT pilihan, GROUP_CONCAT(nama_pasar SEPARATOR ', ') AS pasar_list, COUNT(*) as jumlah FROM pasar WHERE pilihan IS NOT NULL GROUP BY pilihan";
$statistik_result = $conn->query($statistik_sql);
$statistik = array();

if ($statistik_result) {
    while ($row = $statistik_result->fetch_assoc()) {
        $statistik[] = $row;
    }
}
$total_pilihan = array_sum(array_column($statistik, 'jumlah'));
?>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta
        var map = L.map('map').setView([-7.7565, 110.2783], 12);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Data Lokasi Pasar
        var locations = <?= json_encode($locations) ?>;

        // Tambahkan marker untuk setiap pasar
        locations.forEach(function(pasar) {
            L.marker([pasar.latitude, pasar.longitude])
                .addTo(map)
                .bindPopup('<b>' + pasar.nama_pasar + '</b><br>Lat: ' + pasar.latitude + '<br>Long: ' + pasar.longitude + '<br>Pilihan: ' + (pasar.pilihan || '-'));
        });

        // Setelah menambahkan marker
        function addNewMarkerToMap(nama_pasar, latitude, longitude) {
            var newMarker = L.marker([latitude, longitude])
            .addTo(map)
            .bindPopup('<b>' + nama_pasar + '</b><br>Lat: ' + latitude + '<br>Long: ' + longitude);
            
            // Tambahkan ke array locations
            locations.push({
                nama_pasar: nama_pasar,
                latitude: latitude,
                longitude: longitude
            });
        }
        
        // Tambahkan di dalam <script>
        var addPasarMap;
        var addPasarMarker;
        function openAddPasarModal() {
            document.getElementById('addPasarModal').style.display = 'block';
            
            // Inisialisasi peta untuk memilih lokasi
            if (!addPasarMap) {
                addPasarMap = L.map('addPasarMapPicker').setView([-7.7565, 110.2783], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(addPasarMap);
                
                // Tambahkan event listener untuk klik peta
                addPasarMap.on('click', function(e) {
                    
                    // Hapus marker sebelumnya jika ada
                    if (addPasarMarker) {
                        addPasarMap.removeLayer(addPasarMarker);
                    }
                    
                    // Tambahkan marker baru
                    addPasarMarker = L.marker(e.latlng).addTo(addPasarMap);
                    
                    // Isi form koordinat
                    document.getElementById('add_latitude').value = e.latlng.lat.toFixed(6);
                    document.getElementById('add_longitude').value = e.latlng.lng.toFixed(6);
                });
            }
        }
        
        // Fungsi untuk membuka modal hapus pasar
        function openDeletePasarModal() {
            // Tampilkan modal
            document.getElementById('deletePasarModal').style.display = 'block';
            
            // Inisialisasi peta preview
            if (!deletePasarMap) {
                deletePasarMap = L.map('deletePasarMapPreview').setView([-7.7565, 110.2783], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(deletePasarMap);
                
                // Tambahkan marker untuk setiap pasar
                <?php
                // Reset pointer result
                $result = $conn->query("SELECT nama_pasar, latitude, longitude FROM pasar");
                while ($row = $result->fetch_assoc()) {
                    $nama_pasar = htmlspecialchars($row['nama_pasar']);
                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                    echo "
                    L.marker([$latitude, $longitude])
                    .addTo(deletePasarMap)
                    .bindPopup('$nama_pasar')
                    .openPopup();
                    ";
                }
                ?>
                }
                // Event listener untuk preview lokasi saat pilihan berubah
                document.getElementById('delete_nama_pasar').addEventListener('change', function() {
                    
                    // Ambil koordinat pasar yang dipilih
                    <?php
                    $result = $conn->query("SELECT nama_pasar, latitude, longitude FROM pasar");
                    echo "var pasarData = {";
                    while ($row = $result->fetch_assoc()) {
                        $nama_pasar = htmlspecialchars($row['nama_pasar']);
                        $latitude = $row['latitude'];
                        $longitude = $row['longitude'];
                        echo "'$nama_pasar': {lat: $latitude, lng: $longitude},";
                    }
                    echo "};";
                    ?>
                    
                    var selectedPasar = this.value;
                    var koordinat = pasarData[selectedPasar];
                    
                    // Hapus marker sebelumnya jika ada
                    if (deletePasarMarker) {
                        deletePasarMap.removeLayer(deletePasarMarker);
                    }
                    
                    // Tambahkan marker baru dan fokuskan peta
                    deletePasarMarker = L.marker([koordinat.lat, koordinat.lng])
                    .addTo(deletePasarMap)
                    .bindPopup(selectedPasar)
                    .openPopup();
                    deletePasarMap.setView([koordinat.lat, koordinat.lng], 15);
                });
            }
            
            // Variabel global untuk peta
            var deletePasarMap = null;
            var deletePasarMarker = null;
            
            // Fungsi untuk menutup modal
            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
            
            function generatePasarOptions() {
                // Generate opsi pasar dari data yang ada
                return locations.map(pasar => 
                `<option value="${pasar.nama_pasar}">${pasar.nama_pasar}</option>`
                ).join('');
            }
            
            // Modifikasi fungsi closeModal untuk menambahkan reset peta
            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
                
                // Reset peta tambah pasar
                if (modalId === 'addPasarModal' && addPasarMap && addPasarMarker) {
                    addPasarMap.removeLayer(addPasarMarker);
                    document.getElementById('add_nama_pasar').value = '';
                    document.getElementById('add_latitude').value = '';
                    document.getElementById('add_longitude').value = '';
                }
            }
            // Fungsi untuk membuka modal edit
            function openEditModal(data) {
                var row = JSON.parse(data);
                document.getElementById('edit_nama_pasar').value = row.nama_pasar;
                document.getElementById('pilihan').value = row.pilihan || '';
                document.getElementById('editModal').style.display = 'block';
            }
            
            // Menutup modal
            document.querySelectorAll('.close').forEach(function(closeBtn) {
                closeBtn.onclick = function() {
                    closeModal(closeBtn.closest('.modal').id);
                }
            });
            
            // Menutup modal jika klik di luar modal
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.style.display = 'none';
                }
            }
            
            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
            
            // Menampilkan statistik
            function showStatistics() {
                var statistik = <?= json_encode($statistik) ?>;
                var total = statistik.reduce((sum, entry) => sum + entry.jumlah, 0);
                var labels = statistik.map(function(entry) { 
                    var percentage = ((entry.jumlah / total) * 100).toFixed(2);
                    return `${entry.pilihan} (${percentage}%) - ${entry.pasar_list}`;
                });
                var data = statistik.map(function(entry) { return entry.jumlah; });
                document.getElementById('statModal').style.display = 'block';
                new Chart(document.getElementById('statChart'), {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.label || '';
                                        var value = context.parsed || 0;
                                        var percentage = ((value / total) * 100).toFixed(2);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Menampilkan rekomendasi
            function showRecommendations() {
                var statistik = <?= json_encode($statistik) ?>;
                var total = statistik.reduce((sum, entry) => sum + entry.jumlah, 0);
                var sorted = statistik.sort((a, b) => b.jumlah - a.jumlah);

                var rankingList = document.getElementById('rankingList');
                rankingList.innerHTML = '';

                sorted.forEach(function(entry, index) {
                    var percentage = ((entry.jumlah / total) * 100).toFixed(2);
                    var listItem = document.createElement('li');
        
                    listItem.innerHTML = `
                    <div class="ranking-item-left">
                    <span class="ranking-badge">${index + 1}</span>
                    <span class="ranking-category">${entry.pilihan} : </span>
                    <span class="ranking-pasar">${entry.pasar_list}</span>
                    </div>
                    <div class="ranking-item-right">
                    ${percentage}%
                    </div>
                    `;
                    rankingList.appendChild(listItem);
                });
                
                document.getElementById('recommendModal').style.display = 'block';
            }
            // Pastikan fungsi ini berada di dalam <script> yang sama
            function goToPasar(element) {
                // Ambil latitude dan longitude dari atribut data
                var latitude = parseFloat(element.getAttribute('data-lat'));
                var longitude = parseFloat(element.getAttribute('data-lng'));
                
                // Gunakan metode flyTo untuk animasi perpindahan peta
                map.flyTo([latitude, longitude], 14, {
                    animate: true,
                    duration: 1.5  // durasi animasi 1.5 detik
                });
                
                // Buka popup marker untuk pasar yang dipilih
                locations.forEach(function(pasar) {
                    if (pasar.latitude == latitude && pasar.longitude == longitude) {
                        // Cari marker yang sesuai
                        map.eachLayer(function(layer) {
                            if (layer instanceof L.Marker) {
                                if (layer.getLatLng().lat == latitude && layer.getLatLng().lng == longitude) {
                                    layer.openPopup();
                                }
                            }
                        });
                    }
                });
            }
            
            // Modifikasi bagian penambahan marker untuk menyimpan referensi
            var markers = []; // Simpan referensi marker
            locations.forEach(function(pasar) {
                var marker = L.marker([pasar.latitude, pasar.longitude])
                .addTo(map)
                .bindPopup('<b>' + pasar.nama_pasar + '</b><br>Lat: ' + pasar.latitude + '<br>Long: ' + pasar.longitude + '<br>Pilihan: ' + (pasar.pilihan || '-'));
                
                markers.push(marker); // Simpan marker
            });
        </script>
    </body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
