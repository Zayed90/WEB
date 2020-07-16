# README #

Hal yang dibutuhkan agar web dapat berjalan dengan baik

## Konfigurasi Awal ##

### Database ###
```
Nama Database : database_temp
file backup database "database_temp_currently_used"
```
### Pentaho Files ###
```
Lokasi Pentaho .ktr Files = "pentaho file/New_Currently_Using"
1. Pindahkan lokasi tersebut kedalam folder instalasi pentaho
2. Buka pada project "web_profiling/resources/views/pentahologic"
3. Terdapat 9 folder yaitu fitur profiling yang dapat dijalankan
4. Dari masing-masing folder ubah file "namaprofiling_process.blade.php" pada line 24 di variable
'$exec' ganti 2 lokasi pan.bat dan lokasi file .ktr yang sudah di copy tersebut pada lokasi komputer masing2

```
### Laravel Configuration ###

#Hai
```
Pada saat pertama kali menjalankan untuk melakukan generate key baru dan sesuaikan settingan config koneksi database
laravel dengan komputer masing2
```
Pentaho Files
pentaho file isine pindahen ndk folder pdi

Cleansing Pattern Modul
ada pilihan 4 modul disitu, yang pertama adalah modul choose pattern
saat choose pattern ada 2 pilihan cleansing, bisa menggunakan modul atau langsung ter cleansing semua gapakai modul (all cleansed now)
tabel yang di cleansing adalah tb_ereg_pattern dan kolom nomor
terus pas milih pattern pilih salah satu pola yang akan digunakan misal aa999999999

lanjut ke modul selanjutnya yaitu hapus punctuation (jika memilih cleansing yang menggunakan modul)
pilih salah satu id running yang sudah dilakukan proses cleansing
disini kita akan menghapus tanda baca yang ada di cleansing sebelumnya yang belum terhapus

kemudian modul change pattern
disini memilih pattern yang akan diganti, misal aa999999999 yang sudah dicleansing tadi pengen diubah patternya bisa disini
contoh : string to clean=EREG
         new pattern=TERSERAH
centang accepet  to change lalu execution

terakhir delete space, sama seperti punctuation