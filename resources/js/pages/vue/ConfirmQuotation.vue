<template>
    <div class="quotation-card">
        <div class="quotation-header mb-3">
            <h5>Confirm Quotation | List View</h5>
            <hr />
        </div>
        <div class="filter-bar">
            <span><b>Jenis Penawaran</b></span>
            <div class="col-md-2">
                <select class="form-select d-inline">
                    <option>- Seluruh -</option>
                </select>
            </div>
            <div class="col-md-9 d-flex justify-content-end">
                <div class="buttons">
                    <button class="btn btn-secondary btn-md">
                        <i class="fa-solid fa-filter"></i> FIlter
                    </button>
                    <button class="btn btn-primary btn-md ms-2">
                        <i class="fa-solid fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>

        <div class="quotation-table">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>Tanggal Penawaran</th>
                        <th>No. Penawaran</th>
                        <th>Jenis Penawaran</th>
                        <th>Mata Uang</th>
                        <th>Inc. Pajak</th>
                        <th>Status</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>13 Januari 2024</td>
                        <td>2024/I/FN-HO/057</td>
                        <td>Frozen</td>
                        <td>IDR</td>
                        <td>Y</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                        <td>
                            <a
                                href="detail_confirm_quotation"
                                class="btn-primary btn"
                                >Detail</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>14 Februari 2024</td>
                        <td>2024/II/FN-HO/065</td>
                        <td>Frozen</td>
                        <td>IDR</td>
                        <td>Y</td>
                        <td><span class="badge bg-success">Approved</span></td>
                        <td>
                            <a
                                href="detail_confirm_quotation"
                                class="btn-primary btn"
                                >Detail</a
                            >
                        </td>
                    </tr>
                    <!-- Tambahkan baris lain sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-md-2 mt-3">
                <button class="btn btn-primary me-1">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button class="btn btn-light me-1">1</button>
                <button class="btn btn-light me-1">2</button>
                <button class="btn btn-primary">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
        <!-- </div> -->
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

.btn-filter,
.btn-tambah {
    padding: 8px 12px;
    border: none;
    color: #fff;
    background-color: #007bff;
    border-radius: 5px;
    cursor: pointer;
}

.btn-tambah {
    background-color: #28a745;
}

.quotation-table {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #f5f5f5;
}

th,
td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.btn-detail {
    padding: 5px 10px;
    background-color: #6c757d;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-right: 3px;
}

.pagination {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    gap: 5px;
}

.pagination button {
    padding: 8px 12px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}

.badge {
    padding: 5px 10px;
    border-radius: 5px;
    color: #fff;
}

.bg-danger {
    background-color: #dc3545;
}

.bg-success {
    background-color: #28a745;
}
</style>
