<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Inquiry;
use App\Models\ActivityLog;

class ContactUsAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'replied_inquiries' => Inquiry::where('status', 'replied')->count(),
        ];

        $data = [
            // Vision statement
            'contact_vision_en' => Setting::get('contact_vision_en', 'The Textiles Committee of India is a statutory body under the Ministry of Textiles, Government of India, ensuring quality excellence, standardisation, laboratory testing, and export promotion across the textile value chain.'),
            'contact_vision_hi' => Setting::get('contact_vision_hi', 'वस्त्र समिति, वस्त्र मंत्रालय, भारत सरकार के अधीन एक सांविधिक निकाय है, जो गुणवत्ता आश्वासन, परीक्षण प्रयोगशालाओं और निर्यात तत्परता को सुनिश्चित करता है।'),
            'contact_intro_en' => Setting::get('contact_intro_en', 'The Textiles Committee welcomes inquiries, feedback, and service requests from textile mills, weavers, powerloom units, garment exporters, research institutions, and citizens. For quality inspection, testing services, certification, or general queries, please reach out through the form below or contact our central office in Mumbai.'),

            // Head office
            'contact_org_name_en' => Setting::get('contact_org_name_en', 'Textiles Committee of India'),
            'contact_ministry_en' => Setting::get('contact_ministry_en', 'Ministry of Textiles, Government of India'),
            'contact_address_en' => Setting::get('contact_address_en', 'New Prabhadevi Road, RBI Colony, Prabhadevi, Mumbai, Maharashtra – 400025.'),
            'contact_phone' => Setting::get('contact_phone', '+91-22-66527500 / 04'),
            'contact_secretary_phone' => Setting::get('contact_secretary_phone', '+91-22-66527501'),
            'contact_email' => Setting::get('contact_email', 'secy.tc@nic.in'),
            'contact_hours' => Setting::get('contact_hours', 'Mon – Fri, 9:30 AM – 6:00 PM'),

            // WIM
            'wim_name' => Setting::get('wim_name', 'Shri Akhilesh Kumar'),
            'wim_designation' => Setting::get('wim_designation', 'Deputy Director General, Ministry of Textiles'),
            'wim_address' => Setting::get('wim_address', 'GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi – 110023'),
            'wim_phone' => Setting::get('wim_phone', '+91-11-23062109'),
            'wim_email' => Setting::get('wim_email', 'akhilesh[dot]kumar99[at]gov[dot]in'),

            // CISO
            'ciso_name' => Setting::get('ciso_name', 'Shri Akhilesh Kumar'),
            'ciso_designation' => Setting::get('ciso_designation', 'Deputy Director General, Ministry of Textiles'),
            'ciso_role' => Setting::get('ciso_role', 'Administrative Owner (CIO)'),
            'ciso_address' => Setting::get('ciso_address', 'GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi – 110023'),

            // Google Map
            'contact_map_url' => Setting::get('contact_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3772.3394747217596!2d72.8258380757529!3d19.004732682187654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7ce95c1a84f33%3A0xe53be0ef6c41d187!2sTextiles%20Committee%2C%20Govt%20of%20India!5e0!3m2!1sen!2sin!4v1710000000000!5m2!1sen!2sin'),
        ];

        return view('admin.contact-us.index', compact('stats', 'data'));
    }

    public function update(Request $request)
    {
        $fields = [
            'contact_vision_en', 'contact_vision_hi', 'contact_intro_en',
            'contact_org_name_en', 'contact_ministry_en', 'contact_address_en',
            'contact_phone', 'contact_secretary_phone', 'contact_email', 'contact_hours',
            'wim_name', 'wim_designation', 'wim_address', 'wim_phone', 'wim_email',
            'ciso_name', 'ciso_designation', 'ciso_role', 'ciso_address',
            'contact_map_url'
        ];

        foreach ($fields as $f) {
            Setting::set($f, $request->input($f, ''), 'contact');
        }

        // Synchronize with Page ID 76 (contact-us)
        $this->syncContactPage();

        ActivityLog::record('contact_us_updated', 'pages', 76, 'Contact Us details and directory updated by ' . auth()->user()->name);

        return redirect()->back()->with('success', 'Contact Us details and official page content updated successfully.');
    }

    public function syncContactPage()
    {
        $page = Page::where('slug', 'contact-us')->first();
        if (!$page) return;

        $vision = Setting::get('contact_vision_en', 'The Textiles Committee of India is a statutory body under the Ministry of Textiles, Government of India, ensuring quality excellence, standardisation, laboratory testing, and export promotion across the textile value chain.');
        $intro = Setting::get('contact_intro_en', 'The Textiles Committee welcomes inquiries, feedback, and service requests from textile mills, weavers, powerloom units, garment exporters, research institutions, and citizens. For quality inspection, testing services, certification, or general queries, please reach out through the form below or contact our central office in Mumbai.');
        
        $org = Setting::get('contact_org_name_en', 'Textiles Committee of India');
        $ministry = Setting::get('contact_ministry_en', 'Ministry of Textiles, Government of India');
        $address = Setting::get('contact_address_en', 'New Prabhadevi Road, RBI Colony, Prabhadevi, Mumbai, Maharashtra – 400025.');
        $phone = Setting::get('contact_phone', '+91-22-66527500 / 04');
        $secPhone = Setting::get('contact_secretary_phone', '+91-22-66527501');
        $email = Setting::get('contact_email', 'secy.tc@nic.in');
        $hours = Setting::get('contact_hours', 'Mon – Fri, 9:30 AM – 6:00 PM');

        $wimName = Setting::get('wim_name', 'Shri Akhilesh Kumar');
        $wimDesig = Setting::get('wim_designation', 'Deputy Director General, Ministry of Textiles');
        $wimAddr = Setting::get('wim_address', 'GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi – 110023');
        $wimPhone = Setting::get('wim_phone', '+91-11-23062109');
        $wimEmail = Setting::get('wim_email', 'akhilesh[dot]kumar99[at]gov[dot]in');

        $cisoName = Setting::get('ciso_name', 'Shri Akhilesh Kumar');
        $cisoDesig = Setting::get('ciso_designation', 'Deputy Director General, Ministry of Textiles');
        $cisoRole = Setting::get('ciso_role', 'Administrative Owner (CIO)');
        $cisoAddr = Setting::get('ciso_address', 'GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi – 110023');

        $mapUrl = Setting::get('contact_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3772.3394747217596!2d72.8258380757529!3d19.004732682187654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7ce95c1a84f33%3A0xe53be0ef6c41d187!2sTextiles%20Committee%2C%20Govt%20of%20India!5e0!3m2!1sen!2sin!4v1710000000000!5m2!1sen!2sin');

        $html = <<<HTML
<div class="row g-5 my-3" data-component="dbim_full_layout">
    <!-- LEFT COLUMN: Sticky Visionbox & Official Contacts (Matching Image 1 & Inspection Service Theme) -->
    <div class="col-md-12 col-lg-4 stickyBox">
        <!-- 1. Visionbox -->
        <div class="visionbox">
            <div>
                <h2>{$vision}</h2>
                <p>MINISTRY OF TEXTILES &bull; GOVT. OF INDIA</p>
            </div>
        </div>

        <!-- 2. Headquarters Address Box (Matching Image 1) -->
        <div class="box mt-4 p-4">
            <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 14px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                <i class="fa-solid fa-location-dot me-2" style="color: #721835;"></i> Head Office
            </h4>
            <div style="font-size: 1.55rem; line-height: 1.8; color: #1a1a1a;">
                <strong>{$ministry}</strong><br>
                {$org},<br>
                {$address}
            </div>
            <div class="mt-3 pt-3 border-top" style="border-color: #ebd0de !important; font-size: 1.5rem; line-height: 1.8; color: #2b2b2b;">
                <div><strong>EPABX:</strong> {$phone}</div>
                <div><strong>Secretary:</strong> {$secPhone}</div>
                <div><strong>Email:</strong> {$email}</div>
                <div><strong>Office Hours:</strong> {$hours}</div>
            </div>
        </div>

        <!-- 3. Web Information Manager (WIM) (Exact match to Image 1) -->
        <div class="box mt-4 p-4">
            <h4 style="color: #500a2f; font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                Content Related &amp; WIM
            </h4>
            <div style="font-size: 1.5rem; line-height: 1.75; color: #2b2b2b;">
                <strong style="color: #1a1a1a; font-size: 1.6rem;">{$wimName}</strong><br>
                {$wimDesig}<br>
                {$wimAddr}<br>
                <div class="mt-2">
                    <span class="d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-phone" style="color: #721835;"></i> {$wimPhone}
                    </span><br>
                    <span class="d-inline-flex align-items-center gap-2 mt-1">
                        <i class="fa-solid fa-envelope" style="color: #721835;"></i> {$wimEmail}
                    </span>
                </div>
            </div>
        </div>

        <!-- 4. Chief Information Security Officer (CISO) / CIO (Exact match to Image 1) -->
        <div class="box mt-4 p-4">
            <h4 style="color: #500a2f; font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                Chief Information Security Officer (CISO)
            </h4>
            <div style="font-size: 1.5rem; line-height: 1.75; color: #2b2b2b;">
                <strong style="color: #1a1a1a; font-size: 1.6rem;">{$cisoName}</strong><br>
                {$cisoDesig}<br>
                {$cisoRole}<br>
                {$cisoAddr}
            </div>
        </div>

        <!-- 5. Industry Tech Issues Callout Card -->
        <div class="box mt-4 p-4 text-center" style="background: #fdf7fa; border: 1.5px dashed #6c1340;">
            <h4 style="color: #500a2f; font-size: 1.75rem; font-weight: 700; margin-bottom: 8px;">
                Industry Tech Issues?
            </h4>
            <p style="font-size: 1.45rem; line-height: 1.6; color: #555; margin-bottom: 14px;">
                Facing technical, dyeing, or fabric production issues? Submit your issue or view verified solutions.
            </p>
            <a href="/tcwebsite/public/industry-tech-issues" class="btn text-white fw-bold py-2 px-4 d-inline-flex align-items-center justify-content-center gap-2 w-100" style="background: #6c1340; border-radius: 8px; font-size: 1.5rem;">
                <i class="fa fa-wrench"></i>
                <span>Industry Tech Issues Portal</span>
            </a>
        </div>
    </div>

    <!-- RIGHT COLUMN: Aboutcontent with Interactive Form and Map (Matching Image 2) -->
    <div class="col-md-12 col-lg-8">
        <div class="aboutcontent text-justify">
            <h2>Contact Textiles Committee</h2>
            <p>{$intro}</p>

            <!-- Interactive Contact Form & Location Map Grid (Exact Content of Image 2) -->
            <div class="row g-4 mt-2 mb-5">
                <!-- Left: Contact Form -->
                <div class="col-12 col-xl-6">
                    <div class="box p-4 p-md-5 h-100" style="border: 1.5px solid #ebd0de; border-radius: 12px; box-shadow: 0 4px 20px rgba(80, 10, 47, 0.05);">
                        <h3 style="color: #500a2f; font-size: 2.1rem; font-weight: 700; margin-top: 0; margin-bottom: 18px; border-bottom: 2px solid #ebd0de; padding-bottom: 10px;">
                            Send Us a Message
                        </h3>
                        <form action="/tcwebsite/public/inquiry" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem; margin-bottom: 6px;">
                                    Your Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" required placeholder="Enter your full name" style="border: 1px solid #ebd0de; padding: 12px 14px; font-size: 1.55rem; border-radius: 8px; background: #fafafa;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem; margin-bottom: 6px;">
                                    Your Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" required placeholder="name@example.com" style="border: 1px solid #ebd0de; padding: 12px 14px; font-size: 1.55rem; border-radius: 8px; background: #fafafa;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem; margin-bottom: 6px;">
                                    Subject <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="subject" class="form-control" required placeholder="Subject of your inquiry" style="border: 1px solid #ebd0de; padding: 12px 14px; font-size: 1.55rem; border-radius: 8px; background: #fafafa;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem; margin-bottom: 6px;">
                                    Your Message <span class="text-danger">*</span>
                                </label>
                                <textarea name="message" class="form-control" rows="5" required placeholder="Type your detailed message here..." style="border: 1px solid #ebd0de; padding: 12px 14px; font-size: 1.55rem; border-radius: 8px; background: #fafafa;"></textarea>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn text-white fw-bold py-3 px-5 shadow-sm" style="background: #6c1340; border-radius: 8px; font-size: 1.6rem; border: none;">
                                    <i class="fa fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right: Google Map Embed -->
                <div class="col-12 col-xl-6">
                    <div class="box p-0 h-100 overflow-hidden d-flex flex-column" style="border: 1.5px solid #ebd0de; border-radius: 12px; box-shadow: 0 4px 20px rgba(80, 10, 47, 0.05); min-height: 480px;">
                        <div class="p-3" style="background: #fdf7fa; border-bottom: 1px solid #ebd0de;">
                            <h4 style="margin: 0; color: #500a2f; font-size: 1.7rem; font-weight: 700;">
                                <i class="fa-solid fa-map-location-dot me-2" style="color: #721835;"></i> Location Map
                            </h4>
                            <span style="font-size: 1.35rem; color: #666;">{$org}, Prabhadevi, Mumbai</span>
                        </div>
                        <iframe 
                            title="Textiles Committee of India Map"
                            src="{$mapUrl}" 
                            width="100%" 
                            height="100%" 
                            style="border:0; flex-grow: 1; min-height: 420px; display: block;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Regional Offices Network Section -->
            <h2>Nationwide Office &amp; Laboratory Network</h2>
            <p>
                The Textiles Committee operates 28 Regional Offices and 19 state-of-the-art testing laboratories located across all major textile producing and exporting hubs in India, including Ahmedabad, Bengaluru, Chennai, Coimbatore, Hyderabad, Indore, Jaipur, Kanpur, Kolkata, Ludhiana, New Delhi, Surat, and Tirupur.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-3">
                <a href="/tcwebsite/public/page/office-network" class="btn text-white fw-bold py-2 px-4" style="background: #500a2f; border-radius: 8px; font-size: 1.55rem;">
                    <i class="fa fa-building me-2"></i> View Regional Offices Directory
                </a>
                <a href="/tcwebsite/public/page/testing-laboratories" class="btn btn-outline-dark fw-bold py-2 px-4" style="border-radius: 8px; font-size: 1.55rem; border-color: #500a2f; color: #500a2f;">
                    <i class="fa fa-flask me-2"></i> Laboratory Testing Services
                </a>
            </div>
        </div>
    </div>
</div>
HTML;

        $page->content_en = $html;
        $page->content_hi = $html;
        $page->save();
    }
}
