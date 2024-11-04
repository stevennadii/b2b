<template>
    <div class="card">
        <div class="card-body">
            <!-- <div class="confirm-header mb-3">
                <span><b>Confirmation Quotation | Detail</b></span>
                <hr />
            </div> -->
            <!-- Supplier Details -->
            <div>
                <p class="fw-bold">PT. PRIMA GLOBAL FRESH</p>
                <p>Jalan Kol. H. Burlian</p>
                <p>90201</p>
            </div>

            <!-- Header -->
            <div class="text-end header">
                <h1 class="fw-bold">KONFIRMASI PENAWARAN</h1>
            </div>

            <!-- Penawaran Details -->
            <table class="table table-bordered mb-4">
                <thead class="table-light">
                    <tr>
                        <th>No. Approval</th>
                        <th>Tanggal Approval</th>
                        <th>Tanggal Berlaku</th>
                        <th>Status Penawaran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>APB-02/24-0001</td>
                        <td>27 Februari 2024</td>
                        <td>28 Feb, 2024 s/d 15 Mar, 2024</td>
                        <td><span class="badge bg-success">APPROVED</span></td>
                    </tr>
                </tbody>
            </table>

            <!-- Item Details -->
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>MOQ</th>
                        <th>Satuan</th>
                        <th>Mata Uang</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Inc. Pajak</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in penawaran.items" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.jenis_barang }}</td>
                        <td>{{ item.nama_barang }}</td>
                        <td>{{ item.moq }}</td>
                        <td>{{ item.satuan }}</td>
                        <td>{{ item.mata_uang }}</td>
                        <td>{{ formatCurrency(item.harga) }}</td>
                        <td>{{ formatCurrency(item.total) }}</td>
                        <td>{{ item.inc_pajak }}</td>
                        <td>{{ item.status }}</td>
                        <td>{{ item.keterangan }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <span>Cara Kirim : Third Party</span><br />
                <span>Include Biaya Kirim : YA</span>
            </div>
            <!-- Payment Details -->
            <div class="pembayaran mt-4">
                <h5 class="mb-3">Detil Pembayaran:</h5>
                <p>Cara Bayar : BANK TRANSFER</p>
                <p>Account Name : PT. PRIMA GLOBAL FRESH</p>
                <p>Account Number : 849 091 8576</p>
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
                        jenis_barang: "Frozen",
                        nama_barang: "Ikan Tuna Australia",
                        moq: 250,
                        satuan: "KG",
                        mata_uang: "IDR",
                        harga: 35000,
                        total: 8750000,
                        inc_pajak: "Y",
                        status: "Ready",
                        keterangan: "Ready",
                    },
                    {
                        jenis_barang: "Frozen",
                        nama_barang: "Ikan Tuna Portugal",
                        moq: 250,
                        satuan: "KG",
                        mata_uang: "IDR",
                        harga: 31000,
                        total: 7750000,
                        inc_pajak: "Y",
                        status: "Indent",
                        keterangan: "Ready 5 Maret, 2024",
                    },
                    {
                        jenis_barang: "Frozen",
                        nama_barang: "Ikan Tuna Argentina",
                        moq: 250,
                        satuan: "KG",
                        mata_uang: "IDR",
                        harga: 31500,
                        total: 7875000,
                        inc_pajak: "Y",
                        status: "Indent",
                        keterangan: "Ready 8 Maret, 2024",
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
