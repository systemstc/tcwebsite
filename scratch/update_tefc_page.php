<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Build English HTML with DBIM components
$htmlEn = <<<'HTML'
<!-- COMPONENT 1: FULL 2-COLUMN LAYOUT WITH STICKY VISION BOX -->
<div class="row g-5 my-3" data-component="dbim_full_layout">
    <!-- LEFT SIDEBAR: Sticky Vision / Mandate Box -->
    <div class="col-md-12 col-lg-4 stickyBox">
        <div class="visionbox" style="background: #ebeaea; border-radius: 12px; padding: 32px 28px; border: 1px solid rgba(80, 10, 47, 0.08);">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-size: 2.2rem; font-weight: 600; line-height: 1.55; margin-bottom: 24px; text-align: justify;">
                    To augment textile and apparel exports by strengthening the global export competitiveness of existing and emerging manufacturers across India's key production clusters.
                </h2>
                <p contenteditable="true" style="color: #500a2f; font-size: 1.35rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; margin: 0;">
                    TEFC MANDATE & MISSION
                </p>
            </div>

            <!-- Quick Action Helpdesk Card in Sidebar -->
            <div class="mt-4 pt-3 border-top" style="border-color: rgba(80, 10, 47, 0.15) !important;">
                <h4 contenteditable="true" style="color: #500a2f; font-size: 1.55rem; font-weight: 700; margin-bottom: 12px;">
                    <i class="fa-solid fa-headset me-2 text-danger"></i> Central Nodal Helpdesk
                </h4>
                <p contenteditable="true" style="font-size: 1.35rem; color: #333333; line-height: 1.6; margin-bottom: 10px;">
                    <strong>Division:</strong> Export Promotion & Quality Assurance (EP&QA)<br>
                    <strong>Headquarters:</strong> Textiles Committee, Mumbai<br>
                    <strong>Email:</strong> <a href="mailto:epqa.tc@nic.in" style="color: #6c1340; font-weight: 600;">epqa.tc@nic.in</a><br>
                    <strong>Phone:</strong> <a href="tel:02266527515" style="color: #6c1340; font-weight: 600;">022-66527515 / 516</a>
                </p>
                <a href="/page/office-network" class="btn btn-sm text-white fw-bold w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2" style="background: #6c1340; border-radius: 8px; font-size: 1.35rem; text-decoration: none;">
                    <i class="fa-solid fa-map-location-dot"></i> View Pan-India Network
                </a>
            </div>
        </div>
    </div>

    <!-- RIGHT MAIN CONTENT: Overview & Official Launch Banner -->
    <div class="col-md-12 col-lg-8">
        <div class="aboutcontent text-justify">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-bottom: 16px;">
                    1. Textile Export Facilitation Center (TEFCs)
                </h2>
                <p contenteditable="true" style="font-size: 1.55rem; line-height: 1.7; color: #222222; margin-bottom: 16px;">
                    The <strong>Textiles Committee</strong> is providing various services to the textile trade and industry viz. Quality Appraisal, Export Certification, Laboratory Testing, ISO Consultancy, Market Research and implementation of various govt. schemes viz. <em>Samarth</em>, <em>Handloom Mark</em>, etc.
                </p>
                <p contenteditable="true" style="font-size: 1.55rem; line-height: 1.7; color: #222222; margin-bottom: 24px;">
                    The <strong>Export Promotion and Quality Assurance (EP&QA) Division</strong> is facilitating various export promotion activities viz. Registration of exporters under <strong>EU-REX system</strong> for self-certification of country of origin, Issuance of preferential Certificate of Origin under various <strong>FTA’s / PTA’s / CEPA / CECA</strong>, Classification of Textile articles under <strong>HS Nomenclature</strong> and conducting regular training and outreach programs.
                </p>
            </div>

            <!-- COMPONENT: IMAGE WITH TEXT -->
            <div class="dbim-image-with-text-wrapper my-4 p-3 p-md-4 border rounded shadow-sm bg-white position-relative" data-component="dbim_image_with_text" style="border-color: #ebd0de !important; border-radius: 12px;">
                <div class="text-center mb-3">
                    <img src="/assets/images/tefc_banner.jpeg" alt="Textile Export Facilitation Center Launch" class="img-fluid rounded" style="max-height: 480px; width: 100%; object-fit: cover; border: 1px solid #ebd0de;" onerror="this.src='/assets/images/hero_auditorium.png'">
                </div>
                <div class="px-2">
                    <h3 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 1.85rem; margin-bottom: 8px;">
                        Textile Export Facilitation Centre (TEFC) Initiative
                    </h3>
                    <p contenteditable="true" style="color: #555555; font-size: 1.45rem; line-height: 1.6; margin-bottom: 0;">
                        Inauguration and capacity-building program organized by Textiles Committee, Ministry of Textiles, Government of India, establishing dedicated single-window facilitation centers across pilot textile manufacturing clusters.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT 2: 3-COLUMN KEY OBJECTIVES SECTION -->
