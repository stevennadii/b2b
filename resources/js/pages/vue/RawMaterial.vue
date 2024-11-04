<template>
    <div class="container quotation-card">
        <div class="quotation-header">
            <h3 class="mb-2">Create Quotation | Raw Material</h3>
            <div class="row">
                <div class="col-md-3">
                    <p class="ms-1 mb-2">Select Company</p>
                    <select
                        class="form-select"
                        v-model="KodeSupplier"
                        @change="fetchBarang"
                        :disabled="
                            isProductSelected || dataPerusahaan.length === 1
                        "
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
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Transaction Number</label>
                        <input
                            type="text"
                            v-model="transactionNumber"
                            class="form-control"
                            disabled
                        />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Date</label>
                        <input
                            type="text"
                            id="date"
                            v-model="date"
                            disabled
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Quotation Number</label>
                        <input
                            type="text"
                            v-model="offerNumber"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Type Of Shipment</label>
                        <select v-model="deliveryType" class="form-select">
                            <option value="" hidden selected>
                                Select a Shipment
                            </option>
                            <option
                                v-for="jenisPengiriman in dataJenisPengiriman"
                                :key="jenisPengiriman.Id_Jenis_Pengiriman"
                                :value="jenisPengiriman.Id_Jenis_Pengiriman"
                            >
                                {{ jenisPengiriman.Kode_Pengiriman }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th hidden>Product Code</th>
                        <th hidden>Code Stock Owner</th>
                        <th style="width: 25%">Product Name</th>
                        <th>MOQ</th>
                        <th style="width: 20%">Unit Of Measurement</th>
                        <th>Price</th>
                        <!-- <th>Total</th> -->
                        <th style="width: 13%">Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td hidden>
                            <input
                                v-model="item.code"
                                class="form-control text-wrap"
                            />
                        </td>
                        <td hidden>
                            <input
                                v-model="item.code_stock_owner"
                                class="form-control text-wrap"
                            />
                        </td>
                        <td>
                            <input
                                v-model="item.name"
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

                        <td>
                            <input
                                v-model="item.moq"
                                type="number"
                                class="form-control text-wrap"
                            />
                        </td>
                        <td>
                            <select
                                v-model="item.unit"
                                class="form-select text-wrap"
                            >
                                <option
                                    v-for="satuan in dataSatuan"
                                    :key="satuan.id_satuan"
                                    :value="satuan.id_satuan"
                                >
                                    {{ satuan.kode_satuan }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <input
                                v-model="item.price"
                                type="number"
                                class="form-control text-wrap"
                            />
                        </td>

                        <td>
                            <select
                                v-model="item.status"
                                class="form-select text-wrap"
                            >
                                <option value="Ready">Ready</option>
                                <option value="Indent">Indent</option>
                            </select>
                        </td>
                        <td>
                            <input
                                v-model="item.notes"
                                class="form-control text-wrap"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <button class="btn btn-primary mb-3 mt-2" @click="addItem">
                + Add Product
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Offer Validity Date</label>
                    <div
                        class="d-flex align-items-center justify-content-center"
                    >
                        <input
                            type="date"
                            v-model="validFrom"
                            class="form-control me-2 px-1"
                        />
                        <span>s/d</span>
                        <input
                            type="date"
                            v-model="validTo"
                            class="form-control ms-2"
                        />
                    </div>
                    <div class="form-group">
                        <label class="mt-2">Upload File</label>
                        <input
                            type="file"
                            class="form-control"
                            @change="handleFileUpload"
                        />
                    </div>
                    <div class="form-group">
                        <label class="mt-2">Notes</label>
                        <input
                            type="textarea"
                            v-model="description"
                            class="form-control"
                        />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="mb-2">Shipping Method</label>
                    <select v-model="shippingMethod" class="form-select">
                        <option value="">Select a Shipping</option>
                        <option
                            v-for="caraKirim in dataCaraKirim"
                            :key="caraKirim.Id_Cara_Kirim"
                            :value="caraKirim.Id_Cara_Kirim"
                        >
                            {{ caraKirim.Keterangan }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="mt-2">Additional Costs</label>
                    <input
                        type="number"
                        v-model="shippingCost"
                        class="form-control"
                        :disabled="!includeShipping"
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
        dataJenisPengiriman: Array,
        dataSatuan: Array,
        dataSupplier: Array,
        dataFaktur: Object,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
    },
    data() {
        return {
            KodeSupplier: "",
            supplierData: [],
            transactionNumber: this.dataFaktur,
            date: "",
            formattedDate: "",
            offerNumber: "",
            deliveryType: "",
            validFrom: "",
            validTo: "",
            description: "",
            shippingMethod: "",
            shippingCost: 0,
            includeShipping: false,
            items: [],
            file: null,
            isLoading: false,
        };
    },
    mounted() {
        this.getTodayDate();
        if (this.dataPerusahaan.length > 0) {
            this.KodeSupplier = this.dataPerusahaan[0].KodeSupplier;
            this.fetchBarang();
        }
    },
    computed: {
        isProductSelected() {
            return this.items.some((item) => item.name !== "");
        },
        isCompanySelected() {
            return this.KodeSupplier !== ""; // KodeSupplier harus terisi
        },
    },

    methods: {
        async fetchBarang() {
            try {
                const response = await axios.post(
                    `${SRV_URL}raw_material/get_supplier`,
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
                            Authorization: `Bearer ${this.Token}`, // Gunakan token dari props
                        },
                    }
                );
                console.log(response);
                if (response.data.data.status === 200) {
                    this.supplierData = response.data.data.data; // Menyimpan data yang diterima dari API ke variabel lokal
                    console.log(
                        "Data fetched successfully:",
                        this.supplierData
                    );
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
        },
        getTodayDate() {
            const date = new Date();
            const options = { day: "numeric", month: "short", year: "numeric" };
            this.date = new Intl.DateTimeFormat("en-GB", options).format(date);
        },
        filterItems(currentItem, index) {
            const searchTerm = currentItem.name.toLowerCase();

            if (searchTerm.length < 3) {
                this.items[index].filteredItems = [];
                this.items[index].code = ""; // Clear kode barang

                return;
            }

            this.items[index].filteredItems = this.supplierData
                .filter((supplierItem) =>
                    supplierItem.NamaBarang.toLowerCase().includes(searchTerm)
                )
                .map((supplierItem) => ({
                    name: supplierItem.NamaBarang,
                    code: supplierItem.KodeBarang,
                    code_stock_owner: supplierItem.KodeStockOwner,
                }));
        },

        selectItem(selectedItem, index) {
            // Set nama dan kode barang berdasarkan item yang dipilih
            this.items[index].name = selectedItem.name;
            this.items[index].code = selectedItem.code; // Isi kode barang
            this.items[index].code_stock_owner = selectedItem.code_stock_owner; // Isi kode barang

            this.items[index].filteredItems = [];
        },

        addItem() {
            this.items.push({
                type: "",
                code: "",
                name: "",
                code_stock_owner: "",
                moq: 0,
                unit: "Kg",
                price: 0,
                total: 0,
                status: "Ready",
                notes: "",
            });
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        async save() {
            const formData = new FormData();
            formData.append("Kode_Perusahaan", kodePerusahaan);
            formData.append("ID_User", this.UserId);
            formData.append("Auth_SP", this.AuthSP);
            formData.append("Nama_Api", NAMA_API_RAW_MATERIAL);
            formData.append("Kode_Supplier", this.KodeSupplier);
            formData.append("date", this.date);
            formData.append("offerNumber", this.offerNumber);
            formData.append("deliveryType", this.deliveryType);
            formData.append("validFrom", this.validFrom);
            formData.append("validTo", this.validTo);
            formData.append("shippingMethod", this.shippingMethod);
            formData.append("shippingCost", this.shippingCost);
            formData.append("description", this.description);
            formData.append("Flag", this.$props.dataFaktur.Flag);
            formData.append("File", this.file); // Append the file if uploaded
            formData.append("items", JSON.stringify(this.items)); // Convert items array to JSON string

            try {
                this.isLoading = true;
                const response = await axios.post(
                    `${SRV_URL}raw_material/simpan_raw_material`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.Token}`, // Include token if necessary
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
        },

        reset() {
            // Manually reset all properties to their default values
            this.transactionNumber = this.dataFaktur;
            this.offerNumber = "";

            this.validFrom = "";
            this.validTo = "";
            this.description = "";
            this.shippingMethod = "";
            this.shippingCost = 0;
            this.includeShipping = false;
            this.items = [];
            this.file = null;
            this.isLoading = false;
        },
    },
};
</script>

<style scoped>
.quotation-card {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    max-width: 100%;
    margin: 0 auto;
}

.quotation-header {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.header-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 20px;
}

.add-item-btn {
    align-self: flex-start;
    padding: 10px 15px;
    background-color: #007bff;
    border: none;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

.item-table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
}

.item-table th,
.item-table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
    word-wrap: inherit !important;
    white-space: normal;
}

.bottom-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.bottom-section .form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.action-buttons {
    grid-column: 1 / span 3;
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    margin-top: 20px;
}

button {
    padding: 10px 15px;

    border: none;
    color: #fff;
    border-radius: 4px;
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
}

.recommendations li {
    padding: 10px;
    cursor: pointer;
}

.recommendations li:hover {
    background-color: #f0f0f0;
}
</style>
