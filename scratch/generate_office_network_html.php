<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$locations = [
    [
        "id" => "mumbai",
        "city" => "Mumbai",
        "name" => "Textiles Committee Headquarters (Mumbai)",
        "officer" => "Shri Kartikay Dhanda, Secretary, Textiles Committee",
        "address" => "P. Balu Road, Off. Veer Savarkar Marg, Prabhadevi Chowk, Prabhadevi, Mumbai - 400 025 (Maharashtra)",
        "phone" => "022-66527507, 022-66527506",
        "email" => "secy.tc@nic.in",
        "lat" => 19.0144,
        "lng" => 72.8277,
        "zone" => "west",
        "is_hq" => true
    ],
    [
        "id" => "delhi",
        "city" => "Delhi (NCR) - Gurugram",
        "name" => "Textiles Committee Delhi (NCR) - Gurugram",
        "officer" => "Regional Office & Central Testing Laboratory",
        "address" => "Apparel House, 5th Floor, Institutional Area, Sector 44, Gurugram - 122 003 (Haryana)",
        "phone" => "0124-2544201",
        "email" => "ndl1.tc@nic.in",
        "lat" => 28.4526,
        "lng" => 77.0673,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "ahmedabad",
        "city" => "Ahmedabad",
        "name" => "Textiles Committee Ahmedabad",
        "officer" => "Western Zone Regional Office & Eco-Laboratory",
        "address" => "Opp. Dinbai Tower, Mirzapur Road, Lal Darwaza, Ahmedabad – 380 001 (Gujarat)",
        "phone" => "079–2550 7612",
        "email" => "abd.tc@nic.in",
        "lat" => 23.0276,
        "lng" => 72.5873,
        "zone" => "west",
        "is_hq" => false
    ],
    [
        "id" => "bangalore",
        "city" => "Bangalore",
        "name" => "Textiles Committee Bangalore (Bengaluru)",
        "officer" => "Southern Zone Regional Office & Silk Testing Wing",
        "address" => "FKCCI, WTC Building, 1st Floor, Kempe Gowda Road, Bangalore – 560 009 (Karnataka)",
        "phone" => "080-22261401, 080-22208010",
        "email" => "blr.tc@nic.in",
        "lat" => 12.9767,
        "lng" => 77.5713,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "bhubaneshwar",
        "city" => "Bhubaneshwar",
        "name" => "Textiles Committee Bhubaneshwar",
        "officer" => "Eastern Zone Office & Handloom Testing Centre",
        "address" => "C/o Weavers Service Centre Campus, Plot No. A/407, Shahid Nagar, Bhubaneshwar - 751 007 (Odisha)",
        "phone" => "0674-2548303",
        "email" => "bbs.tc@nic.in",
        "lat" => 20.2961,
        "lng" => 85.8245,
        "zone" => "east",
        "is_hq" => false
    ],
    [
        "id" => "chennai",
        "city" => "Chennai",
        "name" => "Textiles Committee Chennai",
        "officer" => "Tamil Nadu Regional Office & Quality Assurance Lab",
        "address" => "TNUHDB Complex, 2nd Floor, 130, R.K Mutt Road, Mylapore, Chennai - 600 004 (Tamil Nadu)",
        "phone" => "044-24610887, 044-24640740",
        "email" => "chennai.tc@nic.in",
        "lat" => 13.0339,
        "lng" => 80.2677,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "coimbatore",
        "city" => "Coimbatore",
        "name" => "Textiles Committee Coimbatore",
        "officer" => "Major Textile Cluster Laboratory & EPQA Cell",
        "address" => "Raj Chambers, 978-A, Thadagam Road, Coimbatore – 641 002 (Tamil Nadu)",
        "phone" => "0422-2473094, 0422-2472689",
        "email" => "cbe.tc@nic.in",
        "lat" => 11.0168,
        "lng" => 76.9558,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "guntur",
        "city" => "Guntur",
        "name" => "Textiles Committee Guntur",
        "officer" => "Andhra Pradesh Cotton & Quality Cell",
        "address" => "Sai Ram Complex, Door No. 25-1-9, Near Mastan Darga, G.T. Road, Guntur – 522 004 (Andhra Pradesh)",
        "phone" => "0863-2218951",
        "email" => "gnt.tc@nic.in",
        "lat" => 16.3067,
        "lng" => 80.4365,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "hyderabad",
        "city" => "Hyderabad",
        "name" => "Textiles Committee Hyderabad",
        "officer" => "Telangana Regional Centre & Lab Facility",
        "address" => "1st Floor, UNI Bldg, D. No 10-1-1200, A C Guards, Masab Tank Road, Hyderabad – 500 004 (Telangana)",
        "phone" => "040-23327153",
        "email" => "oic-hyd.tc@gov.in, rotchyd@gmail.com",
        "lat" => 17.4065,
        "lng" => 78.4772,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "ichalkaranji",
        "city" => "Ichalkaranji",
        "name" => "Textiles Committee Ichalkaranji",
        "officer" => "Powerloom & Weaving Cluster Regional Office",
        "address" => "Hall No. 1, Ward No. 10, Rajaram Stadium, Near Shivaji Putala, Ichalkaranji – 416 115 (Maharashtra)",
        "phone" => "0230-2420838",
        "email" => "ichl.tc@nic.in",
        "lat" => 16.6974,
        "lng" => 74.4646,
        "zone" => "west",
        "is_hq" => false
    ],
    [
        "id" => "indore",
        "city" => "Indore",
        "name" => "Textiles Committee Indore",
        "officer" => "Central India Regional Centre & Lab",
        "address" => "C-1, F Vikas Tower Indira Complex, A.B Road, Navlakha, Indore - 452 001 (Madhya Pradesh)",
        "phone" => "0731-2401243",
        "email" => "Indore.tc@nic.in",
        "lat" => 22.7244,
        "lng" => 75.8839,
        "zone" => "central",
        "is_hq" => false
    ],
    [
        "id" => "jaipur",
        "city" => "Jaipur",
        "name" => "Textiles Committee Jaipur",
        "officer" => "Rajasthan Apparel & Textile Quality Assurance Office",
        "address" => "N/S/O/2, NGR-1, Nehru Place, Tonk Road, Jaipur – 302 015 (Rajasthan)",
        "phone" => "0141-4052664",
        "email" => "jpr.tc@nic.in",
        "lat" => 26.8834,
        "lng" => 75.7958,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "kannur",
        "city" => "Kannur",
        "name" => "Textiles Committee Kannur",
        "officer" => "Kerala Handloom & Export Quality Centre",
        "address" => "Platinum Centre, 2nd Floor, Bank Road, Kannur – 670 001 (Kerala)",
        "phone" => "0497-2706390",
        "email" => "kannur.tc@nic.in",
        "lat" => 11.8745,
        "lng" => 75.3704,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "kanpur",
        "city" => "Kanpur",
        "name" => "Textiles Committee Kanpur",
        "officer" => "Uttar Pradesh Regional Office & Eco-Testing Lab",
        "address" => "117/48, Sarvodaya Nagar (Basement and First Floor), Near Bank of Baroda, Kanpur – 208 005 (Uttar Pradesh)",
        "phone" => "0512-2240066, 0512-2212548",
        "email" => "kanpur.tc@nic.in",
        "lat" => 26.4735,
        "lng" => 80.3475,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "karur",
        "city" => "Karur",
        "name" => "Textiles Committee Karur",
        "officer" => "Home Textiles Export & Testing Centre",
        "address" => "K V R Complex, 2nd Floor, 21 – J, 80 Feet Road, Karur – 639 002 (Tamil Nadu)",
        "phone" => "04324-274871",
        "email" => "krr.tc@nic.in",
        "lat" => 10.9601,
        "lng" => 78.0766,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "kolkata",
        "city" => "Kolkata",
        "name" => "Textiles Committee Kolkata",
        "officer" => "Eastern & North-Eastern Regional Hub & Jute Lab",
        "address" => "Block G.N, Plot-38/3, Sector-V, Salt Lake City, Kolkata – 700 091 (West Bengal)",
        "phone" => "033-46021338",
        "email" => "kol.tc@nic.in",
        "lat" => 22.5735,
        "lng" => 88.4331,
        "zone" => "east",
        "is_hq" => false
    ],
    [
        "id" => "ludhiana",
        "city" => "Ludhiana",
        "name" => "Textiles Committee Ludhiana",
        "officer" => "Knitwear & Woollen Testing Laboratory",
        "address" => "Sona Complex, 3rd Floor, G.T Road, Miller Ganj, Ludhiana – 141 003 (Punjab)",
        "phone" => "0161-2530165, 0161-2530135",
        "email" => "ldh.tc@nic.in",
        "lat" => 30.8872,
        "lng" => 75.8624,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "nagpur",
        "city" => "Nagpur",
        "name" => "Textiles Committee Nagpur",
        "officer" => "Vidarbha Regional Centre & Lab Facility",
        "address" => "Brindavan, 1st Floor, 744, WHC Road, Dharmapeth, Nagpur – 440 010 (Maharashtra)",
        "phone" => "0712-2561564",
        "email" => "ngr.tc@nic.in",
        "lat" => 21.1458,
        "lng" => 79.0882,
        "zone" => "west",
        "is_hq" => false
    ],
    [
        "id" => "surat",
        "city" => "Surat",
        "name" => "Textiles Committee Surat",
        "officer" => "Man-Made Fibre & Synthetic Cluster Office",
        "address" => "Block No. 2(A), 2nd Floor, Resham Bhawan, Lal Darwaza, Surat - 395 003 (Gujarat)",
        "phone" => "0261-2423167",
        "email" => "surat.tc@nic.in",
        "lat" => 21.1959,
        "lng" => 72.8302,
        "zone" => "west",
        "is_hq" => false
    ],
    [
        "id" => "tirupur",
        "city" => "Tirupur",
        "name" => "Textiles Committee Tirupur",
        "officer" => "Knitwear Export Hub & NABL Testing Laboratory",
        "address" => "Plot No 8 & 9, Thiruvika Nagar, 1st Floor, College Road, Tirupur – 641 602 (Tamil Nadu)",
        "phone" => "0421-2201402, 0421-2202500",
        "email" => "tpr.tc@nic.in",
        "lat" => 11.1085,
        "lng" => 77.3411,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "tuticorin",
        "city" => "Tuticorin (Thoothukudi)",
        "name" => "Textiles Committee Tuticorin",
        "officer" => "Port Quality Control & Testing Cell",
        "address" => "57/14, Muniasamypuram II, New Colony, Tuticorin - 628 003 (Tamil Nadu)",
        "phone" => "0461-2323384",
        "email" => "tctutcorin@gmail.com",
        "lat" => 8.7642,
        "lng" => 78.1348,
        "zone" => "south",
        "is_hq" => false
    ],
    [
        "id" => "varanasi",
        "city" => "Varanasi",
        "name" => "Textiles Committee Varanasi",
        "officer" => "Varanasi Handloom Silk & Zari Quality Centre",
        "address" => "52, Patel Nagar, 1st Floor, Mint House, Nadesar, Varanasi - 221 002 (Uttar Pradesh)",
        "phone" => "0542-2500616",
        "email" => "var.tc@nic.in",
        "lat" => 25.3356,
        "lng" => 82.9839,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "srinagar",
        "city" => "Srinagar",
        "name" => "Textiles Committee Srinagar",
        "officer" => "Kashmir Wool, Silk & Pashmina Quality Centre",
        "address" => "C/o Weavers Service Centre, UNDP Project Complex, Baghe Ali Mardan Khan, Nowshera, Srinagar – 190 011 (J&K)",
        "phone" => "0194-2411043",
        "email" => "sgr.tc@nic.in",
        "lat" => 34.1205,
        "lng" => 74.8219,
        "zone" => "north",
        "is_hq" => false
    ],
    [
        "id" => "jnpa",
        "city" => "JNPA (Nhava Sheva)",
        "name" => "Textiles Committee JNPA (Nhava Sheva)",
        "officer" => "Port Quality Cell & Export Inspection Lab",
        "address" => "PB/G/D-5, Port Users Building, Jawaharlal Nehru Port Authority, Nhava Sheva, Navi Mumbai - 400 707 (Maharashtra)",
        "phone" => "022-27240020",
        "email" => "labjnpt2.tc@nic.in",
        "lat" => 18.9496,
        "lng" => 72.9515,
        "zone" => "west",
        "is_hq" => false
    ]
];