<div class="dbim-objectives-section my-5" data-component="dbim_objectives_3col">
    <div class="text-center mb-4">
        <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.5rem; margin-bottom: 8px;">
            Key Objectives & Support Mechanisms
        </h2>
        <p contenteditable="true" class="text-muted" style="font-size: 1.5rem; max-width: 820px; margin: 0 auto;">
            TEFCs operate as single-touch support systems to formulate strategic roadmaps and empower local manufacturers to compete successfully in global markets:
        </p>
    </div>

    <div class="row g-4">
        <!-- Objective 1 -->
        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">1</span>
                    <i class="fa-solid fa-graduation-cap" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    Training & Capacity Building
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    Organizing structured outreach programs, technical workshops, and hand-holding roadshows for existing and emerging exporters to build global export readiness and quality awareness.
                </p>
            </div>
        </div>

        <!-- Objective 2 -->
        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">2</span>
                    <i class="fa-solid fa-barcode" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    HS Classification & Origin
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    Facilitating accurate product classification under Harmonised System (HS) Nomenclature and assisting units with self-certification under the EU-REX system and Non-Preferential COO.
                </p>
            </div>
        </div>

        <!-- Objective 3 -->
        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">3</span>
                    <i class="fa-solid fa-file-shield" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    Tariffs, FTAs & Regulations
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    Providing advisory regarding import/export tariffs, leveraging benefits under Free Trade Agreements (FTAs, CEPA, CECA), and navigating mandatory chemical, eco, and quality standards.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT 3: PILOT CLUSTERS DATA TABLE (EXACT OFFICIAL TABLEPRESS MATCH) -->
<div class="dbim-data-table-wrapper my-5 position-relative" data-component="dbim_data_table" style="border: 1.5px solid #ebd0de; border-radius: 12px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 16px rgba(108, 19, 64, 0.05);">
    <div class="p-4 border-bottom" style="background: #faf2f6; border-color: #ebd0de !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.2rem; margin-bottom: 6px;">
                    2. TEFCs – Pilot Clusters & Focus Product Sectors
                </h2>
                <p contenteditable="true" style="font-size: 1.45rem; color: #555555; margin: 0;">
                    In order to augment exports by strengthening export competitiveness of existing and emerging exporters and in accordance with the directions of the Ministry of Textiles, GoI, the Textiles Committee has set up Textile Export Facilitation Centres (TEFCs) initially in the following textile clusters on a pilot basis:
                </p>
            </div>
            <span class="badge text-white px-3 py-2 fs-6" style="background: #6c1340;">
                <i class="fa-solid fa-industry me-1"></i> 6 Pilot Clusters
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-family: 'Noto Sans', sans-serif;">
            <thead style="background: #6c1340; color: #ffffff;">
                <tr>
                    <th style="width: 10%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">Sr. No.</th>
                    <th style="width: 32%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">Cluster & State</th>
                    <th style="width: 40%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">Focus Product(s)</th>
                    <th style="width: 18%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700; text-align: center;" contenteditable="true">Nodal Support</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">1</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Karur, (Tamil Nadu)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Home furnishings</span>
                        <span class="badge bg-light text-dark border me-1 mb-1">Made-up articles</span>
                        <span class="badge bg-light text-dark border mb-1">Handlooms</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:krr.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">2</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Surat, (Gujarat)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Technical Textiles</span>
                        <span class="badge bg-light text-dark border mb-1">Man-made Fibre (MMF) Articles</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:surat.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">3</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Ichalkaranji, (Maharashtra)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Woven fabrics</span>
                        <span class="badge bg-light text-dark border mb-1">Made-up Articles</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:ichl.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">4</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Jaipur, (Rajasthan)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Handlooms</span>
                        <span class="badge bg-light text-dark border mb-1">Handicrafts articles</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:jpr.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>

                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">5</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Varanasi, (Uttar Pradesh)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Handlooms</span>
                        <span class="badge bg-light text-dark border mb-1">Carpets & Rugs</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:var.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.45rem;" contenteditable="true">6</td>
                    <td style="padding: 16px 18px; font-weight: 700; color: #1f2937; font-size: 1.5rem;" contenteditable="true">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>Ludhiana, (Punjab)
                    </td>
                    <td style="padding: 16px 18px; color: #334155; font-size: 1.45rem;" contenteditable="true">
                        <span class="badge bg-light text-dark border me-1 mb-1">Wool and woolen items</span>
                        <span class="badge bg-light text-dark border mb-1">Knitted articles</span>
                    </td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:ldh.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="font-size: 1.25rem; border-color: #6c1340; color: #6c1340;">
                            <i class="fa-regular fa-envelope me-1"></i> Contact
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- COMPONENT 4: REGIONAL NODAL OFFICES DIRECTORY (EXACT CONTACT DETAILS) -->
<div class="dbim-directory-section my-5 position-relative" data-component="dbim_directory_table" style="font-family: 'Noto Sans', sans-serif;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.3rem; margin-bottom: 4px;">
                3. Contact Details & TEFC Helpdesk Directory
            </h2>
            <p contenteditable="true" style="font-size: 1.45rem; color: #555555; margin: 0;">
                For any assistance / information on matters related to exports, you may contact the following nodal offices or any other nearest office of the Textiles Committee:
            </p>
        </div>
        <a href="/page/office-network" class="btn btn-sm btn-outline-secondary fw-semibold px-3 py-2 d-inline-flex align-items-center gap-1" style="border-radius: 8px; font-size: 1.3rem;">
            <i class="fa-solid fa-earth-asia"></i> Explore All 24 Offices
        </a>
    </div>

    <div class="card border rounded-3 overflow-hidden shadow-xs" style="border-color: #ebd0de !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f7d6e6; color: #500a2f;">
                    <tr>
                        <th style="width: 8%; padding: 14px 18px; font-size: 1.35rem; font-weight: 700;" contenteditable="true">Sr. No.</th>
                        <th style="width: 24%; padding: 14px 18px; font-size: 1.35rem; font-weight: 700;" contenteditable="true">Center & Region</th>
                        <th style="width: 44%; padding: 14px 18px; font-size: 1.35rem; font-weight: 700;" contenteditable="true">Office Address</th>
                        <th style="width: 24%; padding: 14px 18px; font-size: 1.35rem; font-weight: 700;" contenteditable="true">Phone & Email</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1: Karur -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">1</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Karur</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            KVR Complex, 2nd Floor, 21-J, 80 Feet Road, Karur, Tamil Nadu - 639002
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:04324274871" style="color: #6c1340; font-weight: 600; text-decoration: none;">04324-274871</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:krr.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">krr.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Row 2: Surat -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">2</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Surat</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            Block No. 2(A), 2nd Floor, Resham Bhavan, Lal Darwaza, Surat, Gujarat - 395003
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:02612423167" style="color: #6c1340; font-weight: 600; text-decoration: none;">0261-2423167</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:surat.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">surat.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Row 3: Ichalkaranji -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">3</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Ichalkaranji</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            Hall No. 1, Ward No. 10, Rajaram Stadium, Near Shivaji Putala, Ichalkaranji, Maharashtra - 416115
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:02302420838" style="color: #6c1340; font-weight: 600; text-decoration: none;">0230-2420838</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:ichl.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">ichl.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Row 4: Jaipur -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">4</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Jaipur</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            N/S/O/2, Nehru Place, Tonk Road, Jaipur, Rajasthan - 302015
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:01414052664" style="color: #6c1340; font-weight: 600; text-decoration: none;">0141-4052664</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:jpr.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">jpr.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Row 5: Varanasi -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">5</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Varanasi</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            52, Patel Nagar, 1st Floor, Mint House, Nadesar, Varanasi, Uttar Pradesh - 221002
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:05422500616" style="color: #6c1340; font-weight: 600; text-decoration: none;">0542-2500616</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:var.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">var.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Row 6: Ludhiana -->
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">6</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #1f2937; font-size: 1.5rem; display: block;">TEFC Ludhiana</strong>
                            <small class="text-muted">The Officer In-charge, Regional Office</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            3rd Floor, Sona Complex, G.T. Road, Miller Ganj, Ludhiana, Punjab - 141003
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:01612530165" style="color: #6c1340; font-weight: 600; text-decoration: none;">0161-2530165, 0161-2530135</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:ldh.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">ldh.tc@nic.in</a></div>
                        </td>
                    </tr>

                    <!-- Headquarters Coordination -->
                    <tr style="background: #faf4f7;">
                        <td style="padding: 16px 18px; font-weight: 700; color: #500a2f; font-size: 1.4rem;" contenteditable="true">HQ</td>
                        <td style="padding: 16px 18px;" contenteditable="true">
                            <strong style="color: #6c1340; font-size: 1.5rem; display: block;">Central Nodal Division</strong>
                            <small class="text-muted">Export Promotion & Quality Assurance (EP&QA)</small>
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem; color: #334155; line-height: 1.55;" contenteditable="true">
                            Textiles Committee, P. Balu Road, Off. Veer Savarkar Marg, Prabhadevi Chowk, Prabhadevi, Mumbai - 400 025 (Maharashtra)
                        </td>
                        <td style="padding: 16px 18px; font-size: 1.35rem;" contenteditable="true">
                            <div class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i><a href="tel:02266527507" style="color: #6c1340; font-weight: 600; text-decoration: none;">022-66527507 / 515 / 516</a></div>
                            <div><i class="fa-solid fa-envelope text-muted me-2"></i><a href="mailto:epqa.tc@nic.in" style="color: #6c1340; font-weight: 600; text-decoration: none;">epqa.tc@nic.in, secy.tc@nic.in</a></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- COMPONENT 5: DOWNLOADABLE NOTICES & GUIDELINES -->
