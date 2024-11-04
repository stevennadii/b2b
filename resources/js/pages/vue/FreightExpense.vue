<template>
    <div class="quotation-card">
        <div class="quotation-header">
            <h5>Create Quotations | Freight Expenses</h5>
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
                    <select
                        type="text"
                        id="quotation-no"
                        v-model="data.noPenawaran"
                    >
                        <option value="" selected hidden>
                            Select Quotation
                        </option>
                        <option
                            v-for="data in dataFreight"
                            :key="data.No_Penawaran"
                            :value="data.No_Penawaran"
                        >
                            {{ data.No_Penawaran }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Currency Selection -->

            <!-- Expense Table -->
            <div class="expense-table col-md-8">
                <div class="row">
                    <div class="col">
                        <label for="currency">Select Currency</label>
                        <select
                            v-model="selectedCurrency"
                            @change="updateAllCurrencies"
                        >
                            <option selected hidden>Select Currency</option>
                            <option
                                v-for="currency in dataMataUang"
                                :key="currency.Id_Mata_Uang"
                                :value="currency.Kode_Mata_Uang"
                            >
                                {{ currency.Kode_Mata_Uang }} ({{
                                    currency.Terbilang
                                }})
                            </option>
                        </select>
                    </div>
                </div>

                <table>
                    <thead class="text-center">
                        <tr>
                            <th>Expense Details <span>费用名称</span></th>
                            <th>Currency <span>币种</span></th>
                            <th>Unit Price <span>单价</span></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(expense, index) in dataJenisExpense"
                            :key="expense.Id_Jenis_Expense"
                        >
                            <td width="35%">{{ expense.Keterangan }}</td>
                            <td>
                                <input
                                    type="text"
                                    v-model="expense.currency"
                                    disabled
                                />
                            </td>
                            <td>
                                <input
                                    type="text"
                                    v-model="expense.price"
                                    @input="updatePrice($event, index)"
                                />
                                <div v-if="errors[index]" class="error-message">
                                    {{ errors[index] }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <!-- Loop through the computed totalPerCurrency object -->
                        <tr
                            v-for="(total, currency) in totalPerCurrency"
                            :key="currency"
                        >
                            <td colspan="2">
                                <strong>Total for {{ currency }}</strong>
                            </td>
                            <td>
                                <strong>{{ total.toFixed(2) }}</strong>
                            </td>
                        </tr>

                        <!-- Fallback message if no totals are available -->
                        <tr v-if="Object.keys(totalPerCurrency).length === 0">
                            <td colspan="3" class="text-center">
                                No totals to display
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button class="btn-primary form-control" @click="save">
                    Simpan
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
        dataMataUang: Array,
        dataFreight: Array,
        dataJenisExpense: {
            type: Array,
            required: true,
            default: () => [], // Ensure default value if no data is provided
        },
        dataFaktur: Object,
    },

    data() {
        return {
            data: {
                noTransaksi: this.dataFaktur || "",
                tanggal: "",
                noPenawaran: "",
            },
            selectedCurrency: "", // To store the selected currency
            errors: {}, // For error messages
        };
    },

    computed: {
        totalPerCurrency() {
            const totals = {};
            this.dataJenisExpense.forEach((expense) => {
                const currency = expense.currency;
                const price = parseFloat(expense.price) || 0;

                if (currency && price > 0) {
                    if (!totals[currency]) {
                        totals[currency] = 0;
                    }
                    totals[currency] += price;
                }
            });

            return totals;
        },
    },

    mounted() {
        this.getTodayDate();
    },

    methods: {
        getTodayDate() {
            const date = new Date();
            const options = { day: "numeric", month: "short", year: "numeric" };
            this.data.tanggal = new Intl.DateTimeFormat(
                "en-GB",
                options
            ).format(date);
        },

        updatePrice(event, index) {
            const value = event.target.value;

            if (!/^\d*\.?\d*$/.test(value)) {
                this.$set(this.errors, index, "Please enter a valid number");
            } else if (parseFloat(value) < 0) {
                this.$set(this.errors, index, "Price cannot be negative");
            } else {
                this.$set(this.errors, index, null); // Clear error message if valid
            }

            this.$set(this.dataJenisExpense, index, {
                ...this.dataJenisExpense[index],
                price: value,
            });
        },

        updateAllCurrencies() {
            this.dataJenisExpense.forEach((expense) => {
                expense.currency = this.selectedCurrency;
            });
        },

        resetForm() {
            // Reset Quotation No
            this.data.noPenawaran = "";
            this.selectedCurrency = ""; // Reset selected currency

            // Reset every expense in dataJenisExpense
            this.dataJenisExpense.forEach((expense) => {
                expense.price = ""; // Reset price
                expense.currency = ""; // Reset currency
            });

            // Clear any validation errors
            this.errors = {};
        },

        async save() {
            const formData = new FormData();
            const now = new Date();

            // Format the time as HH:MM
            const jam = now
                .toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: false,
                })
                .replace(":", ":");

            formData.append("Kode_Perusahaan", kodePerusahaan);
            formData.append("ID_User", userId);
            formData.append("Auth_SP", authSP);
            formData.append("Nama_Api", NAMA_API_RAW_MATERIAL);
            formData.append("noTransaksi", this.dataFaktur);
            formData.append("noPenawaran", this.data.noPenawaran);
            formData.append("tanggal", this.data.tanggal);
            formData.append("jam", jam);

            const filteredItems = this.dataJenisExpense
                .filter((expense) => parseFloat(expense.price) > 0)
                .map((expense) => ({
                    Id_Jenis_Expense: expense.Id_Jenis_Expense,
                    Id_Mata_Uang: expense.currency,
                    Harga_Unit: expense.price,
                }));

            formData.append("items", JSON.stringify(filteredItems));

            try {
                this.isLoading = true;

                const response = await axios.post(
                    `${SRV_URL}expense/simpan_expense`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${token}`,
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
                    this.resetForm();
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
            } finally {
                this.isLoading = false;
            }
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
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

.expense-table {
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

tbody td,
tfoot td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

tfoot td {
    font-weight: bold;
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

.save-button {
    background-color: #061627;
    color: #fff;
}

.reset-button {
    background-color: #f5a623;
    color: #fff;
}

.error-message {
    color: red;
    font-size: 0.9em;
    margin-top: 5px;
}
</style>
