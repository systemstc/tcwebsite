<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Dignitary;
use App\Models\Scheme;
use App\Models\Tender;
use App\Models\WhatsNew;
use App\Models\Document;
use App\Models\Persona;
use App\Models\ImportantLink;
use App\Models\Campaign;
use App\Models\Page;
use App\Models\Setting;
use App\Models\ActivityLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@tcwebsite.gov.in'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        $editor = User::firstOrCreate(
            ['email' => 'editor@tcwebsite.gov.in'],
            [
                'name' => 'Content Manager',
                'password' => Hash::make('editor123'),
                'role' => 'editor',
                'is_active' => true,
            ]
        );

        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => 'seed',
            'module' => 'system',
            'ip_address' => '127.0.0.1',
            'details' => 'Initial database seed completed with default administrative users and content.',
        ]);

        // 2. Banners
        Banner::truncate();
        Banner::create([
            'title_hi' => 'स्वच्छता ही सेवा',
            'title_en' => 'Swachhata Hi Seva',
            'subtitle_hi' => 'स्वच्छता ही सेवा अभियान',
            'subtitle_en' => 'Swachhata Hi Seva Campaign',
            'image_url' => 'assets/images/banner1_swachhata.png',
            'link_url' => '#',
            'link_text_hi' => 'अधिक जानें',
            'link_text_en' => 'Explore More',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Banner::create([
            'title_hi' => 'वस्त्र अनुसंधान संघों (टीआरए) की समन्वय समिति की दूसरी बैठक',
            'title_en' => '2nd Meeting of the Coordination Committee of Textile Research Associations (TRAs)',
            'subtitle_hi' => 'वस्त्र अनुसंधान और विकास',
            'subtitle_en' => 'Textile Research & Development',
            'image_url' => 'assets/images/banner2_tras.png',
            'link_url' => '#',
            'link_text_hi' => 'अधिक जानें',
            'link_text_en' => 'Explore More',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        Banner::create([
            'title_hi' => 'निफ्ट दीक्षांत समारोह',
            'title_en' => 'NIFT Convocation',
            'subtitle_hi' => 'राष्ट्रीय फैशन प्रौद्योगिकी संस्थान',
            'subtitle_en' => 'National Institute of Fashion Technology',
            'image_url' => 'assets/images/banner3_nift.png',
            'link_url' => '#',
            'link_text_hi' => 'अधिक देखें',
            'link_text_en' => 'Explore More',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        Banner::create([
            'title_hi' => '12वाँ राष्ट्रीय हथकरघा दिवस',
            'title_en' => '12th National Handloom Day',
            'subtitle_hi' => 'हथकरघा बुनकरों का राष्ट्रीय सम्मान',
            'subtitle_en' => 'Honoring our master weavers and heritage',
            'image_url' => 'assets/images/BANNER-1-1.png',
            'link_url' => '#',
            'link_text_hi' => 'अधिक देखें',
            'link_text_en' => 'Explore More',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 3. Announcements
        Announcement::truncate();
        $announcements = [
            'Shri Giriraj Singh holds comprehensive review meeting on PLI Scheme for Textiles and export competitiveness.',
            'Extension of Rebate of State and Central Taxes and Levies Scheme on Export of Apparel/Garment and Made-ups (RoSCTL).',
            'Draft Quality Control Orders (QCO) issued on manufacture of Technical Textiles and Geotextiles.',
            'Kasturi Cotton Bharat - Blockchain-enabled traceability ensuring world-class premium Indian cotton.'
        ];
        foreach ($announcements as $idx => $ann) {
            Announcement::create([
                'title_hi' => $ann,
                'title_en' => $ann,
                'link_url' => '#',
                'is_new' => true,
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        // 4. Dignitaries
        Dignitary::truncate();
        // PM Modi
        Dignitary::create([
            'name_hi' => 'श्री नरेन्द्र मोदी',
            'name_en' => 'Shri Narendra Modi',
            'designation_hi' => 'माननीय प्रधान मंत्री',
            'designation_en' => 'Hon\'ble Prime Minister of India',
            'type' => 'prime_minister',
            'photo_url' => 'assets/images/pm_quote_avatar.png',
            'quote_hi' => 'India\'s technical textiles sector is witnessing rapid growth, driven by key initiatives like the National Technical Textiles Mission and the PLI scheme. These efforts are boosting manufacturing, innovation and exports, positioning India as a global leader.',
            'quote_en' => 'India\'s technical textiles sector is witnessing rapid growth, driven by key initiatives like the National Technical Textiles Mission and the PLI scheme. These efforts are boosting manufacturing, innovation and exports, positioning India as a global leader.',
            'quote_date' => '10.08.2025',
            'profile_link' => 'https://pmindia.gov.in',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Cabinet Minister - Shri Giriraj Singh
        Dignitary::create([
            'name_hi' => 'श्री गिरिराज सिंह',
            'name_en' => 'Shri Giriraj Singh',
            'designation_hi' => 'माननीय वस्त्र मंत्री',
            'designation_en' => 'Hon\'ble Minister of Textiles',
            'type' => 'minister',
            'photo_url' => 'assets/images/dignitary_giriraj.png',
            'profile_link' => '#',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Minister of State - Shri Pabitra Margherita
        Dignitary::create([
            'name_hi' => 'श्री पवित्र मार्गेरिटा',
            'name_en' => 'Shri Pabitra Margherita',
            'designation_hi' => 'माननीय वस्त्र राज्य मंत्री',
            'designation_en' => 'Hon\'ble Minister of State for Textiles',
            'type' => 'minister',
            'photo_url' => 'assets/images/dignitary_pabitra.png',
            'profile_link' => '#',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Secretary - Smt. Neelam Shami Rao
        Dignitary::create([
            'name_hi' => 'श्रीमती नीलम शमी राव',
            'name_en' => 'Smt. Neelam Shami Rao',
            'designation_hi' => 'सचिव, वस्त्र मंत्रालय',
            'designation_en' => 'Secretary, Ministry of Textiles',
            'type' => 'secretary',
            'photo_url' => 'assets/images/dignitary_neelam.png',
            'profile_link' => '#',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 5. Schemes
        Scheme::truncate();
        $schemesData = [
            [
                'title_hi' => 'उत्पादन लिंक्ड प्रोत्साहन (पीएलआई)',
                'title_en' => 'Production Linked Incentive (PLI)',
                'description_hi' => 'वस्त्र क्षेत्र हेतु ₹10,683 करोड़ का उत्पादन आधारित प्रोत्साहन।',
                'description_en' => 'Incentives for MMF apparel and technical textiles.',
                'category' => 'scheme',
            ],
            [
                'title_hi' => 'कपास उत्पादकता मिशन (कपास क्रांति)',
                'title_en' => 'The Cotton Productivity Mission (Kapas Kranti)',
                'description_hi' => 'कपास की उपज और गुणवत्ता सुधार हेतु राष्ट्रीय मिशन।',
                'description_en' => 'Mission to enhance cotton yield, quality and value addition.',
                'category' => 'scheme',
            ],
            [
                'title_hi' => 'टेक्सटाइल फोकस्ड रिसर्च, असेसमेंट, मॉनिटरिंग, प्लानिंग और स्टार्टअप (T-FRAME-PS)',
                'title_en' => 'TEXTILE FOCUSED RESEARCH, ASSESSMENT, MONITORING, PLANNING AND START-UP (T-FRAME-PS) SCHEME',
                'description_hi' => 'तकनीकी अनुसंधान और स्टार्टअप्स के लिए राष्ट्रीय योजना।',
                'description_en' => 'Support for textile startups and cutting-edge R&D.',
                'category' => 'scheme',
            ],
            [
                'title_hi' => 'पीएम मित्र मेगा एकीकृत वस्त्र क्षेत्र और परिधान पार्क',
                'title_en' => 'PM MITRA',
                'description_hi' => '7 राज्यों में विश्व स्तरीय मेगा टेक्सटाइल पार्क।',
                'description_en' => 'PM Mega Integrated Textile Region and Apparel Parks.',
                'category' => 'scheme',
            ],
        ];
        foreach ($schemesData as $idx => $s) {
            Scheme::create(array_merge($s, [
                'link_url' => '#',
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 6. Tenders
        Tender::truncate();
        $tendersData = [
            [
                'reference_no' => 'TC/RFP/2026/01',
                'title_hi' => 'वस्त्र समिति अधिनियम 1963, नियम एवं विनियमों की व्यापक समीक्षा हेतु परामर्शदाता एजेंसी का चयन',
                'title_en' => 'Selection of Agency for Comprehensive Review of the Textiles Committee Act 1963, Rules and Regulations',
                'type' => 'tender',
                'published_date' => '2026-08-15',
                'closing_date' => '2026-10-30',
                'status' => 'open',
            ],
            [
                'reference_no' => 'TC/LAB/EQ/2026/04',
                'title_hi' => 'केंद्रीय परीक्षण प्रयोगशाला, मुंबई हेतु उच्च प्रदर्शन लिक्विड क्रोमैटोग्राफी आपूर्ति निविदा',
                'title_en' => 'Supply and Installation of High Performance Liquid Chromatography for Central Testing Laboratory',
                'type' => 'tender',
                'published_date' => '2026-09-01',
                'closing_date' => '2026-10-25',
                'status' => 'open',
            ],
            [
                'reference_no' => 'TC/REC/EPQA/2026/02',
                'title_hi' => 'गुणवत्ता आश्वासन अधिकारी एवं तकनीकी सहायकों के रिक्त पदों पर सीधी भर्ती',
                'title_en' => 'Recruitment for Posts of Quality Assurance Officer and Technical Assistants',
                'type' => 'vacancy',
                'published_date' => '2026-09-10',
                'closing_date' => '2026-11-15',
                'status' => 'open',
            ],
        ];
        foreach ($tendersData as $idx => $t) {
            Tender::create(array_merge($t, [
                'document_url' => 'assets/images/sample_doc.pdf',
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 7. What's New
        WhatsNew::truncate();
        $whatsNewData = [
            [
                'title_hi' => 'परिधान/वस्त्र और मेड-अप्स के निर्यात पर राज्य और केंद्रीय करों और लेवी की छूट योजना (RoSCTL) के विस्तार के संबंध में (हिंदी)',
                'title_en' => 'Regarding Extension of Rebate of State and Central Taxes and Levies Scheme on Export of Apparel/Garment and Made-ups (RoSCTL) in Hindi',
                'date' => '2026-10-04',
                'is_new' => true,
            ],
            [
                'title_hi' => 'परिधान/वस्त्र और मेड-अप्स के निर्यात पर राज्य और केंद्रीय करों और लेवी की छूट योजना (RoSCTL) के विस्तार के संबंध में (अंग्रेजी)',
                'title_en' => 'Regarding Extension of Rebate of State and Central Taxes and Levies Scheme on Export of Apparel/Garment and Made-ups (RoSCTL) in English',
                'date' => '2026-10-01',
                'is_new' => true,
            ],
            [
                'title_hi' => 'टिप्पणियों के लिए राष्ट्रीय फाइबर मिशन पर मसौदा अवधारणा नोट',
                'title_en' => 'Draft Concept Note On NATIONAL FIBRE MISSION for comments',
                'date' => '2026-09-28',
                'is_new' => true,
            ],
        ];
        foreach ($whatsNewData as $idx => $w) {
            WhatsNew::create(array_merge($w, [
                'link_url' => '#',
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 8. Documents
        Document::truncate();
        $docsData = [
            [
                'title_hi' => 'राजपत्र अधिसूचनाएं',
                'title_en' => 'Gazettes Notifications',
                'category' => 'gazette',
                'description_hi' => 'अधिसूचनाएं',
                'description_en' => 'Notifications',
                'file_size' => '2.4 MB',
                'published_date' => '2026-09-15',
            ],
            [
                'title_hi' => 'रिपोर्ट और प्रकाशन',
                'title_en' => 'Reports And Publications',
                'category' => 'report',
                'description_hi' => 'मंत्रालय की पत्रिका',
                'description_en' => 'Magazine of Ministry',
                'file_size' => '5.8 MB',
                'published_date' => '2026-08-30',
            ],
            [
                'title_hi' => 'रिपोर्ट और प्रकाशन',
                'title_en' => 'Reports And Publications',
                'category' => 'report',
                'description_hi' => 'वस्त्र क्षेत्र की सांख्यिकी प्रणाली को मजबूत करने हेतु टास्क फोर्स रिपोर्ट',
                'description_en' => 'Task Force Report for Strengthening the Statistical System of the Textiles Sector',
                'file_size' => '4.2 MB',
                'published_date' => '2026-07-20',
            ],
            [
                'title_hi' => 'रिपोर्ट और प्रकाशन',
                'title_en' => 'Reports And Publications',
                'category' => 'report',
                'description_hi' => 'वस्त्र विभागीय शिखर सम्मेलन एजेंडा नोट वीआर',
                'description_en' => 'Textiles Departmental Summit Agenda Note VR',
                'file_size' => '1.9 MB',
                'published_date' => '2026-09-05',
            ],
        ];
        foreach ($docsData as $idx => $d) {
            Document::create(array_merge($d, [
                'file_url' => 'assets/images/sample_doc.pdf',
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 9. Personas
        Persona::truncate();
        $personasData = [
            [
                'title_hi' => 'निवेशक के लिए',
                'title_en' => 'FOR INVESTOR',
                'subtitle_hi' => 'पीएम मित्र, पीएलआई और एफडीआई नीति से जुड़े लाभ',
                'subtitle_en' => 'Incentives, PM MITRA and single-window clearances',
                'avatar_url' => 'assets/images/persona_investor_exact.png',
                'link_url' => '#',
            ],
            [
                'title_hi' => 'बुनकरों एवं कारीगरों के लिए',
                'title_en' => 'FOR WEAVERS & ARTISANS',
                'subtitle_hi' => 'हथकरघा मार्क और कल्याणकारी योजनाएं',
                'subtitle_en' => 'Handloom Mark and welfare schemes',
                'avatar_url' => 'assets/images/persona_investor_exact.png',
                'link_url' => '#',
            ],
            [
                'title_hi' => 'निर्यातकों के लिए',
                'title_en' => 'FOR EXPORTERS',
                'subtitle_hi' => 'वैश्विक परीक्षण और प्रमाणन सेवाएं',
                'subtitle_en' => 'Global testing and certification services',
                'avatar_url' => 'assets/images/persona_investor_exact.png',
                'link_url' => '#',
            ],
        ];
        foreach ($personasData as $idx => $p) {
            Persona::create(array_merge($p, [
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 10. Important Links
        ImportantLink::truncate();
        $linksData = [
            ['title_hi' => 'डैशबोर्ड', 'title_en' => 'Dashboard', 'url' => '#', 'category' => 'important'],
            ['title_hi' => 'वस्त्र डेटा', 'title_en' => 'Textile Data', 'url' => '#', 'category' => 'important'],
            ['title_hi' => 'इंडिया हैंडमेड', 'title_en' => 'India Handmade', 'url' => '#', 'category' => 'important'],
            ['title_hi' => 'परीक्षण सुविधाएं', 'title_en' => 'Testing Facilities', 'url' => '#', 'category' => 'important'],
            ['title_hi' => 'भौगोलिक संकेत (जीआई)', 'title_en' => 'Geographical Indications', 'url' => '#', 'category' => 'important'],
        ];
        foreach ($linksData as $idx => $l) {
            ImportantLink::create(array_merge($l, [
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]));
        }

        // 11. Campaigns
        Campaign::truncate();
        Campaign::create([
            'title_hi' => 'मेक इन इंडिया',
            'title_en' => 'Make in India - Driving India\'s Growth',
            'image_url' => 'assets/images/camp_make_in_india_exact.png',
            'link_url' => 'https://www.makeinindia.com',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Campaign::create([
            'title_hi' => 'ब्रिक्स 2026',
            'title_en' => 'BRICS INDIA 2026',
            'image_url' => 'assets/images/camp_brics_exact.png',
            'link_url' => '#',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        Campaign::create([
            'title_hi' => 'वस्त्र डैशबोर्ड',
            'title_en' => 'National Textile Dashboard',
            'image_url' => 'assets/images/camp_dashboard_exact.png',
            'link_url' => '#',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 12. CMS Pages
        Page::truncate();
        Page::create([
            'slug' => 'about-us',
            'title_hi' => 'हमारे बारे में',
            'title_en' => 'About Us',
            'content_hi' => '<p>वस्त्र मंत्रालय, भारत सरकार, शीर्ष संस्थान है जो नीतियों को तैयार करने और भारत के समृद्ध और विविध वस्त्र क्षेत्र के समग्र विकास को बढ़ावा देने के लिए जिम्मेदार है। यह हथकरघा, हस्तशिल्प, रेशम और कम्प्यूटिक विकास से देश के सबसे बड़े रोजगार प्रदाताओं में से एक है। यह भारत को विश्व स्तर पर प्रतिस्पर्धी, अभिनव और टिकाऊ कपड़ा समिति केंद्र के रूप में बदलने के लिए प्रतिबद्ध है और यह विकसित भारत 2047 और आत्मनिर्भर भारत के दृष्टिकोण पर आधारित है।</p>',
            'content_en' => '<p>The Ministry of Textiles, Government of India, is the apex body responsible for policy formulation, planning, development, export promotion and trade regulation of the textile sector. The sector is one of the oldest industries and a vital pillar of the Indian economy providing employment to millions of artisans, weavers, farmers and industrial workers.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'slug' => 'organization',
            'title_hi' => 'हमारा संगठन एवं संरचना',
            'title_en' => 'Our Organization & Structure',
            'content_hi' => '<p>वस्त्र समिति संसद के अधिनियम (वस्त्र समिति अधिनियम, 1963) द्वारा स्थापित एक वैधानिक निकाय है। इसका प्राथमिक उद्देश्य आंतरिक खपत तथा निर्यात दोनों के लिए वस्त्रों एवं वस्त्र मशीनरी की गुणवत्ता सुनिश्चित करना है। समिति के पास देश भर में अत्याधुनिक 19 परीक्षण प्रयोगशालाएं तथा 14 क्षेत्रीय कार्यालय हैं।</p>',
            'content_en' => '<p>The Textiles Committee is a statutory body established under the Textiles Committee Act, 1963 by Parliament. Its primary mandate is ensuring high quality standards in textiles and textile machinery for both internal consumption and export markets with 19 state-of-the-art testing laboratories.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'slug' => 'our-team',
            'title_hi' => 'हमारी टीम एवं नेतृत्व',
            'title_en' => 'Our Team & Leadership',
            'content_hi' => '<p>वस्त्र मंत्रालय का नेतृत्व माननीय वस्त्र मंत्री श्री गिरिराज सिंह, माननीय वस्त्र राज्य मंत्री श्री पवित्र मार्गेरिटा तथा सचिव श्रीमती रचना शाह के मार्गदर्शन में किया जा रहा है। वस्त्र समिति की अध्यक्षता वरिष्ठ अधिकारियों द्वारा की जाती है।</p>',
            'content_en' => '<p>The Ministry of Textiles is led under the guidance of Hon\'ble Minister Shri Giriraj Singh, Hon\'ble Minister of State Shri Pabitra Margherita and Secretary Smt. Rachna Shah.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'slug' => 'dashboard',
            'title_hi' => 'हमारा डैशबोर्ड',
            'title_en' => 'Our Dashboard',
            'content_hi' => '<p>वस्त्र क्षेत्र का वास्तविक समय डेटा डैशबोर्ड: उत्पादन आंकड़े, परीक्षण प्रमाण पत्र, निर्यात सूचकांक और पीएम मित्र योजना की प्रगति का व्यापक अवलोकन।</p>',
            'content_en' => '<p>Real-time analytics dashboard of the textile sector: production figures, laboratory testing certificates issued, export index and PM MITRA implementation status.</p>',
            'is_active' => true,
        ]);

        // 13. Site Settings
        Setting::truncate();
        $settings = [
            'site_title_hi' => 'वस्त्र मंत्रालय | वस्त्र समिति',
            'site_title_en' => 'Ministry of Textiles | Textiles Committee',
            'site_tagline_hi' => 'भारत सरकार',
            'site_tagline_en' => 'Government of India',
            'contact_email' => 'contact@textilescommittee.gov.in',
            'contact_phone' => '+91-22-66527500 / 66527504',
            'contact_address_hi' => 'वस्त्र समिति, वस्त्र मंत्रालय, पी. बालू रोड, प्रभादेवी, मुंबई - 400025, महाराष्ट्र',
            'contact_address_en' => 'Textiles Committee, Ministry of Textiles, P. Balu Road, Prabhadevi, Mumbai - 400025, Maharashtra',
            'visitor_count' => '8614226',
            'twitter_handle' => '@TexMinIndia',
            'facebook_url' => 'https://facebook.com/MinistryofTextilesIndia',
            'youtube_url' => 'https://youtube.com/@MinistryofTextiles',
            'instagram_url' => 'https://instagram.com/ministryoftextiles',
        ];
        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }
    }
}
