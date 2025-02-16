<?php

$province = $_GET['province'];


$districts = [
    
    'Badakhshan' => ['Arghanj Khwa', 'Argo', 'Baharak','Darayem', 'Darwaz', 'Darwaz-e-Balla', 'Faiz Abad', 'Ishkashem', 'Jurm','Keshem','Khash','Khwahan', 'Kof Ab', 'Kohistan', 'Koran-wa-Monjan','Raghistan', 'Shahr-e-Buzorg','Shaki', 'Shighnan', 'Shuhada', 'Tagab','Teshkan','Wakhan','Warduj', 'Yaftal-e-Sufla', 'Yamgan', 'Yawan', 'Zebagak'],
    'Badghis' => ['Ab Kamari','Bala Murghab','Ghormach', 'Jawand', 'Muqur', 'Qadis', 'Qala-e-Naw'],
    'Baghlan' => ['Andarab', 'Baghlan-e-jadid','Burka', 'Dahana-e-Ghory', 'Deh Salah', 'Dushi', 'Firing Wa Gharu', 'Guzargah-e- Nur', 'Khenjan','Khowst wa Fereng', 'Khwaja Hejran', 'Nahrin', 'Pul-e-khumri', 'Pul-e-Hesar', 'Tala-wa-barfak'],
    'Balkh' => ['Balkh', 'Chahar Bolak', 'Chahar Kent', 'Chemtal', 'Dawlat Abad', 'Deh Dadi', 'Kaldar', 'Khulm', 'Kishindeh', 'Marmul', 'Mazar-e-Sharif', 'Nahr-e-Shahi', 'Sharak-e-Hayratan', 'Sholgareh', 'Shor Tepa', 'Zari'],
    'Bamyan' => ['Bamyan', 'Kahmard', 'Panjab', 'Sayghan', 'Shibar', 'Waras', 'Yakawlang'],
    'Daykundi' => ['Ashtarlay', 'Gizab', 'Kajran', 'Khadir', 'kiti', 'Miramor', 'Nili', 'Sang-e-Takht', 'Shahristan'],
    'Farah' => ['Anar Dara', 'Bakwa', 'Bala Buluk', 'Farah', 'Gulestan', 'Khak-e-Safed', 'Lash-e-Juwayn', 'Pur Chaman','Pusht Rod', 'Qala-e-Kah', 'Shib Koh'],
    'Faryab' => ['Almar', 'Andkhoy', 'Bil Cheragh', 'Dawlat Abad', 'Garziwan', 'Ghormach','Khan-e-Chahar Bagh', 'Khwaja Sabzposh', 'Khyber', 'Kohistan', 'Maymana', 'Pashtun kot', 'Qaram Qol', 'Qaysar', 'Qorghan', 'Shirin Tagab'],
    'Ghazni' => ['Ab Band', 'Ajrestan', 'Andar', 'Deh Yak', 'Gelan', 'Ghazni', 'Giro', 'Jaghatu', 'Jaghuri', 'Khwaja Umari', 'Malestan', 'Muqur', 'Nawa', 'Nawur', 'Qarabagh', 'Rashidan', 'Waghaz', 'Wali Muhammad-e-Shahid', 'Zana Khan'],
    'Ghor' => ['Chaghcharan', 'Chahar Sadra', 'Dawlat Yar', 'Du Lina', 'Lal Wa Sarjangal', 'Pasaband', 'Saghar', 'Shahrak', 'Taywarah', 'Tolak'],
    'Helmand' => ['Baghran', 'Deh shu', 'Garm Ser', 'Kajaki', 'Lashkar Gah', 'Musa Qaleh', 'Nad-e-Ali', 'Nahr-e-Saraj', 'Naw Zad',  'Nawa-e-Barak Zaiy', 'Reg / Khan Neshin', 'Sangin', 'Wa Sher'],
    'Herat' => ['Adraskan', 'Chisht-e-Sharif', 'Farsi', 'Ghoryan', 'Gulran', 'Guzara', 'Herat', 'Injil', 'Karukh', 'Kohsan', 'Kushk', 'Kushk-e-Kohna', 'Obe', 'Pashtun Zarghun', 'Shindand', 'Zinda Jan'],
    'Jowzjan' => ['Aqcha', 'Darz Ab', 'Fayz Abad',' Khamyab', 'Khanaqa', 'Khwaja Du Koh', 'Mardyan', 'Mingajik', 'Qarqin', 'Qush Tepa', 'Shiberghan'],
    'Kabul' => [ 'Kabul', 'Bagrami', 'Chahar Asyab', 'Deh Sabz', 'Estalef', 'Farza', 'Guldara', 'Kalakan', 'Surobi'],
    'Kandahar' => ['Kandahar','Arghandab', 'Arghistan', 'Daman', 'Ghorak', 'Khakrez', 'Maruf', 'Maywand', 'Miyanshin', 'Nesh', 'Panj wayi', 'Reg', 'Shah Wali Kot', 'Shor Abak', 'Spin Boldak', 'Zheray'],
    'Kapisa' => ['Nejrab', 'Tagab', 'Mahmud-e-Raqi', 'Alasay', 'Hesa Awal-e- Kohestan', 'Hisa Duwum-e- Kohestan', 'Koh Band'],
    'Khost' => ['Matun', 'Bak', 'Gurbuz', 'Jaji Maydan', 'Tani', 'Mando Zayi', 'Musa Khel', 'Nadir Shah Kot', 'Qalandar', 'Sabri', 'Spera', 'Tere Zayi'],
    'Kunar' => ['Asad Abad', 'Bar Kunar', 'Chapa Dara', 'Chawkay', 'Dangam', 'Dara-e-Pech', 'Ghazi Abad', 'Khas Kunar', 'Marawara', 'Narang', 'Nari', 'Nurgal', 'Sarkani', 'Shigal wa shel tan', 'Wata Pur'],
    'Kunduz' => ['Kunduz', 'Ali Abad', 'Khan Abad', 'Imam Saheb', 'Chahar Darah', 'Dasht-e-Archi', 'Qala-e-Zal', 'Aqtash'],
    'Laghman' => ['Alingar', 'Alishang', 'Badpakh', 'Daulat Shah', 'Mehtarlam', 'Qarghayi'],
    'Nangarhar' => ['Jalalabad', 'Achin', 'Bati Kot', 'Behsud', 'Chaparhar', 'Dara-e-Nur', 'Deh Bala', 'Dur Baba', 'Ghani Khel', 'Heska Mina', 'Hesarak', 'Goshta', 'Kama', 'Khowgiani', 'Kot', 'Kuz Kunar', 'Lal Pur', 'Muhmand Dara', 'Nazian', 'Pachier Agam', 'Rodat', 'Sherzad', 'Shinwar', 'Sukh Rod'],
    'Nimroz' => ['Chahar Burjak', 'Chakhansur', 'Delaram', 'Kang', 'Khash Rod','Zaranj'],
    'Nuristan' => ['Parun', 'Barg-e-Matal', 'Du Ab', 'Kamdesh', 'Mandol', 'Nurgaram', 'Wama', 'Waygal'],
    'Paktia' => ['Gardez','Ahmadaba', 'Zazi Aryoub', 'Samkani', 'Dand-e-Patan', 'Jani Khel','Laja Mangal', 'Lija Ahmad Khel', 'Sayed Karam', 'Shawak', 'Zadran', 'Zurmat'],
    'Paktika' => ['Burmul', 'Dila', 'Gian', 'Gomal', 'Jani Khel', 'Mata Khan', 'Nika', 'Omna', 'Rawzeh', 'Sarobi', 'Sharan', 'Tarwe', 'Urgun', 'Waza Khah', 'Wor Mamay', 'Yahya Khel', 'Yosuf Khel', 'Zarghun Shahr', 'Ziruk'],
    'Panjshir' => ['Abshar', 'Bazarak', 'Dara', 'Khenj', 'Parian', 'Rukha', 'Shutul', 'Onaba'],
    'Samangan' => ['Aybak', 'Darah Suf-e-Payin', 'Darah Suf-e-Bala', 'Feroz Nakhchir', 'Hazrat-e- Sultan', 'Khuram wa Sarbagh', 'Ruy-e-Du Ab'],
    'Sar-e Pol' => ['Sar-e-Pul', 'Balkh Ab', 'Gosfandi', 'Kohistanat', 'San Charak', 'Sayad', 'Sozma Qala'],
    'Takhar' => ['Baharak', 'Bangi', 'Chah Ab', 'Chal', 'Darqad', 'Dasht-e-Qala', 'Farkhar', 'Hazar Sumuch', 'Ishkamish', 'Kalafgan', 'Khwaja Bahawuddin', 'Khwaja Ghar', 'Namak Ab', 'Rostaq', 'Taloqan', 'Warsaj', 'Yangi Qala'],
    'Urozgan' => ['Khas Uruzgan', 'Dehrawud', 'Gizab', 'Chora', 'Shahid-e-Hassas', 'Tirin Kot'],
    'Wardak' => ['Maydan Shahr','Saydabad', 'Nerkh', 'Markaz-e-Behsud', 'Jalrez', 'Jaghatu', 'Hesa Awal-e- Behsud', 'Day Mirdad', 'Chak'],
    'Logar' => ['Mohammad Agha', 'Baraki Barak', 'Pul-e-Alam','Charkh', 'Kharwar','Khoshi', 'Azra'],
    'Zabul' => ['Qalat', 'Arghandab', 'Atghar', 'Day chopan', 'Kakar', 'Mizan', 'Naw Bahar', 'Shah Joy', 'Shahr-e-Safa', 'Shinkay', 'Shomulzay', 'Tarnak Wa Jaldak']
   
];

if (isset($districts[$province])) {
   
    echo json_encode(array_map(function($district) {
        return ['district' => $district];
    }, $districts[$province]));
} else {
    echo json_encode([]);
}
?>