$jsonLocations = json_encode($locations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

$html = <<<HTML
<div class="tc-office-network-wrap" id="tcOfficeNetwork">
    <!-- SECTION 1: OFFICIAL INTERACTIVE GIS MAP PANEL -->
    <div class="texmin-map-panel mb-5 p-3 p-md-4 rounded-3 shadow-sm" style="background: #ffffff; border: 1.5px solid #ebd0de;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 pb-3 border-bottom">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center gap-2" style="color: #500a2f; font-size: 2.2rem; font-family: 'Noto Sans', sans-serif;">
                    <i class="fa-solid fa-map-location-dot" style="color: #6c1340;"></i>
                    <span>Pan-India Regional Offices & Laboratories Network</span>
                </h2>
                <p class="text-muted mb-0" style="font-size: 1.4rem;">
                    Textiles Committee has 24 regional offices, NABL-accredited testing laboratories, and port quality inspection cells across India.
                </p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button type="button" class="btn btn-sm px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" onclick="locateNearestOffice()" style="background: #fdf2f7; color: #6c1340; border: 1.5px solid #d4aabf; border-radius: 8px; font-size: 1.3rem;">
                    <i class="fa-solid fa-crosshairs text-danger"></i> Locate Nearest Office
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" onclick="resetOfficeMap()" style="border-radius: 8px; font-size: 1.3rem;">
                    <i class="fa-solid fa-arrows-to-circle text-primary"></i> Reset All India
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" onclick="toggleMapFullscreen()" id="mapFsBtn" style="border-radius: 8px; font-size: 1.3rem;">
                    <i class="fa-solid fa-expand"></i> Fullscreen
                </button>
            </div>
        </div>

        <!-- ZONE FILTER PILLS -->
        <div class="d-flex align-items-center gap-2 flex-wrap mb-3" id="roZoneFilters">
            <span class="fw-semibold text-muted small me-1"><i class="fa-solid fa-filter me-1"></i> Zone:</span>
            <button type="button" class="btn btn-sm ro-zone-btn active" data-zone="all" onclick="filterByZone('all', this)">
                All India (24)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="north" onclick="filterByZone('north', this)">
                North Zone (6)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="west" onclick="filterByZone('west', this)">
                West Zone (6)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="south" onclick="filterByZone('south', this)">
                South Zone (9)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="east" onclick="filterByZone('east', this)">
                East Zone (2)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="central" onclick="filterByZone('central', this)">
                Central Zone (1)
            </button>
            <button type="button" class="btn btn-sm ro-zone-btn" data-zone="hq" onclick="filterByZone('hq', this)">
                <i class="fa-solid fa-star text-warning me-1"></i> HQ Mumbai
            </button>
        </div>

        <!-- Interactive Map Container -->
        <div class="position-relative">
            <div id="tcOfficeMap" style="height: 520px; width: 100%; border-radius: 12px; border: 1.5px solid #d4aabf; background: #eef2f5; z-index: 1;"></div>
            
            <!-- Map Legend Overlay -->
            <div class="map-legend-box p-2 rounded shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="legend-dot-hq"></span>
                    <span class="small fw-bold text-dark">Headquarters (Mumbai)</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="legend-dot-ro"></span>
                    <span class="small fw-semibold text-muted">Regional Office & Lab (23)</span>
                </div>
            </div>
        </div>

        <!-- Search Input Bar & Live Count Status -->
        <div class="row align-items-center g-3 mt-2 pt-2">
            <div class="col-md-7 col-lg-6 col-12">
                <div class="input-group">
                    <span class="input-group-text bg-white" style="border: 1.5px solid #d4aabf; border-right: none; color: #500a2f;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="roSearchInput" class="form-control" placeholder="Search by city, state, officer, lab or address..." oninput="filterRoList()" style="font-size: 1.4rem; border: 1.5px solid #d4aabf; border-left: none;">
                    <button class="btn btn-outline-secondary" type="button" onclick="clearRoSearch()" style="border-color: #d4aabf;">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-5 col-lg-6 col-12 text-md-end">
                <span id="roResultCount" class="badge px-3 py-2" style="background: #6c1340; color: #ffffff; font-size: 1.25rem; font-weight: 600;">
                    Showing all 24 offices & laboratories
                </span>
            </div>
        </div>
    </div>

    <!-- SECTION 2: 2-COLUMN REGIONAL OFFICE CARDS -->
    <div class="row g-4" id="roCardsContainer">
HTML;

foreach ($locations as $ro) {
    $zoneLabel = ucfirst($ro['zone']) . ' Zone';
    $isHqBadge = $ro['is_hq'] ? '<span class="badge texmin-hq-badge"><i class="fa-solid fa-star me-1"></i>HEADQUARTERS</span>' : "<span class=\"badge bg-light text-dark border\">{$zoneLabel}</span>";
    $firstPhone = trim(explode(',', $ro['phone'])[0]);

    $html .= <<<CARD
        <div class="col-lg-6 col-md-6 col-12 d-flex ro-card-col" data-ro-id="{$ro['id']}" data-zone="{$ro['zone']}" data-is-hq="{$ro['is_hq']}">
            <div class="texmin-ro-card w-100" id="ro-card-{$ro['id']}" data-ro-id="{$ro['id']}" data-city="{$ro['city']}" data-name="{$ro['name']}" data-address="{$ro['address']}" onclick="selectRo('{$ro['id']}')">
                <!-- Top Section: Title & Subtitle -->
                <div class="mb-2">
                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-1">
                        <h3 class="texmin-card-title mb-0">
                            {$ro['name']}
                        </h3>
                    </div>
                    <div class="texmin-card-subtitle">
                        {$ro['officer']}
                    </div>
                </div>

                <!-- Middle Section: Address, Phone, Email -->
                <div class="texmin-card-body flex-grow-1 my-2">
                    <p class="texmin-card-address mb-2">
                        <i class="fa-solid fa-location-dot me-2 text-theme-icon"></i>{$ro['address']}
                    </p>
                    <div class="texmin-card-meta d-flex flex-wrap gap-3 pt-1">
                        <span class="texmin-meta-item">
                            <i class="fa-solid fa-phone me-1 text-theme-icon"></i>
                            <a href="tel:{$firstPhone}" class="text-decoration-none text-theme-link" onclick="event.stopPropagation();">{$ro['phone']}</a>
                        </span>
                        <span class="texmin-meta-item">
                            <i class="fa-solid fa-envelope me-1 text-theme-icon"></i>
                            <a href="mailto:{$ro['email']}" class="text-decoration-none text-theme-link" onclick="event.stopPropagation();">{$ro['email']}</a>
                        </span>
                    </div>
                </div>

                <!-- Bottom Section: Badges and Action -->
                <div class="texmin-card-footer d-flex align-items-center justify-content-between pt-2 border-top">
                    <div class="d-flex align-items-center gap-2">
                        {$isHqBadge}
                        <span class="small text-theme-muted d-none d-sm-inline">Click to locate</span>
                    </div>
                    <button type="button" class="texmin-arrow-btn" aria-label="Locate {$ro['city']} on Map" title="Locate on Map">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
CARD;
}

$html .= <<<SCRIPT
    </div>
</div>

<style>
/* Office Network Component Styling */
.texmin-ro-card {
    background: #ffffff;
    border: 1.5px solid #ebd0de;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(108, 19, 64, 0.04);
}
.texmin-ro-card:hover {
    border-color: #6c1340;
    box-shadow: 0 6px 18px rgba(108, 19, 64, 0.12);
    transform: translateY(-2px);
}
.texmin-ro-card.active-ro-card {
    border-color: #6c1340 !important;
    background: #fdf5f9 !important;
    box-shadow: 0 0 0 3px rgba(108, 19, 64, 0.25) !important;
}
.texmin-card-title {
    color: #500a2f;
    font-size: 1.7rem;
    font-weight: 700;
    font-family: 'Noto Sans', sans-serif;
    line-height: 1.35;
}
.texmin-card-subtitle {
    color: #64748b;
    font-size: 1.35rem;
    font-weight: 500;
    margin-top: 2px;
}
.texmin-card-address {
    color: #334155;
    font-size: 1.35rem;
    line-height: 1.5;
}
.texmin-meta-item {
    font-size: 1.3rem;
    color: #475569;
}
.text-theme-icon {
    color: #6c1340 !important;
}
.text-theme-link {
    color: #6c1340 !important;
    font-weight: 600;
}
.text-theme-link:hover {
    text-decoration: underline !important;
}
.texmin-hq-badge {
    background: linear-gradient(135deg, #b8144b, #6c1340);
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    letter-spacing: 0.5px;
}
.texmin-arrow-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #6c1340;
    color: #ffffff;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.texmin-ro-card:hover .texmin-arrow-btn {
    background: #500a2f;
    transform: translateX(3px);
}
.ro-zone-btn {
    background: #ffffff;
    color: #475569;
    border: 1px solid #d4aabf;
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 1.25rem;
    font-weight: 600;
    transition: all 0.2s;
}
.ro-zone-btn:hover {
    background: #fdf2f7;
    color: #6c1340;
    border-color: #6c1340;
}
.ro-zone-btn.active {
    background: #6c1340 !important;
    color: #ffffff !important;
    border-color: #6c1340 !important;
}
.map-legend-box {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(4px);
    border: 1px solid #d4aabf;
    z-index: 500;
}
.legend-dot-hq {
    width: 14px;
    height: 14px;
    background: #b8144b;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 1.5px #facc15;
    border-radius: 50%;
    display: inline-block;
}
.legend-dot-ro {
    width: 14px;
    height: 14px;
    background: #500a2f;
    border: 2px solid #ffffff;
    border-radius: 50%;
    display: inline-block;
}
/* Custom Leaflet Map Pin Styles */
.tc-pin-wrap {
    position: relative;
    width: 36px;
    height: 48px;
    cursor: pointer;
    transition: transform 0.2s ease;
}
.tc-pin-wrap:hover, .tc-pin-wrap.active {
    transform: scale(1.22);
    z-index: 1000 !important;
}
.tc-pin-halo {
    position: absolute;
    top: 6px;
    left: 2px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(184, 20, 75, 0.35);
    animation: tcPulse 2s infinite;
}
@keyframes tcPulse {
    0% { transform: scale(0.9); opacity: 0.8; }
    50% { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(0.9); opacity: 0; }
}
/* Leaflet Popup Styling */
.leaflet-popup-content-wrapper {
    padding: 0 !important;
    border-radius: 10px !important;
    overflow: hidden !important;
    box-shadow: 0 8px 24px rgba(80, 10, 47, 0.22) !important;
    border: 1px solid #ebd0de !important;
}
.leaflet-popup-content {
    margin: 0 !important;
    line-height: 1.4 !important;
}
.ro-popup-head {
    background: linear-gradient(135deg, #6c1340, #500a2f);
    color: #ffffff;
    padding: 12px 16px;
    font-weight: 700;
}
.ro-popup-body {
    padding: 14px 16px;
    background: #ffffff;
    font-size: 1.3rem;
    color: #1e293b;
}
</style>

<script>
(function() {
    var roLocations = {$jsonLocations};
    var mapInstance = null;
    var markersMap = {};
    var activeMarkerId = null;
    var currentZoneFilter = 'all';

    function initMap() {
        if (typeof L === 'undefined') {
            setTimeout(initMap, 150);
            return;
        }

        var mapEl = document.getElementById('tcOfficeMap');
        if (!mapEl) return;

        if (mapInstance) {
            mapInstance.remove();
            mapInstance = null;
        }

        // Initialize Map centered on India
        mapInstance = L.map('tcOfficeMap', {
            center: [22.8, 79.5],
            zoom: 5,
            minZoom: 4,
            maxZoom: 18,
            scrollWheelZoom: false
        });

        // High-clarity OpenStreetMap Tile Layer
        var osmLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors | Ministry of Textiles &copy; Textiles Committee',
            maxZoom: 19
        });
        osmLayer.addTo(mapInstance);

        // SVG Pin Icon Generator
        function createPinIcon(isHq, id) {
            var fillColor = isHq ? '#b8144b' : '#6c1340';
            var badgeSvg = isHq 
                ? '<circle cx="18" cy="16" r="6" fill="#facc15" stroke="#ffffff" stroke-width="1.5"/><path d="M18 12 L19.2 14.8 L22.2 15.1 L19.9 17.1 L20.6 20 L18 18.5 L15.4 20 L16.1 17.1 L13.8 15.1 L16.8 14.8 Z" fill="#b8144b"/>'
                : '<circle cx="18" cy="16" r="5.5" fill="#ffffff"/><circle cx="18" cy="16" r="3" fill="#6c1340"/>';

            var haloHtml = isHq ? '<div class="tc-pin-halo"></div>' : '';

            var svgHtml = '<div class="tc-pin-wrap" id="pin-wrap-' + id + '">' +
                haloHtml +
                '<svg viewBox="0 0 36 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 36px; height: 48px; filter: drop-shadow(0 3px 6px rgba(0,0,0,0.3));">' +
                    '<path d="M18 0 C8.06 0 0 8.06 0 18 C0 31.5 16.5 47 17.3 47.7 C17.7 48.1 18.3 48.1 18.7 47.7 C19.5 47 36 31.5 36 18 C36 8.06 27.94 0 18 0 Z" fill="' + fillColor + '"/>' +
                    '<path d="M18 2 C9.16 2 2 9.16 2 18 C2 29.8 16.8 44 18 45.1 C19.2 44 34 29.8 34 18 C34 9.16 26.84 2 18 2 Z" fill="rgba(255,255,255,0.18)"/>' +
                    badgeSvg +
                '</svg>' +
            '</div>';

            return L.divIcon({
                className: 'tc-map-marker',
                html: svgHtml,
                iconSize: [36, 48],
                iconAnchor: [18, 48],
                popupAnchor: [0, -46]
            });
        }

        // Add Markers for all 24 Locations
        roLocations.forEach(function(ro) {
            var icon = createPinIcon(ro.is_hq, ro.id);
            var marker = L.marker([ro.lat, ro.lng], { icon: icon, title: ro.name });
            marker.addTo(mapInstance);

            var hqTag = ro.is_hq ? '<span class="badge bg-warning text-dark ms-2" style="font-size: 11px;">HEADQUARTERS</span>' : '';
            var phonePrimary = ro.phone.split(',')[0].trim();

            var popupContent = '<div class="ro-popup-head">' +
                '<div style="font-size: 1.45rem; font-weight: 700;">' + ro.name + hqTag + '</div>' +
                '<small style="color: #fce7f3; font-weight: 500;">' + ro.city + ' &bull; ' + ro.zone.toUpperCase() + ' ZONE</small>' +
            '</div>' +
            '<div class="ro-popup-body">' +
                '<div style="margin-bottom: 6px;"><strong style="color: #500a2f;">Designation:</strong> ' + ro.officer + '</div>' +
                '<div style="margin-bottom: 6px;"><strong style="color: #500a2f;">Address:</strong> ' + ro.address + '</div>' +
                '<div style="margin-bottom: 6px;"><strong style="color: #500a2f;">Phone:</strong> <a href="tel:' + phonePrimary + '" style="color:#6c1340; font-weight:700; text-decoration:none;">' + ro.phone + '</a></div>' +
                '<div style="margin-bottom: 10px;"><strong style="color: #500a2f;">Email:</strong> <a href="mailto:' + ro.email + '" style="color:#6c1340; font-weight:700; text-decoration:none;">' + ro.email + '</a></div>' +
                '<div style="text-align: right; border-top: 1px solid #ebd0de; padding-top: 8px;">' +
                    '<a href="https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(ro.name + ' ' + ro.address) + '" target="_blank" class="btn btn-sm btn-outline-danger fw-bold px-2 py-1" style="font-size: 1.15rem; border-color: #6c1340; color: #6c1340;">' +
                        '<i class="fa-solid fa-diamond-turn-right me-1"></i> Get Directions &rarr;' +
                    '</a>' +
                '</div>' +
            '</div>';

            marker.bindPopup(popupContent, { maxWidth: 360 });

            marker.on('click', function() {
                highlightCard(ro.id);
            });

            markersMap[ro.id] = marker;
        });

        // Ensure Leaflet calculates dimensions cleanly
        setTimeout(function() {
            if (mapInstance) mapInstance.invalidateSize();
        }, 300);

        window.addEventListener('resize', function() {
            if (mapInstance) mapInstance.invalidateSize();
        });
    }

    // Global Interactive Functions
    window.selectRo = function(id) {
        var ro = roLocations.find(function(item) { return item.id === id; });
        if (!ro || !mapInstance) return;

        mapInstance.flyTo([ro.lat, ro.lng], 13, {
            duration: 1.2,
            easeLinearity: 0.25
        });

        if (markersMap[id]) {
            markersMap[id].openPopup();
        }

        highlightCard(id);

        var mapPanel = document.querySelector('.texmin-map-panel');
        if (mapPanel) {
            mapPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    window.highlightCard = function(id) {
        document.querySelectorAll('.texmin-ro-card').forEach(function(c) {
            c.classList.remove('active-ro-card');
        });
        document.querySelectorAll('.tc-pin-wrap').forEach(function(p) {
            p.classList.remove('active');
        });

        var card = document.getElementById('ro-card-' + id);
        if (card) {
            card.classList.add('active-ro-card');
        }

        var pin = document.getElementById('pin-wrap-' + id);
        if (pin) {
            pin.classList.add('active');
        }
        activeMarkerId = id;
    };

    window.resetOfficeMap = function() {
        if (!mapInstance) return;
        mapInstance.setView([22.8, 79.5], 5);
        if (activeMarkerId && markersMap[activeMarkerId]) {
            mapInstance.closePopup();
        }
        document.querySelectorAll('.texmin-ro-card').forEach(function(c) {
            c.classList.remove('active-ro-card');
        });
        document.querySelectorAll('.tc-pin-wrap').forEach(function(p) {
            p.classList.remove('active');
        });
        document.getElementById('roSearchInput').value = '';
        filterByZone('all');
    };

    window.filterByZone = function(zone, btnEl) {
        currentZoneFilter = zone;
        if (btnEl) {
            document.querySelectorAll('.ro-zone-btn').forEach(function(b) { b.classList.remove('active'); });
            btnEl.classList.add('active');
        }

        var q = (document.getElementById('roSearchInput').value || '').toLowerCase().trim();
        var visibleCount = 0;
        var visibleBounds = [];

        document.querySelectorAll('.ro-card-col').forEach(function(col) {
            var cardZone = col.getAttribute('data-zone') || '';
            var isHq = col.getAttribute('data-is-hq') === '1';
            var id = col.getAttribute('data-ro-id');
            var card = col.querySelector('.texmin-ro-card');

            var name = (card.getAttribute('data-name') || '').toLowerCase();
            var city = (card.getAttribute('data-city') || '').toLowerCase();
            var address = (card.getAttribute('data-address') || '').toLowerCase();

            var zoneMatch = (zone === 'all') || (zone === 'hq' && isHq) || (cardZone === zone);
            var searchMatch = !q || name.includes(q) || city.includes(q) || address.includes(q);

            if (zoneMatch && searchMatch) {
                col.style.display = 'flex';
                visibleCount++;
                if (markersMap[id]) {
                    markersMap[id].addTo(mapInstance);
                    visibleBounds.push(markersMap[id].getLatLng());
                }
            } else {
                col.style.display = 'none';
                if (markersMap[id]) {
                    mapInstance.removeLayer(markersMap[id]);
                }
            }
        });

        document.getElementById('roResultCount').textContent = 'Showing ' + visibleCount + ' of ' + roLocations.length + ' locations';

        if (visibleBounds.length > 0 && mapInstance) {
            if (zone === 'all' && !q) {
                mapInstance.setView([22.8, 79.5], 5);
            } else {
                var bounds = L.latLngBounds(visibleBounds);
                mapInstance.fitBounds(bounds, { padding: [40, 40], maxZoom: 12 });
            }
        }
    };

    window.filterRoList = function() {
        var activeBtn = document.querySelector('.ro-zone-btn.active');
        var zone = activeBtn ? activeBtn.getAttribute('data-zone') : 'all';
        filterByZone(zone);
    };

    window.clearRoSearch = function() {
        var input = document.getElementById('roSearchInput');
        if (input) {
            input.value = '';
            filterRoList();
        }
    };

    window.toggleMapFullscreen = function() {
        var mapPanel = document.querySelector('.texmin-map-panel');
        if (!mapPanel) return;
        if (!document.fullscreenElement) {
            mapPanel.requestFullscreen().catch(function(err) {});
            document.getElementById('mapFsBtn').innerHTML = '<i class="fa-solid fa-compress"></i> Exit Fullscreen';
        } else {
            document.exitFullscreen();
            document.getElementById('mapFsBtn').innerHTML = '<i class="fa-solid fa-expand"></i> Fullscreen';
        }
    };

    // Calculate nearest office using Haversine formula
    window.locateNearestOffice = function() {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }

        navigator.geolocation.getCurrentPosition(function(pos) {
            var userLat = pos.coords.latitude;
            var userLng = pos.coords.longitude;

            var nearest = null;
            var minDistance = Infinity;

            function deg2rad(deg) { return deg * (Math.PI / 180); }
            function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
                var R = 6371;
                var dLat = deg2rad(lat2 - lat1);
                var dLon = deg2rad(lon2 - lon1);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            roLocations.forEach(function(ro) {
                var d = getDistanceFromLatLonInKm(userLat, userLng, ro.lat, ro.lng);
                if (d < minDistance) {
                    minDistance = d;
                    nearest = ro;
                }
            });

            if (nearest) {
                filterByZone('all');
                selectRo(nearest.id);
                var distKm = Math.round(minDistance);
                var badge = document.getElementById('roResultCount');
                if (badge) {
                    badge.innerHTML = '<i class="fa-solid fa-location-arrow me-1"></i> Nearest: <strong>' + nearest.city + '</strong> (~' + distKm + ' km away)';
                }
            }
        }, function(err) {
            alert('Unable to retrieve your location. Please check browser permissions.');
        }, { timeout: 10000 });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
})();
</script>
SCRIPT;

$page = \App\Models\Page::where('slug', 'office-network')->first();
if ($page) {
    $page->content_en = $html;
    $page->content_hi = $html;
    $page->save();
    echo "Successfully updated Page 11 (office-network) with proper interactive map! Content length: " . strlen($html) . " bytes\n";
} else {
    echo "Page office-network not found!\n";
}
