<template>
    <div class="quotation-card">
        <div class="quotation-header">
            <h5>Create Quotations | Freight Quotation</h5>
            <hr />
        </div>
        <div class="form-container">
            <div class="row">
                <!-- Transaction Details -->
                <div class="col">
                    <label for="transaction-no">Transaction No.</label>
                    <input
                        type="text"
                        id="transaction-no"
                        v-model="data.noTransaksi"
                        disabled
                    />
                </div>
                <div class="col">
                    <label for="date">Date</label>
                    <input
                        type="text"
                        id="date"
                        v-model="data.tanggal"
                        disabled
                    />
                </div>
                <div class="col">
                    <label for="quotation-no">Quotation No.</label>
                    <input
                        type="text"
                        id="quotation-no"
                        v-model="data.noPenawaran"
                    />
                </div>
            </div>

            <div class="row">
                <!-- Port and Destination -->
                <div class="col">
                    <label for="port-loading">Port of Loading</label>
                    <select id="port-loading" v-model="data.PelabuhanMuatan">
                        <option value="" disabled selected>
                            Select a port
                        </option>
                        <option
                            v-for="port in dataPelabuhanAsal"
                            :key="port.Id_Pelabuhan_Asal"
                            :value="port.Id_Pelabuhan_Asal"
                        >
                            {{ port.Keterangan }}
                        </option>
                    </select>
                </div>
                <div class="col">
                    <label for="destination">Destination</label>
                    <select id="destination" v-model="data.tujuan">
                        <option value="" disabled selected>
                            Select a destination
                        </option>
                        <option
                            v-for="tujuan in dataTujuan"
                            :key="tujuan.Id_Tujuan"
                            :value="tujuan.Id_Tujuan"
                        >
                            {{ tujuan.Keterangan }}
                        </option>
                    </select>
                </div>
                <div class="col">
                    <label for="container">Container</label>
                    <select id="container" v-model="data.container">
                        <option hidden selected value="">
                            Select a Container
                        </option>

                        <option
                            v-for="container in dataContainer"
                            :key="container.Id_Container"
                            :value="container.Id_Container"
                        >
                            {{ container.Keterangan }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Shipping Table -->
            <div class="card">
                <div class="card-body bg-light">
                    <div class="shipping-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Shipping Co.</th>

                                    <th>Currency</th>
                                    <th>Unit Price</th>
                                    <th>E.T.D</th>
                                    <th>E.T.A</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        pengiriman, index
                                    ) in dataPengiriman"
                                    :key="index"
                                >
                                    <td>
                                        <select
                                            v-model="
                                                data.selectedPengiriman[index]
                                            "
                                        >
                                            <option
                                                :key="
                                                    pengiriman.Kode_Pengiriman
                                                "
                                                :value="
                                                    pengiriman.Kode_Pengiriman
                                                "
                                            >
                                                {{ pengiriman.Kode_Pengiriman }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select v-model="data.currency[index]">
                                            <option value="" selected hidden>
                                                Select Currency
                                            </option>
                                            <option
                                                v-for="mataUang in dataMataUang"
                                                :key="mataUang.Kode_Mata_Uang"
                                                :value="mataUang.Kode_Mata_Uang"
                                            >
                                                {{ mataUang.Kode_Mata_Uang }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            v-model="data.price[index]"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="date"
                                            v-model="data.etd[index]"
                                            @change="validateETA(index)"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="date"
                                            v-model="data.eta[index]"
                                            @change="validateETA(index)"
                                        />
                                        <!-- Error message display for this row -->
                                        <span
                                            v-if="data.errorMessages[index]"
                                            class="error-message"
                                        >
                                            {{ data.errorMessages[index] }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="row">
                <div class="col-md-12">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        v-model="data.notes"
                        placeholder="Enter any notes here..."
                    ></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button class="btn-primary form-control" @click="save">
                    Save
                </button>
                <button class="reset-button form-control" @click="resetForm">
                    Reset
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import {
    SRV_URL,
    NAMA_API_RAW_MATERIAL,
    kodePerusahaan,
} from "../helpers/shared_value";

export default {
    props: {
        dataPelabuhanAsal: Array,
        dataTujuan: Array,
        dataMataUang: Array,
        dataContainer: Array,
        dataPengiriman: Array,
        dataFaktur: Object,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        KodeSupplier: Object,
    },
    data() {
        return {
            data: {
                noTransaksi: this.dataFaktur || "",
                tanggal: "",
                container: "",
                noPenawaran: "",
                PelabuhanMuatan: "",
                tujuan: "",
                notes: "",
                dataMataUang: [],
                selectedPengiriman: [],
                currency: [],
                price: [],
                etd: [],
                eta: [],
                errorMessages: [],
            },
        };
    },
    mounted() {
        this.getTodayDate();

        this.data.selectedPengiriman = this.dataPengiriman.map(
            (p) => p.Kode_Pengiriman
        );
        this.data.currency = this.dataPengiriman.map(() => "USD"); // Bisa sesuaikan dengan nilai default currency
    },
    methods: {
        validateETA(index) {
            const etdDate = new Date(this.data.etd[index]);
            const etaDate = new Date(this.data.eta[index]);

            // Format dates to 'd-M-Y' format
            const etdFormatted = etdDate.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });
            const etaFormatted = etaDate.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });

            if (isNaN(etdDate) || isNaN(etaDate)) {
                // Do nothing if invalid dates are provided
                return;
            }

            // Compare ETA and ETD dates
            if (etaDate < etdDate) {
                // Trigger SweetAlert2 popup if validation fails
                Swal.fire({
                    icon: "error",
                    title: "Invalid",
                    text: `ETA Cannot Be Earlier Than ETD .`,
                });

                // Optional: Prevent further action if needed
                this.$set(
                    this.data.errorMessages,
                    index,
                    `ETA Cannot Be Earlier Than ETD .`
                );
            } else {
                // Clear the error message if the dates are valid
                this.$set(this.data.errorMessages, index, "");
            }
        },
        async save() {
            // Validate if any error messages exist before proceeding
            const invalidETA = this.data.errorMessages.some(
                (msg) => msg !== ""
            );
            if (invalidETA) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Data",
                    text: "Please resolve all errors before saving.",
                });
                return;
            }

            const formData = new FormData();
            const now = new Date();
            const jam = now
                .toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: false,
                })
                .replace(":", ":");

            // Append basic form data
            formData.append("Kode_Perusahaan", kodePerusahaan);
            formData.append("ID_User", this.UserId);
            formData.append("Auth_SP", this.AuthSP);
            formData.append("Nama_Api", NAMA_API_RAW_MATERIAL);
            formData.append("noTransaksi", this.dataFaktur);
            formData.append("noPenawaran", this.data.noPenawaran);
            formData.append("container", this.data.container);
            formData.append("tanggal", this.data.tanggal);
            formData.append("jam", jam);
            formData.append("PelabuhanMuatan", this.data.PelabuhanMuatan);
            formData.append("tujuan", this.data.tujuan);
            formData.append("notes", this.data.notes);

            // Append shipping details from the items
            this.dataPengiriman.forEach((pengiriman, index) => {
                formData.append(
                    `items[${index}][Kode_Pengiriman]`,
                    this.data.selectedPengiriman[index]
                );
                formData.append(
                    `items[${index}][currency]`,
                    this.data.currency[index]
                );
                formData.append(
                    `items[${index}][price]`,
                    this.data.price[index]
                );
                formData.append(`items[${index}][etd]`, this.data.etd[index]);
                formData.append(`items[${index}][eta]`, this.data.eta[index]);
            });
            for (const [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            // Make the API request
            try {
                const response = await axios.post(
                    `${SRV_URL}freight/simpan_quotation`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.Token}`,
                        },
                    }
                );

                // Handle success or error response
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
                Swal.fire({
                    title: "Error",
                    text: error.response?.data?.message || error.message,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        },

        getTodayDate() {
            const date = new Date();
            const options = { day: "numeric", month: "short", year: "numeric" };
            this.data.tanggal = new Intl.DateTimeFormat(
                "en-GB",
                options
            ).format(date);
        },
        resetForm() {
            this.data.noPenawaran = "";
            // this.data.PelabuhanMuatan = "";
            this.data.tujuan = "";
            this.data.selectedPengiriman = [];
            this.data.currency = [];
            this.data.price = [];
            this.data.etd = [];
            this.data.eta = [];
            this.data.notes = "";
        },
    },
};
</script>

<style scoped>
.quotation-card {
    width: 100%;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-top: 20px;
}

.quotation-header {
    text-align: left;
    margin-bottom: 20px;
}

.form-container {
    display: flex;
    flex-direction: column;
}

.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.col {
    flex: 1;
    margin-right: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input,
select,
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

textarea {
    height: 80px;
    resize: none;
}

.invalid {
    border-color: red;
}

.error-text {
    color: red;
    font-size: 0.9em;
    margin-top: -8px;
    margin-bottom: 10px;
    display: block;
    text-shadow: none;
}

.shipping-table {
    margin-bottom: 20px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

thead th {
    text-align: left;
    padding: 10px;
    background-color: #f5f5f5;
    border-bottom: 2px solid #ddd;
}

tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.buttons {
    display: flex;
    justify-content: flex-end;
}

.save-button,
.reset-button {
    padding: 10px 20px;
    margin-left: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.reset-button {
    background-color: #f5a623;
    color: #fff;
}
.error-message {
    color: red;
    font-size: 0.9em;
}
</style>
