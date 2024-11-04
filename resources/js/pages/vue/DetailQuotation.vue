<template>
    <div class="card">
        <div class="card-body">
            <div>
                <p class="fw-bold">MULTI EXPRESS TRANSINDO</p>
                <p>Jalan Soekarno-Hatta</p>
                <p>90201</p>
            </div>
            <div class="text-end header">
                <h1 class="fw-bold">PENAWARAN</h1>
            </div>

            <table class="table table-bordered mb-4">
                <thead class="table-light">
                    <tr>
                        <th>No. Penawaran</th>
                        <th>Tanggal Penawaran</th>
                        <th>Tanggal Berlaku</th>
                        <th>Pengiriman</th>
                        <th>Mata Uang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024//II/MET/0105</td>
                        <td>27 Ferbruari 2024</td>
                        <td>28 Feb, 2024 s/d 05 Mar, 2024</td>
                        <td>Domestik</td>
                        <td>IDR</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Jenis Kendaraan</th>
                        <th>Lokasi Asal</th>
                        <th>Lokasi Tujuan</th>
                        <th>Tarif</th>
                        <th>Biaya Lain</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in penawaran.items" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.jenis_kendaraan }}</td>
                        <td>{{ item.lokasi_asal }}</td>
                        <td>{{ item.lokasi_tujuan }}</td>
                        <td>{{ formatCurrency(item.tarif) }}</td>
                        <td>{{ formatCurrency(item.biaya_lain) }}</td>
                        <td>{{ formatCurrency(item.total) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="pembayaran mt-4">
                <h5 class="mb-3">Detil Pembayaran:</h5>
                <p>Cara Bayar : BANK TRANSFER</p>
                <p>Account Name : CV. MULTI EXPRESS TRANSINDO</p>
                <p>Account Number : 849 019 7777</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.header h1 {
    bottom: 60px;
    right: 35px;
    position: relative;
    color: green;
}
.pembayaran,
.pembayaran h5 {
    color: grey;
}
.table th,
.table td {
    text-align: center;
}
</style>
<script>
export default {
    name: "DetailQuotation",
    data() {
        return {
            penawaran: {
                items: [
                    {
                        jenis_kendaraan: "Truck",
                        lokasi_asal: "Jakarta",
                        lokasi_tujuan: "Surabaya",
                        tarif: 1680000,
                        biaya_lain: 50000,
                        total: 1730000,
                    },
                    {
                        jenis_kendaraan: "Container",
                        lokasi_asal: "Bandung",
                        lokasi_tujuan: "Medan",
                        tarif: 1650000,
                        biaya_lain: 70000,
                        total: 1720000,
                    },
                    {
                        jenis_kendaraan: "Van",
                        lokasi_asal: "Semarang",
                        lokasi_tujuan: "Bali",
                        tarif: 1675000,
                        biaya_lain: 60000,
                        total: 1731000,
                    },
                    {
                        jenis_kendaraan: "Truck",
                        lokasi_asal: "Yogyakarta",
                        lokasi_tujuan: "Jakarta",
                        tarif: 1950000,
                        biaya_lain: 80000,
                        total: 2030000,
                    },
                    {
                        jenis_kendaraan: "Container",
                        lokasi_asal: "Surabaya",
                        lokasi_tujuan: "Makassar",
                        tarif: 1700000,
                        biaya_lain: 65000,
                        total: 1765000,
                    },
                ],
            },
        };
    },
    methods: {
        formatCurrency(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
            }).format(value);
        },
    },
};
</script>