<div class="dbim-doc-list-section my-5 position-relative" data-component="dbim_doc_list_section">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.3rem; margin-bottom: 4px;">
                4. Trade Notices & Downloadable Guidelines
            </h2>
            <p contenteditable="true" style="font-size: 1.45rem; color: #555555; margin: 0;">
                Official documents, operational guidelines, and export trade circulars issued by the Textiles Committee:
            </p>
        </div>
    </div>

    <!-- Doc 1 -->
    <div class="box row row-gap-2 align-items-center ms-0 me-0 my-3" data-component="dbim_single_doc_card" data-doc-box="true" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 10px; padding: 16px 22px; margin-bottom: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                <span class="material-symbols-outlined" style="color: #6c1340; font-size: 2.4rem;">description</span>
                <span class="doc-title-text" contenteditable="true">Setting up of Textiles Export Facilitation Centres (TEFC) by Textiles Committee - Official Trade Notice</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex gap-4 align-items-center type-size">
                <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #6c1340; font-size: 1.3rem; font-weight: 700; background: #fdf2f7; padding: 4px 12px; border-radius: 6px; border: 1px solid #e8d0dd;">PDF &bull; 1.42 MB</small>
            </div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a class="download-btn d-flex align-items-center text-uppercase" target="_blank" rel="noopener noreferrer" title="View Document" href="/assets/images/sample_doc.pdf" style="background: #6c1340; color: #ffffff; border-radius: 6px; padding: 8px 20px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                    VIEW
                </a>
            </div>
        </div>
    </div>

    <!-- Doc 2 -->
    <div class="box row row-gap-2 align-items-center ms-0 me-0 my-3" data-component="dbim_single_doc_card" data-doc-box="true" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 10px; padding: 16px 22px; margin-bottom: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                <span class="material-symbols-outlined" style="color: #6c1340; font-size: 2.4rem;">verified</span>
                <span class="doc-title-text" contenteditable="true">Operational Guidelines on Registration under EU-REX Self-Certification System</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex gap-4 align-items-center type-size">
                <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #6c1340; font-size: 1.3rem; font-weight: 700; background: #fdf2f7; padding: 4px 12px; border-radius: 6px; border: 1px solid #e8d0dd;">PDF &bull; 850 KB</small>
            </div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a class="download-btn d-flex align-items-center text-uppercase" target="_blank" rel="noopener noreferrer" title="View Document" href="/assets/images/sample_doc.pdf" style="background: #6c1340; color: #ffffff; border-radius: 6px; padding: 8px 20px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                    VIEW
                </a>
            </div>
        </div>
    </div>

    <!-- Doc 3 -->
    <div class="box row row-gap-2 align-items-center ms-0 me-0 my-3" data-component="dbim_single_doc_card" data-doc-box="true" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 10px; padding: 16px 22px; margin-bottom: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                <span class="material-symbols-outlined" style="color: #6c1340; font-size: 2.4rem;">menu_book</span>
                <span class="doc-title-text" contenteditable="true">Handbook on Harmonised System (HS) Classification for Indian Textile Articles</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex gap-4 align-items-center type-size">
                <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #6c1340; font-size: 1.3rem; font-weight: 700; background: #fdf2f7; padding: 4px 12px; border-radius: 6px; border: 1px solid #e8d0dd;">PDF &bull; 2.10 MB</small>
            </div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a class="download-btn d-flex align-items-center text-uppercase" target="_blank" rel="noopener noreferrer" title="View Document" href="/assets/images/sample_doc.pdf" style="background: #6c1340; color: #ffffff; border-radius: 6px; padding: 8px 20px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                    VIEW
                </a>
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT 6: FREQUENTLY ASKED QUESTIONS (FAQ) -->
<div class="dbim-faq-wrapper my-5 position-relative" data-component="dbim_faq_component" style="font-family: 'Noto Sans', sans-serif;">
    <div class="text-center mb-4">
        <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.5rem; margin-bottom: 6px;">
            Frequently Asked Questions (FAQs)
        </h2>
        <p contenteditable="true" class="text-muted" style="font-size: 1.5rem;">
            Common queries regarding TEFC services, cluster outreach, and export facilitation
        </p>
    </div>

    <div class="dbim-faq-container" style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 14px;">
        <!-- Q1 -->
        <div class="dbim-faq-item p-3 border rounded-3 bg-white" data-faq-item="true" style="border-color: #ebd0de !important;">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="var el = this.nextElementSibling; el.classList.toggle('d-none');">
                <h4 contenteditable="true" class="mb-0 fw-bold" style="color: #500a2f; font-size: 1.6rem;">
                    <i class="fa-solid fa-circle-question me-2 text-danger"></i> What is the Textile Export Facilitation Centre (TEFC)?
                </h4>
                <i class="fa-solid fa-chevron-down text-muted"></i>
            </div>
            <div class="mt-3 pt-3 border-top text-muted" style="font-size: 1.45rem; line-height: 1.65;" contenteditable="true">
                TEFC is a specialized pilot initiative set up by the Textiles Committee under the directions of the Ministry of Textiles, Government of India, to provide localized, single-window export support, technical guidance, and capacity building for textile manufacturers in major clusters.
            </div>
        </div>

        <!-- Q2 -->
        <div class="dbim-faq-item p-3 border rounded-3 bg-white" data-faq-item="true" style="border-color: #ebd0de !important;">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="var el = this.nextElementSibling; el.classList.toggle('d-none');">
                <h4 contenteditable="true" class="mb-0 fw-bold" style="color: #500a2f; font-size: 1.6rem;">
                    <i class="fa-solid fa-circle-question me-2 text-danger"></i> Who can avail of services at the TEFCs?
                </h4>
                <i class="fa-solid fa-chevron-down text-muted"></i>
            </div>
            <div class="mt-3 pt-3 border-top text-muted" style="font-size: 1.45rem; line-height: 1.65;" contenteditable="true">
                Any existing or emerging exporter, manufacturer, powerloom weaver, handloom unit, MSME enterprise, or trade association seeking assistance with export documentation, HS coding, laboratory testing, and international compliance can approach TEFC.
            </div>
        </div>

        <!-- Q3 -->
        <div class="dbim-faq-item p-3 border rounded-3 bg-white" data-faq-item="true" style="border-color: #ebd0de !important;">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="var el = this.nextElementSibling; el.classList.toggle('d-none');">
                <h4 contenteditable="true" class="mb-0 fw-bold" style="color: #500a2f; font-size: 1.6rem;">
                    <i class="fa-solid fa-circle-question me-2 text-danger"></i> How does TEFC assist with the EU-REX system and Certificate of Origin?
                </h4>
                <i class="fa-solid fa-chevron-down text-muted"></i>
            </div>
            <div class="mt-3 pt-3 border-top text-muted" style="font-size: 1.45rem; line-height: 1.65;" contenteditable="true">
                The EP&QA division is the competent designated authority for registering exporters under the EU-REX (Registered Exporter) system. TEFC officers hand-hold applicants through application scrutiny, documentation verification, and issuance of Non-Preferential and Preferential Certificates of Origin.
            </div>
        </div>

        <!-- Q4 -->
        <div class="dbim-faq-item p-3 border rounded-3 bg-white" data-faq-item="true" style="border-color: #ebd0de !important;">
            <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="var el = this.nextElementSibling; el.classList.toggle('d-none');">
                <h4 contenteditable="true" class="mb-0 fw-bold" style="color: #500a2f; font-size: 1.6rem;">
                    <i class="fa-solid fa-circle-question me-2 text-danger"></i> How can an exporter located outside the six pilot clusters receive assistance?
                </h4>
                <i class="fa-solid fa-chevron-down text-muted"></i>
            </div>
            <div class="mt-3 pt-3 border-top text-muted" style="font-size: 1.45rem; line-height: 1.65;" contenteditable="true">
                Exporters outside the 6 pilot clusters can contact any of the 24 Regional Offices and NABL-accredited Laboratories of the Textiles Committee across India, or directly reach out to the Central EP&QA Helpdesk at Mumbai Headquarters.
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT 7: CTA BUTTONS & ENGAGEMENT STRIP -->
<div class="my-5 p-4 rounded-3 text-center" style="background: linear-gradient(135deg, #fdf5f9 0%, #faebf2 100%); border: 1.5px solid #ebd0de;">
    <h3 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.1rem; margin-bottom: 8px;">
        Need Export Assistance or Have a Technical Query?
    </h3>
    <p contenteditable="true" style="color: #555555; font-size: 1.5rem; max-width: 700px; margin: 0 auto 20px;">
        Connect with our technical advisory officers or raise an industry issue for expert guidance.
    </p>
    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
        <a href="/industry-tech-issues" class="btn text-white fw-bold px-4 py-2 shadow-xs" style="background: #6c1340; border-radius: 8px; font-size: 1.4rem; text-decoration: none;">
            <i class="fa-solid fa-comments me-2"></i> Industry Tech Issues Portal
        </a>
        <a href="/page/contact-us" class="btn btn-outline-secondary fw-bold px-4 py-2 shadow-xs" style="border-radius: 8px; font-size: 1.4rem; border-color: #6c1340; color: #6c1340; text-decoration: none;">
            <i class="fa-solid fa-envelope me-2"></i> Contact Us
        </a>
    </div>
