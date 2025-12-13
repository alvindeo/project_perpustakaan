<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Member;
use App\Models\LibraryInfo;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@library.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create librarian user
        User::create([
            'name' => 'Pustakawan',
            'email' => 'librarian@library.com',
            'password' => Hash::make('librarian123'),
            'role' => 'librarian',
        ]);

        // Create sample member user
        $memberUser = User::create([
            'name' => 'John Doe',
            'email' => 'member@library.com',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Novel dan cerita fiksi'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan umum'],
            ['name' => 'Sains', 'description' => 'Buku sains dan teknologi'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah'],
            ['name' => 'Biografi', 'description' => 'Biografi tokoh'],
            ['name' => 'Referensi', 'description' => 'Kamus, ensiklopedia, dll'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample books
        $books = [
            [
                'isbn' => '978-602-03-0001-1',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'category_id' => 1,
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'synopsis' => 'Novel tentang kehidupan anak-anak di Belitung',
                'stock' => 5,
                'available' => 5,
            ],
            [
                'isbn' => '978-602-03-0002-8',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'category_id' => 1,
                'publisher' => 'Hasta Mitra',
                'publication_year' => 1980,
                'synopsis' => 'Novel sejarah Indonesia',
                'stock' => 3,
                'available' => 3,
            ],
            [
                'isbn' => '978-602-03-0003-5',
                'title' => 'Fisika untuk SMA',
                'author' => 'Dr. Bambang Haryanto',
                'category_id' => 3,
                'publisher' => 'Erlangga',
                'publication_year' => 2020,
                'synopsis' => 'Buku pelajaran fisika',
                'stock' => 10,
                'available' => 10,
            ],
            [
                'isbn' => '978-602-03-0004-2',
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'Prof. Sartono Kartodirdjo',
                'category_id' => 4,
                'publisher' => 'Gramedia',
                'publication_year' => 2018,
                'synopsis' => 'Sejarah Indonesia modern',
                'stock' => 4,
                'available' => 4,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create sample member
        Member::create([
            'member_code' => 'M2024001',
            'name' => 'John Doe',
            'email' => 'member@library.com',
            'member_type' => 'student',
            'class' => 'XII IPA 1',
            'phone' => '081234567890',
            'status' => 'active',
            'user_id' => $memberUser->id,
        ]);

        // Create library info
        $libraryInfos = [
            ['key' => 'library_name', 'value' => 'Perpustakaan SMA Dian Nuswantoro'],
            ['key' => 'opening_hours', 'value' => 'Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 12:00'],
            ['key' => 'address', 'value' => 'Jl. Nakula I No. 5-11, Semarang'],
            ['key' => 'phone', 'value' => '(024) 3517261'],
            ['key' => 'email', 'value' => 'perpustakaan@dinus.sch.id'],
            ['key' => 'rules', 'value' => "1. Anggota wajib menunjukkan kartu anggota\n2. Maksimal peminjaman 3 buku\n3. Lama peminjaman 7 hari\n4. Denda keterlambatan Rp 1.000/hari"],
            ['key' => 'fine_per_day', 'value' => '1000'],
            ['key' => 'max_borrow_days', 'value' => '7'],
            ['key' => 'max_books_per_member', 'value' => '3'],
        ];

        foreach ($libraryInfos as $info) {
            LibraryInfo::create($info);
        }

        // Create sample events
        Event::create([
            'title' => 'Bulan Literasi Sekolah',
            'description' => 'Program literasi selama bulan ini dengan berbagai kegiatan menarik',
            'event_date' => now()->addDays(7),
            'type' => 'event',
        ]);

        Event::create([
            'title' => 'Koleksi Buku Baru Tersedia',
            'description' => '50 judul buku baru telah ditambahkan ke koleksi perpustakaan',
            'event_date' => now(),
            'type' => 'news',
        ]);
    }
}
