<template>
    <div class="card p-4">
        <h5 class="mb-3">Purchase Order</h5>

        <!-- Row 2: Button Tambah Transaksi -->
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-4 d-flex align-items-center">
                <span class="me-5 flex-shrink-1">No Transaksi</span>
                <input
                    type="text"
                    class="form-control ms-1 py-1"
                    v-model="data.noTransaksi"
                    disabled
                />
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-4 d-flex align-items-center">
                <span class="me-5 flex-shrink-1">No DO </span>
                <input
                    v-model="data.noDO"
                    type="text"
                    class="form-control ms-5 py-1"
                />
            </div>
            <div class="col-12 col-md-3 d-flex align-items-center">
                <span class="ms-4 flex-shrink-1">ETD </span>
                <input
                    v-model="data.etd"
                    type="date"
                    class="form-control ms-4 py-1"
                />
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center">
                <span class="ms-4 me-5 flex-shrink-1">ETA</span>
                <input
                    v-model="data.eta"
                    type="date"
                    class="form-control ms-4 py-1"
                />
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-4 d-flex align-items-center">
                <span class="me-4 flex-shrink-1">Jenis Kendaraan</span>
                <select v-model="data.jenisKendaraan" class="form-select py-1">
                    <option value="">Pilih Kendaraan</option>
                    <option
                        v-for="kendaraan in dataKendaraan"
                        :key="kendaraan.Id_Kendaraan"
                        :value="kendaraan.Id_Kendaraan"
                    >
                        {{ kendaraan.Kode_Kendaraan }}
                    </option>
                </select>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-center">
                <span class="ms-4 flex-shrink-1">Plat</span>
                <input
                    v-model="data.plat"
                    type="text"
                    class="form-control ms-4 py-1"
                />
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-4 d-flex align-items-center">
                <span class="me-5 flex-shrink-1">Driver</span>
                <input
                    v-model="data.driver"
                    type="text"
                    class="form-control ms-5 py-1"
                />
            </div>
            <div class="col-12 col-md-3 d-flex align-items-center">
                <span class="ms-4 flex-shrink-1">No HP</span>
                <input
                    v-model="data.noHp"
                    type="text"
                    class="form-control ms-3 py-1"
                />
            </div>
        </div>

        <div class="row d-flex justify-content-start">
            <div class="col-md-12">
                <a href="detail_purchase-order" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </a>
            </div>
        </div>
        <hr />
        <!-- Tabel Purchase Order -->
        <div class="row mb-3 me-2 ms-1">
            <table class="table table-bordered">
                <thead class="text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Nomor PO</th>
                        <th>Nama Barang</th>
                        <th>Batch Details</th>
                        <th>Quantity Kirim</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr
                        v-for="(item, index) in itemsBySelectedPO"
                        :key="item.id"
                    >
                        <td class="text-center">{{ index + 1 }}</td>
                        <td class="text-center">{{ item.no_po }}</td>
                        <td>{{ item.nama_barang }}</td>
                        <!-- 2 -->
                        <td>
                            <div
                                class=""
                                v-for="(batch, batchIndex) in item.batches"
                                :key="batchIndex"
                            >
                                <strong>Batch No:</strong>
                                {{ batch.No_Batch }}

                                <strong>/ Exp:</strong>
                                {{ batch.Tanggal_Expired }}

                                <strong>/ Qty:</strong>
                                {{ batch.Quantity }}
                            </div>
                        </td>
                        <td class="text-center">
                            {{ item.qty_kirim }}
                            <div
                                v-if="item.errorQtyKirim"
                                class="text-danger mt-1"
                            >
                                {{ item.errorQtyKirim }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Buttons Save, Reset & Summary -->
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <button
                    type="button"
                    class="btn btn-primary form-control"
                    @click="simpan"
                >
                    Save
                </button>
            </div>
            <div class="col-12 col-md-6">
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
        dataKendaraan: Array,
        dataFaktur: Object,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        KodeSupplier: Object,
    },
    data() {
        return {
            error: null,
            // selectedPO: "",
            itemsBySelectedPO: [],
            data: {
                lokasi: "",
                kodeSupplier: "",
                noTransaksi: this.dataFaktur,
                noDO: "",
                etd: "",
                eta: "",
                jenisKendaraan: "",
                plat: "",
                driver: "",
                noHp: "",
                jam: "",
                tanggal: "",
            },
            savedData: {},
        };
    },
    mounted() {
        this.fetchPurchaseOrderData(); // Panggil data saat komponen dimuat
    },
    methods: {
        async simpan() {
            // Validasi data sebelum menyimpan
            try {
                const now = new Date();
                const jamSekarang = `${now
                    .getHours()
                    .toString()
                    .padStart(2, "0")}:${now
                    .getMinutes()
                    .toString()
                    .padStart(2, "0")}:${now
                    .getSeconds()
                    .toString()
                    .padStart(2, "0")}`;
                const tanggalSekarang = `${now.getFullYear()}-${(
                    now.getMonth() + 1
                )
                    .toString()
                    .padStart(2, "0")}-${now
                    .getDate()
                    .toString()
                    .padStart(2, "0")}`;
                const saveData = {
                    Kode_Perusahaan: `${kodePerusahaan}`,
                    ID_User: this.UserId,
                    Auth_SP: this.AuthSP,
                    Nama_Api: `${NAMA_API_PURHCASE_ORDER}`,
                    lokasi: this.Lokasi,
                    kodeSupplier: this.KodeSupplier,
                    noTransaksi: this.data.noTransaksi,
                    noDO: this.data.noDO,
                    etd: this.data.etd,
                    eta: this.data.eta,
                    jenisKendaraan: this.data.jenisKendaraan,
                    plat: this.data.plat,
                    driver: this.data.driver,
                    noHp: this.data.noHp,
                    jam: jamSekarang,
                    tanggal: tanggalSekarang,
                };
                // console.log(saveData);
                const response = await axios.post(
                    `${SRV_URL}supplier/simpan_purchase_order`,
                    saveData,
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );
                // console.log(response);
                if (response.data && response.data.status === "success") {
                    Swal.fire("Success", response.data.message, "success");

                    this.reset();
                    window.location.reload();
                } else {
                    Swal.fire(
                        "Error",
                        "Terjadi kesalahan saat menyimpan data.",
                        "error"
                    );
                }
            } catch (error) {
                console.error("Error saving data:", error);
                Swal.fire(
                    "Error",
                    "Gagal menyimpan data. Silakan coba lagi.",
                    "error"
                );
            }
        },

        async fetchPurchaseOrderData() {
            try {
                const response = await axios.post(
                    `${SRV_URL}supplier/get_detail_sementara`,
                    {
                        kode_perusahaan: kodePerusahaan,
                        id_user: this.UserId,
                        auth_sp: this.AuthSP,
                        version: "1.0.0",
                        nama_api: NAMA_API_PURHCASE_ORDER,
                        locale: "id",
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                if (
                    response.data &&
                    response.data.data &&
                    response.data.data.data
                ) {
                    this.itemsBySelectedPO = response.data.data.data.map(
                        (item) => ({
                            ...item,
                            // Cek apakah batch_details adalah objek atau string
                            batches:
                                typeof item.batch_details === "string"
                                    ? JSON.parse(item.batch_details) // Parsing jika batch_details berupa string JSON
                                    : item.batch_details || [], // Jika sudah objek, langsung gunakan
                        })
                    );
                } else {
                    this.error =
                        "Data tidak ditemukan atau format tidak valid.";
                }
            } catch (error) {
                console.error("Error fetching data:", error);
                this.error = "Gagal mengambil data. Silakan coba lagi.";
            }
        },

        reset() {
            // Reset data
            this.data = {
                noDO: "",
                etd: "",
                eta: "",
                jenisKendaraan: "",
                plat: "",
                driver: "",
                noHp: "",
            };
            this.itemsBySelectedPO = [];
            this.savedData = null;
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

.btn-primary,
.table-responsive {
    overflow-x: auto;
    /* Agar tabel bisa di-scroll pada perangkat kecil */
}

.flex-shrink-1 {
    white-space: nowrap;
    /* Mencegah teks dari pembungkus default */
}
</style>

<!--      <tr>
                        <td colspan="4">
                            <small
                                ><strong>Note:</strong> Expired date:
                                25-09-2024</small
                            ><br />
                            <small
                                ><strong>Note:</strong> Expired date:
                                27-12-2024</small
                            >
                        </td>
                    </tr> -->
