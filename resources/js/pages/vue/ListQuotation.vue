<template>
    <div class="quotation-card">
        <div class="quotation-header mb-3">
            <h5>Penawaran | List View</h5>
            <hr />
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar row align-items-center mb-3">
            <div class="col-12 col-md-6 d-flex align-items-center mb-2 mb-md-0">
                <span class="me-2"><b>Jenis Penawaran</b></span>
                <select class="form-select w-auto d-inline">
                    <option>- Seluruh -</option>
                </select>
            </div>

            <div class="col-12 col-md-12 text-md-end">
                <button class="btn btn-secondary ms-2 mb-md-0">
                    <i class="fa-solid fa-filter"></i>
                </button>
                <button class="btn btn-primary ms-2">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- Quotation Table -->
        <div class="quotation-table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>Tanggal Penawaran</th>
                        <th>No. Penawaran</th>
                        <th>Supplier</th>
                        <th>Jenis Penawaran</th>
                        <th>Pengiriman</th>
                        <th>Mata Uang</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>13 Januari 2024</td>
                        <td>2024/III/MET/0388</td>
                        <td>Multi Ekspress Transindo</td>
                        <td>Ekspedisi</td>
                        <td>Domestik</td>
                        <td>IDR</td>
                        <td>
                            <a
                                href="detail_quotation"
                                class="btn btn-warning btn-md me-2"
                                >Detail</a
                            >
                            <button class="btn btn-danger btn-md">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>27 Februari 2024</td>
                        <td>2024/III/JNE/0105</td>
                        <td>JNE Cargo</td>
                        <td>Ekspedisi</td>
                        <td>Domestik</td>
                        <td>IDR</td>
                        <td>
                            <a
                                href="detail_quotation"
                                class="btn btn-warning btn-md me-2"
                                >Detail</a
                            >
                            <button class="btn btn-danger btn-md">
                                <i class="fa-solid fa-trash"></i>
                            </button>
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
}

.quotation-table {
    margin-top: 20px;
}

.pagination {
    margin-top: 20px;
    gap: 5px;
}
</style>
