<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireLogin();

// Simpan nama user untuk digunakan dalam cerita
$_SESSION['player_name'] = $_SESSION['user_name'] ?? 'Player';

// Menggunakan satu gambar untuk karakter Astrit
$astritImage = 'https://i.pinimg.com/736x/76/9a/db/769adb2cf348ee9213df37551a6e42a3.jpg';

$characters = [
    'astrit-neutral' => $astritImage,
    'astrit-surprised' => $astritImage,
    'astrit-happy' => $astritImage,
    'astrit-thinking' => $astritImage,
    'astrit-shy' => $astritImage
];

// Data cerita dan pilihan
$story = [
    'start' => [
        'character' => $characters['astrit-neutral'],
        'text' => "Hari pertama di Universitas. Di perpustakaan fakultas MIPA, kamu melihat seorang gadis yang sedang serius membaca buku. Dia adalah Astrit Dwi Antika, mahasiswi jenius dengan IQ 150 yang terkenal di kampus karena prestasinya yang luar biasa. Meskipun kamu terkenal tampan dan populer, tapi kali ini kamu merasa tertantang. Beberapa mahasiswi lain di sekitar perpustakaan mulai berbisik-bisik saat melihatmu.",
        'choices' => [
            'a' => [
                'text' => 'Mencoba menyapa dengan sopan dan memperkenalkan diri',
                'next' => 'scene1a'
            ],
            'b' => [
                'text' => 'Pura-pura meminjam buku di dekatnya sambil mencuri pandang',
                'next' => 'scene1b'
            ],
            'c' => [
                'text' => 'Memperhatikan dari jauh sambil mempelajari kebiasaannya',
                'next' => 'scene1c'
            ]
        ]
    ],
    'scene1a' => [
        'character' => $characters['astrit-surprised'],
        'text' => '"Oh, hai," Astrit melirik sekilas dari bukunya, sedikit terkejut dengan kehadiranmu. Beberapa mahasiswi di sekitar mulai berbisik-bisik lebih keras, ada yang terlihat iri, ada yang mengambil foto diam-diam. "Tumben ada yang berani mendekat, biasanya orang-orang segan," tambahnya dengan nada sedikit bingung.',
        'choices' => [
            'a' => [
                'text' => 'Tanyakan tentang buku yang sedang dibacanya dengan tulus',
                'next' => 'scene2a',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Jelaskan bahwa kamu tertarik dengan kepribadiannya, bukan hanya kepintarannya',
                'next' => 'scene2b',
                'points' => ['manners' => 2]
            ],
            'c' => [
                'text' => 'Akui bahwa kamu memang sudah lama ingin berkenalan',
                'next' => 'scene2c',
                'points' => ['manners' => 1, 'patience' => 1]
            ]
        ]
    ],
    'scene1b' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit tampak menyadari kehadiranmu saat kamu mengambil buku di dekatnya. Matanya yang tajam melirik sekilas ke arahmu, kemudian ke buku yang kamu ambil. "Quantum Mechanics and Path Integrals by Feynman? Buku yang menarik," komentarnya pelan, ada sedikit ketertarikan dalam suaranya.',
        'choices' => [
            'a' => [
                'text' => 'Tanya pendapatnya tentang interpretasi Copenhagen',
                'next' => 'scene2d',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Akui bahwa kamu baru mulai tertarik dengan fisika kuantum',
                'next' => 'scene2e',
                'points' => ['manners' => 2, 'patience' => 1]
            ],
            'c' => [
                'text' => 'Duduk di dekatnya dan mulai membaca dengan serius',
                'next' => 'scene2f',
                'points' => ['patience' => 2]
            ]
        ]
    ],
    'scene1c' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Dari kejauhan, kamu memperhatikan bahwa Astrit selalu datang ke perpustakaan pada jam yang sama, membaca buku-buku fisika tingkat lanjut. Sesekali dia menulis sesuatu di notebook-nya dengan sangat serius. Hari ini dia sedang membaca tentang String Theory.',
        'choices' => [
            'a' => [
                'text' => 'Pinjam buku yang sama dan mulai mempelajarinya',
                'next' => 'scene2g',
                'points' => ['intelligence' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Cari tahu lebih banyak tentang minatnya dari teman sekelasnya',
                'next' => 'scene2h',
                'points' => ['intelligence' => 1, 'patience' => 2]
            ],
            'c' => [
                'text' => 'Datang di jam yang sama besok dengan buku fisika lain',
                'next' => 'scene2i',
                'points' => ['patience' => 2, 'manners' => 1]
            ]
        ]
    ],
    'scene2a' => [
        'character' => $characters['astrit-happy'],
        'text' => '"Oh, ini?" Mata Astrit berbinar. "Ini tentang Teori String dan M-Theory. Kamu tertarik dengan fisika teoretis? Jarang sekali ada yang bertanya tentang ini!" Dia membuka halaman yang ditandai. "Lihat bagian ini, tentang dimensi tambahan dalam teori string. Menurutku ini sangat menarik karena..."',
        'choices' => [
            'a' => [
                'text' => 'Diskusikan pemahaman dasarmu tentang teori string dengan antusias',
                'next' => 'scene3a',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Dengarkan penjelasannya dengan penuh perhatian dan ajukan pertanyaan',
                'next' => 'scene3b',
                'points' => ['patience' => 2, 'manners' => 1]
            ],
            'c' => [
                'text' => 'Ceritakan ketertarikanmu pada fisika sejak SMA',
                'next' => 'scene3c',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ]
        ]
    ],
    'scene2b' => [
        'character' => $characters['astrit-shy'],
        'text' => 'Astrit tersenyum tipis mendengar perkenalan formalmu. "Senang berkenalan denganmu, {player_name}. Kamu mahasiswa jurusan apa?"',
        'choices' => [
            'a' => [
                'text' => 'Ceritakan tentang jurusanmu dengan antusias',
                'next' => 'scene3c',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan pendapatnya tentang jurusanmu',
                'next' => 'scene3d',
                'points' => ['manners' => 2]
            ]
        ]
    ],
    'scene2c' => [
        'character' => $characters['astrit-thinking'],
        'text' => '"Ah, buku itu..." Astrit mulai menjelaskan detail menarik tentang buku yang kamu ambil.',
        'choices' => [
            'a' => [
                'text' => 'Ajak diskusi lebih dalam',
                'next' => 'scene3e',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Dengarkan dengan penuh perhatian',
                'next' => 'scene3f',
                'points' => ['patience' => 2]
            ]
        ]
    ],
    'scene2d' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Kamu memilih untuk fokus pada bukumu. Astrit sesekali melirik ke arahmu, tampak penasaran dengan buku yang kamu baca.',
        'choices' => [
            'a' => [
                'text' => 'Tunjukkan halaman menarik dari buku',
                'next' => 'scene3g',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Terus membaca dengan tenang',
                'next' => 'scene3h',
                'points' => ['patience' => 2]
            ]
        ]
    ],
    'scene2e' => [
        'character' => $characters['astrit-surprised'],
        'text' => 'Kamu menemukan buku fisika kuantum yang sama dan mulai membacanya. Astrit tampak terkejut melihatmu serius membaca.',
        'choices' => [
            'a' => [
                'text' => 'Duduk di dekatnya dan mulai belajar',
                'next' => 'scene3i',
                'points' => ['intelligence' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan pendapatnya tentang bab tertentu',
                'next' => 'scene3j',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ]
        ]
    ],
    'scene2f' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Setelah beberapa saat, Astrit beranjak ke rak buku lain. Dia tampak mencari sesuatu.',
        'choices' => [
            'a' => [
                'text' => 'Tawarkan bantuan mencari buku',
                'next' => 'scene3k',
                'points' => ['manners' => 2]
            ],
            'b' => [
                'text' => 'Ikuti dia dan cari buku yang sama',
                'next' => 'scene3l',
                'points' => ['patience' => 1, 'intelligence' => 1]
            ]
        ]
    ],
    'scene2g' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Kamu mulai membaca buku yang sama dengan Astrit. Dia memperhatikanmu dengan senyum tipis. "Kamu tertarik dengan String Theory juga?"',
        'choices' => [
            'a' => [
                'text' => 'Jelaskan bahwa kamu ingin memahami apa yang dia pelajari',
                'next' => 'scene3m',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan bagian mana yang menurutnya paling menarik',
                'next' => 'scene3n',
                'points' => ['manners' => 2, 'patience' => 1]
            ]
        ]
    ],
    'scene2h' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Dari teman sekelasnya, kamu mengetahui bahwa Astrit sangat menyukai fisika teoretis dan sering menghabiskan waktu di lab komputer untuk simulasi.',
        'choices' => [
            'a' => [
                'text' => 'Pelajari dasar-dasar simulasi fisika',
                'next' => 'scene3o',
                'points' => ['intelligence' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Coba temui dia di lab komputer',
                'next' => 'scene3p',
                'points' => ['manners' => 1, 'patience' => 1]
            ]
        ]
    ],
    'scene2i' => [
        'character' => $characters['astrit-surprised'],
        'text' => 'Keesokan harinya, Astrit tampak terkejut melihatmu sudah ada di perpustakaan dengan buku fisika. "Kamu... juga tertarik dengan fisika?"',
        'choices' => [
            'a' => [
                'text' => 'Ceritakan ketertarikanmu pada fisika dengan antusias',
                'next' => 'scene3q',
                'points' => ['intelligence' => 1, 'manners' => 2]
            ],
            'b' => [
                'text' => 'Akui bahwa kamu ingin belajar lebih banyak darinya',
                'next' => 'scene3r',
                'points' => ['manners' => 2, 'patience' => 1]
            ]
        ]
    ],
    'scene3a' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Mata Astrit berbinar saat kamu menjelaskan pemahaman dasarmu tentang teori string. "Jarang ada yang bisa diskusi tentang ini!"',
        'choices' => [
            'a' => [
                'text' => 'Ajak belajar bersama di lain waktu',
                'next' => 'ending_good',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan rekomendasi buku lanjutan',
                'next' => 'ending_rival',
                'points' => ['intelligence' => 3]
            ]
        ]
    ],
    'scene3b' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Astrit tersenyum tulus. "Aku senang ada yang mau belajar. Mau kujelaskan dasarnya?"',
        'choices' => [
            'a' => [
                'text' => 'Terima tawarannya dengan antusias',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 1, 'manners' => 2, 'patience' => 2]
            ],
            'b' => [
                'text' => 'Minta rekomendasi buku pemula',
                'next' => 'ending_friend',
                'points' => ['manners' => 2, 'patience' => 1]
            ]
        ]
    ],
    'scene3c' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit mendengarkan dengan penuh minat saat kamu bercerita tentang jurusanmu. "Itu bidang yang menarik juga!"',
        'choices' => [
            'a' => [
                'text' => 'Diskusikan irisan kedua bidang',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan pendapatnya tentang kolaborasi',
                'next' => 'ending_good',
                'points' => ['manners' => 2]
            ]
        ]
    ],
    'scene3d' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Astrit memberikan pandangan menarik tentang jurusanmu. Dia tampak senang berbagi pengetahuan.',
        'choices' => [
            'a' => [
                'text' => 'Ajak diskusi lebih lanjut di cafe',
                'next' => 'ending_good',
                'points' => ['manners' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Catat semua sarannya dengan serius',
                'next' => 'ending_friend',
                'points' => ['intelligence' => 1, 'patience' => 2]
            ]
        ]
    ],
    'scene3e' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Diskusi menjadi semakin menarik. Astrit tampak senang menemukan seseorang yang bisa mengimbangi pemikirannya.',
        'choices' => [
            'a' => [
                'text' => 'Ajak bertemu lagi untuk diskusi',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Buat grup belajar bersama',
                'next' => 'ending_drama',
                'points' => ['manners' => 2]
            ]
        ]
    ],
    'scene3f' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit menghargai cara kamu mendengarkan. "Kamu benar-benar memperhatikan ya?"',
        'choices' => [
            'a' => [
                'text' => 'Sampaikan ketertarikanmu pada penjelasannya',
                'next' => 'ending_good',
                'points' => ['manners' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Minta dia menjelaskan lebih detail',
                'next' => 'ending_friend',
                'points' => ['patience' => 2]
            ]
        ]
    ],
    'scene3g' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Astrit tampak tertarik dengan halaman yang kamu tunjukkan. "Wah, kamu juga memahami bagian ini?"',
        'choices' => [
            'a' => [
                'text' => 'Jelaskan pemahamanmu dengan antusias',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Minta pendapatnya tentang interpretasimu',
                'next' => 'ending_good',
                'points' => ['manners' => 2]
            ]
        ]
    ],
    'scene3h' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Keheningan yang nyaman tercipta saat kalian berdua fokus membaca. Astrit sesekali tersenyum melihat keseriusanmu.',
        'choices' => [
            'a' => [
                'text' => 'Ajak diskusi santai setelah selesai membaca',
                'next' => 'ending_good',
                'points' => ['patience' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Lanjutkan membaca dalam diam',
                'next' => 'ending_friend',
                'points' => ['patience' => 3]
            ]
        ]
    ],
    'scene3i' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Astrit tampak senang melihat keseriusanmu dalam belajar. "Kamu cepat menangkap konsepnya ya."',
        'choices' => [
            'a' => [
                'text' => 'Usulkan untuk belajar bersama secara rutin',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Fokus menyelesaikan bab yang sedang dibaca',
                'next' => 'ending_rival',
                'points' => ['intelligence' => 3]
            ]
        ]
    ],
    'scene3j' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit menjelaskan dengan detail tentang bab yang kamu tanyakan. Matanya berbinar saat membahas konsep rumit.',
        'choices' => [
            'a' => [
                'text' => 'Tunjukkan pemahaman dan tambahkan insight',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Catat semua penjelasannya dengan teliti',
                'next' => 'ending_friend',
                'points' => ['patience' => 2, 'manners' => 1]
            ]
        ]
    ],
    'scene3k' => [
        'character' => $characters['astrit-surprised'],
        'text' => '"Oh, terima kasih! Aku sedang mencari buku tentang Mekanika Kuantum tingkat lanjut."',
        'choices' => [
            'a' => [
                'text' => 'Bantu mencari sambil diskusi tentang topik tersebut',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 1, 'manners' => 2]
            ],
            'b' => [
                'text' => 'Cari buku dengan efisien dan profesional',
                'next' => 'ending_good',
                'points' => ['manners' => 2, 'patience' => 1]
            ]
        ]
    ],
    'scene3l' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Astrit menyadari kamu mengikutinya. Dia berhenti sejenak dan menoleh ke arahmu.',
        'choices' => [
            'a' => [
                'text' => 'Jelaskan dengan jujur ketertarikanmu pada topik yang sama',
                'next' => 'ending_good',
                'points' => ['manners' => 2, 'intelligence' => 1]
            ],
            'b' => [
                'text' => 'Pura-pura kebetulan mencari di rak yang sama',
                'next' => 'ending_drama',
                'points' => ['patience' => 1]
            ]
        ]
    ],
    'scene3m' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Setelah beberapa kali pertemuan di perpustakaan, Astrit mulai terlihat lebih nyaman denganmu. "Kamu berbeda dari yang kukira," katanya sambil tersenyum. "Kupikir kamu hanya seperti mahasiswa populer lainnya, tapi ternyata..."',
        'choices' => [
            'a' => [
                'text' => 'Ajak dia makan siang bersama di cafe dekat kampus',
                'next' => 'scene4a',
                'points' => ['manners' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Tanyakan apa yang membuatnya berubah pikiran',
                'next' => 'scene4b',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ]
        ]
    ],
    'scene4a' => [
        'character' => $characters['astrit-shy'],
        'text' => 'Di cafe, suasana lebih santai. Astrit bercerita tentang mimpinya menjadi fisikawan teoretis. "Tapi kadang aku merasa kesepian. Tidak banyak yang bisa diajak diskusi tentang hal-hal seperti ini..."',
        'choices' => [
            'a' => [
                'text' => 'Janji akan selalu mendukung mimpinya',
                'next' => 'ending_perfect',
                'points' => ['manners' => 2, 'patience' => 2]
            ],
            'b' => [
                'text' => 'Bagikan juga mimpimu dengannya',
                'next' => 'ending_good',
                'points' => ['intelligence' => 1, 'manners' => 1]
            ]
        ]
    ],
    'scene4b' => [
        'character' => $characters['astrit-thinking'],
        'text' => '"Kamu..." Astrit tersipu. "Kamu menunjukkan ketertarikan yang tulus pada ilmu pengetahuan. Dan kamu tidak pernah mencoba untuk pamer atau memaksakan diri. Itu... membuatku nyaman."',
        'choices' => [
            'a' => [
                'text' => 'Ungkapkan perasaanmu dengan tulus',
                'next' => 'ending_perfect',
                'points' => ['manners' => 2, 'patience' => 1]
            ],
            'b' => [
                'text' => 'Ajak dia mengerjakan proyek penelitian bersama',
                'next' => 'ending_good',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ]
        ]
    ],
    'scene3n' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit mulai menjelaskan dengan antusias tentang teori yang dia sukai. "Menurutku bagian yang paling menarik adalah konsep dimensi tambahan..."',
        'choices' => [
            'a' => [
                'text' => 'Diskusikan pemahaman dasarmu tentang dimensi',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Minta dia menjelaskan lebih detail',
                'next' => 'ending_good',
                'points' => ['patience' => 2, 'manners' => 1]
            ]
        ]
    ],
    'scene3o' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Setelah beberapa hari belajar, kamu mencoba mendekati Astrit di lab komputer. Dia tampak terkesan dengan usahamu.',
        'choices' => [
            'a' => [
                'text' => 'Tanyakan tips untuk simulasi yang lebih baik',
                'next' => 'ending_good',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Ajak kolaborasi dalam proyek simulasi',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 1, 'manners' => 2]
            ]
        ]
    ],
    'scene3p' => [
        'character' => $characters['astrit-surprised'],
        'text' => 'Astrit terkejut melihatmu di lab. "Kamu juga menggunakan lab komputer untuk penelitian?"',
        'choices' => [
            'a' => [
                'text' => 'Jelaskan proyek yang ingin kamu kerjakan',
                'next' => 'ending_good',
                'points' => ['intelligence' => 2, 'manners' => 1]
            ],
            'b' => [
                'text' => 'Minta saran untuk memulai penelitian',
                'next' => 'ending_friend',
                'points' => ['manners' => 2, 'patience' => 1]
            ]
        ]
    ],
    'scene3q' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Mata Astrit berbinar mendengar penjelasanmu. "Akhirnya ada yang bisa diajak diskusi serius tentang ini!"',
        'choices' => [
            'a' => [
                'text' => 'Usulkan untuk membuat kelompok diskusi',
                'next' => 'ending_perfect',
                'points' => ['intelligence' => 1, 'manners' => 2]
            ],
            'b' => [
                'text' => 'Fokus pada diskusi berdua saja',
                'next' => 'ending_good',
                'points' => ['manners' => 1, 'patience' => 2]
            ]
        ]
    ],
    'scene3r' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Astrit tampak menghargai kejujuranmu. "Kamu berbeda dari yang lain. Biasanya orang-orang berpura-pura sudah mengerti..."',
        'choices' => [
            'a' => [
                'text' => 'Minta dia menjadi mentor belajarmu',
                'next' => 'ending_perfect',
                'points' => ['manners' => 2, 'patience' => 2]
            ],
            'b' => [
                'text' => 'Janji akan berusaha keras belajar',
                'next' => 'ending_good',
                'points' => ['intelligence' => 1, 'patience' => 2]
            ]
        ]
    ],
    'ending_perfect' => [
        'character' => $characters['astrit-happy'],
        'text' => 'Setelah beberapa pertemuan, Astrit mulai membuka hatinya. Kalian menjadi dekat dan saling memahami.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ],
    'ending_good' => [
        'character' => $characters['astrit-shy'],
        'text' => 'Astrit mulai menunjukkan ketertarikan padamu. Hubungan kalian berkembang dengan baik.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ],
    'ending_friend' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Kalian menjadi teman baik. Astrit menghargaimu sebagai teman diskusi yang menyenangkan.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ],
    'ending_rival' => [
        'character' => $characters['astrit-thinking'],
        'text' => 'Persaingan akademik yang sehat membuat kalian saling mendorong untuk berkembang.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ],
    'ending_drama' => [
        'character' => $characters['astrit-surprised'],
        'text' => 'Fans fanatikmu membuat situasi menjadi rumit. Astrit memutuskan untuk menjaga jarak.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ],
    'ending_bad' => [
        'character' => $characters['astrit-neutral'],
        'text' => 'Astrit merasa tidak nyaman dengan pendekatanmu. Dia memilih untuk menghindarimu.',
        'choices' => [
            'a' => [
                'text' => 'Mulai Ulang',
                'next' => 'start'
            ]
        ]
    ]
];

// Endings berdasarkan poin yang dikumpulkan
$endings = [
    'perfect' => [
        'title' => 'Perfect Ending',
        'text' => 'Astrit akhirnya membuka hatinya untukmu. Kalian berdua menjadi pasangan yang sempurna, membuktikan bahwa cinta sejati bisa mengalahkan segala perbedaan.',
        'requirements' => [
            'intelligence' => 8,
            'manners' => 8,
            'patience' => 8
        ]
    ],
    'good' => [
        'title' => 'Good Ending',
        'text' => 'Setelah berbagai usaha, Astrit mengakui bahwa dia tertarik padamu. Kalian mulai menjalin hubungan yang manis.',
        'requirements' => [
            'intelligence' => 6,
            'manners' => 6,
            'patience' => 6
        ]
    ],
    'friend' => [
        'title' => 'Friend Zone Ending',
        'text' => 'Astrit menghargaimu sebagai teman baik. Mungkin suatu hari perasaannya akan berubah.',
        'requirements' => [
            'intelligence' => 4,
            'manners' => 4,
            'patience' => 4
        ]
    ],
    'rival' => [
        'title' => 'Rival Ending',
        'text' => 'Astrit melihatmu sebagai rival intelektual. Kalian bersaing dalam prestasi akademik.',
        'requirements' => [
            'intelligence' => 7,
            'manners' => 2,
            'patience' => 2
        ]
    ],
    'drama' => [
        'title' => 'Drama Ending',
        'text' => 'Fans fanatikmu membuat situasi menjadi rumit. Astrit memutuskan untuk menjaga jarak.',
        'requirements' => [
            'intelligence' => 2,
            'manners' => 2,
            'patience' => 7
        ]
    ],
    'bad' => [
        'title' => 'Bad Ending',
        'text' => 'Astrit merasa terganggu dengan pendekatanmu. Dia memilih untuk menghindarimu.',
        'requirements' => [
            'intelligence' => 1,
            'manners' => 1,
            'patience' => 1
        ]
    ]
];

// Handle game progress
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        $choice = $_POST['choice'];
        $currentScene = $_POST['current_scene'];
        
        // Update points
        if (isset($story[$currentScene]['choices'][$choice]['points'])) {
            foreach ($story[$currentScene]['choices'][$choice]['points'] as $stat => $value) {
                $_SESSION['game_stats'][$stat] = ($_SESSION['game_stats'][$stat] ?? 0) + $value;
            }
        }
        
        // Move to next scene
        $_SESSION['current_scene'] = $story[$currentScene]['choices'][$choice]['next'];
    }
}

