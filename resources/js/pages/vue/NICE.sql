ALTER Procedure SP_B2B_Get_Expedition
(          
@Kode_Perusahaan varchar(3),          
@Id_User varchar(30),          
@Auth_SP varchar(30),          
@Nama_Api varchar(30),          
@Result varchar(300) output,                  
@Result_Number int output                
)                
as                
set nocount on;                
begin                
begin try                    
                
 -------------------                              
 --AWAL TEMPLATE UNTUK CEK ROLE DLL                              
 declare @Ada_Data_User int;                                          
 declare @Ada_Data_Menu int;                                          
                                          
 select  @Ada_Data_User = dbo.B2B_Check_Data_User(@Kode_Perusahaan, @ID_User, @Auth_SP);                                      
 select  @Ada_Data_Menu = dbo.B2B_Check_Role_SP(@Kode_Perusahaan, @ID_User, @Nama_Api);                                      

set @Result_Number = 1 
 
 
SELECT 
    a.No_Penawaran AS NoPenawaran,
    e.Kode_Kendaraan AS JenisKendaraan,
    b.Id_User AS Ekspedisi,
    f.nama_kabupaten_kota AS Asal,
    f.nama_kabupaten_kota AS Tujuan,
    'IDR' AS MataUang,
    d.Tarif AS Tarif,
    d.Biaya_Lain AS BiayaLain,
    d.Tarif + d.Biaya_Lain AS Total,
    'Y' AS IncPajak,
    CONCAT(b.Tanggal_Mulai, ' S/D ', b.Tanggal_Selesai) AS Periode,
    @Result_Number as result_number
FROM 
    B2B_Approval_Expedition a,
    B2B_Expedition b,
    B2B_Detail_Expedition c,
    B2B_Detail_Vehicle_Expedition d,
    B2B_Master_Kendaraan e,
    tbl_kabupaten_kota f
WHERE 
    a.No_Transaksi = b.No_Faktur 
    AND b.No_Faktur = c.No_Faktur
    AND c.No_Urut = d.Id_Detail_Expedition
    AND d.Jenis_Kendaraan = e.Id_Kendaraan
    AND c.Kota_Asal = f.id_kabupaten_kota
    AND c.Kota_Tujuan = f.id_kabupaten_kota
GROUP BY
    a.No_Penawaran,
    e.Kode_Kendaraan,
    b.Id_User,
    f.nama_kabupaten_kota,
    f.nama_kabupaten_kota,
    d.Tarif,
    d.Biaya_Lain,
    b.Tanggal_Mulai,
    b.Tanggal_Selesai
ORDER BY 
    d.Tarif ASC; -- Sort by Harga from smallest to largest

       
end try                      
begin catch                
rollback                
 set @result_number = 0;                            
 set @result = 'Ada Kesalahan! ' + ERROR_MESSAGE();                              
 select @result_number as result_number, @result as result;                                
end catch                
end

SELECT 
    a.No_Penawaran AS NoPenawaran,
    d.Jenis_Kendaraan AS JenisKendaraan,
    b.Id_User AS Ekspedisi,
    c.Kota_Asal AS Asal,
    c.Kota_Tujuan AS Tujuan,
    'IDR' AS MataUang,
    d.Tarif AS Tarif,
    d.Biaya_Lain AS BiayaLain,
    d.Tarif + d.Biaya_Lain AS Total,
    'Y' AS IncPajak,
    CONCAT(b.Tanggal_Mulai, ' S/D ', b.Tanggal_Selesai) AS Periode
FROM 
    B2B_Approval_Expedition a,
    B2B_Expedition b,
    B2B_Detail_Expedition c,
    B2B_Detail_Vehicle_Expedition d,
    B2B_Master_Kendaraan e,
    tbl_kabupaten_kota f
WHERE 
    a.No_Transaksi = b.No_Faktur 
    AND b.No_Faktur = c.No_Faktur
    AND c.No_Urut = d.Id_Detail_Expedition
    AND d.Jenis_Kendaraan = e.Id_Kendaraan
    AND c.Kota_Asal = f.id_kabupaten_kota
    AND c.Kota_Tujuan = f.id_kabupaten_kota
GROUP BY
    a.No_Penawaran,
    d.Jenis_Kendaraan,
    b.Id_User,
    c.Kota_Asal,
    c.Kota_Tujuan,
    d.Tarif,
    d.Biaya_Lain,
    b.Tanggal_Mulai,
    b.Tanggal_Selesai
ORDER BY 
    d.Tarif ASC; -- Sort by Harga from smallest to largest

    select * from B2B_Approval_Expedition a
    select * from B2B_Expedition b
    select * from B2B_Detail_Expedition c
    select * from B2B_Detail_Vehicle_Expedition d


    DELETE from B2B_Approval_Expedition
    DELETE from B2B_Expedition 
    DELETE from B2B_Detail_Expedition 
    DELETE from B2B_Detail_Vehicle_Expedition 

    select * from B2B_Jenis_Expense