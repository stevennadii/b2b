<template>
    <div class="quotation-card">
        <!-- Header Section -->
        <div class="quotation-header mb-3">
            <h5>Approval Expedition | Detail</h5>
            <hr />
        </div>

        <!-- Filters Section -->
        <div
            class="filters d-flex justify-content-between align-items-center mb-3"
        >
            <div class="filter-items d-flex align-items-center">
                <div class="filter-item">
                    <label for="jenis-kendaraan">Jenis Kendaraan</label>
                    <select
                        id="jenis-kendaraan"
                        v-model="filters.jenisKendaraan"
                        class="px-3"
                        @change="onVehicleChange"
                    >
                        <option value="">Pilih Semua</option>
                        <option
                            v-for="data in dataKendaraan"
                            :key="data.Kode_Kendaraan"
                            :value="data.Kode_Kendaraan"
                        >
                            {{ data.Kode_Kendaraan }}
                        </option>
                    </select>
                </div>

                <div class="filter-item ml-2 position-relative">
                    <label for="asal">Asal</label>
                    <input
                        id="asal"
                        v-model="filters.asal"
                        class="form-control text-wrap"
                        @input="filterItemsAsal"
                        @blur="handleBlurAsal"
                        placeholder="Type the city name..."
                        :disabled="!filters.jenisKendaraan"
                    />
                    <ul
                        v-if="showAsalDropdown && filteredItemsAsal.length > 0"
                        class="recommendations position-absolute w-100 list-unstyled shadow-sm"
                        style="
                            z-index: 1000;
                            max-height: 200px;
                            overflow-y: auto;
                            background: white;
                            border: 1px solid #ddd;
                        "
                    >
                        <li
                            v-for="item in filteredItemsAsal"
                            :key="item.id"
                            class="p-2 cursor-pointer hover:bg-gray-100"
                            @mousedown="selectItemAsal(item)"
                        >
                            {{ item.nama_kabupaten_kota }}
                        </li>
                    </ul>
                </div>

                <div class="filter-item ml-2 position-relative">
                    <label for="tujuan">Tujuan</label>
                    <input
                        id="tujuan"
                        v-model="filters.tujuan"
                        class="form-control text-wrap"
                        @input="filterItemsTujuan"
                        @blur="handleBlurTujuan"
                        placeholder="Type the city name..."
                        :disabled="!filters.jenisKendaraan"
                    />
                    <ul
                        v-if="
                            showTujuanDropdown && filteredItemsTujuan.length > 0
                        "
                        class="recommendations position-absolute w-100 list-unstyled shadow-sm"
                        style="
                            z-index: 1000;
                            max-height: 200px;
                            overflow-y: auto;
                            background: white;
                            border: 1px solid #ddd;
                        "
                    >
                        <li
                            v-for="item in filteredItemsTujuan"
                            :key="item.id"
                            class="p-2 cursor-pointer hover:bg-gray-100"
                            @mousedown="selectItemTujuan(item)"
                        >
                            {{ item.nama_kabupaten_kota }}
                        </li>
                    </ul>
                </div>

                <div class="filter-item ml-2">
                    <label for="harga">Urutan</label>
                    <select id="harga" v-model="filters.harga" class="px-3">
                        <option value="DESC">Termahal</option>
                        <option value="ASC">Termurah</option>
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
                        <th hidden>No Urut</th>
                        <th>No Penawaran</th>
                        <th>Jenis Kendaraan</th>
                        <th>Ekspedisi</th>
                        <th>Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Mata Uang</th>
                        <th>Tarif</th>
                        <th>Biaya Lain</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(data, index) in filteredDataTable"
                        :key="data.NoPenawaran"
                    >
                        <td hidden>{{ data.NoUrut }}</td>
                        <td>{{ data.NoPenawaran }}</td>
                        <td>{{ data.JenisKendaraan }}</td>
                        <td>{{ data.Ekspedisi }}</td>
                        <td>{{ data.Asal }}</td>
                        <td>{{ data.Tujuan }}</td>
                        <td>{{ data.MataUang }}</td>
                        <td>{{ formatCurrency(data.Tarif) }}</td>
                        <td>{{ formatCurrency(data.BiayaLain) }}</td>
                        <td>{{ formatCurrency(data.Total) }}</td>
                        <td class="action">
                            <select
                                name="action"
                                id="action"
                                class="form-select"
                                v-model="selectedActions[index]"
                            >
                                <option value="" hidden selected>
                                    Pilih Action
                                </option>
                                <option
                                    v-for="status in dataStatus"
                                    :key="status.Kode_Status"
                                    :value="status.Kode_Status"
                                >
                                    {{ status.Keterangan }}
                                </option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Buttons Section -->
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary" @click="save">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2"; // Ensure SweetAlert2 is imported
import {
    SRV_URL,
    NAMA_API_RAW_MATERIAL,
    kodePerusahaan,
} from "../helpers/shared_value";
import { NAMA_API_EXPEDITION } from "../helpers/shared_value";