// Initialize game if needed
if (!isset($_SESSION['current_scene'])) {
    $_SESSION['current_scene'] = 'start';
    $_SESSION['game_stats'] = [
        'intelligence' => 0,
        'manners' => 0,
        'patience' => 0
    ];
}

$currentScene = $story[$_SESSION['current_scene']];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personality Game - Journey to Better Self</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #5C6BC0;
            --accent-color: #7E57C2;
            --success-color: #4CAF50;
            --warning-color: #FFC107;
            --danger-color: #FF5252;
            --text-color: #333;
            --light-bg: #f5f7fa;
        }

        body {
            background: linear-gradient(135deg, #1a1f3c 0%, #2a3158 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            position: relative;
            overflow-x: hidden;
        }

        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .game-container {
            max-width: 1200px;
            margin: 80px auto 2rem;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .game-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .scene {
            position: relative;
            width: 100%;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .character {
            width: auto;
            height: 500px;
            object-fit: contain;
            margin: 1rem 0;
            filter: drop-shadow(0 0 15px rgba(0,0,0,0.5));
            transition: transform 0.3s ease;
        }

        .character:hover {
            transform: scale(1.02);
        }

        .dialog-box {
            width: 90%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            font-size: 1.2rem;
            line-height: 1.8;
            margin-top: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .dialog-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.1) 50%);
        }

        .choices {
            display: grid;
            gap: 1rem;
            margin-top: 2rem;
            width: 100%;
        }

        .choice-btn {
            padding: 1.2rem 2rem;
            background: rgba(74, 144, 226, 0.1);
            color: white;
            border: 1px solid rgba(74, 144, 226, 0.3);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            text-align: left;
            position: relative;
        }

        .choice-btn:hover {
            background: rgba(74, 144, 226, 0.2);
            border-color: rgba(74, 144, 226, 0.5);
            transform: translateY(-2px);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-item:hover::before {
            transform: scaleX(1);
        }

        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(74, 144, 226, 0.3);
        }

        .scene-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: black;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .scene-transition.active {
            opacity: 1;
            pointer-events: all;
        }

        @media (max-width: 768px) {
            .game-container {
                margin: 60px 1rem 1rem;
                padding: 1rem;
            }

            .character {
                height: 400px;
            }

            .dialog-box {
                font-size: 1rem;
                padding: 1.5rem;
            }

            .choice-btn {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .stat-item {
                padding: 1rem;
            }
        }

        .game-title {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
            text-shadow: 0 0 10px rgba(74, 144, 226, 0.5);
            position: relative;
            padding-bottom: 1rem;
        }

        .game-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .choice-btn .choice-number {
            display: inline-block;
            width: 25px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <i class="fas fa-gamepad"></i>
            Journey to Better Self
        </div>
        <ul class="nav-links">
            <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="iq-test.php"><i class="fas fa-brain"></i> IQ Test</a></li>
            <li><a href="personality-game.php"><i class="fas fa-gamepad"></i> Personality Game</a></li>
            <li><a href="quotes.php"><i class="fas fa-quote-right"></i> Wisdom</a></li>
            <li><a href="games/flappy-bird.php"><i class="fas fa-dove"></i> Mini Games</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="scene-transition"></div>

    <main>
        <div class="game-container">
            <h1 class="game-title">Visual Novel - Journey to Better Self</h1>
            
            <div class="scene">
                <img src="<?php echo $currentScene['character']; ?>" alt="Character" class="character">
                <div class="dialog-box">
                    <?php echo str_replace('{player_name}', $_SESSION['player_name'], $currentScene['text']); ?>
                </div>
            </div>

            <div class="choices">
                <form method="POST" id="choiceForm">
                    <input type="hidden" name="current_scene" value="<?php echo $_SESSION['current_scene']; ?>">
                    <?php 
                    $choiceNumber = 1;
                    foreach ($currentScene['choices'] as $key => $choice): 
                    ?>
                    <button type="submit" name="choice" value="<?php echo $key; ?>" class="choice-btn">
                        <span class="choice-number"><?php echo $choiceNumber++; ?></span>
                        <?php echo $choice['text']; ?>
                    </button>
                    <?php endforeach; ?>
                </form>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-label">Intelligence</div>
                    <div class="stat-value"><?php echo $_SESSION['game_stats']['intelligence']; ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Manners</div>
                    <div class="stat-value"><?php echo $_SESSION['game_stats']['manners']; ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Patience</div>
                    <div class="stat-value"><?php echo $_SESSION['game_stats']['patience']; ?></div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Animasi transisi scene yang ringan
        document.getElementById('choiceForm').addEventListener('submit', function() {
            document.querySelector('.scene-transition').classList.add('active');
            setTimeout(() => {
                document.querySelector('.scene-transition').classList.remove('active');
            }, 300);
        });

        // Efek hover sederhana untuk karakter
        const character = document.querySelector('.character');
        character.addEventListener('mouseover', () => {
            character.style.transform = 'scale(1.02)';
        });
        character.addEventListener('mouseout', () => {
            character.style.transform = 'scale(1)';
        });
    </script>
</body>
</html> 