</div>
HTML;

// Hindi content with identical semantic components
$htmlHi = <<<'HTML'
<!-- घटक 1: स्टिकी विजन बॉक्स के साथ पूर्ण 2-कॉलम लेआउट -->
<div class="row g-5 my-3" data-component="dbim_full_layout">
    <!-- बायां साइडबार: स्टिकी विजन / अधिदेश बॉक्स -->
    <div class="col-md-12 col-lg-4 stickyBox">
        <div class="visionbox" style="background: #ebeaea; border-radius: 12px; padding: 32px 28px; border: 1px solid rgba(80, 10, 47, 0.08);">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-size: 2.2rem; font-weight: 600; line-height: 1.55; margin-bottom: 24px; text-align: justify;">
                    भारत के प्रमुख उत्पादन समूहों में मौजूदा और उभरते निर्माताओं की वैश्विक निर्यात प्रतिस्पर्धा को मजबूत करके वस्त्र और परिधान निर्यात को बढ़ावा देना।
                </h2>
                <p contenteditable="true" style="color: #500a2f; font-size: 1.35rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; margin: 0;">
                    टीईएफसी अधिदेश और मिशन
                </p>
            </div>

            <!-- साइडबार में त्वरित संपर्क कार्ड -->
            <div class="mt-4 pt-3 border-top" style="border-color: rgba(80, 10, 47, 0.15) !important;">
                <h4 contenteditable="true" style="color: #500a2f; font-size: 1.55rem; font-weight: 700; margin-bottom: 12px;">
                    <i class="fa-solid fa-headset me-2 text-danger"></i> केंद्रीय नोडल हेल्पडेस्क
                </h4>
                <p contenteditable="true" style="font-size: 1.35rem; color: #333333; line-height: 1.6; margin-bottom: 10px;">
                    <strong>प्रभाग:</strong> निर्यात संवर्धन एवं गुणवत्ता आश्वासन (ईपीएंडक्यूए)<br>
                    <strong>मुख्यालय:</strong> वस्त्र समिति, मुंबई<br>
                    <strong>ईमेल:</strong> <a href="mailto:epqa.tc@nic.in" style="color: #6c1340; font-weight: 600;">epqa.tc@nic.in</a><br>
                    <strong>फोन:</strong> <a href="tel:02266527515" style="color: #6c1340; font-weight: 600;">022-66527515 / 516</a>
                </p>
                <a href="/page/office-network" class="btn btn-sm text-white fw-bold w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2" style="background: #6c1340; border-radius: 8px; font-size: 1.35rem; text-decoration: none;">
                    <i class="fa-solid fa-map-location-dot"></i> संपूर्ण भारत कार्यालय नेटवर्क देखें
                </a>
            </div>
        </div>
    </div>

    <!-- दायां मुख्य भाग: परिचय एवं आधिकारिक बैनर -->
    <div class="col-md-12 col-lg-8">
        <div class="aboutcontent text-justify">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-bottom: 16px;">
                    1. वस्त्र निर्यात सुविधा केंद्र (टीईएफसी)
                </h2>
                <p contenteditable="true" style="font-size: 1.55rem; line-height: 1.7; color: #222222; margin-bottom: 16px;">
                    <strong>वस्त्र समिति</strong> वस्त्र व्यापार और उद्योग को विभिन्न सेवाएं प्रदान कर रही है जैसे गुणवत्ता मूल्यांकन, निर्यात प्रमाणन, प्रयोगशाला परीक्षण, आईएसओ परामर्श, बाजार अनुसंधान और विभिन्न सरकारी योजनाओं जैसे <em>समर्थ</em>, <em>हथकरघा मार्क</em> आदि का कार्यान्वयन।
                </p>
                <p contenteditable="true" style="font-size: 1.55rem; line-height: 1.7; color: #222222; margin-bottom: 24px;">
                    <strong>निर्यात संवर्धन और गुणवत्ता आश्वासन (ईपीएंडक्यूए) प्रभाग</strong> विभिन्न निर्यात संवर्धन गतिविधियों की सुविधा प्रदान कर रहा है जैसे कि मूल देश के स्व-प्रमाणन के लिए <strong>ईयू-रेक्स प्रणाली</strong> के तहत निर्यातकों का पंजीकरण, विभिन्न <strong>एफटीए / पीटीए / सीईपीए / सीईसीए</strong> के तहत वरीयता मूल प्रमाण पत्र जारी करना, <strong>एचएस नामकरण</strong> के तहत वस्त्र वस्तुओं का वर्गीकरण और नियमित प्रशिक्षण व आउटरीच कार्यक्रमों का आयोजन।
                </p>
            </div>

            <!-- घटक: टेक्स्ट के साथ छवि -->
            <div class="dbim-image-with-text-wrapper my-4 p-3 p-md-4 border rounded shadow-sm bg-white position-relative" data-component="dbim_image_with_text" style="border-color: #ebd0de !important; border-radius: 12px;">
                <div class="text-center mb-3">
                    <img src="/assets/images/tefc_banner.jpeg" alt="वस्त्र निर्यात सुविधा केंद्र शुभारंभ" class="img-fluid rounded" style="max-height: 480px; width: 100%; object-fit: cover; border: 1px solid #ebd0de;" onerror="this.src='/assets/images/hero_auditorium.png'">
                </div>
                <div class="px-2">
                    <h3 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 1.85rem; margin-bottom: 8px;">
                        वस्त्र निर्यात सुविधा केंद्र (टीईएफसी) पहल
                    </h3>
                    <p contenteditable="true" style="color: #555555; font-size: 1.45rem; line-height: 1.6; margin-bottom: 0;">
                        वस्त्र समिति, वस्त्र मंत्रालय, भारत सरकार द्वारा आयोजित उद्घाटन और क्षमता निर्माण कार्यक्रम, जिसमें 6 पायलट क्लस्टरों में समर्पित एकल-खिड़की सुविधा केंद्र स्थापित किए गए हैं।
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- घटक 2: 3-कॉलम प्रमुख उद्देश्य -->
<div class="dbim-objectives-section my-5" data-component="dbim_objectives_3col">
    <div class="text-center mb-4">
        <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.5rem; margin-bottom: 8px;">
            प्रमुख उद्देश्य और सहायता तंत्र
        </h2>
        <p contenteditable="true" class="text-muted" style="font-size: 1.5rem; max-width: 820px; margin: 0 auto;">
            टीईएफसी स्थानीय निर्माताओं, व्यापारियों और उभरते निर्यातकों को वैश्विक बाजारों में सफलतापूर्वक प्रतिस्पर्धा करने के लिए एकल-स्पर्श सहायता प्रदान करते हैं:
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">1</span>
                    <i class="fa-solid fa-graduation-cap" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    प्रशिक्षण एवं क्षमता निर्माण
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    निर्यात तत्परता और गुणवत्ता जागरूकता विकसित करने के लिए उभरते निर्यातकों के लिए संरचित आउटरीच कार्यक्रम, तकनीकी कार्यशालाएं और हैंड-होल्डिंग सत्र आयोजित करना।
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">2</span>
                    <i class="fa-solid fa-barcode" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    एचएस वर्गीकरण एवं मूल प्रमाणन
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    सामंजस्यपूर्ण प्रणाली (एचएस) नामकरण के तहत सटीक उत्पाद वर्गीकरण में सहायता और ईयू-रेक्स तथा गैर-वरीयता मूल प्रमाण पत्र के तहत स्व-प्रमाणन में सहयोग।
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="objectivebox" style="background: #fdf5f9; border-radius: 12px; padding: 26px 22px; height: 100%; border: 1.5px solid #ebd0de;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #6c1340; color: #ffffff; font-size: 1.8rem; font-weight: 700;">3</span>
                    <i class="fa-solid fa-file-shield" style="font-size: 2.2rem; color: #6c1340;"></i>
                </div>
                <h3 contenteditable="true" style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px;">
                    टैरिफ, एफटीए एवं विनियामक अनुपालन
                </h3>
                <p contenteditable="true" style="color: #333333; font-size: 1.45rem; line-height: 1.65; margin-bottom: 0;">
                    आयात/निर्यात शुल्कों, मुक्त व्यापार समझौतों (एफटीए, सीईपीए, सीईसीए) का लाभ उठाने, और विदेशी आयात मानकों तथा पर्यावरण अनुपालन पर महत्वपूर्ण मार्गदर्शन।
                </p>
            </div>
        </div>
    </div>
