<?php 
// Data array
$arrString = ['paus','hiu','buaya','lumba-lumba','duyung'];

// 1. is_array()
echo "Cek is_array(): ";
if(is_array($arrString)){
    echo "Benar, ini array\n\n";
} else {
    echo "Bukan array\n\n";
}

// 2. count()
echo "Jumlah data (count): ";
echo count($arrString);
echo "\n\n";

// 3. sort()
echo "Hasil sort (urut A-Z):\n";
$sorted = $arrString; // copy biar data asli tidak berubah
sort($sorted);
foreach($sorted as $data){
    echo "- $data\n";
}
echo "\n";

// 4. shuffle()
echo "Hasil shuffle (acak):\n";
$shuffled = $arrString; // copy
shuffle($shuffled);
foreach($shuffled as $data){
    echo "- $data\n";
}
echo "\n";
?>