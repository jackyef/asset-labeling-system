This an Asset Labeling System developed as part of my internship. 

Built on CodeIgniter PHP Framework.

Sistem pelabelan aset ini memiliki konsep mutasi yang berbeda dibanding sistem sebelumnya.
Sebelumnya, mutasi aset didefinisikan sebagai perpindahan aset dari suatu lokasi ke lokasi lain. Namun, sejalan dengan berjalannya sistem itu, disadari bahwa timbul suatu permasalahan utama, yaitu: 

Ketika seorang karyawan berpindah lokasi, misalnya dari HQ level 4 ke HQ level 2, maka aset tersebut tidak ikut berpindah pada sistem, melainkan harus dipindahkan ke Gudang, kemudian kembali pada karyawan pada lokasi yang baru. 

Hal ini memberikan suatu realisasi bahwa pelabelan aset dalam esensinya, tidak terlalu mementingkan sejarah lokasi aset tersebut, tetapi yang diutamakan adalah sejarah kepenanggungjawaban atas aset tersebut. Tidak terlalu penting untuk mengetahui mengenai suatu aset tertentu pernah berada di lokasi mana, saja tetapi yang lebih penting adalah untuk mengetahui siapa saja yang pernah bertanggung jawab atas suatu aset tersebut.

Sistem pelabelan aset ini mengikuti definisi mutasi yang baru. Mutasi aset didefinisikan sebagai perpindahan kepenanggungjawaban atas suatu aset dari seorang karyawan ke karyawan lain. Lokasi dari aset saat ini (current location) pun dapat dilihat dari lokasi karyawan yang memegang aset tersebut saat ini. 

====
Masalah kedua yang dihadapi sistem pelabelan aset yang lama adalah dalam menangani item yang dapat dibongkar pasang. Sistem yang dikembangkan menangani permasalahan ini dengan menambahkan jenis item baru yang dapat dibongkar.

===
Masalah ketiga adalah pelaporan mutasi