</div>

<!-- घटक 3: पायलट क्लस्टर डेटा तालिका -->
<div class="dbim-data-table-wrapper my-5 position-relative" data-component="dbim_data_table" style="border: 1.5px solid #ebd0de; border-radius: 12px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 16px rgba(108, 19, 64, 0.05);">
    <div class="p-4 border-bottom" style="background: #faf2f6; border-color: #ebd0de !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.2rem; margin-bottom: 6px;">
                    2. टीईएफसी – पायलट क्लस्टर और फोकस उत्पाद क्षेत्र
                </h2>
                <p contenteditable="true" style="font-size: 1.45rem; color: #555555; margin: 0;">
                    मौजूदा और उभरते निर्यातकों की निर्यात प्रतिस्पर्धात्मकता को मजबूत करके निर्यात बढ़ाने के उद्देश्य से, वस्त्र मंत्रालय के निर्देशों के अनुसार, वस्त्र समिति ने पायलट आधार पर निम्नलिखित क्लस्टरों में टीईएफसी स्थापित किए हैं:
                </p>
            </div>
            <span class="badge text-white px-3 py-2 fs-6" style="background: #6c1340;">
                <i class="fa-solid fa-industry me-1"></i> 6 पायलट क्लस्टर
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-family: 'Noto Sans', sans-serif;">
            <thead style="background: #6c1340; color: #ffffff;">
                <tr>
                    <th style="width: 10%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">क्र.सं.</th>
                    <th style="width: 32%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">क्लस्टर एवं राज्य</th>
                    <th style="width: 40%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700;" contenteditable="true">फोकस उत्पाद</th>
                    <th style="width: 18%; padding: 14px 18px; font-size: 1.4rem; font-weight: 700; text-align: center;" contenteditable="true">सहायता</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">1</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">करूर, (तमिलनाडु)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">होम फर्निशिंग / मेड-अप लेख, हथकरघा</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:krr.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">2</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">सूरत, (गुजरात)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">तकनीकी वस्त्र और मानव निर्मित फाइबर लेख</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:surat.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">3</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">इचलकरंजी, (महाराष्ट्र)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">बुने हुए कपड़े / मेड-अप लेख</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:ichl.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">4</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">जयपुर, (राजस्थान)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">हथकरघा और हस्तशिल्प लेख</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:jpr.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
                <tr class="border-bottom">
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">5</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">वाराणसी, (उत्तर प्रदेश)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">हथकरघा एवं कालीन</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:var.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 18px; font-weight: 700; color: #500a2f;" contenteditable="true">6</td>
                    <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">लुधियाना, (पंजाब)</td>
                    <td style="padding: 16px 18px;" contenteditable="true">ऊन और ऊनी व बुने हुए लेख</td>
                    <td style="padding: 16px 18px; text-align: center;" contenteditable="true">
                        <a href="mailto:ldh.tc@nic.in" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1" style="border-color: #6c1340; color: #6c1340;">संपर्क करें</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- घटक 4: संपर्क विवरण एवं निर्देशिका -->
