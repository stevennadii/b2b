ALTER PROCEDURE SP_B2B_SIMPAN_RAW_DAN_DETAIL_TEST (
  @Kode_Perusahaan varchar(3),
  @ID_User varchar(15),
  @Auth_SP varchar(30),
  @Nama_Api varchar(150),
  @Tanggal DATE,
  @IdUser varchar(25),
  @NoPenawaran varchar(50),
  @IdPengiriman INT,
  @TanggalAwal DATE,
  @TanggalAkhir DATE,
  @IdCaraKirim INT,
  @File VARCHAR(255),
  @Biaya FLOAT,
  @Keterangan VARCHAR(255),
  @Flag CHAR(1),
  @Result_Number int OUTPUT,
  @Result varchar(300) OUTPUT
)
AS
BEGIN
  SET NOCOUNT ON;
  BEGIN TRY

 declare @Ada_Data_User int;                                          
 declare @Ada_Data_Menu int;                                          
                                          
 select  @Ada_Data_User = dbo.B2B_Check_Data_User(@Kode_Perusahaan, @ID_User, @Auth_SP);                                      
 select  @Ada_Data_Menu = dbo.B2B_Check_Role_SP(@Kode_Perusahaan, @ID_User, @Nama_Api);                                      

  
 if (@Ada_Data_User) = 0                 
 begin                                           
  set @Result_Number = 0;                                          
  set @Result = 'Akses ditolak!'                                        
  select @Result_Number as result_number , @Result as result                                          
 return 0;                                          
 end            
        
 else if (@Ada_Data_Menu) = 0                 
 begin                                           
  set @Result_Number = 0;                                          
  set @Result = 'Akses ditolak!!'                                        
  select @Result_Number as result_number , @Result as result                                          
 return 0;                                          
 end 

declare @Ttl_Baris int;                                              
select @Ttl_Baris = count(kode_perusahaan) from B2BDetailRawSementara where Id_User = @ID_User and kode_perusahaan = @Kode_Perusahaan
                                       
if (@Ttl_Baris = 0)
                                                                          
begin                                                                
  set @result_number = '0';                                            
  set @Result = 'Ok'                                          
  select @result_number as result_number, @result as result;                                                     
  return 0;                                                                              
end                      

declare @Init_Faktur_Baru varchar(10);                  
  declare @Faktur_Terakhir as varchar(40);                                  
  declare @Nomor_Faktur_Bahan_Baku as int;                              
                           
                          
  declare @Faktur_Baru varchar(20);             
  
  select @Init_Faktur_Baru = init_quatation_b  from init;                                  
                                       
  select @Faktur_Terakhir = No_Faktur from B2B_Penawaran_Bahan_Baku where Kode_Perusahaan = @Kode_Perusahaan and                                   
  left(no_faktur, len(@Init_Faktur_Baru) + 7) = @Init_Faktur_Baru + '-' +  format(dbo.Get_Date_Time(), 'MM/yy-');                              
                                        
  if (@Faktur_Terakhir = '') or (@Faktur_Terakhir is null)                                   
  begin                                  
   set @Faktur_Baru = @Init_Faktur_Baru + '-' + format(dbo.Get_Date_Time(), 'MM/yy-') + '0001';                                  
  end                                   
  else                                  
  begin                                  
   set @Nomor_Faktur_Bahan_Baku = right(@Faktur_Terakhir, 4);                                  
   set @Faktur_Baru = @Init_Faktur_Baru + '-'  + format(dbo.Get_Date_Time(), 'MM/yy-') + format(@Nomor_Faktur_Bahan_Baku + 1, '0000');                                  
  end                                  


--  insert into B2B_Penawaran_Bahan_Baku(Kode_Perusahaan,No_Faktur,Tanggal,Id_User,No_Penawaran,Id_Pengiriman,Tanggal_Awal_Berlaku_Pnwr,Tanggal_Akhir_Berlaku_Pnwr,Id_Cara_Kirim,Biaya_Kirim,Keterangan,Flag_Include_Biaya_Kirim) values(@Kode_Perusahaan,@Faktur_Baru,@Tanggal,@ID_User,@NoPenawaran,@IdPengiriman,@TanggalAwal,@TanggalAkhir,@IdCaraKirim,@Biaya,@Keterangan,@Flag)   

    DECLARE @Counter INT ;                                                
    SET @Counter = 1;                                                
    WHILE (@Counter <= @Ttl_Baris)                    
    begin                
    
    declare @Id_Raw_Material_Sementara int;									     

    ;with cte as (                                                              
        select a.id, ROW_NUMBER() OVER (Order by id) as nomor from B2BDetailRawSementara a where                                                                 
        a.Kode_Perusahaan = @Kode_Perusahaan  and a.Id_User = @ID_User  
    ) select @Id_Raw_Material_Sementara = id from cte where nomor = @Counter;       
      
    insert into B2B_Penawaran_Bahan_Baku_Detail(Kode_Perusahaan,No_Faktur,Kode_Stock_Owner,Kode_Barang,Satuan,MOQ,Harga,Total,Id_Status,Keterangan)
    select kode_perusahaan,@Faktur_Baru,kode_stock_owner,kode_barang,satuan,moq,harga,total,[status],keterangan from B2BDetailRawSementara where id = @Id_Raw_Material_Sementara



    set @Counter = @Counter + 1;          
    end
    -- Set output hasil
    DELETE FROM B2BDetailRawSementara WHERE Id_User = @ID_User;
    SET @Result_Number = 1;
    SET @Result = 'Data berhasil disimpan';
    SELECT @Result_Number AS result_number, @Result AS result;
  END TRY

  BEGIN CATCH
    -- Jika terjadi kesalahan, rollback
    -- ROLLBACK TRANSACTION;
    SET @Result_Number = 0;
    SET @Result = ERROR_MESSAGE();
    SELECT @Result_Number AS result_number, @Result AS result;
  END CATCH
END

