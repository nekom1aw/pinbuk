<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Seed 10 judul populer untuk setiap kategori utama.
     */
    public function run(): void
    {
        $catalog = [
            1 => [
                'category' => 'Hutan',
                'cover' => 'hutan.png',
                'publisher' => 'Environmental Library',
                'books' => [
                    ['The Hidden Life of Trees', 'Peter Wohlleben', 2015],
                    ['The Overstory', 'Richard Powers', 2018],
                    ['The Forest Unseen', 'David George Haskell', 2012],
                    ['Finding the Mother Tree', 'Suzanne Simard', 2021],
                    ['The Man Who Planted Trees', 'Jean Giono', 1953],
                    ['Braiding Sweetgrass', 'Robin Wall Kimmerer', 2013],
                    ['The Songs of Trees', 'David George Haskell', 2017],
                    ['Forest Bathing', 'Qing Li', 2018],
                    ['The Secret Wisdom of Nature', 'Peter Wohlleben', 2017],
                    ['Tropical Rain Forest Ecology, Diversity, and Conservation', 'Jaboury Ghazoul dan Douglas Sheil', 2010],
                ],
            ],
            2 => [
                'category' => 'Kebun',
                'cover' => 'kebun.png',
                'publisher' => 'Sustainable Agriculture Library',
                'books' => [
                    ['The One-Straw Revolution', 'Masanobu Fukuoka', 1978],
                    ["Gaia's Garden", 'Toby Hemenway', 2001],
                    ["Permaculture: A Designer's Manual", 'Bill Mollison', 1988],
                    ['The New Organic Grower', 'Eliot Coleman', 1989],
                    ['The Market Gardener', 'Jean-Martin Fortier', 2014],
                    ['Teaming with Microbes', 'Jeff Lowenfels dan Wayne Lewis', 2006],
                    ['The Botany of Desire', 'Michael Pollan', 2001],
                    ["The Omnivore's Dilemma", 'Michael Pollan', 2006],
                    ['The Resilient Farm and Homestead', 'Ben Falk', 2013],
                    ['Edible Forest Gardens', 'Dave Jacke dan Eric Toensmeier', 2005],
                ],
            ],
            3 => [
                'category' => 'Tambang & Energi',
                'cover' => 'tambang-energi.png',
                'publisher' => 'Energy and Resources Library',
                'books' => [
                    ['Energy and Civilization: A History', 'Vaclav Smil', 2017],
                    ['The Prize', 'Daniel Yergin', 1991],
                    ['The Quest', 'Daniel Yergin', 2011],
                    ['Sustainable Energy – Without the Hot Air', 'David J. C. MacKay', 2008],
                    ['The Grid', 'Gretchen Bakke', 2016],
                    ['This Changes Everything', 'Naomi Klein', 2014],
                    ['Mining Economics and Strategy', 'Ian C. Runge', 1998],
                    ['Renewable Energy: Power for a Sustainable Future', 'Godfrey Boyle', 2012],
                    ['The New Map', 'Daniel Yergin', 2020],
                    ['Material World', 'Ed Conway', 2023],
                ],
            ],
            4 => [
                'category' => 'Laut',
                'cover' => 'laut.png',
                'publisher' => 'Marine Conservation Library',
                'books' => [
                    ['The Sea Around Us', 'Rachel Carson', 1951],
                    ['The Soul of an Octopus', 'Sy Montgomery', 2015],
                    ['Blue Mind', 'Wallace J. Nichols', 2014],
                    ['The Unnatural History of the Sea', 'Callum Roberts', 2007],
                    ['Cod', 'Mark Kurlansky', 1997],
                    ['The Outlaw Ocean', 'Ian Urbina', 2019],
                    ['Marine Biology', 'Peter Castro dan Michael E. Huber', 2018],
                    ['Ocean of Life', 'Callum Roberts', 2012],
                    ['The Brilliant Abyss', 'Helen Scales', 2021],
                    ['Other Minds', 'Peter Godfrey-Smith', 2016],
                ],
            ],
            5 => [
                'category' => 'Hukum',
                'cover' => 'hukum.png',
                'publisher' => 'Law and Policy Library',
                'books' => [
                    ['The Concept of Law', 'H. L. A. Hart', 1961],
                    ['The Rule of Law', 'Tom Bingham', 2010],
                    ['Justice: What Is the Right Thing to Do?', 'Michael J. Sandel', 2009],
                    ['Environmental Law', 'Stuart Bell dan Donald McGillivray', 2008],
                    ['Hukum Lingkungan di Indonesia', 'Takdir Rahmadi', 2011],
                    ['Pengantar Ilmu Hukum', 'Peter Mahmud Marzuki', 2008],
                    ['Ilmu Hukum', 'Satjipto Rahardjo', 1982],
                    ['Hukum Agraria Indonesia', 'Boedi Harsono', 1997],
                    ['Pure Theory of Law', 'Hans Kelsen', 1960],
                    ['The Environmental Rights Revolution', 'David R. Boyd', 2012],
                ],
            ],
            6 => [
                'category' => 'Keuangan',
                'cover' => 'keuangan.png',
                'publisher' => 'Finance Library',
                'books' => [
                    ['The Intelligent Investor', 'Benjamin Graham', 1949],
                    ['Rich Dad Poor Dad', 'Robert T. Kiyosaki', 1997],
                    ['The Psychology of Money', 'Morgan Housel', 2020],
                    ['A Random Walk Down Wall Street', 'Burton G. Malkiel', 1973],
                    ['Common Stocks and Uncommon Profits', 'Philip Fisher', 1958],
                    ['One Up On Wall Street', 'Peter Lynch', 1989],
                    ['Your Money or Your Life', 'Vicki Robin dan Joe Dominguez', 1992],
                    ['The Millionaire Next Door', 'Thomas J. Stanley dan William D. Danko', 1996],
                    ['Principles', 'Ray Dalio', 2017],
                    ['The Little Book of Common Sense Investing', 'John C. Bogle', 2007],
                ],
            ],
            7 => [
                'category' => 'Novel',
                'cover' => 'novel.png',
                'publisher' => 'Literature Library',
                'books' => [
                    ['Laskar Pelangi', 'Andrea Hirata', 2005],
                    ['Bumi Manusia', 'Pramoedya Ananta Toer', 1980],
                    ['Laut Bercerita', 'Leila S. Chudori', 2017],
                    ['Negeri 5 Menara', 'Ahmad Fuadi', 2009],
                    ['Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1982],
                    ['Cantik Itu Luka', 'Eka Kurniawan', 2002],
                    ['1984', 'George Orwell', 1949],
                    ['To Kill a Mockingbird', 'Harper Lee', 1960],
                    ['The Alchemist', 'Paulo Coelho', 1988],
                    ['The Little Prince', 'Antoine de Saint-Exupéry', 1943],
                ],
            ],
            8 => [
                'category' => 'Lainnya',
                'cover' => 'lainnya.png',
                'publisher' => 'General Knowledge Library',
                'books' => [
                    ['Sapiens', 'Yuval Noah Harari', 2011],
                    ['Homo Deus', 'Yuval Noah Harari', 2015],
                    ['Atomic Habits', 'James Clear', 2018],
                    ['Thinking, Fast and Slow', 'Daniel Kahneman', 2011],
                    ['Ikigai', 'Héctor García dan Francesc Miralles', 2016],
                    ['Factfulness', 'Hans Rosling', 2018],
                    ['A Brief History of Time', 'Stephen Hawking', 1988],
                    ['Cosmos', 'Carl Sagan', 1980],
                    ['Guns, Germs, and Steel', 'Jared Diamond', 1997],
                    ["Man's Search for Meaning", 'Viktor E. Frankl', 1946],
                ],
            ],
        ];

        foreach ($catalog as $categoryId => $group) {
            foreach ($group['books'] as $bookIndex => [$title, $author, $year]) {
                $sequence = (($categoryId - 1) * 10) + $bookIndex + 1;
                $code = 'B-'.str_pad((string) $sequence, 5, '0', STR_PAD_LEFT);

                DB::table('buku')->updateOrInsert(
                    ['kode_uniq' => $code],
                    [
                        'nama_buku' => $title,
                        'penulis' => $author,
                        'terbit_tahun' => $year,
                        'penerbit' => $group['publisher'],
                        'ringkasan' => "Koleksi populer kategori {$group['category']} karya {$author}. Data ini disiapkan sebagai contoh katalog dan dapat dilengkapi dengan sinopsis serta sampul resmi.",
                        'foto_buku' => "/images/book-covers/books/{$code}.jpg",
                        'file' => null,
                        'jenis_buku' => 'cetak',
                        'position_foto' => 'center',
                        'id_kategori_buku' => $categoryId,
                        'sub_kategori1' => null,
                        'sub_kategori2' => null,
                        'stok' => ($bookIndex % 5) + 1,
                        'tampil' => 'ya',
                        'qr_code' => null,
                        'kondisi' => $bookIndex % 3 === 0 ? 'Bekas' : 'Baru',
                        'catatan' => 'Data buku populer dari BukuSeeder.',
                        'tags' => json_encode([
                            strtolower(str_replace([' ', '&'], ['-', 'dan'], $group['category'])),
                            'koleksi-populer',
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
