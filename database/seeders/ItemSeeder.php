<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'item_name' => "Jam tangan AOKEYO",
                'start_price' => 300000,
                'item_desc' => "Jam tangan murah dengan tampilan menawan",
                'item_image' => 'Lenovo-Laptop-PNG-Picture.png',
                'item_status' => '0',
                'created_at' => now(),
            ],
            [
                'item_name' => "Monitor AXIOO",
                'start_price' => 4000000,
                'item_desc' => "Axioo SCREEN DISPLAY 75 inch IFP + STANDING, touchscreen, kabel power, kabel HDMI, kabel USB touch screen, Remote, stylus pen (2pcs), wall bracket, Dongle Wifi USB",
                'item_image' => 'Lenovo-Laptop-PNG-Picture.png',
                'item_status' => '0',
                'created_at' => now(),
            ],
            [
                'item_name' => "Razer Phone Gaming",
                'start_price' => 2000000,
                'item_desc' => "Razer Phone merupakan ponsel gaming pertama yang diluncurkan oleh Razer, perusahaan yang memproduksi perangkat game. Razer merancang ponsel ini untuk memiliki performa layaknya handheld gaming dengan prosesor berkekuatan tinggi dan didukung RAM yang besar. Tak hanya itu, HP Razer Phone ini juga memiliki kapasitas baterai besar dan layar beresolusi 4K.",
                'item_image' => 'Lenovo-Laptop-PNG-Picture.png',
                'item_status' => '0',
                'created_at' => now(),
            ],
            [
                'item_name' => "Google lens",
                'start_price' => 4000000,
                'item_desc' => "Kacamata ini mampu melindungi mata Anda dari kontak langsung dengan aktifitas pekerjaan Anda, membuat mata tidak terkontaminasi zat ataupun partikel berbahaya yang dapat merusak mata maupun paparan virus.",
                'item_image' => 'Lenovo-Laptop-PNG-Picture.png',
                'item_status' => '0',
                'created_at' => now(),
            ],
            [
                'item_name' => "Lenovo",
                'start_price' => 7000000,
                'item_desc' => "Laptop Lenovo Ideapad S145 hadir dengan desain yang ramping ditambah dengan layarnya yang bisa dibuka hingga 180 derajat. Laptop ini dibekali dengan sejumlah spesifikasi unggulan yang cukup tangguh dan memiliki fitur yang menarik. Jika kamu tertarik untuk memiliki Lenovo Ideapad S145, maka bisa menyimak ulasan ini untuk mendapatkan spesifikasi hingga fitur menarik yang dimilikinya.",
                'item_image' => 'Lenovo-Laptop-PNG-Picture.png',
                'item_status' => '0',
                'created_at' => now(),
            ],
        ];

        Item::insert($items);
    }
}
