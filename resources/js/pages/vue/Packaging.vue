<template>
    <div class="quotation-card table-responsive">
        <div class="quotation-header">
            <h5>Create Quotations | Packaging</h5>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3 mt-3">
                <p class="ms-1 mb-2">Select Company</p>
                <select
                    class="form-select"
                    v-model="KodeSupplier"
                    @change="fetchBarang"
                    :disabled="isDropdownDisabled"
                >
                    <option
                        v-for="(data, index) in dataPerusahaan"
                        :key="data.KodeSupplier"
                        :value="data.KodeSupplier"
                        selected
                    >
                        {{ data.NamaPerusahaan }}
                    </option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Transaction Details -->
            <div class="col">
                <label for="transaction-no">Transaction Number</label>
                <input
                    type="text"
                    id="transaction-no"
                    v-model="data.noTransaksi"
                    disabled
                />
            </div>
            <div class="col">
                <label for="date">Date</label>
                <input type="text" id="date" v-model="data.tanggal" disabled />
            </div>
            <div class="col">
                <label for="quotation-no">Quotation Number</label>
                <input
                    type="text"
                    id="quotation-no"
                    v-model="data.noPenawaran"
                />
            </div>
        </div>
        <div class="quotation-content">
            <table>
                <thead>
                    <tr>
                        <th hidden>Product Code</th>
                        <th hidden>Kode Stock Owner</th>
                        <th>Product Name</th>
                        <th>Dimension (ρ x l x t)</th>
                        <th>Diameter</th>
                        <th>Thickness</th>
                        <th>MOQ</th>
                        <th>Unit Of Measure</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Spesification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in data.barang" :key="index">
                        <td hidden>
                            <input
                                type="text"
                                v-model="item.kodeBarang"
                                class="wide-input"
                                disabled
                            />
                        </td>
                        <td hidden>
                            <input
                                type="text"
                                v-model="item.kodeStockOwner"
                                class="wide-input"
                                disabled
                            />
                        </td>
                        <td style="width: 15%">
                            <input
                                v-model="item.namaBarang"
                                class="form-control text-wrap"
                                @input="filterItems(item, index)"
                                :disabled="!isCompanySelected"
                                placeholder="Type the item name..."
                            />
                            <ul
                                v-if="
                                    item.filteredItems &&
                                    item.filteredItems.length > 0
                                "
                                class="recommendations"
                            >
                                <li
                                    v-for="(
                                        filteredItem, fiIndex
                                    ) in item.filteredItems"
                                    :key="fiIndex"
                                    @click="selectItem(filteredItem, index)"
                                >
                                    {{ filteredItem.name }}
                                </li>
                            </ul>
                        </td>
                        <td style="width: 11%">
                            <div
                                style="
                                    display: flex;
                                    gap: 5px;
                                    white-space: nowrap;
                                "
                            >
                                <input
                                    type="number"
                                    v-model="item.panjang"
                                    placeholder="ρ"
                                    class="wide-input"
                                />
                                <input
                                    type="number"
                                    v-model="item.lebar"
                                    placeholder="l"
                                    class="wide-input"
                                />
                                <input
                                    type="number"
                                    v-model="item.tinggi"
                                    placeholder="t"
                                    class="wide-input"
                                />
                            </div>
                        </td>

                        <td>
                            <input
                                type="number"
                                v-model="item.diameter"
                                class="wide-input"
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="item.ketebalan"
                                class="wide-input"
                            />
                        </td>
                        <td style="width: 9%">
                            <input
                                type="number"
                                v-model="item.moq"
                                class="wide-input"
                            />
                        </td>
                        <td style="width: 11%">
                            <select v-model="item.satuan" class="wide-input">
                                <option value="" selected hidden>
                                    Select UoM
                                </option>
                                <option
                                    v-for="(item, index) in dataSatuan"
                                    :key="item.id_satuan"
                                    :value="item.id_satuan"
                                >
                                    {{ item.Keterangan }}
                                </option>
                            </select>
                        </td>
                        <td style="width: 13%">
                            <input
                                type="number"
                                v-model="item.harga"
                                class="wide-input"
                            />
                        </td>
                        <td style="width: 10%">
                            <select v-model="item.status" class="wide-input">
                                <option>Indent</option>
                                <option>Ready</option>
                            </select>
                        </td>
                        <td style="width: 16%">
                            <input
                                type="text"
                                v-model="item.notes"
                                class="wide-input"
                            />
                        </td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger text-center"
                                @click="removeItem(index)"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Tombol Tambah Barang -->
            <button
                type="button"
                class="btn btn-primary mt-3 form-control"
                @click="addItem"
            >
                Tambah Barang
            </button>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Offer Validity Date</label>
                        <div class="d-flex align-items-center">
                            <input
                                type="date"
                                v-model="data.tanggalBerlaku"
                                class="form-control me-2"
                            />
                            <span>s/d</span>
                            <input
                                type="date"
                                v-model="data.tanggalSelesai"
                                class="form-control ms-2"
                            />
                        </div>
                        <div class="form-group">
                            <label class="mt-2">Upload File</label>
                            <input
                                type="file"
                                @change="onFileChange"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label class="mt-2">Notes</label>
                            <input
                                type="textarea"
                                v-model="data.keterangan"
                                class="form-control"
                            />
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="mb-2">Shipping Method</label>
                        <select class="form-select" v-model="data.caraKirim">
                            <option value="" selected hidden>
                                Select a Shipping
                            </option>
                            <option
                                v-for="(item, index) in dataCaraKirim"
                                :key="item.Id_Cara_Kirim"
                                :value="item.Id_Cara_Kirim"
                            >
                                {{ item.Keterangan }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="mt-2">Additional Costs</label>
                        <input
                            type="number"
                            v-model="data.biayaKirim"
                            class="form-control"
                            :disabled="!includeShipping"
                        />

                        <label class="mt-2">Film Costs</label>
                        <input
                            type="number"
                            v-model="data.biayaFilm"
                            class="form-control"
                            :disabled="!includeFilm"
                        />

                        <div class="form-check mt-2">
                            <input
                                type="checkbox"
                                v-model="includeShipping"
                                class="form-check-input"
                            />
                            <label class="form-check-label"
                                >Include Additional Costs</label
                            >
                        </div>

                        <div class="form-check mt-2">
                            <input
                                type="checkbox"
                                v-model="includeFilm"
                                class="form-check-input"
                            />
                            <label class="form-check-label"
                                >Include Film Printing</label
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <button
                        type="button"
                        class="btn btn-primary form-control mb-3"
                        @click="save"
                    >
                        Save
                    </button>
                </div>
                <div class="col-md-6">
                    <button
                        type="button"
                        class="btn reset-btn form-control"
                        @click="reset"
                    >
                        Reset
                    </button>
                </div>
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
        dataPerusahaan: Array,
        dataCaraKirim: Array,
        dataSatuan: Array,
        dataBarang: Array,
        dataFaktur: Object,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        KodeSupplier: Object,
    },
    mounted() {
        this.getTodayDate();
        if (this.dataPerusahaan.length > 0) {
            // Set default company to the first one in the list
            this.KodeSupplier = this.dataPerusahaan[0].KodeSupplier;
            this.fetchBarang(); // Fetch items for the default company
        }
    },

    computed: {
        isProductSelected() {
            // Mengembalikan true jika ada item yang memiliki nama produk terisi
            return this.items.some((item) => item.namaBarang !== "");
        },
        isCompanySelected() {
            return this.KodeSupplier !== ""; // KodeSupplier harus terisi
        },
    },
    data() {
        return {
            KodeSupplier: "",
            supplierData: [],
            data: {
                noTransaksi: this.dataFaktur,
                noPenawaran: "",
                tanggal: "",
                barang: [
                    {
                        kodeBarang: "",
                        kodeStockOwner: "",
                        namaBarang: "",
                        panjang: "",
                        lebar: "",
                        tinggi: "",
                        diameter: "",
                        ketebalan: "",
                        moq: "",
                        satuan: "",
                        harga: "",
                        notes: "",
                        status: "Indent",
                    },
                ],
                tanggalBerlaku: "",
                tanggalSelesai: "",
                caraKirim: "",
                biayaKirim: "",
                biayaFilm: "",
                includeShipping: false,
                includeFilm: false,
                keterangan: "",
            },
            isDropdownDisabled: false,
            includeShipping: false,
            includeFilm: false,
        };
    },
    watch: {
        "data.barang": {
            handler(newItems) {
                this.isDropdownDisabled = newItems.some(
                    (item) => item.namaBarang.length > 0
                );
            },
            deep: true,
        },
    },
    methods: {
        async fetchBarang() {
            try {
                const response = await axios.post(
                    `${SRV_URL}packaging/get_supplier`,
                    {
                        kodeSupplier: this.KodeSupplier,
                        kode_perusahaan: kodePerusahaan,
                        id_user: this.UserId,
                        auth_sp: this.AuthSP,
                        nama_api: NAMA_API_RAW_MATERIAL,
                        version: "1.0.0",
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                if (response.data.data.status === 200) {
                    this.supplierData = response.data.data.data;
                } else {
                    console.error(
                        "Failed to fetch data:",
                        response.data.message
                    );
                }
            } catch (error) {
                console.error(
                    "Error fetching data:",
                    error.response ? error.response.data.message : error.message
                );
            }
            // console.log(this.filteredBarang);
        },
        getTodayDate() {
            const date = new Date();
            const options = { day: "numeric", month: "short", year: "numeric" };
            this.data.tanggal = new Intl.DateTimeFormat(
                "en-GB",
                options
            ).format(date);
        },
        onFileChange(event) {
            const file = event.target.files[0];
            // Handle file upload
        },
        filterItems(item, index) {
            const searchTerm = item.namaBarang.toLowerCase();
            if (searchTerm.length < 3) {
                this.data.barang[index].filteredItems = [];
                this.data.barang[index].code = ""; // Clear kode barang
                return;
            }

            // Filter supplier data based on search term
            this.data.barang[index].filteredItems = this.supplierData
                .filter((supplierItem) =>
                    supplierItem.NamaBarang.toLowerCase().includes(searchTerm)
                )
                .map((supplierItem) => ({
                    name: supplierItem.NamaBarang,
                    code: supplierItem.KodeBarang,
                    stockOwner: supplierItem.KodeStockOwner,
                    groupType: supplierItem.Kode_Group_Jenis,
                }));
        },

        selectItem(filteredItem, index) {
            // Set selected item properties in the row based on clicked suggestion
            this.data.barang[index].namaBarang = filteredItem.name;
            this.data.barang[index].kodeBarang = filteredItem.code;
            this.data.barang[index].kodeStockOwner = filteredItem.stockOwner;

            this.data.barang[index].filteredItems = []; // Clear filtered items list
        },
        async save() {
            const formData = new FormData();
            const now = new Date();
            const jam = now
                .toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: false,
                })
                .replace(":", ":");
            formData.append("Kode_Perusahaan", kodePerusahaan);
            formData.append("ID_User", this.UserId);
            formData.append("Auth_SP", this.AuthSP);
            formData.append("Nama_Api", NAMA_API_RAW_MATERIAL);
            formData.append("Kode_Supplier", this.KodeSupplier);
            // Append data yang diperlukan ke formData
            formData.append("noTransaksi", this.data.noTransaksi); // Menyimpan noTransaksi
            formData.append("noPenawaran", this.data.noPenawaran); // Menyimpan noPenawaran
            formData.append("tanggal", this.data.tanggal); // Menyimpan tanggal
            formData.append("jam", jam); // Menyimpan tanggal
            formData.append("tanggalBerlaku", this.data.tanggalBerlaku); // Tanggal berlaku penawaran
            formData.append("tanggalSelesai", this.data.tanggalSelesai); // Tanggal selesai penawaran
            formData.append("caraKirim", this.data.caraKirim); // Cara kirim
            formData.append("biayaKirim", this.data.biayaKirim); // Biaya kirim
            formData.append("biayaFilm", this.data.biayaFilm); // Biaya kirim
            formData.append("includeShipping", this.includeShipping ? 1 : 0); // Include biaya kirim
            formData.append("includeFilm", this.includeFilm ? 1 : 0); // Include cetak film
            formData.append("keterangan", this.data.keterangan); // Keterangan

            this.data.barang.forEach((item, index) => {
                formData.append(
                    `barang[${index}][kodeBarang]`,
                    item.kodeBarang
                );
                formData.append(
                    `barang[${index}][namaBarang]`,
                    item.namaBarang
                );
                formData.append(
                    `barang[${index}][kodeStockOwner]`,
                    item.kodeStockOwner
                );
                formData.append(`barang[${index}][panjang]`, item.panjang);
                formData.append(`barang[${index}][lebar]`, item.lebar);
                formData.append(`barang[${index}][tinggi]`, item.tinggi);
                formData.append(`barang[${index}][diameter]`, item.diameter);
                formData.append(`barang[${index}][ketebalan]`, item.ketebalan);
                formData.append(`barang[${index}][moq]`, item.moq);
                formData.append(`barang[${index}][satuan]`, item.satuan);
                formData.append(`barang[${index}][harga]`, item.harga);
                formData.append(`barang[${index}][status]`, item.status);
                formData.append(`barang[${index}][notes]`, item.notes);
            });

            try {
                // Tampilkan indikator loading
                this.isLoading = true;

                // Kirim data ke server dengan axios POST
                const response = await axios.post(
                    `${SRV_URL}packaging/simpan_packaging`, // Endpoint URL
                    formData, // Data yang akan dikirim
                    {
                        headers: {
                            "Content-Type": "multipart/form-data", // Menggunakan multipart/form-data
                            Authorization: `Bearer ${this.Token}`, // Sertakan token authorization jika diperlukan
                        },
                    }
                );

                if (response.data.status === "success") {
                    Swal.fire({
                        title: "Success",
                        text: "Data berhasil disimpan!",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                    location.reload(); // Reset form setelah berhasil
                } else {
                    // Tampilkan pesan error dari server jika gagal
                    Swal.fire({
                        title: "Error",
                        text: response.data.message || "Data gagal disimpan!",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            } catch (error) {
                // Tampilkan error dari response
                Swal.fire({
                    title: "Error",
                    text: error.response?.data?.message || error.message,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            } finally {
                // Selesai loading
                this.isLoading = false;
            }
        },

        addItem() {
            this.data.barang.push({
                kodeBarang: "",
                namaBarang: "",

                panjang: "",
                lebar: "",
                tinggi: "",
                diameter: "",
                ketebalan: "",
                moq: "",
                satuan: "",
                harga: "",
                notes: "",
                status: "Indent",
            });
        },
        removeItem(index) {
            this.data.barang.splice(index, 1);
        },
    },
};
</script>

<style scoped>
.quotation-card {
    padding: 20px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.quotation-content {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 8px;
    border-radius: 3px;
    border: 1px solid #ccc;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    text-wrap: nowrap;
}

table th,
table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

button {
    padding: 10px 20px;
    margin-right: 10px;
    border: none;
    border-radius: 3px;

    color: white;
    cursor: pointer;
}

.reset-btn {
    background-color: #f0ad4e;
    color: black;
}

.recommendations {
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    list-style-type: none;
    padding: 0;
    margin: 0;
    text-wrap: nowrap;
    text-align: left;
    padding: 7px;
}

.recommendations li {
    padding: 5px;
    cursor: pointer;
}

.recommendations li:hover {
    background-color: #f0f0f0;
}
</style>
