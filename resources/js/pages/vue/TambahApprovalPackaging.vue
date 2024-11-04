<template>
    <div class="quotation-card">
        <!-- Header Section -->
        <div class="quotation-header mb-3">
            <h5>Approval Packaging | Detail</h5>
            <hr />
        </div>

        <!-- Filters Section -->
        <div
            class="filters d-flex justify-content-between align-items-center mb-3"
        >
            <div class="filter-items d-flex align-items-center">
                <!-- <div class="filter-item">
                    <label for="Supplier">Supplier</label>
                    <select
                        id="jenis-kendaraan"
                        v-model="filters.supplier"
                        class="px-3"
                    >
                        <option disabled value="">Pilih Supplier</option>
                        <option value="Prima Fresh">Prima Fresh</option>
                        <option value="Supplier 2">Supplier 2</option>
                    </select>
                </div> -->

                <div class="filter-item ml-2">
                    <label for="name">Nama Barang</label>
                    <select id="name" v-model="filters.name" class="px-3">
                        <option disabled value="" hidden>
                            Pilih Nama Barang
                        </option>
                        <option
                            v-for="data in dataBarang"
                            :key="data.Nama"
                            :value="data.Nama"
                        >
                            {{ data.Nama }}
                        </option>
                    </select>
                </div>

                <div class="filter-item ml-2">
                    <label for="price">Harga</label>
                    <select id="price" v-model="filters.price" class="px-3">
                        <option disabled value="" hidden>Pilih Harga</option>
                        <option value="ASC">Low Price</option>
                        <option value="DESC">High Price</option>
                    </select>
                </div>
                <div class="filter-item ml-2">
                    <label for="statuss">Status</label>
                    <select id="statuss" v-model="filters.status" class="px-3">
                        <option disabled value="" hidden>Pilih Status</option>
                        <option value="Ready">Ready</option>
                        <option value="Indent">Indent</option>
                    </select>
                </div>
            </div>

            <!-- Right-aligned controls -->
            <div class="right-controls d-flex align-items-center">
                <input
                    type="text"
                    class="py-2 mr-2 me-3 text-center"
                    v-model="data.noApproval"
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
                        <th>Nama Barang</th>
                        <th>MOQ</th>
                        <th>Satuan</th>
                        <th>Mata Uang</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Prioritas</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredData" :key="index">
                        <td hidden>{{ item.NoUrut }}</td>
                        <td>{{ item.NoPenawaran }}</td>
                        <td>{{ item.NamaBarang }}</td>
                        <td>
                            {{
                                parseFloat(data["MOQ"]) ===
                                parseInt(data["MOQ"])
                                    ? parseInt(data["MOQ"])
                                    : item["MOQ"]
                            }}
                        </td>
                        <td>{{ item.Satuan }}</td>
                        <td>IDR</td>
                        <td>
                            {{
                                new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                }).format(item["Harga"])
                            }}
                        </td>
                        <td>{{ item.Id_Status }}</td>
                        <td>{{ item.Spesifikasi }}</td>
                        <td>{{ index + 1 }}</td>
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
        <div class="buttons mt-3">
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
export default {
    props: {
        dataBarang: Array,
        dataApproval: Array,
        dataStatus: Array,
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
                status: "",
                name: "",
                price: "",
            },
            data: {
                noApproval: this.dataFaktur || "",
                tanggal: this.tanggal || this.getTodayDate(),
            },

            selectedActions: {},
            filteredDataApproval: [],
        };
    },
    watch: {
        "filters.name": function () {
            this.applyFilter();
            // console.log(this.filteredData);
        },
        "filters.price": function () {
            this.applyFilter();
        },
        "filters.status": function () {
            this.applyFilter();
        },
    },
    computed: {
        filteredData() {
            return this.filteredDataApproval;
        },
    },

    methods: {
        async save() {
            // Kumpulkan data yang memiliki action diisi
            const dataToSave = this.filteredDataApproval
                .map((item, index) => ({
                    ...item,
                    action: this.selectedActions[index],
                }))
                .filter((item) => item.action); // Filter hanya yang ada action

            // Buat objek FormData
            const formData = new FormData();

            // Tambahkan setiap item dalam dataToSave ke formData
            dataToSave.forEach((item, index) => {
                formData.append(
                    `data[${index}][NoTransaksi]`,
                    item.NoTransaksi
                );
                formData.append(
                    `data[${index}][NoPenawaran]`,
                    item.NoPenawaran
                );
                formData.append(`data[${index}][KodeBarang]`, item.KodeBarang);
                formData.append(`data[${index}][NoUrut]`, item.NoUrut);
                formData.append(`data[${index}][action]`, item.action); // action dari dropdown
            });

            // Tambahkan parameter tambahan ke FormData jika diperlukan
            formData.append("NamaAPI", NAMA_API_RAW_MATERIAL);
            formData.append("KodePerusahaan", kodePerusahaan);
            formData.append("AuthSP", this.AuthSP);
            formData.append("UserId", this.UserId);
            formData.append("Token", this.Token);
            formData.append("Lokasi", this.Lokasi);
            formData.append("noApproval", this.data.noApproval);

            // Kirim formData ke API menggunakan axios
            try {
                this.isLoading = true;
                const response = await axios.post(
                    `${SRV_URL}approval_packaging/simpan_approval_compare`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.Token}`, // Include token if necessary
                        },
                    }
                );
                // console.log(response.data);
                if (response.data.status === "success") {
                    Swal.fire({
                        title: "Success",
                        text: "Data Saved Successfully!",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.data.message || "Data gagal disimpan!",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            } catch (error) {
                // Handle error response
                Swal.fire({
                    title: "Error",
                    text: error.response?.data?.message || error.message,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            } finally {
                // Set loading back to false
                this.isLoading = false;
            }
            // Debugging FormData
        },
        getTodayDate() {
            const date = new Date();
            const day = String(date.getDate()).padStart(2, "0");
            const month = date.toLocaleString("default", { month: "short" });
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        },
        applyFilter() {
            // Filter data hanya jika nama barang diisi
            let filtered = this.filters.name // v-model barang
                ? this.dataApproval.filter((item) => {
                      const matchesName = item.NamaBarang === this.filters.name;
                      const matchesStatus = this.filters.status
                          ? item.Id_Status === this.filters.status
                          : true;
                      return matchesName && matchesStatus;
                  })
                : [];

            // Urutkan berdasarkan harga jika filter harga diisi
            if (this.filters.price) {
                filtered = filtered.sort((a, b) => {
                    return this.filters.price === "ASC"
                        ? a.Harga - b.Harga // Ascending untuk termurah
                        : b.Harga - a.Harga; // Descending untuk termahal
                });
            }

            this.filteredDataApproval = filtered;
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
