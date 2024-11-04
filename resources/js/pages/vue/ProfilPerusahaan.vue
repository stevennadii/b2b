<template>
    <div class="card">
        <div class="card-body">
            <form @submit.prevent="submitForm">
                <div class="d-flex justify-content-between mb-4">
                    <p>Profil Perusahaan</p>
                    <p>Profile</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="ekspedisi">Jenis Ekspedisi</label>
                            </div>
                            <div class="col-md-10">
                                <selectVue
                                    multiple="multiple"
                                    :options="dataEkspedisi"
                                    v-model="formData.jenisEkspedisi"
                                    class="ms-4"
                                ></selectVue>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Usaha -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="badan-usaha"
                                class="me-3"
                                style="width: 170px"
                                >Badan Usaha</label
                            >
                            <select
                                class="form-select"
                                id="badan-usaha"
                                v-model="formData.badan_usaha"
                            >
                                <option hidden value>Pilih Badan Usaha</option>
                                <option value="PT">PT</option>
                                <option value="CV">CV</option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="nama-perusahaan"
                                class="me-3"
                                style="width: 170px"
                                >Nama Perusahaan</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="nama-perusahaan"
                                v-model="formData.nama_perusahaan"
                            />
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="alamat-usaha"
                                class="me-3"
                                style="width: 170px"
                                >Alamat Usaha</label
                            >
                            <textarea
                                id="alamat-usaha"
                                rows="5"
                                class="form-control"
                                v-model="formData.alamat_usaha"
                            ></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="negara"
                                class="me-3"
                                style="width: 170px"
                                >Negara</label
                            >
                            <select
                                class="form-select"
                                v-model="formData.negara"
                            >
                                <option value="">Pilih Negara</option>
                                <option
                                    v-for="negara in negaraList"
                                    :value="negara.value"
                                    :key="negara.value"
                                >
                                    {{ negara.text }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="provinsi"
                                class="me-3"
                                style="width: 170px"
                                >Provinsi</label
                            >
                            <select
                                class="form-select"
                                v-model="formData.provinsi"
                            >
                                <option value="">Pilih Provinsi</option>
                                <option
                                    v-for="provinsi in getProvinces()"
                                    :value="provinsi.value"
                                    :key="provinsi.value"
                                >
                                    {{ provinsi.text }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="kota" class="me-3" style="width: 170px"
                                >Kabupaten / Kota</label
                            >
                            <select
                                class="form-select"
                                v-model="formData.kabupaten_kota"
                            >
                                <option value="">Pilih Kota</option>
                                <option
                                    v-for="kota in getCities()"
                                    :value="kota.value"
                                    :key="kota.value"
                                >
                                    {{ kota.text }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="telepon"
                                class="me-3"
                                style="width: 170px"
                                >Telepon</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="telepon"
                                v-model="formData.telepon"
                            />
                        </div>
                    </div>
                </div>
                <!-- Akhir badan usaha -->

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="status-pajak"
                                class="me-3"
                                style="width: 170px"
                                >Status Pajak</label
                            >
                            <select
                                class="form-select"
                                id="status-pajak"
                                v-model="formData.status_pajak"
                            >
                                <option value selected>
                                    Pilih Status Pajak
                                </option>
                                <option value="Aktif">Aktif</option>
                                <option value="Inaktif">Inaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label for="npwp" class="me-3" style="width: 170px"
                                >NPWP</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="npwp"
                                v-model="formData.npwp"
                            />
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="nama-pic"
                                class="me-3"
                                style="width: 170px"
                                >Nama PIC</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="nama-pic"
                                v-model="formData.nama_pic"
                            />
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="jabatan"
                                class="me-3"
                                style="width: 170px"
                                >Jabatan</label
                            >
                            <select
                                class="form-select"
                                id="jabatan"
                                v-model="formData.jabatan"
                            >
                                <option value selected>Pilih Jabatan</option>
                                <option value="Direktur">Direktur</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="ponsel"
                                class="me-3"
                                style="width: 170px"
                                >Ponsel</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="ponsel"
                                v-model="formData.ponsel"
                            />
                        </div>
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="cara-bayar"
                                class="me-3"
                                style="width: 170px"
                                >Cara Bayar</label
                            >
                            <select
                                class="form-select"
                                id="cara-bayar"
                                v-model="formData.cara_bayar"
                            >
                                <option value selected>Pilih Cara Bayar</option>
                                <option value="Cash">Cash</option>
                                <option value="Kredit">Kredit</option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="tempo" class="me-3" style="width: 170px"
                                >Tempo</label
                            >
                            <select
                                class="form-select"
                                id="tempo"
                                v-model="formData.tempo"
                            >
                                <option value selected>Pilih Tempo</option>
                                <option value="1 Termin">1 Termin</option>
                                <option value="2 Termin">2 Termin</option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="tipe-pembayaran"
                                class="me-3"
                                style="width: 170px"
                                >Tipe Pembayaran</label
                            >
                            <select
                                class="form-select"
                                id="tipe-pembayaran"
                                v-model="formData.tipe_pembayaran"
                            >
                                <option value selected>
                                    Pilih Tipe Pembayaran
                                </option>
                                <option value="Kredit">Kredit</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="ekspedisi">Mata Uang</label>
                                </div>
                                <div class="col-md-10">
                                    <selectVue
                                        multiple="multiple"
                                        :options="dataMataUang"
                                        class="ms-4"
                                        v-model="formData.mataUang"
                                    ></selectVue>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 d-flex align-items-center">
                            <label for="bank" class="me-3" style="width: 170px"
                                >Bank</label
                            >
                            <select
                                class="form-select"
                                id="bank"
                                v-model="formData.bank"
                            >
                                <option value selected>Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="BRI">BRI</option>
                                <option value="Bank Mandiri">
                                    Bank Mandiri
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="cabang"
                                class="me-3"
                                style="width: 170px"
                                >Cabang</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="cabang"
                                v-model="formData.cabang"
                            />
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="nama-nasabah"
                                class="me-3"
                                style="width: 170px"
                                >Nama Nasabah</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="nama-nasabah"
                                v-model="formData.nama_nasabah"
                            />
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="no-rekening"
                                class="me-3"
                                style="width: 170px"
                                >No Rekening</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="no-rekening"
                                v-model="formData.no_rekening"
                            />
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label
                                for="swift-code"
                                class="me-3"
                                style="width: 170px"
                                >Swift Code</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="swift-code"
                                v-model="formData.swift_code"
                            />
                        </div>
                    </div>
                </div>
                <!-- Akhir Pembayaran -->

                <div class="d-flex justify-content-center">
                    <button type="reset" class="btn btn-warning me-3">
                        RESET
                    </button>
                    <button type="submit" class="btn btn-primary">
                        SIMPAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import selectVue from "vue-select";
import "vue-select/dist/vue-select.css";
import Swal from "sweetalert2"; // Ensure SweetAlert2 is imported
import { checkConsole, SRV_URL } from "../helpers/shared_value";
// Fetch daftar negara saat halaman dimuat

export default {
    props: {
        token: Object,
        user_id: Object,
        authsp: Object,
        namaAPI: Object,
    },
    components: {
        selectVue,
    },
    data() {
        return {
            formData: {
                jenisEkspedisi: [],
                badan_usaha: "",
                nama_perusahaan: "",
                alamat_usaha: "",
                negara: "",
                provinsi: "",
                kabupaten_kota: "",
                telepon: "",
                status_pajak: "",
                npwp: "",
                nama_pic: "",
                jabatan: "",
                ponsel: "",
                cara_bayar: "",
                tipe_pembayaran: "",
                mataUang: [],
                bank: "",
                cabang: "",
                nama_nasabah: "",
                no_rekening: "",
                swift_code: "",
                userid: "evo",
                id_user: "evo",
                auth_sp: "231879123",
                nama_api:
                    "$2y$10$zqMVt81TW.ARWAQIWBRBS./9/xbdLkQp3SXwN5ISWqrxqqyUTx2AC",
                kode_perusahaan: "001",
            },
            dataEkspedisi: ["Darat", "Laut", "Udara"],
            dataMataUang: ["CNY", "IDR", "USD"],
            isLoading: false,
            token: "49|Vn6uu6ObCSvS7GXqtj2Zdd8l0zkLFUYFA3TVA3IH", // Ensure token is set
            checkConsole: "T",
            negaraList: [
                { value: "id", text: "Indonesia" },
                { value: "cn", text: "China" },
                { value: "th", text: "Thailand" },
                { value: "vn", text: "Vietnam" },
            ],
            provinsiList: {
                id: [
                    { value: "id-jkt", text: "Jakarta" },
                    { value: "id-jateng", text: "Jawa Tengah" },
                    { value: "id-jatim", text: "Jawa Timur" },
                    { value: "id-bali", text: "Bali" },
                ],
                cn: [
                    { value: "cn-bj", text: "Beijing" },
                    { value: "cn-sh", text: "Shanghai" },
                    { value: "cn-gd", text: "Guangdong" },
                    { value: "cn-zj", text: "Zhejiang" },
                ],
                th: [
                    { value: "th-bkk", text: "Bangkok" },
                    { value: "th-ct", text: "Chiang Mai" },
                    { value: "th-pk", text: "Phuket" },
                    { value: "th-kl", text: "Krabi" },
                ],
                vn: [
                    { value: "vn-hn", text: "Hanoi" },
                    { value: "vn-hcm", text: "Ho Chi Minh City" },
                    { value: "vn-dn", text: "Da Nang" },
                    { value: "vn-ct", text: "Can Tho" },
                ],
            },
            kotaList: {
                "id-jkt": [
                    { value: "jakarta-pusat", text: "Jakarta Pusat" },
                    { value: "jakarta-selatan", text: "Jakarta Selatan" },
                    { value: "jakarta-utara", text: "Jakarta Utara" },
                    { value: "jakarta-barat", text: "Jakarta Barat" },
                    { value: "jakarta-timur", text: "Jakarta Timur" },
                ],
                "id-jateng": [
                    { value: "semarang", text: "Semarang" },
                    { value: "solo", text: "Surakarta" },
                    { value: "magelang", text: "Magelang" },
                    { value: "tegal", text: "Tegal" },
                ],
                "id-jatim": [
                    { value: "surabaya", text: "Surabaya" },
                    { value: "malang", text: "Malang" },
                    { value: "kediri", text: "Kediri" },
                    { value: "blitar", text: "Blitar" },
                ],
                "id-bali": [
                    { value: "denpasar", text: "Denpasar" },
                    { value: "ubud", text: "Ubud" },
                    { value: "kuta", text: "Kuta" },
                    { value: "nusa-dua", text: "Nusa Dua" },
                ],
                "cn-bj": [
                    { value: "dongcheng", text: "Dongcheng" },
                    { value: "chaoyang", text: "Chaoyang" },
                    { value: "xicheng", text: "Xicheng" },
                    { value: "haidian", text: "Haidian" },
                ],
                "cn-sh": [
                    { value: "pudong", text: "Pudong" },
                    { value: "minhang", text: "Minhang" },
                    { value: "jingan", text: "Jing'an" },
                    { value: "xuhui", text: "Xuhui" },
                ],
                "cn-gd": [
                    { value: "guangzhou", text: "Guangzhou" },
                    { value: "shenzhen", text: "Shenzhen" },
                    { value: "dongguan", text: "Dongguan" },
                    { value: "foshan", text: "Foshan" },
                ],
                "cn-zj": [
                    { value: "hangzhou", text: "Hangzhou" },
                    { value: "ningbo", text: "Ningbo" },
                    { value: "wenzhou", text: "Wenzhou" },
                    { value: "jiaxing", text: "Jiaxing" },
                ],
                "th-bkk": [
                    { value: "ratchathewi", text: "Ratchathewi" },
                    { value: "sathon", text: "Sathon" },
                    { value: "bangkapi", text: "Bangkapi" },
                    { value: "chatuchak", text: "Chatuchak" },
                ],
                "th-ct": [
                    { value: "mueang-chiang-mai", text: "Mueang Chiang Mai" },
                    { value: "hang-dong", text: "Hang Dong" },
                    { value: "saraphi", text: "Saraphi" },
                    { value: "san-pa-tong", text: "San Pa Tong" },
                ],
                "th-pk": [
                    { value: "mueang-phuket", text: "Mueang Phuket" },
                    { value: "kathu", text: "Kathu" },
                    { value: "thalang", text: "Thalang" },
                    { value: "patong", text: "Patong" },
                ],
                "th-kl": [
                    { value: "mueang-krabi", text: "Mueang Krabi" },
                    { value: "ao-nang", text: "Ao Nang" },
                    { value: "koh-lanta", text: "Koh Lanta" },
                    { value: "nuea-khlong", text: "Nuea Khlong" },
                ],
                "vn-hn": [
                    { value: "hoankiem", text: "Hoan Kiem" },
                    { value: "dongda", text: "Dong Da" },
                    { value: "thanhxuan", text: "Thanh Xuan" },
                    { value: "ba-dinh", text: "Ba Dinh" },
                ],
                "vn-hcm": [
                    { value: "district-1", text: "District 1" },
                    { value: "district-2", text: "District 2" },
                    { value: "binh-thanh", text: "Binh Thanh" },
                    { value: "go-vap", text: "Go Vap" },
                ],
                "vn-dn": [
                    { value: "hai-chau", text: "Hai Chau" },
                    { value: "thanh-khe", text: "Thanh Khe" },
                    { value: "son-tra", text: "Son Tra" },
                    { value: "cam-le", text: "Cam Le" },
                ],
                "vn-ct": [
                    { value: "ninh-kieu", text: "Ninh Kieu" },
                    { value: "binh-thuy", text: "Binh Thuy" },
                    { value: "cai-rang", text: "Cai Rang" },
                    { value: "o-mon", text: "O Mon" },
                ],
            },

            // Example value, define this or pass it properly
        };
    },
    methods: {
        getProvinces() {
            return this.provinsiList[this.formData.negara] || [];
        },
        getCities() {
            return this.kotaList[this.formData.provinsi] || [];
        },
        validateForm() {
            const validations = [
                {
                    condition: !this.formData.jenisEkspedisi.length,
                    message: "Please select at least one type of expedition.",
                },
                {
                    condition: !this.formData.badan_usaha,
                    message: "Please select the business entity (Badan Usaha).",
                },
                {
                    condition: !this.formData.nama_perusahaan,
                    message: "Please enter the company name.",
                },
                {
                    condition: !this.formData.alamat_usaha,
                    message: "Please enter the company address.",
                },
                {
                    condition: !this.formData.negara,
                    message: "Please select the country.",
                },
                {
                    condition: !this.formData.provinsi,
                    message: "Please select the province.",
                },
                {
                    condition: !this.formData.kabupaten_kota,
                    message: "Please select the city.",
                },
                {
                    condition:
                        !this.formData.telepon ||
                        !/^\d+$/.test(this.formData.telepon),
                    message: "Please enter a valid phone number.",
                },
                {
                    condition: !this.formData.status_pajak,
                    message: "Please select the tax status.",
                },
                {
                    condition:
                        !this.formData.npwp ||
                        !/^\d{15}$/.test(this.formData.npwp),
                    message: "Please enter a valid 15-digit NPWP.",
                },
                {
                    condition: !this.formData.nama_pic,
                    message: "Please enter the name of the PIC.",
                },
                {
                    condition: !this.formData.jabatan,
                    message: "Please select the position (Jabatan) of the PIC.",
                },
                {
                    condition:
                        !this.formData.ponsel ||
                        !/^\d+$/.test(this.formData.ponsel),
                    message: "Please enter a valid mobile number.",
                },
                {
                    condition: !this.formData.cara_bayar,
                    message: "Please select the payment method.",
                },
                {
                    condition: !this.formData.mataUang.length,
                    message: "Please select at least one currency.",
                },
                {
                    condition: !this.formData.bank,
                    message: "Please select the bank.",
                },
                {
                    condition:
                        !this.formData.no_rekening ||
                        !/^\d+$/.test(this.formData.no_rekening),
                    message: "Please enter a valid bank account number.",
                },
                {
                    condition: !this.formData.swift_code,
                    message: "Please enter the Swift Code.",
                },
            ];
            for (const validation of validations) {
                if (validation.condition) {
                    Swal.fire("Validation Error", validation.message, "error");
                    return false;
                }
            }
            return true;
        },
        async submitForm() {
            if (!this.validateForm()) return;
            this.isLoading = true;

            await axios({
                method: "post",
                url: SRV_URL + "profil_perusahaan/simpan_profil_perusahaan",
                data: this.formData,
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + this.token,
                },
            })
                .then((response) => {
                    Swal.fire({
                        title: "Sukses!!",
                        text: response.data.data.message,
                        icon: "success",
                    }).then((result) => {
                        window.location.reload();
                    });
                    if (checkConsole == "T") {
                        console.log(response.data);
                    }

                    this.isLoading = false;
                })
                .catch((e) => {
                    window.scrollTo(0, 0);
                    this.isLoading = false;
                    if (checkConsole == "T") {
                        console.log(e);
                    }
                    Swal.fire(
                        "Terjadi kesalahan",
                        "gagal, " + e.response.data.data.message,
                        "error"
                    );
                });
            setTimeout(() => {
                this.isLoading = false;
            }, 1000);
        },
        resetForm() {
            this.formData = {
                jenisEkspedisi: [],
                badanUsaha: "",
                namaPerusahaan: "",
                alamatUsaha: "",
                negara: "",
                provinsi: "",
                kabupaten_kota: "",
                telepon: "",
                status_pajak: "",
                npwp: "",
                namaPic: "",
                jabatan: "",
                ponsel: "",
                cara_bayar: "",
                tipe_pembayaran: "",
                mataUang: [],
                bank: "",
                cabang: "",
                nama_nasabah: "",
                no_rekening: "",
                swift_code: "",
            };
        },
    },
};
</script>
