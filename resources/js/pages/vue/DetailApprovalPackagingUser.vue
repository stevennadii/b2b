<template>
    <div class="quotation-card">
        <!-- Header Section -->
        <div class="quotation-header mb-3">
            <h5>Approval Packaging | Detail</h5>
            <hr />
        </div>

        <!-- Table Section -->
        <div class="quotation-table mt-3">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th hidden>No. Urut</th>

                        <th>No. Penawaran</th>
                        <th>Nama Barang</th>
                        <th>MOQ</th>
                        <th>Satuan</th>
                        <th>Mata Uang</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in detailData" :key="index">
                        <td hidden>{{ index + 1 }}</td>

                        <td>{{ item.NoPenawaran }}</td>
                        <td>{{ item.NamaBarang }}</td>
                        <td>{{ item.MOQ }}</td>
                        <td>{{ item.Id_Satuan }}</td>
                        <td>IDR</td>
                        <td>
                            {{
                                new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                }).format(item["Harga"])
                            }}
                        </td>
                        <td>{{ item.Keterangan }}</td>

                        <td>
                            <!-- Conditional Badge for Flag_Approval -->
                            <span
                                :class="{
                                    'badge bg-danger':
                                        item.Flag_Approval === 'R',
                                    'badge bg-success':
                                        item.Flag_Approval === 'A',
                                    'badge bg-soft-secondary text-dark':
                                        item.Flag_Approval === null,
                                }"
                            >
                                {{
                                    item.Flag_Approval === "R"
                                        ? "Rejected"
                                        : item.Flag_Approval === "A"
                                        ? "Approved"
                                        : "Unproses"
                                }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
    },
    data() {
        return {
            detailData: [], // Initialize detailData as an empty array
        };
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search);
        const NoPenawaran = urlParams.get("NoPenawaran");
        if (NoPenawaran) {
            this.fetchDetailData(NoPenawaran);
        } else {
            console.error("NoPenawaran tidak ditemukan di URL");
        }
    },
    methods: {
        async fetchDetailData(NoPenawaran) {
            try {
                const response = await axios.post(
                    `${SRV_URL}approval_packaging/get_approval_detail_user`,
                    {
                        noPenawaran: NoPenawaran,
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
                    this.detailData = response.data.data.data;
                    console.log(NoPenawaran); // Store API response in detailData
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

.filter-item select,
.action-select {
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

.action {
    background-color: #a3b1d1 !important; /* Muted Slate Blue */
}
</style>
