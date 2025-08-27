<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Currency data (code => [name, symbol]).
     *
     * @var array
     */
    protected $currencies = [
        'AED' => ['United Arab Emirates Dirham', 'د.إ'],
        'ARS' => ['Argentine Peso', '$'],
        'AUD' => ['Australian Dollar', 'A$'],
        'BHD' => ['Bahraini Dinar', 'ب.د'],
        'BDT' => ['Bangladeshi Taka', '৳'],
        'BRL' => ['Brazilian Real', 'R$'],
        'CAD' => ['Canadian Dollar', 'C$'],
        'CHF' => ['Swiss Franc', 'CHF'],
        'CLP' => ['Chilean Peso', '$'],
        'CNY' => ['Chinese Yuan', '¥'],
        'COP' => ['Colombian Peso', '$'],
        'CZK' => ['Czech Koruna', 'Kč'],
        'DKK' => ['Danish Krone', 'kr'],
        'DZD' => ['Algerian Dinar', 'د.ج'],
        'EGP' => ['Egyptian Pound', 'E£'],
        'EUR' => ['Euro', '€'],
        'FJD' => ['Fijian Dollar', 'FJ$'],
        'GBP' => ['British Pound', '£'],
        'HKD' => ['Hong Kong Dollar', 'HK$'],
        'HUF' => ['Hungarian Forint', 'Ft'],
        'IDR' => ['Indonesian Rupiah', 'Rp'],
        'ILS' => ['Israeli New Shekel', '₪'],
        'INR' => ['Indian Rupee', '₹'],
        'JOD' => ['Jordanian Dinar', 'د.ا'],
        'JPY' => ['Japanese Yen', '¥'],
        'KRW' => ['South Korean Won', '₩'],
        'KWD' => ['Kuwaiti Dinar', 'د.ك'],
        'KZT' => ['Kazakhstani Tenge', '₸'],
        'LBP' => ['Lebanese Pound', 'ل.ل'],
        'LKR' => ['Sri Lankan Rupee', '₨'],
        'LYD' => ['Libyan Dinar', 'ل.د'],
        'MAD' => ['Moroccan Dirham', 'د.م.'],
        'MUR' => ['Mauritian Rupee', '₨'],
        'MXN' => ['Mexican Peso', '$'],
        'MYR' => ['Malaysian Ringgit', 'RM'],
        'NGN' => ['Nigerian Naira', '₦'],
        'NOK' => ['Norwegian Krone', 'kr'],
        'NPR' => ['Nepalese Rupee', '₨'],
        'NZD' => ['New Zealand Dollar', 'NZ$'],
        'OMR' => ['Omani Rial', '﷼'],
        'PAB' => ['Panamanian Balboa', 'B/.'],
        'PEN' => ['Peruvian Sol', 'S/'],
        'PHP' => ['Philippine Peso', '₱'],
        'PKR' => ['Pakistani Rupee', '₨'],
        'PLN' => ['Polish Zloty', 'zł'],
        'PYG' => ['Paraguayan Guarani', '₲'],
        'QAR' => ['Qatari Riyal', '﷼'],
        'RON' => ['Romanian Leu', 'lei'],
        'RUB' => ['Russian Ruble', '₽'],
        'SAR' => ['Saudi Riyal', '﷼'],
        'SEK' => ['Swedish Krona', 'kr'],
        'SGD' => ['Singapore Dollar', 'S$'],
        'THB' => ['Thai Baht', '฿'],
        'TND' => ['Tunisian Dinar', 'د.ت'],
        'TRY' => ['Turkish Lira', '₺'],
        'TWD' => ['New Taiwan Dollar', 'NT$'],
        'UAH' => ['Ukrainian Hryvnia', '₴'],
        'USD' => ['US Dollar', '$'],
        'UZS' => ['Uzbekistani Soʻm', 'сўм'],
        'VEF' => ['Venezuelan Bolívar', 'Bs.F'],
        'VND' => ['Vietnamese Dong', '₫'],
        'XAF' => ['Central African CFA Franc', 'FCFA'],
        'XOF' => ['West African CFA Franc', 'CFA'],
        'ZAR' => ['South African Rand', 'R'],
        'ZMW' => ['Zambian Kwacha', 'ZK'],
    ];

    /**
     * Run the database seeds.
     *
     * @param array $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        DB::table('currencies')->delete();

        $defaultCurrency = $parameters['default_currency'] ?? config('app.currency');
        $allowedCurrencies = $parameters['allowed_currencies'] ?? [$defaultCurrency];

        $data = [];
        $id = 1;

        foreach ($allowedCurrencies as $currency) {
            if (!isset($this->currencies[$currency])) {
                continue;
            }

            [$name, $symbol] = $this->currencies[$currency];

            $data[] = [
                'id'     => $id++,
                'code'   => $currency,
                'name'   => $name,
                'symbol' => $symbol,
            ];
        }

        DB::table('currencies')->insert($data);
    }
}
