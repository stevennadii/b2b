<template>
    <div class="card p-4">
        <h5 class="mb-3">Create Quotation | Expedition</h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <p class="ms-1 mb-2">Select Company</p>
                <select class="form-select" v-model="KodeSupplier">
                    <option
                        v-for="(data, index) in dataPerusahaan"
                        :key="data.KodeSupplier"
                        :value="data.KodeSupplier"
                    >
                        {{ data.NamaPerusahaan }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Row 1: No. Transaksi & Tanggal -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="noTransaksi">Transaction Number</label>
                <input
                    type="text"
                    id="noTransaksi"
                    class="form-control"
                    v-model="noTransaksi"
                    disabled
                />
            </div>
            <div class="col-md-6">
                <label for="tanggal">Date</label>
                <input
                    type="date"
                    id="tanggal"
                    class="form-control"
                    v-model="tanggal"
                />
                <span v-if="errors.tanggal" class="text-danger">{{
                    errors.tanggal
                }}</span>
            </div>
        </div>

        <!-- Row 2: No. Penawaran -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="noPenawaran">Quotation Number</label>
                <input
                    type="text"
                    id="noPenawaran"
                    class="form-control"
                    v-model="noPenawaran"
                />
                <span v-if="errors.noPenawaran" class="text-danger">{{
                    errors.noPenawaran
                }}</span>
            </div>
            <div class="col-md-6">
                <label for="jenisEkspedisi">Shipping Method</label>
                <select v-model="jenisEkspedisi" class="form-control">
                    <option value="" selected hidden>Select Shipping</option>
                    <option
                        v-for="jenis in dataJenisEkspedisi"
                        :key="jenis.id"
                        :value="jenis.id"
                    >
                        {{ jenis.Keterangan }}
                    </option>
                </select>
                <span v-if="errors.jenisEkspedisi" class="text-danger">
                    {{ errors.jenisEkspedisi }}
                </span>
            </div>
        </div>
        <div class="row">
            <div
                class="col-md-12 d-flex justify-content-end align-items-end mb-3"
            >
                <button type="button" class="btn btn-primary" @click="addArea">
                    + Tambah Area Kirim
                </button>
            </div>
        </div>
        <!-- Shipping Areas Section -->
        <div v-for="(area, index) in shippingAreas" :key="index" class="mb-4">
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-2" style="width: 70px">
                            <button
                                type="button"
                                class="btn btn-danger form-control"
                                @click="removeArea(index)"
                            >
                                X
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>City Of Origin</label>
                            <select
                                v-model="area.asalKota"
                                class="form-control"
                                @change="fetchKecamatanAsal(area.asalKota)"
                            >
                                <option value="" selected hidden>
                                    Select City
                                </option>
                                <option
                                    v-for="kota in dataKota"
                                    :key="kota.id_kabupaten_kota"
                                    :value="kota.id_kabupaten_kota"
                                >
                                    {{ kota.nama_kabupaten_kota }}
                                </option>
                            </select>
                            <span
                                v-if="errors.areas[index]?.asalKota"
                                class="text-danger"
                                >{{ errors.areas[index].asalKota }}</span
                            >
                        </div>
                        <div class="col-md-2">
                            <label>Sub-District Of Origin</label>
                            <select
                                v-model="area.asalKecamatan"
                                class="form-control"
                            >
                                <option value="" selected hidden>
                                    Select Sub-District
                                </option>
                                <option
                                    v-for="kecamatan in dataKecamatanAsal"
                                    :key="kecamatan.id_kecamatan"
                                    :value="kecamatan.id_kecamatan"
                                >
                                    {{ kecamatan.nama_kecamatan }}
                                </option>
                            </select>
                            <span
                                v-if="errors.areas[index]?.asalKecamatan"
                                class="text-danger"
                                >{{ errors.areas[index].asalKecamatan }}</span
                            >
                        </div>
                        <div class="col-md-2">
                            <label>Destination City</label>
                            <select
                                v-model="area.tujuanKota"
                                class="form-control"
                                @change="fetchKecamatanTujuan(area.tujuanKota)"
                            >
                                <option value="" selected hidden>
                                    Select City
                                </option>
                                <option
                                    v-for="kota in dataKota"
                                    :key="kota.id_kabupaten_kota"
                                    :value="kota.id_kabupaten_kota"
                                >
                                    {{ kota.nama_kabupaten_kota }}
                                </option>
                            </select>
                            <span
                                v-if="errors.areas[index]?.tujuanKota"
                                class="text-danger"
                                >{{ errors.areas[index].tujuanKota }}</span
                            >
                        </div>
                        <div class="col-md-2">
                            <label>Destination Sub-District</label>
                            <select
                                v-model="area.tujuanKecamatan"
                                class="form-control"
                            >
                                <option value="" selected>
                                    Select Sub-District
                                </option>
                                <option
                                    v-for="kecamatan in dataKecamatanTujuan"
                                    :key="kecamatan.id_kecamatan"
                                    :value="kecamatan.id_kecamatan"
                                >
                                    {{ kecamatan.nama_kecamatan }}
                                </option>
                            </select>
                            <span
                                v-if="errors.areas[index]?.tujuanKecamatan"
                                class="text-danger"
                                >{{ errors.areas[index].tujuanKecamatan }}</span
                            >
                        </div>
                    </div>

                    <!-- Multiple Vehicles within an Area -->
                    <div
                        v-for="(vehicle, vIndex) in area.vehicles"
                        :key="vIndex"
                        class="mt-3"
                    >
                        <div class="row">
                            <div class="col-md-3">
                                <label>Vehicle Type</label>
                                <select
                                    v-model="vehicle.jenisKendaraan"
                                    class="form-control"
                                    @change="
                                        setKapasitasKendaraan(
                                            vehicle.jenisKendaraan,
                                            index,
                                            vIndex
                                        )
                                    "
                                >
                                    <option value="" selected hidden>
                                        Select Vehicle
                                    </option>
                                    <option
                                        v-for="kendaraan in dataKendaraan"
                                        :key="kendaraan.Id_Kendaraan"
                                        :value="kendaraan.Id_Kendaraan"
                                    >
                                        {{ kendaraan.Kode_Kendaraan }}
                                    </option>
                                </select>
                                <span
                                    v-if="
                                        errors.areas[index]?.vehicles[vIndex]
                                            ?.jenisKendaraan
                                    "
                                    class="text-danger"
                                >
                                    {{
                                        errors.areas[index].vehicles[vIndex]
                                            .jenisKendaraan
                                    }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <label>Capacity</label>
                                <input
                                    type="text"
                                    v-model="vehicle.kapasitas"
                                    class="form-control"
                                    disabled
                                />
                                <span
                                    v-if="
                                        errors.areas[index]?.vehicles[vIndex]
                                            ?.kapasitas
                                    "
                                    class="text-danger"
                                    >{{
                                        errors.areas[index].vehicles[vIndex]
                                            .kapasitas
                                    }}</span
                                >
                            </div>
                            <div class="col-md-2">
                                <label>Rate</label>
                                <input
                                    type="number"
                                    v-model="vehicle.tarif"
                                    class="form-control"
                                />
                                <span
                                    v-if="
                                        errors.areas[index]?.vehicles[vIndex]
                                            ?.tarif
                                    "
                                    class="text-danger"
                                    >{{
                                        errors.areas[index].vehicles[vIndex]
                                            .tarif
                                    }}</span
                                >
                            </div>
                            <div class="col-md-2">
                                <label>Additional Costs</label>
                                <input
                                    type="number"
                                    v-model="vehicle.biayaLain"
                                    class="form-control"
                                />
                                <span
                                    v-if="
                                        errors.areas[index]?.vehicles[vIndex]
                                            ?.biayaLain
                                    "
                                    class="text-danger"
                                    >{{
                                        errors.areas[index].vehicles[vIndex]
                                            .biayaLain
                                    }}</span
                                >
                            </div>
                            <div class="col-md-2">
                                <label>Total</label>
                                <input
                                    type="number"
                                    :value="calculateVehicleTotal(vehicle)"
                                    class="form-control"
                                    readonly
                                />
                            </div>
                            <div class="col-md-1 d-flex align-items-end mt-2">
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    @click="removeVehicle(index, vIndex)"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Add Vehicle Button -->

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-start">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="addVehicle(index)"
                            >
                                <i class="fa-solid fa-plus"> </i> Add Vehicle
                            </button>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
        </div>

        <!-- Tanggal Berlaku Penawaran -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="penawaranDateStart">Offer Validity Date</label>
                <input
                    type="date"
                    id="penawaranDateStart"
                    class="form-control"
                    v-model="penawaranDateStart"
                />
                <span v-if="errors.penawaranDateStart" class="text-danger">{{
                    errors.penawaranDateStart
                }}</span>
            </div>

            <div class="col-md-3">
                <label for="penawaranDateEnd">Offer Completion Date</label>
                <input
                    type="date"
                    id="penawaranDateEnd"
                    class="form-control"
                    v-model="penawaranDateEnd"
                />
                <span v-if="errors.penawaranDateEnd" class="text-danger">{{
                    errors.penawaranDateEnd
                }}</span>
            </div>
        </div>

        <!-- Upload File -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="uploadFile">Upload File</label>
                <input type="file" id="uploadFile" class="form-control" />
                <span v-if="errors.uploadFile" class="text-danger">{{
                    errors.uploadFile
                }}</span>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="keterangan">Notes</label>
                <textarea
                    id="keterangan"
                    class="form-control"
                    v-model="keterangan"
                ></textarea>
                <span v-if="errors.keterangan" class="text-danger">{{
                    errors.keterangan
                }}</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <button
                    type="button"
                    class="btn btn-primary form-control"
                    @click="save"
                >
                    Save
                </button>
            </div>
            <div class="col-md-6">
                <button
                    type="button"
                    class="btn btn-warning form-control"
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
    checkConsole,
    SRV_URL,
    NAMA_API_EXPEDITION,
    kodePerusahaan,
    versionApp,
} from "../helpers/shared_value";
import { version } from "vue";
export default {
    props: {
        AuthSP: Object,
        UserId: Object,
        Token: Object,
        Lokasi: Object,

        dataKota: Array,
        dataJenisEkspedisi: Array,
        dataPerusahaan: Array,
        dataFaktur: Object,
    },

    data() {
        return {
            noTransaksi: this.dataFaktur,
            tanggal: new Date().toISOString().substr(0, 10),
            jenisEkspedisi: "",
            KodeSupplier: "",
            dataKendaraan: [],
            noPenawaran: "",
            vehicle: {
                jenisKendaraan: "",
                kapasitas: "",
            },

            dataKecamatanAsal: [],
            dataKecamatanTujuan: [],
            shippingAreas: [
                {
                    asalKota: "",
                    asalKecamatan: "",
                    tujuanKota: "",
                    tujuanKecamatan: "",
                    vehicles: [
                        {
                            jenisKendaraan: "",
                            kapasitas: "",
                            tarif: 0,
                            biayaLain: 0,
                        },
                    ],
                },
            ],
            penawaranDateStart: "",
            penawaranDateEnd: "",
            keterangan: "",
            errors: {
                tanggal: "",
                noPenawaran: "",
                penawaranDateStart: "",
                penawaranDateEnd: "",
                uploadFile: "",
                keterangan: "",
                areas: [],
            },
        };
    },
    watch: {
        // Watcher to fetch vehicles when jenisEkspedisi is selected
        jenisEkspedisi(newVal) {
            if (this.KodeSupplier && newVal) {
                this.fetchKendaraan();
            } else {
                this.dataKendaraan = [];
            }
        },
    },

    methods: {
        fetchKendaraan() {
            const payload = {
                kode_supplier: this.KodeSupplier,
                idJenis: this.jenisEkspedisi,
                kode_perusahaan: kodePerusahaan,
                id_user: this.UserId,
                auth_sp: this.AuthSP,
                version: versionApp,
                nama_api: NAMA_API_EXPEDITION,
            };

            axios
                .post(`${SRV_URL}expedition/get_kendaraanEkspedisi`, payload, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${this.Token}`,
                    },
                })
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.dataKendaraan = response.data.data.data;
                    } else {
                        console.error(
                            "Unexpected response structure:",
                            response.data
                        );
                    }
                })
                .catch((error) => {
                    console.error(error);
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        fetchKecamatanAsal(id) {
            this.dataKecamatanAsal = [];
            const payload = {
                idKecamatan: id,
                kode_perusahaan: `${kodePerusahaan}`,
                id_user: this.UserId,
                auth_sp: this.AuthSP,
                version: `${versionApp}`,
                nama_api: `${NAMA_API_EXPEDITION}`,
            };

            axios
                .post(`${SRV_URL}expedition/get_kecamatan`, payload, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${this.Token}`,
                    },
                })

                .then((response) => {
                    if (response.data && response.data.data) {
                        this.dataKecamatanAsal = response.data.data.data;
                        // console.log(this.dataKecamatan);
                    } else {
                        console.error(
                            "Unexpected response structure:",
                            response.data
                        );
                    }
                })
                .catch((error) => {
                    console.error(error);
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        fetchKecamatanTujuan(id) {
            this.dataKecamatanTujuan = [];
            const payload = {
                idKecamatan: id,
                kode_perusahaan: `${kodePerusahaan}`,
                id_user: this.UserId,
                auth_sp: this.AuthSP,
                version: `${versionApp}`,
                nama_api: `${NAMA_API_EXPEDITION}`,
            };

            axios
                .post(`${SRV_URL}expedition/get_kecamatan`, payload, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${this.Token}`,
                    },
                })

                .then((response) => {
                    if (response.data && response.data.data) {
                        this.dataKecamatanTujuan = response.data.data.data;
                        // console.log(this.dataKecamatan);
                    } else {
                        console.error(
                            "Unexpected response structure:",
                            response.data
                        );
                    }
                })
                .catch((error) => {
                    console.error(error);
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        setKapasitasKendaraan(idKendaraan, index, vIndex) {
            const selectedKendaraan = this.dataKendaraan.find(
                (kendaraan) => kendaraan.Id_Kendaraan === idKendaraan
            );

            if (selectedKendaraan) {
                // Pastikan Anda mengupdate vehicle.kapasitas yang tepat
                this.shippingAreas[index].vehicles[vIndex].kapasitas =
                    selectedKendaraan.Kapasitas;
            } else {
                this.vehicle.kapasitas = "";
            }
        },

        addArea() {
            // console.log(this.dataKendaraan);
            this.shippingAreas.push({
                asalKota: "",
                asalKecamatan: "",
                tujuanKota: "",
                tujuanKecamatan: "",
                vehicles: [
                    {
                        jenisKendaraan: "",
                        kapasitas: "",
                        tarif: 0,
                        biayaLain: 0,
                    },
                ],
            });
        },
        removeArea(index) {
            this.shippingAreas.splice(index, 1);
            this.errors.areas.splice(index, 1);
        },
        addVehicle(areaIndex) {
            this.shippingAreas[areaIndex].vehicles.push({
                jenisKendaraan: "",
                kapasitas: "",
                tarif: 0,
                biayaLain: 0,
            });
        },
        removeVehicle(areaIndex, vehicleIndex) {
            this.shippingAreas[areaIndex].vehicles.splice(vehicleIndex, 1);
        },
        calculateVehicleTotal(vehicle) {
            return vehicle.tarif + vehicle.biayaLain;
        },

        validateForm() {
            let isValid = true;
            if (!this.tanggal) {
                this.errors.tanggal = "Tanggal is required.";
                isValid = false;
            }
            if (!this.noPenawaran) {
                this.errors.noPenawaran = "No. Penawaran is required.";
                isValid = false;
            }
            if (!this.penawaranDateStart) {
                this.errors.penawaranDateStart =
                    "Tanggal Berlaku Penawaran Start is required.";
                isValid = false;
            }
            if (!this.penawaranDateEnd) {
                this.errors.penawaranDateEnd =
                    "Tanggal Berlaku Penawaran End is required.";
                isValid = false;
            }
            if (
                new Date(this.penawaranDateStart) >
                new Date(this.penawaranDateEnd)
            ) {
                this.errors.penawaranDateEnd =
                    "Tanggal Berlaku Penawaran End must be after Start date.";
                isValid = false;
            }
            if (!this.keterangan) {
                this.errors.keterangan = "Keterangan is required.";
                isValid = false;
            }
            this.shippingAreas.forEach((area, index) => {
                // this.validateArea(index);
                area.vehicles.forEach((vehicle, vIndex) => {
                    // this.validateVehicle(index, vIndex);
                });
            });
            return isValid;
        },
        async save() {
            const now = new Date();
            const jamSekarang = `${now
                .getHours()
                .toString()
                .padStart(2, "0")}:${now
                .getMinutes()
                .toString()
                .padStart(2, "0")}:${now
                .getSeconds()
                .toString()
                .padStart(2, "0")}`;
            if (this.validateForm()) {
                // Data preparation for the API call
                const shippingAreasPayload = this.shippingAreas.map((area) => ({
                    asalKota: area.asalKota,
                    asalKecamatan: area.asalKecamatan,
                    tujuanKota: area.tujuanKota,
                    tujuanKecamatan: area.tujuanKecamatan,
                    vehicles: area.vehicles.map((vehicle) => ({
                        jenisKendaraan: vehicle.jenisKendaraan,
                        kapasitas: vehicle.kapasitas,
                        tarif: vehicle.tarif,
                        biayaLain: vehicle.biayaLain,
                    })),
                }));

                const payload = {
                    tanggal: this.tanggal,
                    noPenawaran: this.noPenawaran,
                    jenisEkspedisi: this.jenisEkspedisi,
                    KodeSupplier: this.KodeSupplier,
                    shippingAreas: shippingAreasPayload,
                    penawaranDateStart: this.penawaranDateStart,
                    penawaranDateEnd: this.penawaranDateEnd,
                    keterangan: this.keterangan,
                    file: null,
                    jam: jamSekarang,
                    kode_perusahaan: kodePerusahaan,
                    id_user: this.UserId,
                    auth_sp: this.AuthSP,
                    version: "1.0.0",
                    nama_api: NAMA_API_EXPEDITION,
                    shippingAreasPayload,
                };

                try {
                    const response = await axios.post(
                        `${SRV_URL}expedition/simpan_expedition`,
                        payload,
                        {
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${this.Token}`,
                            },
                        }
                    );
                    console.log(response.data);
                    if (response.data && response.data.status === "success") {
                        Swal.fire("Success", response.data.message, "success");

                        // this.reset();
                        window.location.reload();
                    } else {
                        await Swal.fire({
                            icon: "error",
                            title: "Error",
                            text:
                                response.data.message ||
                                "Something went wrong.",
                        });
                    }
                } catch (error) {
                    console.error("Save Quotation Error:", error);
                    await Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:
                            error.response?.data?.message ||
                            "An error occurred.",
                    });

                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                }
            } else {
                await Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    text: "Please fix the validation errors before saving.",
                });
            }
        },

        reset() {
            // Reset form functionality
            this.noTransaksi = this.dataFaktur;
            this.tanggal = new Date().toISOString().substr(0, 10);
            this.noPenawaran = "";
            this.shippingAreas = [
                {
                    asalKota: "",
                    asalKecamatan: "",
                    tujuanKota: "",
                    tujuanKecamatan: "",
                    vehicles: [
                        {
                            jenisKendaraan: "",
                            kapasitas: "",
                            tarif: 0,
                            biayaLain: 0,
                        },
                    ],
                },
            ];
            this.penawaranDateStart = "";
            this.penawaranDateEnd = "";
            this.keterangan = "";
            this.errors = {
                tanggal: "",
                noPenawaran: "",
                penawaranDateStart: "",
                penawaranDateEnd: "",
                uploadFile: "",
                keterangan: "",
                areas: [],
            };
        },
    },
};
</script>

<style scoped>
.text-danger {
    color: red;
}
</style>
