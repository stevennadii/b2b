<template>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="card p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="/new/purchase-order" class="btn btn-primary">
                    Kembali
                </a>
            </div>
        </div>
        <div class="row mb-3 mt-3">
            <div class="col-md-5 d-flex align-items-center">
                <h5 class="me-3 mb-0 flex-shrink-1">Nomor PO</h5>
                <select
                    name="nomorPO"
                    id="nomorPO"
                    class="form-select"
                    v-model="selectedPO"
                    @change="loadItemsByPO"
                >
                    <option value="" hidden>Pilih PO</option>
                    <option
                        v-for="po in purchaseOrders"
                        :key="po.no_faktur"
                        :value="po.no_faktur"
                    >
                        {{ po.no_faktur }}
                    </option>
                </select>
            </div>
        </div>

        <hr />
        <!-- Tabel Purchase Order -->
        <div class="row mb-3 me-2 ms-1">
            <table class="table col-md-12 table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th hidden>Urut PO</th>
                        <th>Kode</th>
                        <th>Kode Stock Owner</th>
                        <th>Nama</th>
                        <th>Qty Order</th>
                        <th>Proses</th>
                        <th>Unproses</th>
                        <th>Satuan</th>
                        <th>Qty Kirim</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in itemsBySelectedPO"
                        :key="item.id"
                    >
                        <td>{{ index + 1 }}</td>
                        <td hidden>{{ item.UrutPO }}</td>
                        <td>{{ item.Kode_Barang }}</td>
                        <td>{{ item.Kode_Stock_Owner }}</td>
                        <td>{{ item.Nama }}</td>
                        <td>{{ item.Jumlah }}</td>

                        <td>{{ item.proses }}</td>
                        <td>{{ item.unproses }}</td>
                        <td>{{ item.Satuan }}</td>

                        <td>
                            <input
                                type="number"
                                v-model="item.qty_kirim"
                                class="form-control py-1"
                                :disabled="item.isDisabled"
                                @keyup="handleQtyKirimChange(item)"
                                @mouseenter="removeQtyKirim(item)"
                            />
                            <!-- Menampilkan pesan error jika ada -->
                            <p v-if="item.errorQtyKirim" class="text-danger">
                                {{ item.errorQtyKirim }}
                            </p>
                        </td>

                        <td class="text-center">
                            <button
                                class="btn btn-primary btn-sm me-3"
                                @click="openDetailModal(item, index)"
                            >
                                Detail
                            </button>
                            <button
                                class="btn btn-danger btn-sm me-3"
                                @click="removeIndex(item, index)"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Buttons Save, Reset & Summary -->
        <div class="row">
            <div class="col-12 col-md-3 mb-3 ms-1">
                <button
                    type="button"
                    class="btn btn-primary form-control"
                    @click="save"
                >
                    Save
                </button>
            </div>
            <div class="col-12 col-md-3">
                <button
                    type="button"
                    class="btn btn-warning form-control"
                    @click="reset"
                >
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div v-if="showDetailModal" class="modal d-block" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Barang - {{ this.selectedPO }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeDetailModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>Quantity Kirim: {{ detailBarang.qty_kirim }}</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Batch No</th>
                                    <th>Tanggal Produksi</th>
                                    <th
                                        v-if="
                                            detailBarang.Metode_Pengeluaran_Stok !==
                                            'FIFO'
                                        "
                                    >
                                        Tanggal Expired
                                    </th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        batch, index
                                    ) in detailBarang.batches"
                                    :key="index"
                                >
                                    <td>
                                        <input
                                            type="text"
                                            v-model="batch.batchNo"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="date"
                                            v-model="batch.prodDate"
                                            class="form-control"
                                        />
                                    </td>
                                    <td
                                        v-if="
                                            detailBarang.Metode_Pengeluaran_Stok !==
                                            'FIFO'
                                        "
                                    >
                                        <input
                                            type="date"
                                            v-model="batch.expDate"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            v-model="batch.quantity"
                                            class="form-control"
                                            @input="
                                                validateBatchQuantity(
                                                    detailBarang
                                                )
                                            "
                                        />
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-danger btn-sm"
                                            @click="removeBatch(index)"
                                        >
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <button class="btn btn-primary mt-3 me-2" @click="addBatch">
                        Tambah Batch
                    </button>
                    <button
                        class="btn btn-success mt-3"
                        @click="saveBatchDetails"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
import {
    SRV_URL,
    NAMA_API_PURHCASE_ORDER,
    kodePerusahaan,
} from "../helpers/shared_value";

