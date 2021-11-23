<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('countries')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE countries AUTO_INCREMENT = 1");
        }
        $rows = [
            ['iso' => 'US', 'title' => 'United States', 'created_by' => 1],
            ['iso' => 'CA', 'title' => 'Canada', 'created_by' => 1],
            ['iso' => 'AF', 'title' => 'Afghanistan', 'created_by' => 1],
            ['iso' => 'AL', 'title' => 'Albania', 'created_by' => 1],
            ['iso' => 'DZ', 'title' => 'Algeria', 'created_by' => 1],
            ['iso' => 'AS', 'title' => 'American Samoa', 'created_by' => 1],
            ['iso' => 'AD', 'title' => 'Andorra', 'created_by' => 1],
            ['iso' => 'AO', 'title' => 'Angola', 'created_by' => 1],
            ['iso' => 'AI', 'title' => 'Anguilla', 'created_by' => 1],
            ['iso' => 'AQ', 'title' => 'Antarctica', 'created_by' => 1],
            ['iso' => 'AG', 'title' => 'Antigua and/or Barbuda', 'created_by' => 1],
            ['iso' => 'AR', 'title' => 'Argentina', 'created_by' => 1],
            ['iso' => 'AM', 'title' => 'Armenia', 'created_by' => 1],
            ['iso' => 'AW', 'title' => 'Aruba', 'created_by' => 1],
            ['iso' => 'AU', 'title' => 'Australia', 'created_by' => 1],
            ['iso' => 'AT', 'title' => 'Austria', 'created_by' => 1],
            ['iso' => 'AZ', 'title' => 'Azerbaijan', 'created_by' => 1],
            ['iso' => 'BS', 'title' => 'Bahamas', 'created_by' => 1],
            ['iso' => 'BH', 'title' => 'Bahrain', 'created_by' => 1],
            ['iso' => 'BD', 'title' => 'Bangladesh', 'created_by' => 1],
            ['iso' => 'BB', 'title' => 'Barbados', 'created_by' => 1],
            ['iso' => 'BY', 'title' => 'Belarus', 'created_by' => 1],
            ['iso' => 'BE', 'title' => 'Belgium', 'created_by' => 1],
            ['iso' => 'BZ', 'title' => 'Belize', 'created_by' => 1],
            ['iso' => 'BJ', 'title' => 'Benin', 'created_by' => 1],
            ['iso' => 'BM', 'title' => 'Bermuda', 'created_by' => 1],
            ['iso' => 'BT', 'title' => 'Bhutan', 'created_by' => 1],
            ['iso' => 'BO', 'title' => 'Bolivia', 'created_by' => 1],
            ['iso' => 'BA', 'title' => 'Bosnia and Herzegovina', 'created_by' => 1],
            ['iso' => 'BW', 'title' => 'Botswana', 'created_by' => 1],
            ['iso' => 'BV', 'title' => 'Bouvet Island', 'created_by' => 1],
            ['iso' => 'BR', 'title' => 'Brazil', 'created_by' => 1],
            ['iso' => 'IO', 'title' => 'British lndian Ocean Territory', 'created_by' => 1],
            ['iso' => 'BN', 'title' => 'Brunei Darussalam', 'created_by' => 1],
            ['iso' => 'BG', 'title' => 'Bulgaria', 'created_by' => 1],
            ['iso' => 'BF', 'title' => 'Burkina Faso', 'created_by' => 1],
            ['iso' => 'BI', 'title' => 'Burundi', 'created_by' => 1],
            ['iso' => 'KH', 'title' => 'Cambodia', 'created_by' => 1],
            ['iso' => 'CM', 'title' => 'Cameroon', 'created_by' => 1],
            ['iso' => 'CV', 'title' => 'Cape Verde', 'created_by' => 1],
            ['iso' => 'KY', 'title' => 'Cayman Islands', 'created_by' => 1],
            ['iso' => 'CF', 'title' => 'Central African Republic', 'created_by' => 1],
            ['iso' => 'TD', 'title' => 'Chad', 'created_by' => 1],
            ['iso' => 'CL', 'title' => 'Chile', 'created_by' => 1],
            ['iso' => 'CN', 'title' => 'China', 'created_by' => 1],
            ['iso' => 'CX', 'title' => 'Christmas Island', 'created_by' => 1],
            ['iso' => 'CC', 'title' => 'Cocos (Keeling) Islands', 'created_by' => 1],
            ['iso' => 'CO', 'title' => 'Colombia', 'created_by' => 1],
            ['iso' => 'KM', 'title' => 'Comoros', 'created_by' => 1],
            ['iso' => 'CG', 'title' => 'Congo', 'created_by' => 1],
            ['iso' => 'CK', 'title' => 'Cook Islands', 'created_by' => 1],
            ['iso' => 'CR', 'title' => 'Costa Rica', 'created_by' => 1],
            ['iso' => 'HR', 'title' => 'Croatia (Hrvatska)', 'created_by' => 1],
            ['iso' => 'CU', 'title' => 'Cuba', 'created_by' => 1],
            ['iso' => 'CY', 'title' => 'Cyprus', 'created_by' => 1],
            ['iso' => 'CZ', 'title' => 'Czech Republic', 'created_by' => 1],
            ['iso' => 'CD', 'title' => 'Democratic Republic of Congo', 'created_by' => 1],
            ['iso' => 'DK', 'title' => 'Denmark', 'created_by' => 1],
            ['iso' => 'DJ', 'title' => 'Djibouti', 'created_by' => 1],
            ['iso' => 'DM', 'title' => 'Dominica', 'created_by' => 1],
            ['iso' => 'DO', 'title' => 'Dominican Republic', 'created_by' => 1],
            ['iso' => 'TP', 'title' => 'East Timor', 'created_by' => 1],
            ['iso' => 'EC', 'title' => 'Ecudaor', 'created_by' => 1],
            ['iso' => 'EG', 'title' => 'Egypt', 'created_by' => 1],
            ['iso' => 'SV', 'title' => 'El Salvador', 'created_by' => 1],
            ['iso' => 'GQ', 'title' => 'Equatorial Guinea', 'created_by' => 1],
            ['iso' => 'ER', 'title' => 'Eritrea', 'created_by' => 1],
            ['iso' => 'EE', 'title' => 'Estonia', 'created_by' => 1],
            ['iso' => 'ET', 'title' => 'Ethiopia', 'created_by' => 1],
            ['iso' => 'FK', 'title' => 'Falkland Islands (Malvinas)', 'created_by' => 1],
            ['iso' => 'FO', 'title' => 'Faroe Islands', 'created_by' => 1],
            ['iso' => 'FJ', 'title' => 'Fiji', 'created_by' => 1],
            ['iso' => 'FI', 'title' => 'Finland', 'created_by' => 1],
            ['iso' => 'FR', 'title' => 'France', 'created_by' => 1],
            ['iso' => 'FX', 'title' => 'France, Metropolitan', 'created_by' => 1],
            ['iso' => 'GF', 'title' => 'French Guiana', 'created_by' => 1],
            ['iso' => 'PF', 'title' => 'French Polynesia', 'created_by' => 1],
            ['iso' => 'TF', 'title' => 'French Southern Territories', 'created_by' => 1],
            ['iso' => 'GA', 'title' => 'Gabon', 'created_by' => 1],
            ['iso' => 'GM', 'title' => 'Gambia', 'created_by' => 1],
            ['iso' => 'GE', 'title' => 'Georgia', 'created_by' => 1],
            ['iso' => 'DE', 'title' => 'Germany', 'created_by' => 1],
            ['iso' => 'GH', 'title' => 'Ghana', 'created_by' => 1],
            ['iso' => 'GI', 'title' => 'Gibraltar', 'created_by' => 1],
            ['iso' => 'GR', 'title' => 'Greece', 'created_by' => 1],
            ['iso' => 'GL', 'title' => 'Greenland', 'created_by' => 1],
            ['iso' => 'GD', 'title' => 'Grenada', 'created_by' => 1],
            ['iso' => 'GP', 'title' => 'Guadeloupe', 'created_by' => 1],
            ['iso' => 'GU', 'title' => 'Guam', 'created_by' => 1],
            ['iso' => 'GT', 'title' => 'Guatemala', 'created_by' => 1],
            ['iso' => 'GN', 'title' => 'Guinea', 'created_by' => 1],
            ['iso' => 'GW', 'title' => 'Guinea-Bissau', 'created_by' => 1],
            ['iso' => 'GY', 'title' => 'Guyana', 'created_by' => 1],
            ['iso' => 'HT', 'title' => 'Haiti', 'created_by' => 1],
            ['iso' => 'HM', 'title' => 'Heard and Mc Donald Islands', 'created_by' => 1],
            ['iso' => 'HN', 'title' => 'Honduras', 'created_by' => 1],
            ['iso' => 'HK', 'title' => 'Hong Kong', 'created_by' => 1],
            ['iso' => 'HU', 'title' => 'Hungary', 'created_by' => 1],
            ['iso' => 'IS', 'title' => 'Iceland', 'created_by' => 1],
            ['iso' => 'IN', 'title' => 'India', 'created_by' => 1],
            ['iso' => 'ID', 'title' => 'Indonesia', 'created_by' => 1],
            ['iso' => 'IR', 'title' => 'Iran (Islamic Republic of)', 'created_by' => 1],
            ['iso' => 'IQ', 'title' => 'Iraq', 'created_by' => 1],
            ['iso' => 'IE', 'title' => 'Ireland', 'created_by' => 1],
            ['iso' => 'IL', 'title' => 'Israel', 'created_by' => 1],
            ['iso' => 'IT', 'title' => 'Italy', 'created_by' => 1],
            ['iso' => 'CI', 'title' => 'Ivory Coast', 'created_by' => 1],
            ['iso' => 'JM', 'title' => 'Jamaica', 'created_by' => 1],
            ['iso' => 'JP', 'title' => 'Japan', 'created_by' => 1],
            ['iso' => 'JO', 'title' => 'Jordan', 'created_by' => 1],
            ['iso' => 'KZ', 'title' => 'Kazakhstan', 'created_by' => 1],
            ['iso' => 'KE', 'title' => 'Kenya', 'created_by' => 1],
            ['iso' => 'KI', 'title' => 'Kiribati', 'created_by' => 1],
            ['iso' => 'KP', 'title' => 'Korea, Democratic People\'s Republic of', 'created_by' => 1],
            ['iso' => 'KR', 'title' => 'Korea, Republic of', 'created_by' => 1],
            ['iso' => 'KW', 'title' => 'Kuwait', 'created_by' => 1],
            ['iso' => 'KG', 'title' => 'Kyrgyzstan', 'created_by' => 1],
            ['iso' => 'LA', 'title' => 'Lao People\'s Democratic Republic', 'created_by' => 1],
            ['iso' => 'LV', 'title' => 'Latvia', 'created_by' => 1],
            ['iso' => 'LB', 'title' => 'Lebanon', 'created_by' => 1],
            ['iso' => 'LS', 'title' => 'Lesotho', 'created_by' => 1],
            ['iso' => 'LR', 'title' => 'Liberia', 'created_by' => 1],
            ['iso' => 'LY', 'title' => 'Libyan Arab Jamahiriya', 'created_by' => 1],
            ['iso' => 'LI', 'title' => 'Liechtenstein', 'created_by' => 1],
            ['iso' => 'LT', 'title' => 'Lithuania', 'created_by' => 1],
            ['iso' => 'LU', 'title' => 'Luxembourg', 'created_by' => 1],
            ['iso' => 'MO', 'title' => 'Macau', 'created_by' => 1],
            ['iso' => 'MK', 'title' => 'Macedonia', 'created_by' => 1],
            ['iso' => 'MG', 'title' => 'Madagascar', 'created_by' => 1],
            ['iso' => 'MW', 'title' => 'Malawi', 'created_by' => 1],
            ['iso' => 'MY', 'title' => 'Malaysia', 'created_by' => 1],
            ['iso' => 'MV', 'title' => 'Maldives', 'created_by' => 1],
            ['iso' => 'ML', 'title' => 'Mali', 'created_by' => 1],
            ['iso' => 'MT', 'title' => 'Malta', 'created_by' => 1],
            ['iso' => 'MH', 'title' => 'Marshall Islands', 'created_by' => 1],
            ['iso' => 'MQ', 'title' => 'Martinique', 'created_by' => 1],
            ['iso' => 'MR', 'title' => 'Mauritania', 'created_by' => 1],
            ['iso' => 'MU', 'title' => 'Mauritius', 'created_by' => 1],
            ['iso' => 'TY', 'title' => 'Mayotte', 'created_by' => 1],
            ['iso' => 'MX', 'title' => 'Mexico', 'created_by' => 1],
            ['iso' => 'FM', 'title' => 'Micronesia, Federated States of', 'created_by' => 1],
            ['iso' => 'MD', 'title' => 'Moldova, Republic of', 'created_by' => 1],
            ['iso' => 'MC', 'title' => 'Monaco', 'created_by' => 1],
            ['iso' => 'MN', 'title' => 'Mongolia', 'created_by' => 1],
            ['iso' => 'MS', 'title' => 'Montserrat', 'created_by' => 1],
            ['iso' => 'MA', 'title' => 'Morocco', 'created_by' => 1],
            ['iso' => 'MZ', 'title' => 'Mozambique', 'created_by' => 1],
            ['iso' => 'MM', 'title' => 'Myanmar', 'created_by' => 1],
            ['iso' => 'NA', 'title' => 'Namibia', 'created_by' => 1],
            ['iso' => 'NR', 'title' => 'Nauru', 'created_by' => 1],
            ['iso' => 'NP', 'title' => 'Nepal', 'created_by' => 1],
            ['iso' => 'NL', 'title' => 'Netherlands', 'created_by' => 1],
            ['iso' => 'AN', 'title' => 'Netherlands Antilles', 'created_by' => 1],
            ['iso' => 'NC', 'title' => 'New Caledonia', 'created_by' => 1],
            ['iso' => 'NZ', 'title' => 'New Zealand', 'created_by' => 1],
            ['iso' => 'NI', 'title' => 'Nicaragua', 'created_by' => 1],
            ['iso' => 'NE', 'title' => 'Niger', 'created_by' => 1],
            ['iso' => 'NG', 'title' => 'Nigeria', 'created_by' => 1],
            ['iso' => 'NU', 'title' => 'Niue', 'created_by' => 1],
            ['iso' => 'NF', 'title' => 'Norfork Island', 'created_by' => 1],
            ['iso' => 'MP', 'title' => 'Northern Mariana Islands', 'created_by' => 1],
            ['iso' => 'NO', 'title' => 'Norway', 'created_by' => 1],
            ['iso' => 'OM', 'title' => 'Oman', 'created_by' => 1],
            ['iso' => 'PK', 'title' => 'Pakistan', 'created_by' => 1],
            ['iso' => 'PW', 'title' => 'Palau', 'created_by' => 1],
            ['iso' => 'PA', 'title' => 'Panama', 'created_by' => 1],
            ['iso' => 'PG', 'title' => 'Papua New Guinea', 'created_by' => 1],
            ['iso' => 'PY', 'title' => 'Paraguay', 'created_by' => 1],
            ['iso' => 'PE', 'title' => 'Peru', 'created_by' => 1],
            ['iso' => 'PH', 'title' => 'Philippines', 'created_by' => 1],
            ['iso' => 'PN', 'title' => 'Pitcairn', 'created_by' => 1],
            ['iso' => 'PL', 'title' => 'Poland', 'created_by' => 1],
            ['iso' => 'PT', 'title' => 'Portugal', 'created_by' => 1],
            ['iso' => 'PR', 'title' => 'Puerto Rico', 'created_by' => 1],
            ['iso' => 'QA', 'title' => 'Qatar', 'created_by' => 1],
            ['iso' => 'SS', 'title' => 'Republic of South Sudan', 'created_by' => 1],
            ['iso' => 'RE', 'title' => 'Reunion', 'created_by' => 1],
            ['iso' => 'RO', 'title' => 'Romania', 'created_by' => 1],
            ['iso' => 'RU', 'title' => 'Russian Federation', 'created_by' => 1],
            ['iso' => 'RW', 'title' => 'Rwanda', 'created_by' => 1],
            ['iso' => 'KN', 'title' => 'Saint Kitts and Nevis', 'created_by' => 1],
            ['iso' => 'LC', 'title' => 'Saint Lucia', 'created_by' => 1],
            ['iso' => 'VC', 'title' => 'Saint Vincent and the Grenadines', 'created_by' => 1],
            ['iso' => 'WS', 'title' => 'Samoa', 'created_by' => 1],
            ['iso' => 'SM', 'title' => 'San Marino', 'created_by' => 1],
            ['iso' => 'ST', 'title' => 'Sao Tome and Principe', 'created_by' => 1],
            ['iso' => 'SA', 'title' => 'Saudi Arabia', 'created_by' => 1],
            ['iso' => 'SN', 'title' => 'Senegal', 'created_by' => 1],
            ['iso' => 'RS', 'title' => 'Serbia', 'created_by' => 1],
            ['iso' => 'SC', 'title' => 'Seychelles', 'created_by' => 1],
            ['iso' => 'SL', 'title' => 'Sierra Leone', 'created_by' => 1],
            ['iso' => 'SG', 'title' => 'Singapore', 'created_by' => 1],
            ['iso' => 'SK', 'title' => 'Slovakia', 'created_by' => 1],
            ['iso' => 'SI', 'title' => 'Slovenia', 'created_by' => 1],
            ['iso' => 'SB', 'title' => 'Solomon Islands', 'created_by' => 1],
            ['iso' => 'SO', 'title' => 'Somalia', 'created_by' => 1],
            ['iso' => 'ZA', 'title' => 'South Africa', 'created_by' => 1],
            ['iso' => 'GS', 'title' => 'South Georgia South Sandwich Islands', 'created_by' => 1],
            ['iso' => 'ES', 'title' => 'Spain', 'created_by' => 1],
            ['iso' => 'LK', 'title' => 'Sri Lanka', 'created_by' => 1],
            ['iso' => 'SH', 'title' => 'St. Helena', 'created_by' => 1],
            ['iso' => 'PM', 'title' => 'St. Pierre and Miquelon', 'created_by' => 1],
            ['iso' => 'SD', 'title' => 'Sudan', 'created_by' => 1],
            ['iso' => 'SR', 'title' => 'Suriname', 'created_by' => 1],
            ['iso' => 'SJ', 'title' => 'Svalbarn and Jan Mayen Islands', 'created_by' => 1],
            ['iso' => 'SZ', 'title' => 'Swaziland', 'created_by' => 1],
            ['iso' => 'SE', 'title' => 'Sweden', 'created_by' => 1],
            ['iso' => 'CH', 'title' => 'Switzerland', 'created_by' => 1],
            ['iso' => 'SY', 'title' => 'Syrian Arab Republic', 'created_by' => 1],
            ['iso' => 'TW', 'title' => 'Taiwan', 'created_by' => 1],
            ['iso' => 'TJ', 'title' => 'Tajikistan', 'created_by' => 1],
            ['iso' => 'TZ', 'title' => 'Tanzania, United Republic of', 'created_by' => 1],
            ['iso' => 'TH', 'title' => 'Thailand', 'created_by' => 1],
            ['iso' => 'TG', 'title' => 'Togo', 'created_by' => 1],
            ['iso' => 'TK', 'title' => 'Tokelau', 'created_by' => 1],
            ['iso' => 'TO', 'title' => 'Tonga', 'created_by' => 1],
            ['iso' => 'TT', 'title' => 'Trinidad and Tobago', 'created_by' => 1],
            ['iso' => 'TN', 'title' => 'Tunisia', 'created_by' => 1],
            ['iso' => 'TR', 'title' => 'Turkey', 'created_by' => 1],
            ['iso' => 'TM', 'title' => 'Turkmenistan', 'created_by' => 1],
            ['iso' => 'TC', 'title' => 'Turks and Caicos Islands', 'created_by' => 1],
            ['iso' => 'TV', 'title' => 'Tuvalu', 'created_by' => 1],
            ['iso' => 'UG', 'title' => 'Uganda', 'created_by' => 1],
            ['iso' => 'UA', 'title' => 'Ukraine', 'created_by' => 1],
            ['iso' => 'AE', 'title' => 'United Arab Emirates', 'created_by' => 1],
            ['iso' => 'GB', 'title' => 'United Kingdom', 'created_by' => 1],
            ['iso' => 'UM', 'title' => 'United States minor outlying islands', 'created_by' => 1],
            ['iso' => 'UY', 'title' => 'Uruguay', 'created_by' => 1],
            ['iso' => 'UZ', 'title' => 'Uzbekistan', 'created_by' => 1],
            ['iso' => 'VU', 'title' => 'Vanuatu', 'created_by' => 1],
            ['iso' => 'VA', 'title' => 'Vatican City State', 'created_by' => 1],
            ['iso' => 'VE', 'title' => 'Venezuela', 'created_by' => 1],
            ['iso' => 'VN', 'title' => 'Vietnam', 'created_by' => 1],
            ['iso' => 'VG', 'title' => 'Virgin Islands (British)', 'created_by' => 1],
            ['iso' => 'VI', 'title' => 'Virgin Islands (U.S.)', 'created_by' => 1],
            ['iso' => 'WF', 'title' => 'Wallis and Futuna Islands', 'created_by' => 1],
            ['iso' => 'EH', 'title' => 'Western Sahara', 'created_by' => 1],
            ['iso' => 'YE', 'title' => 'Yemen', 'created_by' => 1],
            ['iso' => 'YU', 'title' => 'Yugoslavia', 'created_by' => 1],
            ['iso' => 'ZR', 'title' => 'Zaire', 'created_by' => 1],
            ['iso' => 'ZM', 'title' => 'Zambia', 'created_by' => 1],
            ['iso' => 'ZW', 'title' => 'Zimbabwe', 'created_by' => 1],
        ];
        if ($rows) {
            foreach ($rows as &$row) {
                foreach (langs() as $lang) {
                    $title[$lang] = $row['title'];
                }
                $row['title'] = json_encode($title);
            }
        }
        DB::table('countries')->insert($rows);
    }

}
