<template>
    <div class="quotation-card">
        <div class="quotation-header mb-3">
            <h5>Daftar Perusahaan</h5>
            <hr />
        </div>

        <!-- Quotation Table -->
        <div class="quotation-table table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <!-- <th style="width: 8%">Kode Perusahaan</th> -->
                        <!-- <th style="width: 15%">Badan Usaha</th> -->
                        <th style="width: 25%">Nama Perusahaan</th>
                        <th style="width: 20%">Alamat Usaha</th>
                        <th style="width: 10%">Negara</th>
                        <th style="width: 15%">Kota</th>
                        <th style="width: 15%">Telepon</th>
                        <!-- <th style="width: 13%">Nama PIC</th> -->
                        <th>Telpon</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, index) in companies" :key="index">
                        <!-- <td>{{ company. }}</td> -->
                        <!-- <td>{{ company.Badan_Usaha }}</td> -->
                        <td>{{ company.NamaPerusahaan }}</td>
                        <td>{{ company.Alamat }}</td>
                        <td>{{ company.Negara }}</td>
                        <td>{{ company.Kota }}</td>
                        <!-- <td>{{ company.Nama_Pic }}</td> -->
                        <td>{{ company.Telepon }}</td>
                        <td>
                            <a
                                :href="`/new/detail_perusahaan/${company.Id}`"
                                class="btn btn-primary btn-sm"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination d-flex justify-content-end mt-3">
            <button class="btn btn-primary me-2">Previous</button>
            <button class="btn btn-light me-2">1</button>
            <button class="btn btn-light me-2">2</button>
            <button class="btn btn-primary">Next</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        companies: Array,
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
