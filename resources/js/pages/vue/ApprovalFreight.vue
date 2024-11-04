<template>
    <div class="quotation-card">
        <div class="quotation-header mb-3">
            <h5>Approval Freight | List View</h5>
            <hr />
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar justify-content-end d-flex mb-3">
            <div class="buttons">
                <button class="btn btn-primary ms-2">Filters</button>
                <a href="tambah_approval_freight" class="btn btn-success ms-2"
                    >Tambah</a
                >
            </div>
        </div>

        <!-- Quotation Table -->
        <div class="quotation-table table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Approval</th>
                        <th>Jenis Kendaraan</th>
                        <th>Lokasi Asal</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AP.F-02/24-0001</td>
                        <td>Trailer 20 Ft</td>
                        <td>Qing Dao</td>
                        <td>
                            <a
                                href="detail_approval_freight"
                                class="btn btn-primary btn-sm"
                                >Detail</a
                            >
                        </td>
                    </tr>

                    <!-- Tambahkan baris lain sesuai kebutuhan -->
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
