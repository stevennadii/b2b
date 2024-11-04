<template>
    <div class="quotation-card">
        <!-- Header Section -->
        <div class="quotation-header mb-3">
            <h5>Approval Freight | Detail</h5>
            <hr />
        </div>

        <!-- Filters Section -->
        <div
            class="filters d-flex justify-content-between align-items-center mb-3"
        >
            <div class="filter-items d-flex align-items-center">
                <div class="filter-item">
                    <label for="jenis-container">Jenis Container</label>
                    <select
                        id="jenis-container"
                        v-model="filters.jenisContainer"
                        class="px-3"
                    >
                        <option value="" hidden>Pilih Container</option>
                        <option
                            v-for="container in dataContainer"
                            :value="container.Id_Container"
                            :key="container.Id_Container"
                        >
                            {{ container.Keterangan }}
                        </option>
                    </select>
                </div>

                <div class="filter-item ml-2">
                    <label for="asal">Asal</label>
                    <select id="asal" v-model="filters.asal" class="px-4">
                        <option value="" hidden>Pilih Asal</option>
                        <option
                            v-for="asal in dataAsal"
                            :value="asal.Id_Pelabuhan_Asal"
                            :key="asal.Id_Pelabuhan_Asal"
                        >
                            {{ asal.Keterangan }}
                        </option>
                    </select>
                </div>

                <div class="filter-item ml-2">
                    <label for="shipping">Shipping</label>
                    <select
                        id="shipping"
                        v-model="filters.shipping"
                        class="px-3"
                    >
                        <option value="" hidden>Pilih Shipping</option>
                        <option
                            v-for="shipping in dataPengiriman"
                            :value="shipping.Kode_Pengiriman"
                            :key="shipping.Kode_Pengiriman"
                        >
                            {{ shipping.Keterangan }}
                        </option>
                    </select>
                </div>

                <div class="filter-item ml-2">
                    <label for="urutan">Urutan</label>
                    <select id="urutan" v-model="filters.urutan" class="px-3">
                        <option value="lowest">Harga Terendah</option>
                        <option value="highest">Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            <!-- Right-aligned controls -->
            <div class="right-controls d-flex align-items-center">
                <input
                    type="text"
                    class="py-2 mr-2 me-3 text-center"
                    v-model="data.noTransaksi"
                    disabled
                />
                <input
                    type="text"
                    class="py-2 mr-2 me-3 text-center"
                    v-model="data.tanggal"
                    disabled
                />
            </div>
        </div>

        <!-- Table Section -->
        <div class="quotation-table mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input
                                type="checkbox"
                                v-model="selectAll"
                                @change="toggleSelectAll"
                            />
                        </th>
                        <th>No Penawaran</th>
                        <th>Jenis Kendaraan</th>
                        <th>Agent</th>
                        <th>Shipping</th>
                        <th>Kota Tujuan</th>
                        <th>Mata Uang</th>
                        <th>Tarif</th>
                        <th>ETD</th>
                        <th>ETA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(data, index) in dataQuotation"
                        :key="data['No_Penawaran']"
                    >
                        <td>
                            <input
                                type="checkbox"
                                :value="index"
                                v-model="selectedOffers"
                            />
                        </td>
                        <td>{{ data["No_Penawaran"] }}</td>
                        <td>{{ data["Jenis_Container"] }}</td>
                        <td>{{ data["Agent"] }}</td>
                        <td>{{ data["Shipping"] }}</td>
                        <td>{{ data["Tujuan"] }}</td>
                        <td>{{ data["Mata_Uang"] }}</td>
                        <td>{{ data["Tarif"] }}</td>
                        <td>{{ data["ETD"] }}</td>
                        <td>{{ data["ETA"] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Buttons Section -->
        <div class="buttons mt-3">
            <button class="btn btn-primary">APPROVE</button>
            <button class="btn btn-warning">HOLD</button>
            <button class="btn btn-danger">REJECT</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        dataTujuan: Array,
        dataContainer: Array,
        dataAsal: Array,
        dataPengiriman: Array,
        dataQuotation: Array,
        dataFaktur: Object,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        KodeSupplier: Object,
    },
    data() {
        return {
            filters: {
                jenisContainer: "",
                asal: "",
                shipping: "",
                urutan: "lowest",
            },
            data: {
                noTransaksi: this.dataFaktur || "",
                tanggal: this.dataFaktur?.tanggal || this.getTodayDate(),
            },
            selectAll: false,
            selectedOffers: [],
        };
    },
    watch: {
        // Watcher untuk memperbarui checkbox "select all"
        selectedOffers() {
            // Update selectAll based on whether all offers are selected
            this.selectAll =
                this.selectedOffers.length === this.dataQuotation.length;
        },
    },
    methods: {
        getTodayDate() {
            const date = new Date();
            const day = String(date.getDate()).padStart(2, "0");
            const month = date.toLocaleString("default", { month: "short" });
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        },
        toggleSelectAll() {
            if (this.selectAll) {
                // Jika selectAll aktif, tambahkan semua index ke selectedOffers
                this.selectedOffers = this.dataQuotation.map(
                    (_, index) => index
                );
            } else {
                // Jika tidak aktif, kosongkan selectedOffers
                this.selectedOffers = [];
            }
        },
    },
};
</script>

<style>
.quotation-card {
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filters {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.filter-items {
    display: flex;
    gap: 15px;
}

.filter-item label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.filter-item select {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.right-controls .btn {
    font-size: 12px;
    border-radius: 4px;
}

.table {
    width: 100%;
    margin-top: 20px;
}

.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}

.table th {
    background-color: #f8f9fa;
}

.buttons {
    display: flex;
    gap: 10px;
}

.buttons .btn {
    padding: 10px 20px;
    font-weight: bold;
}
</style>