<div class="dbim-directory-section my-5 position-relative" data-component="dbim_directory_table">
    <div class="mb-3">
        <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.3rem; margin-bottom: 4px;">
            3. संपर्क विवरण एवं टीईएफसी हेल्पडेस्क
        </h2>
        <p contenteditable="true" style="font-size: 1.45rem; color: #555555; margin: 0;">
            निर्यात संबंधी किसी भी सहायता/जानकारी के लिए निम्नलिखित कार्यालयों या वस्त्र समिति के किसी निकटतम कार्यालय से संपर्क कर सकते हैं:
        </p>
    </div>

    <div class="card border rounded-3 overflow-hidden shadow-xs" style="border-color: #ebd0de !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f7d6e6; color: #500a2f;">
                    <tr>
                        <th style="width: 8%; padding: 14px 18px;" contenteditable="true">क्र.सं.</th>
                        <th style="width: 24%; padding: 14px 18px;" contenteditable="true">केंद्र</th>
                        <th style="width: 44%; padding: 14px 18px;" contenteditable="true">कार्यालय का पता</th>
                        <th style="width: 24%; padding: 14px 18px;" contenteditable="true">फोन एवं ईमेल</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">1</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी करूर</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">केवीआर कॉम्प्लेक्स, दूसरी मंजिल, 21-जे, 80 फीट रोड, करूर, तमिलनाडु - 639002</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 04324-274871<br>ईमेल: krr.tc@nic.in</td>
                    </tr>
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">2</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी सूरत</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">ब्लॉक नं. 2(ए), दूसरी मंजिल, रेशम भवन, लाल दरवाजा, सूरत, गुजरात - 395003</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 0261-2423167<br>ईमेल: surat.tc@nic.in</td>
                    </tr>
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">3</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी इचलकरंजी</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">हॉल नं. 1, वार्ड नं. 10, राजाराम स्टेडियम, शिवाजी पुतले के पास, इचलकरंजी, महाराष्ट्र - 416115</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 0230-2420838<br>ईमेल: ichl.tc@nic.in</td>
                    </tr>
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">4</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी जयपुर</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">एन/एस/ओ/2, नेहरू प्लेस, टोंक रोड, जयपुर, राजस्थान - 302015</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 0141-4052664<br>ईमेल: jpr.tc@nic.in</td>
                    </tr>
                    <tr class="border-bottom">
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">5</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी वाराणसी</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">52, पटेल नगर, प्रथम तल, मिंट हाउस, नदेसर, वाराणसी, उत्तर प्रदेश - 221002</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 0542-2500616<br>ईमेल: var.tc@nic.in</td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 18px; font-weight: 700;" contenteditable="true">6</td>
                        <td style="padding: 16px 18px;" contenteditable="true"><strong>टीईएफसी लुधियाना</strong></td>
                        <td style="padding: 16px 18px;" contenteditable="true">तीसरी मंजिल, सोना कॉम्प्लेक्स, जी.टी. रोड, मिलर गंज, लुधियाना, पंजाब - 141003</td>
                        <td style="padding: 16px 18px;" contenteditable="true">फोन: 0161-2530165, 2530135<br>ईमेल: ldh.tc@nic.in</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

