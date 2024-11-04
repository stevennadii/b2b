<template>
    <div class="quotation-card">
        <div class="quotation-header mb-3">
            <h5>Approval Packaging | List View</h5>
            <hr />
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar justify-content-end d-flex mb-3">
            <div class="buttons">
                <!-- <button class="btn btn-primary">Filters</button> -->
                <a class="btn btn-success ms-2" href="tambah_approval_packaging"
                    >Tambah</a
                >
            </div>
        </div>

        <!-- Quotation Table -->
        <div class="quotation-table table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No Penawaran</th>
                        <th>Tanggal Berlaku Penawaran</th>
                        <th>Tanggal Selesai Penawaran</th>
                        <th>Status</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="dataApproval.length === 0">
                        <td colspan="5" class="text-center">
                            No approval data available
                        </td>
                    </tr>
                    <tr
                        v-else
                        v-for="data in dataApproval"
                        :key="data.NoPenawaran"
                        class="text-center"
                    >
                        <td>{{ data.NoPenawaran }}</td>
                        <td>{{ formatDate(data.TanggalAwal) }}</td>
                        <td>{{ formatDate(data.TanggalAkhir) }}</td>
                        <td>
                            <span
                                :class="{
                                    'badge bg-success text-dark':
                                        data.Flag === 'Y',
                                    'badge bg-warning text-dark':
                                        data.Flag === 'T',
                                    'badge bg-soft-secondary text-dark':
                                        data.Flag === null,
                                }"
                            >
                                {{
                                    data.Flag === "Y"
                                        ? "Complete"
                                        : data.Flag === "T"
                                        ? "Incomplete"
                                        : "Unproses"
                                }}
                            </span>
                        </td>
                        <td>
                            <a
                                :href="`detail_approval_packaging_admin?NoPenawaran=${data.NoPenawaran}`"
                                class="btn btn-md bg-primary btn-dark"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination d-flex justify-content-end">
            <button class="btn btn-primary me-2">Previous</button>
            <button class="btn btn-light me-2">1</button>
            <button class="btn btn-light me-2">2</button>
            <button class="btn btn-primary">Next</button>
        </div>
    </div>
</template>
<script>
import dayjs from "dayjs";
import axios from "axios";
import Swal from "sweetalert2"; // Ensure SweetAlert2 is imported
import {
    SRV_URL,
    NAMA_API_RAW_MATERIAL,
    kodePerusahaan,
} from "../helpers/shared_value";

export default {
    props: {
        dataApproval: Array,
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,
        // KodeSupplier: Object,
    },
    methods: {
        formatDate(date) {
            return dayjs(date).format("DD-MMM-YYYY");
        },
    },
};
</script>

<style scoped>
.quotation-card {
    width: 100%;
    margin: 20px auto;
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.quotation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.quotation-table {
    margin-top: 20px;
}

.table thead {
    background-color: rgb(219, 219, 219);
}

th,
td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.pagination {
    margin-top: 20px;
    gap: 5px;
}
</style>