export default {
    props: {
        dataPO: Array,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        KodeSupplier: Object,
    },
    data() {
        return {
            showDetailModal: false,
            detailBarang: {
                nama: "",
                qtyKirim: "0",
                batches: [],
            },
            error: null,
            purchaseOrders: this.dataPO || [], // Ambil langsung dari props
            selectedPO: "",
            itemsBySelectedPO: [], // Akan diisi setelah PO dipilih
            isDisabled: false,
        };
    },
    mounted() {
        this.items.forEach((item) => {
            // Set the initial disabled state based on the current values
            item.isDisabled = Number(item.terkirim) === Number(item.Jumlah);
        });
    },

    methods: {
        async loadItemsByPO() {
            if (this.selectedPO) {
                try {
                    const response = await axios.post(
                        `${SRV_URL}supplier/get_data_detail_po`,
                        {
                            kode_perusahaan: kodePerusahaan,
                            id_user: this.UserId,
                            auth_sp: this.AuthSP,
                            version: "1.0.0",
                            nama_api: NAMA_API_PURHCASE_ORDER,
                            locale: "id",
                            noFaktur: this.selectedPO,
                        },
                        {
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${this.Token}`,
                            },
                        }
                    );
                    // console.log(headers);
                    this.itemsBySelectedPO = response.data.data.data || [];
                } catch (error) {
                    console.error(
                        "Error fetching items: ",
                        error.response?.data || error.message || error
                    );

                    Swal.fire({
                        title: "Attention!",
                        text: "Data Telah Dikirim",
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                }
            } else {
                this.itemsBySelectedPO = [];
            }
        },

        removeIndex(item, index) {
            if (index !== -1) {
                this.itemsBySelectedPO.splice(index, 1);
            } else {
                alert("Item tidak ditemukan.");
            }
        },
        openDetailModal(barang, index) {
            this.showDetailModal = true;
            this.detailBarang = { ...barang, batches: barang.batches || [] };
            this.fetchBatchData(barang.Kode_Barang, index);
        },
        closeDetailModal() {
            this.showDetailModal = false;
        },
        async fetchBatchData(kodeBarang, index) {
            try {
                const response = await axios.post(
                    `${SRV_URL}supplier/get_data_detail_batch_po`,
                    {
                        kodeBarang: kodeBarang,
                        noPO: this.selectedPO,
                        kode_perusahaan: kodePerusahaan,
                        nama_api: NAMA_API_PURHCASE_ORDER,
                        id_user: this.UserId,
                        auth_sp: this.AuthSP,
                        version: "1.0.0",
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                // Set batches jika ada data yang sudah disimpan
                if (
                    response.data &&
                    response.data.data &&
                    response.data.data.data
                ) {
                    this.detailBarang.batches = response.data.data.data.map(
                        (batch) => ({
                            batchNo: batch.No_Batch,
                            prodDate: batch.Tanggal_Produksi,
                            expDate: batch.Tanggal_Expired,
                            quantity: batch.Quantity,
                            index: index,
                        })
                    );
                }
            } catch (error) {
                // console.error("Error fetching batch data: ", error);
            }
        },
        handleQtyKirimChange(item) {
            // Convert qty_kirim to a number if it's a string
            item.qty_kirim = Number(item.qty_kirim);

            // Calculate the total of qty_kirim + terkirim
            const totalQty = item.qty_kirim + Number(item.terkirim);

            // Check if totalQty exceeds the Qty Order (Jumlah)
            if (totalQty > Number(item.Jumlah)) {
                // Set an error message if the total exceeds Qty Order
                item.errorQtyKirim = `Qty Kirim + Terkirim tidak boleh melebihi Qty Order (${item.Jumlah})!`;
            } else {
                // Clear the error message if the validation passes
                item.errorQtyKirim = null;
            }

            item.isDisabled = Number(item.terkirim) === Number(item.Jumlah);
            // Disable qty_kirim if all sent items equal the order quantity
        },
        removeQtyKirim(item) {
            item.isDisabled = Number(item.terkirim) === Number(item.Jumlah);
            // Disable qty_kirim if all sent items equal the order quantity
        },
        validateItem(item) {
            // Gunakan id atau kode unik untuk menemukan item yang sesuai
            const index = this.itemsBySelectedPO.findIndex(
                (i) => i.kode === item.kode
            );

            if (index !== -1) {
                const totalQty =
                    item.qty_kirim + this.itemsBySelectedPO[index].qty_kirim;

                // Validasi apakah total kirim + terkirim melebihi Qty Order
                if (totalQty > this.itemsBySelectedPO[index].Jumlah) {
                    this.itemsBySelectedPO[index].errorQtyKirim =
                        "Qty Kirim + Terkirim tidak boleh melebihi Qty Order!";
                } else {
                    this.itemsBySelectedPO[index].errorQtyKirim = null; // Clear error jika valid
                }
            }
        },

        async saveBatchDetails() {
            const DefaultExpDate = new Date(
                Date.now() + 240 * 30 * 24 * 60 * 60 * 1000
            )
                .toISOString()
                .split("T")[0];

            const batchDetails = this.detailBarang.batches.map((batch) => ({
                kode_barang: this.detailBarang.Kode_Barang,
                kode_stock_owner: this.detailBarang.Kode_Stock_Owner,
                batch_no: batch.batchNo,
                produksi_date: batch.prodDate,
                exp_date:
                    this.detailBarang.Metode_Pengeluaran_Stok !== "FIFO"
                        ? batch.expDate
                        : DefaultExpDate, // Set exp_date to null if FIFO
                quantity: batch.quantity,
            }));

            // Prepare the payload for the POST request
            const payload = {
                batchDetails, // The prepared batch details
                kode_perusahaan: kodePerusahaan, // Company code
                id_user: this.UserId, // User ID
                auth_sp: this.AuthSP, // Authorization string
                namaAPi: NAMA_API_PURHCASE_ORDER, // API name (ensure it matches your backend)
                version: "1.0.0", // Version
                nomorPO: this.selectedPO, // The selected PO number
            };

            try {
                const response = await axios.post(
                    `${SRV_URL}supplier/simpan_batch_sementara`, // Adjust the endpoint as necessary
                    payload, // Send the payload
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                await Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Batch berhasil disimpan!",
                });

                this.closeDetailModal();
            } catch (error) {
                if (error.response) {
                    // The request was made and the server responded with a status code
                    console.error("Error response data: ", error.response.data);
                    console.error(
                        "Error response status: ",
                        error.response.status
                    );
                    console.error(
                        "Error response headers: ",
                        error.response.headers
                    );
                    await Swal.fire({
                        icon: "error",
                        title: "Terjadi kesalahan",
                        text:
                            error.response.data.message ||
                            "Terjadi kesalahan saat menyimpan batch.",
                    });
                } else if (error.request) {
                    // The request was made but no response was received
                    console.error("Error request: ", error.request);
                } else {
                    // Something happened in setting up the request
                    console.error("Error message: ", error.message);
                }
            }
        },

        addBatch() {
            this.detailBarang.batches.push({
                batchNo: "",
                expDate: "",
                quantity: 0,
            });
        },
        removeBatch(index) {
            this.detailBarang.batches.splice(index, 1);
        },
        validateBatchQuantity(barang) {
            console.log(barang.terkirim);
            const totalBatchQuantity = barang.batches.reduce(
                (total, batch) => total + Number(batch.quantity || 0),
                0
            );

            if (totalBatchQuantity > barang.qty_kirim) {
                this.error = "Total quantity batch melebihi qty kirim!";
            } else {
                this.error = null; // Reset error jika valid
            }
        },
        async save() {
            let hasError = false;

            // Loop through each item and check for validation errors
            for (const item of this.itemsBySelectedPO) {
                const totalQty = Number(item.qty_kirim) + Number(item.terkirim);

                // If totalQty exceeds the order quantity, set an error and prevent saving
                if (totalQty > Number(item.Jumlah)) {
                    item.errorQtyKirim = `Qty Kirim + Terkirim tidak boleh melebihi Qty Order (${item.Jumlah})!`;
                    hasError = true;
                } else {
                    item.errorQtyKirim = null; // Clear the error if validation passes
                }
            }

            // If there is any error, prevent the save process
            if (hasError) {
                await Swal.fire({
                    icon: "error",
                    title: "Terdapat kesalahan",
                    text: "Terdapat kesalahan pada pengisian Qty Kirim. Periksa kembali sebelum menyimpan.",
                });
                return;
            }

            // Prepare the payload for the backend with all data (not just qty_kirim)
            const poItems = this.itemsBySelectedPO.map((item) => ({
                kode_barang: item.Kode_Barang,
                kode_stock_owner: item.Kode_Stock_Owner,
                nama: item.Nama,
                jumlah_order: item.Jumlah, // Qty Order
                terkirim: item.terkirim, // Qty already shipped
                qty_kirim: item.qty_kirim, // New shipping quantity
                UrutPO: item.UrutPO, // New shipping quantity
                satuan: item.Satuan, // Unit
            }));

            try {
                // Send the entire PO data to the backend and save the response
                const $response = await axios.post(
                    `${SRV_URL}supplier/simpan_detail_sementara`,
                    {
                        poItems,
                        nomorPO: this.selectedPO,
                        kode_perusahaan: kodePerusahaan,
                        nama_api: NAMA_API_PURHCASE_ORDER,
                        id_user: this.UserId,
                        auth_sp: this.AuthSP,
                        version: "1.0.0",
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                // Handle the response
                console.log("Response from backend: ", $response.data);

                // Optionally alert or process based on $response content
                await Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Data berhasil disimpan!",
                });

                this.reset(); // Reset the form after a successful save
            } catch (error) {
                console.error("Error saving data: ", error);
                await Swal.fire({
                    icon: "error",
                    title: "Terjadi kesalahan",
                    text: "Terjadi kesalahan saat menyimpan data.",
                });
            }
        },

        reset() {
            this.selectedPO = "";
            this.itemsBySelectedPO = [];
        },
    },
    watch: {
        selectedPO() {
            this.loadItemsByPO();
        },
    },
};
</script>

<style scoped>
.table {
    width: 100%;
    margin-top: 20px;
}

.btn-sm {
    margin-top: 10px;
}

.btn-primary {
    overflow-x: auto; /* Agar tabel bisa di-scroll pada perangkat kecil */
}

.flex-shrink-1 {
    white-space: nowrap; /* Mencegah teks dari pembungkus default */
}
</style>
