<?php

class TCDogrulama
{
    public function tcKimlik($tc, $ad, $soyad, $ay, $gun, $yil): array
    {
        if (!$this->identityVerify($tc)) {
            return [
                'success' => false,
                'obj' => [
                    'HataAciklama' => 'T.C Kimlik Numaranız Hatalı'
                ]
            ];
        }

        if (!$this->nameString($ad)) {
            return [
                'success' => false,
                'obj' => [
                    'HataAciklama' => 'Ad Sadece Karakter Olabilir.'
                ]
            ];
        }

        $TCDogrulama = ["TCKimlikNo" => $tc, "Ad" => $ad, "Soyad" => $soyad, "DogumAy" => $ay, "DogumGun" => $gun, "DogumYil" => $yil];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://tckimlik.nvi.gov.tr/tcKimlikNoDogrula/search');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $TCDogrulama);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);

    }

    private function identityVerify(string $id): bool
    {
        if (mb_strlen($id) != 11) {
            return false;
        }
        return true;
    }

    private function nameString(string $id): bool
    {
        if (is_string($id) === false) {
            return false;
        }
        return true;
    }

}

$a = new TCDogrulama;
$data = $a->tcKimlik('tcggir', 'KUBİLAY', 'YILDIRIM', 'aygir', 'gungir', 'yilgir');


print_r(json_encode($data));

?>