<template>
    <div class="quotation-card">
        <div class="quotation-header">
            <h5>Create Penawaran | Freight Comparison</h5>
            <hr />
        </div>
        <div class="form-container">
            <!-- Transaction Details -->
            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <label for="transaction-no" class="form-label"
                        >No. Transaksi</label
                    >
                    <input
                        type="text"
                        id="transaction-no"
                        class="form-control"
                        value="QTF-08/24-0073"
                        disabled
                    />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input
                        type="text"
                        id="date"
                        class="form-control"
                        value="03 Agustus 2024"
                        disabled
                    />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="origin" class="form-label">Asal</label>
                    <select id="origin" class="form-select">
                        <option selected>Qing Dao / Han Ou</option>
                    </select>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="comparison-table mb-4">
                <div
                    v-for="(comparison, index) in comparisons"
                    :key="index"
                    class="comparison-section mb-3"
                >
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="destination" class="form-label"
                                        >Tujuan</label
                                    >
                                    <select
                                        id="destination"
                                        class="form-select"
                                    >
                                        <option
                                            v-for="destination in destinations"
                                            :key="destination"
                                        >
                                            {{ destination }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="agent" class="form-label"
                                        >Agent {{ index + 1 }}</label
                                    >
                                    <select id="agent" class="form-select">
                                        <option
                                            v-for="agent in agents"
                                            :key="agent"
                                        >
                                            {{ agent }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Shipping</th>
                                            <th>Currency</th>
                                            <th>Cost</th>
                                            <th>ETD</th>
                                            <th>ETA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="option in comparison.options"
                                            :key="option.shipping"
                                        >
                                            <td>{{ option.shipping }}</td>
                                            <td style="width: 12%">
                                                <select
                                                    class="form-select"
                                                    style="width: 75%"
                                                >
                                                    <option selected>
                                                        USD $
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ option.cost }}</td>
                                            <td>{{ option.etd }}</td>
                                            <td>{{ option.eta }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    class="btn btn-primary w-100 mt-3"
                    @click="addComparison"
                >
                    + Tambah Area Kirim & Agent
                </button>
            </div>

            <!-- Additional Information -->
            <div class="additional-info">
                <div class="row">
                    <div class="col-md-6">
                        <label for="offer-date" class="form-label"
                            >Tanggal Berlaku Penawaran</label
                        >
                        <div class="d-flex align-items-center">
                            <input
                                type="text"
                                id="offer-date-start"
                                value="05 Agustus 2024"
                                disabled
                                class="form-control"
                            />
                            <span class="mb-2 me-2 ms-2"> S/D </span>
                            <input
                                type="text"
                                id="offer-date-end"
                                value="20 Agustus 2024"
                                disabled
                                class="form-control"
                            />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="notes" class="form-label">Keterangan</label>
                        <textarea id="notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="upload-file" class="form-label"
                            >Upload File</label
                        >
                        <input
                            type="file"
                            id="upload-file"
                            class="form-control"
                            accept=".pdf"
                        />
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="buttons d-flex justify-content-end mt-5">
                <button class="btn btn-primary me-4 form-control">Save</button>
                <button class="btn btn-warning form-control">Reset</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FreightComparison",
    data() {
        return {
            comparisons: [
                {
                    destination: "Jakarta",
                    agent: "Ying Chi",
                    options: [
                        {
                            shipping: "Cosco",
                            cost: "1,650.00",
                            etd: "09 Aug, 2024",
                            eta: "21 Aug, 2024",
                        },
                        {
                            shipping: "OOCL",
                            cost: "1,675.00",
                            etd: "09 Aug, 2024",
                            eta: "21 Aug, 2024",
                        },
                        {
                            shipping: "EMC",
                            cost: "1,950.00",
                            etd: "08 Aug, 2024",
                            eta: "20 Aug, 2024",
                        },
                    ],
                },
                {
                    destination: "Jakarta",
                    agent: "Tianjin",
                    options: [
                        {
                            shipping: "TSL",
                            cost: "1,700.00",
                            etd: "09 Aug, 2024",
                            eta: "21 Aug, 2024",
                        },
                        {
                            shipping: "STIC",
                            cost: "2,000.00",
                            etd: "09 Aug, 2024",
                            eta: "21 Aug, 2024",
                        },
                        {
                            shipping: "OOCL",
                            cost: "1,675.00",
                            etd: "09 Aug, 2024",
                            eta: "21 Aug, 2024",
                        },
                    ],
                },
            ],
            destinations: ["Jakarta", "Surabaya", "Medan"],
            agents: ["Ying Chi", "Tianjin", "Shanghai"],
        };
    },
    methods: {
        addComparison() {
            this.comparisons.push({
                destination: "",
                agent: "",
                options: [],
            });
        },
    },
};
</script>

<style scoped>
.quotation-card {
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
}

.quotation-header {
    text-align: left;
    margin-bottom: 20px;
}

.save-button {
    background-color: #061627;
    color: #fff;
}

.reset-button {
    background-color: #f5a623;
    color: #fff;
}

.add-area-button {
    background-color: #28a745;
    color: #fff;
    margin-top: 10px;
}

/* Media Query for Smaller Screens */
@media (max-width: 768px) {
    .comparison-table {
        overflow-x: auto;
    }

    .comparison-section .card {
        margin-bottom: 15px;
    }

    .form-container .row > .col-md-4,
    .form-container .row > .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .form-container .d-flex.align-items-center {
        flex-direction: column;
    }

    .form-container .d-flex.align-items-center .form-control {
        width: 100%;
        margin-bottom: 10px;
    }

    .buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .buttons button {
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .form-container .row > .col-md-4,
    .form-container .row > .col-md-6 {
        margin-bottom: 15px;
    }
}
</style>
