<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $url = 'https://aceh.tribunnews.com/tag/aceh-jaya';
        $url2 = 'https://aceh.tribunnews.com/tag/calang';

        // Mengambil konten dari URL menggunakan file_get_contents
        $html = file_get_contents($url);
        $html2 = file_get_contents($url2);

        // Menentukan pola regex untuk mengekstrak teks antara tag <h3> dan </h3>
        $pattern = '/<h3>(.*?)<\/h3>/s';

        $pattern_gambar = '/<img[^>]*src="([^"]*)"[^>]*>/';

        // Melakukan pencocokan pola regex
        preg_match_all($pattern_gambar, $html, $matches_gambar);
        preg_match_all($pattern_gambar, $html2, $matches_gambar2);

        // Melakukan pencocokan pola regex
        preg_match_all($pattern, $html, $matches);
        preg_match_all($pattern, $html2, $matches2);

        // Mengambil teks antara tag <h3> dan </h3>
        $judul = $matches[1];
        $judul2 = $matches2[1];

        $gambar = $matches_gambar[1];
        $gambar2 = $matches_gambar2[1];

        // menggabungkan
        foreach($judul2 as $j){
            if(!in_array($j, $judul)){
                array_push($judul, $j);
            }
        }

        $diperbolehkan = array("jpg","png","jpeg","svg");

        $arr_gambar = array();
        foreach($gambar2 as $g){

            // cek gambar
            $ex = explode(".", $g);
            $ekstensi = end($ex);
            if(in_array($ekstensi, $diperbolehkan)){

                if(!in_array($g, $gambar)){
                    array_push($gambar, $g);
                }

            }

        }
        // print_r($gambar);




        $data['judul'] = $judul;    
        $data['gambar'] = $gambar;

        return view('home', $data);



    }
}