export default {
    props: {
        dataKendaraan: Array,
        dataKota: Array,
        dataStatus: Array,
        dataApproval: Array,
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
                asal: "",
                tujuan: "",
                jenisKendaraan: "",
                harga: "",
            },
            data: {
                noTransaksi: this.dataFaktur || "",
                tanggal: this.getTodayDate(),
            },
            filteredItemsAsal: [],
            filteredItemsTujuan: [],
            selectedActions: {},
            filteredDataTable: [],
            showAsalDropdown: false,
            showTujuanDropdown: false,
            debounceTimeout: null,
        };
    },
    created() {
        this.initializeData();
    },
    methods: {
        initializeData() {
            this.filteredDataTable = [...this.dataApproval];
        },
        getTodayDate() {
            const date = new Date();
            const day = String(date.getDate()).padStart(2, "0");
            const month = date.toLocaleString("default", { month: "short" });
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        },
        onVehicleChange() {
            this.filters.asal = "";
            this.filters.tujuan = "";
            this.filteredItemsAsal = [];
            this.filteredItemsTujuan = [];
            this.applyFilters();
        },
        filterItemsAsal() {
            clearTimeout(this.debounceTimeout);
            this.showAsalDropdown = true;

            this.debounceTimeout = setTimeout(() => {
                const searchTerm = this.filters.asal.toLowerCase().trim();
                if (searchTerm) {
                    this.filteredItemsAsal = this.dataKota
                        .filter((kota) =>
                            kota.nama_kabupaten_kota
                                .toLowerCase()
                                .includes(searchTerm)
                        )
                        .slice(0, 10); // Limit to 10 results for better performance
                } else {
                    this.filteredItemsAsal = [];
                }
            }, 300);
        },
        filterItemsTujuan() {
            clearTimeout(this.debounceTimeout);
            this.showTujuanDropdown = true;

            this.debounceTimeout = setTimeout(() => {
                const searchTerm = this.filters.tujuan.toLowerCase().trim();
                if (searchTerm) {
                    this.filteredItemsTujuan = this.dataKota
                        .filter((kota) =>
                            kota.nama_kabupaten_kota
                                .toLowerCase()
                                .includes(searchTerm)
                        )
                        .slice(0, 10);
                } else {
                    this.filteredItemsTujuan = [];
                }
            }, 300);
        },
        handleBlurAsal() {
            setTimeout(() => {
                this.showAsalDropdown = false;
            }, 200);
        },
        handleBlurTujuan() {
            setTimeout(() => {
                this.showTujuanDropdown = false;
            }, 200);
        },
        selectItemAsal(selectedItem) {
            this.filters.asal = selectedItem.nama_kabupaten_kota;
            this.filteredItemsAsal = [];
            this.showAsalDropdown = false;
            this.applyFilters();
        },
        selectItemTujuan(selectedItem) {
            this.filters.tujuan = selectedItem.nama_kabupaten_kota;
            this.filteredItemsTujuan = [];
            this.showTujuanDropdown = false;
            this.applyFilters();
        },
        applyFilters() {
            // Start with the original data
            let filteredData = [...this.dataApproval];

            // Apply vehicle filter
            if (this.filters.jenisKendaraan) {
                filteredData = filteredData.filter(
                    (item) =>
                        item.JenisKendaraan === this.filters.jenisKendaraan
                );
            }

            // Apply origin filter
            if (this.filters.asal) {
                filteredData = filteredData.filter((item) =>
                    item.Asal.toLowerCase().includes(
                        this.filters.asal.toLowerCase()
                    )
                );
            }

            // Apply destination filter
            if (this.filters.tujuan) {
                filteredData = filteredData.filter((item) =>
                    item.Tujuan.toLowerCase().includes(
                        this.filters.tujuan.toLowerCase()
                    )
                );
            }

            // Apply price sorting
            if (this.filters.harga) {
                filteredData.sort((a, b) => {
                    const comparison = a.Tarif - b.Tarif;
                    return this.filters.harga === "DESC"
                        ? -comparison
                        : comparison;
                });
            }

            this.filteredDataTable = filteredData;
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
            }).format(value);
        },
        async save() {
            try {
                this.isLoading = true;

                const formData = new FormData();

                // Append basic information
                formData.append("Kode_Perusahaan", "001");
                formData.append("ID_User", this.UserId);
                formData.append("Auth_SP", this.AuthSP);
                formData.append("Nama_Api", NAMA_API_EXPEDITION);
                formData.append("No_Approval", this.dataFaktur);

                // Prepare and append approval details as JSON
                const approvalDetails = this.filteredDataTable
                    .map((item, index) => {
                        if (this.selectedActions[index]) {
                            return {
                                No_Transaksi: item.NoTransaksi,
                                NoUrut: item.NoUrut,
                                action: this.selectedActions[index],
                                JenisKendaraan: item.JenisKendaraan,
                                Ekspedisi: item.Ekspedisi,
                                Asal: item.Asal,
                                Tujuan: item.Tujuan,
                                MataUang: item.MataUang,
                                Tarif: item.Tarif,
                                BiayaLain: item.BiayaLain,
                                Total: item.Total,
                            };
                        }
                        return null;
                    })
                    .filter((item) => item !== null);

                formData.append(
                    "approval_details",
                    JSON.stringify(approvalDetails)
                );

                const response = await axios.post(
                    `${SRV_URL}approval_expedition/simpan_approval_compare`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                if (response.data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Data berhasil disimpan",
                        confirmButtonText: "OK",
                    });

                    this.selectedActions = {};
                    this.$emit("save-success", response.data);
                } else {
                    throw new Error(
                        response.data.message || "Gagal menyimpan data"
                    );
                }
            } catch (error) {
                console.error("Save Error:", error);

                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text:
                        error.message ||
                        "Terjadi kesalahan saat menyimpan data",
                    confirmButtonText: "OK",
                });
            } finally {
                this.isLoading = false;
            }
        },
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.applyFilters();
            },
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
.recommendations {
    position: absolute; /* Make the dropdown position absolute */
    z-index: 1000; /* Ensure it appears above the table */
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    list-style-type: none;
    padding: 0;
    margin: 0;
    border-radius: 4px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.recommendations li {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.recommendations li:hover {
    background-color: #f0f0f0;
}
</style>
