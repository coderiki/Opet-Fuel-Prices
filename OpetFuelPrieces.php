<?php


namespace App\Library;



class OpetFuelPrieces
{
    private $prices_url = "https://www.opet.com.tr/AjaxProcess/GetFuelPricesList";

    private $field_names = [
        "_IlceAd" => "district",
        "_Kdv" => "is_tax",
        "_Kursunsuz95" => "ultra_force_95",
        "_Kursunsuz9597" => "ultra_force_95_97",
        "_MotorinEcoForce" => "eco_force_euro_diesel",
        "_Motorin" => "ultra_force_euro_diesel",
        "_GazYagi" => "oil",
        "_FuelOil" => "fuel_oil",
        "_YuksekKukurtluOil" => "high_sulfur_fuel_oil",
        "_KaloriferYakiti" => "heating_fuel",
        "_NormalBenzin" => "normal_gasoline",
        "_PotasyumluSuperBenzin" => "potassium_super_gasoline",
        "_Motorin7000PPM" => "diesel_7000_PPM",
        "_Kalyak" => "fuel_oil_4",
        "_FuelOil6" => "fuel_oil_6",
        "_FuelOil1" => "fuel_oil_1",
        "_Kursunsuz98" => "ultra_force_98",
        "_KatkiliKursunsuzBenzin95" => "additive_ultra_force_95",
        "_KirsalMotorin" => "rural_diesel",
        "_FuelOil5" => "fuel_oil_5",
        "PriceDate" => "price_date"
    ];

    public function getPricesFromOpet($name)
    {
        $data = [
            "Cityname" => $name
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->prices_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = @curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function setPricesProvinceData(array $data)
    {
        $new_data = [];

        if (isset($data["data"])) {
            foreach ($data["data"] as $item) {
                $new_item = [];

                foreach ($item as $key => $value) {
                    $new_item = array_merge($new_item, [$this->field_names[$key] ?? $key => $value]);
                }

                array_push($new_data, $new_item);
            }
        }

        return $new_data;
    }
}