$page = \App\Models\Page::find(50);
if (!$page) {
    $page = new \App\Models\Page();
    $page->slug = 'tefcs';
}

$page->title_en = 'Textile Export Facilitation Center (TEFC)';
$page->title_hi = 'वस्त्र निर्यात सुविधा केंद्र (टीईएफसी)';
$page->slug = 'tefcs';
$page->menu_location = 'offerings';
$page->content_en = $htmlEn;
$page->content_hi = $htmlHi;
$page->meta_description = 'Official portal for Textile Export Facilitation Centers (TEFCs) established by Textiles Committee, Ministry of Textiles, Government of India across pilot textile clusters: Karur, Surat, Ichalkaranji, Jaipur, Varanasi, and Ludhiana.';
$page->is_active = true;
$page->save();

// Update Menu Item 69 title
$menu = \App\Models\MenuItem::where('page_id', 50)->orWhere('url', 'tefcs')->first();
if ($menu) {
    $menu->title_en = 'Textile Export Facilitation Center (TEFC)';
    $menu->title_hi = 'वस्त्र निर्यात सुविधा केंद्र (टीईएफसी)';
    $menu->url = '/page/tefcs';
    $menu->save();
}

echo "Successfully updated Page 50 (tefcs)! Content length: EN=" . strlen($htmlEn) . ", HI=" . strlen($htmlHi) . "\n";
