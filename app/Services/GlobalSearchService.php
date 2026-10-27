<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Document;
use App\Models\WhatsNew;
use App\Models\Scheme;
use App\Models\Tender;
use App\Models\IndustryTechIssue;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class GlobalSearchService
{
    /**
     * Perform unified global search across pages, documents, inside PDF text,
     * what's new, schemes, tenders, and technical issues.
     */
    public function search(string $query, int $limitPerCategory = 20): array
    {
        $q = trim($query);
        if (mb_strlen($q) < 2) {
            return [
                'query' => $q,
                'total' => 0,
                'pages' => collect(),
                'documents' => collect(),
                'pdf_texts' => collect(),
                'whats_new' => collect(),
                'schemes' => collect(),
                'tenders' => collect(),
                'tech_issues' => collect(),
                'all' => collect(),
            ];
        }

        $locale = session('locale', 'en');
        $lowerQ = mb_strtolower($q);

        // 1. SEARCH PAGES (Every CMS page title, content, meta)
        $pages = Page::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_hi', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('content_en', 'like', "%{$q}%")
                    ->orWhere('content_hi', 'like', "%{$q}%")
                    ->orWhere('meta_description', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($page) use ($locale, $q) {
                $title = $locale === 'hi' ? ($page->title_hi ?: $page->title_en) : ($page->title_en ?: $page->title_hi);
                $content = $locale === 'hi' ? ($page->content_hi ?: $page->content_en) : ($page->content_en ?: $page->content_hi);
                $plain = strip_tags($content ?? '');
                $snippet = $this->extractSnippet($plain, $q, 140);

                return [
                    'id' => $page->id,
                    'type' => 'page',
                    'type_label' => $locale === 'hi' ? 'वेबसाइट पृष्ठ' : 'Portal Page',
                    'icon' => 'article',
                    'title' => $title,
                    'url' => route('page.show', $page->slug),
                    'slug' => $page->slug,
                    'snippet' => $snippet,
                    'meta' => ucfirst($page->menu_location ?: 'General'),
                    'badge_class' => 'bg-primary',
                ];
            });

        // 2. SEARCH DATABASE DOCUMENTS (Title, Category, Description)
        $matchedDocUrls = [];
        $documents = Document::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_hi', 'like', "%{$q}%")
                    ->orWhere('description_en', 'like', "%{$q}%")
                    ->orWhere('description_hi', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($doc) use ($locale, $q, &$matchedDocUrls) {
                $title = $locale === 'hi' ? ($doc->title_hi ?: $doc->title_en) : ($doc->title_en ?: $doc->title_hi);
                $desc = $locale === 'hi' ? ($doc->description_hi ?: $doc->description_en) : ($doc->description_en ?: $doc->description_hi);
                $url = asset($doc->file_url ?: 'assets/images/sample_doc.pdf');

                if ($doc->file_url) {
                    $matchedDocUrls[] = strtolower(basename($doc->file_url));
                }

                return [
                    'id' => $doc->id,
                    'type' => 'document',
                    'type_label' => $locale === 'hi' ? 'आधिकारिक दस्तावेज़' : 'Official Document',
                    'icon' => 'picture_as_pdf',
                    'title' => $title,
                    'url' => $url,
                    'snippet' => $this->extractSnippet($desc ?: $title, $q, 140),
                    'meta' => ($doc->file_size ?: 'PDF') . ($doc->published_date ? ' • ' . date('d M Y', strtotime($doc->published_date)) : ''),
                    'badge_class' => 'bg-danger',
                    'is_pdf' => true,
                ];
            });

        // 3. SEARCH INSIDE PDF TEXT / PHYSICAL DOCUMENTS
        $pdfTexts = collect($this->searchInsidePdfs($q, $matchedDocUrls, $limitPerCategory));

        // 4. SEARCH WHAT'S NEW & CIRCULARS
        $whatsNews = WhatsNew::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_hi', 'like', "%{$q}%")
                    ->orWhere('content_en', 'like', "%{$q}%")
                    ->orWhere('content_hi', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($item) use ($locale, $q) {
                $title = $locale === 'hi' ? ($item->title_hi ?: $item->title_en) : ($item->title_en ?: $item->title_hi);
                $content = $locale === 'hi' ? ($item->content_hi ?: $item->content_en) : ($item->content_en ?: $item->content_hi);
                $url = $item->document_url ? asset($item->document_url) : ($item->link_url && $item->link_url !== '#' ? $item->link_url : route('whats-new.index'));

                return [
                    'id' => $item->id,
                    'type' => 'whats_new',
                    'type_label' => $locale === 'hi' ? 'नवीनतम सूचना' : "What's New / Circular",
                    'icon' => 'campaign',
                    'title' => $title,
                    'url' => $url,
                    'snippet' => $this->extractSnippet($content ?: $title, $q, 140),
                    'meta' => ($item->category ?: 'Notice') . ($item->date ? ' • ' . date('d M Y', strtotime($item->date)) : ''),
                    'badge_class' => 'bg-warning text-dark',
                    'is_pdf' => (bool) $item->document_url,
                ];
            });

        // 5. SEARCH GOVERNMENT SPONSORED SCHEMES
        $schemes = Scheme::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_hi', 'like', "%{$q}%")
                    ->orWhere('description_en', 'like', "%{$q}%")
                    ->orWhere('description_hi', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($sch) use ($locale, $q) {
                $title = $locale === 'hi' ? ($sch->title_hi ?: $sch->title_en) : ($sch->title_en ?: $sch->title_hi);
                $desc = $locale === 'hi' ? ($sch->description_hi ?: $sch->description_en) : ($sch->description_en ?: $sch->description_hi);
                $url = $sch->link_url && $sch->link_url !== '#' ? $sch->link_url : route('page.show', 'samarth');

                return [
                    'id' => $sch->id,
                    'type' => 'scheme',
                    'type_label' => $locale === 'hi' ? 'योजना एवं सेवा' : 'Scheme & Offering',
                    'icon' => 'verified',
                    'title' => $title,
                    'url' => $url,
                    'snippet' => $this->extractSnippet($desc ?: $title, $q, 140),
                    'meta' => 'Ministry Initiative',
                    'badge_class' => 'bg-success',
                ];
            });

        // 6. SEARCH TENDERS & VACANCIES
        $tenders = Tender::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_hi', 'like', "%{$q}%")
                    ->orWhere('reference_no', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($t) use ($locale, $q) {
                $title = $locale === 'hi' ? ($t->title_hi ?: $t->title_en) : ($t->title_en ?: $t->title_hi);
                $url = $t->document_url ? asset($t->document_url) : '#';

                return [
                    'id' => $t->id,
                    'type' => 'tender',
                    'type_label' => ucfirst($t->type ?: 'Tender'),
                    'icon' => 'gavel',
                    'title' => $title,
                    'url' => $url,
                    'snippet' => "Ref: " . ($t->reference_no ?: 'N/A') . " • Closing Date: " . ($t->closing_date ? $t->closing_date->format('d/m/Y') : 'Open'),
                    'meta' => ucfirst($t->type ?: 'Tender'),
                    'badge_class' => 'bg-secondary',
                    'is_pdf' => (bool) $t->document_url,
                ];
            });

        // 7. SEARCH INDUSTRY TECHNICAL ISSUES & SOLUTIONS
        $techIssues = IndustryTechIssue::where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('solution', 'like', "%{$q}%")
                    ->orWhere('tags', 'like', "%{$q}%");
            })
            ->take($limitPerCategory)
            ->get()
            ->map(function ($issue) use ($q) {
                return [
                    'id' => $issue->id,
                    'type' => 'tech_issue',
                    'type_label' => 'Technical Issue & Solution',
                    'icon' => 'engineering',
                    'title' => $issue->title,
                    'url' => route('industry-tech-issues.show', $issue->slug),
                    'snippet' => $this->extractSnippet($issue->description ?: ($issue->solution ?: $issue->title), $q, 140),
                    'meta' => ucfirst($issue->category ?: 'General') . ' • ' . ucfirst($issue->status),
                    'badge_class' => 'bg-info text-dark',
                ];
            });

        // Combine all results
        $all = collect()
            ->concat($pages)
            ->concat($documents)
            ->concat($pdfTexts)
            ->concat($whatsNews)
            ->concat($schemes)
            ->concat($tenders)
            ->concat($techIssues);

        return [
            'query' => $q,
            'total' => $all->count(),
            'pages' => $pages,
            'documents' => $documents,
            'pdf_texts' => $pdfTexts,
            'whats_new' => $whatsNews,
            'schemes' => $schemes,
            'tenders' => $tenders,
            'tech_issues' => $techIssues,
            'all' => $all,
        ];
    }

    /**
     * Search deep inside PDF document contents using cached plain text.
     */
    protected function searchInsidePdfs(string $query, array $excludeFilenames = [], int $limit = 15): array
    {
        $cacheDir = storage_path('app/pdf_text_cache');
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }

        // Collect all PDFs across known document folders
        $pdfDirs = [
            public_path('assets/documents'),
            public_path('assets/documents/rti'),
            public_path('assets/documents/samarth'),
            public_path('uploads/documents'),
            public_path('assets/images'),
            storage_path('app/public/whats_new'),
        ];

        $pdfFiles = [];
        foreach ($pdfDirs as $dir) {
            if (is_dir($dir)) {
                $matched = glob($dir . '/*.pdf');
                if ($matched) {
                    $pdfFiles = array_merge($pdfFiles, $matched);
                }
            }
        }

        $pdfFiles = array_unique($pdfFiles);
        $results = [];
        $parser = null;

        // Friendly title map for known official documents
        $titleMap = [
            'tc-act-1963.pdf' => 'Textiles Committee Act, 1963 (Official Gazette)',
            'samarth-course-directory.pdf' => 'SAMARTH Skill Training Course Directory & Guidelines',
            'handloom-mark-guidelines.pdf' => 'Handloom Mark Scheme Operational Guidelines',
            'jute-mark-guidelines.pdf' => 'Jute Mark India Quality Standards & Protocols',
            'mtc-survey-2024.pdf' => 'Market for Textiles and Clothing (MTC) National Survey Report',
            'testing-tariff-2024.pdf' => 'Schedule of Testing Charges & Tariffs for Laboratories',
            'priyadarshini-vol32.pdf' => 'Priyadarshini Official In-house Journal Vol. 32',
            'star-rating-cotton.pdf' => 'Star Rating Guidelines for Ginning and Pressing Factories',
            'sample_doc.pdf' => 'Textiles Committee Gazette Notification & Circular',
            'sample-act.pdf' => 'Statutory Rules & Regulations Gazette Document',
            'RTI_Annexure_1.pdf' => 'RTI Annexure I - Organisation Particulars, Functions & Duties',
            'RTI_Annexure_2.pdf' => 'RTI Annexure II - Powers and Duties of Officers and Employees',
            'RTI_Annexure_3.pdf' => 'RTI Annexure III - Decision Making Process & Accountability Channels',
            'RTI_Annexure_4.pdf' => 'RTI Annexure IV - Norms for Discharge of Functions',
            'RTI_Annexure_5.pdf' => 'RTI Annexure V - Rules, Regulations, Manuals & Records',
            'RTI_Annexure_6.pdf' => 'RTI Annexure VI - Statement of Categories of Documents Held',
            'RTI_Annexure_8.pdf' => 'RTI Annexure VIII - Boards, Councils & Committees Constituted',
            'RTI_Annexure_9.pdf' => 'RTI Annexure IX - Directory of Officers and Employees',
            'RTI_Annexure_10.pdf' => 'RTI Annexure X - Monthly Remuneration & Compensation System',
            'RTI_Annexure_11.pdf' => 'RTI Annexure XI - Budget Allocation & Expenditure Reports',
            'RTI_Annexure_12.pdf' => 'RTI Annexure XII - Manner of Execution of Subsidy Programmes',
            'RTI_Annexure_13.pdf' => 'RTI Annexure XIII - Recipients of Concessions & Permits (TRQC)',
            'RTI_Annexure_14.pdf' => 'RTI Annexure XIV - Information Held in Electronic Form',
            'RTI_Annexure_15.pdf' => 'RTI Annexure XV - Citizen Information Facilities & Library Hours',
            'RTI_Annexure_16.pdf' => 'RTI Annexure XVI - Directory of Nodal Officer, CPIO, FAA, DPIO & APIO',
            'RTI_Annexure_17.pdf' => 'RTI Annexure XVII - Other Prescribed Information & Updates',
            'rti_annexure_16_cpio.pdf' => 'RTI Official Directory - Nodal Officer, CPIO, FAA, DPIO & APIO',
        ];

        foreach ($pdfFiles as $filePath) {
            if (!is_file($filePath)) continue;

            $filename = basename($filePath);
            if (in_array(strtolower($filename), $excludeFilenames)) {
                continue;
            }

            $mtime = filemtime($filePath);
            $cacheFile = $cacheDir . '/' . md5($filePath . '_' . $mtime) . '.txt';

            $text = '';
            if (file_exists($cacheFile)) {
                $text = file_get_contents($cacheFile);
            } else {
                if (!$parser) {
                    $parser = new Parser();
                }
                try {
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                    @file_put_contents($cacheFile, $text);
                } catch (\Throwable $e) {
                    continue;
                }
            }

            if (empty($text)) continue;

            // Search inside text (case-insensitive)
            $pos = mb_stripos($text, $query);
            if ($pos !== false) {
                // Extract contextual snippet
                $snippet = $this->extractSnippet($text, $query, 160);

                // Derive title
                $title = $titleMap[$filename] ?? null;
                if (!$title) {
                    // Try to clean humanized name
                    $cleanName = preg_replace('/^(?:doc_\d+_[a-f0-9]+|act-texcom_\d+_[a-z0-9]+)/i', '', $filename);
                    $cleanName = str_replace(['-', '_', '.pdf'], [' ', ' ', ''], $cleanName);
                    $title = trim($cleanName) ? ucwords(trim($cleanName)) : ('Textiles Committee Document (' . substr($filename, 0, 16) . ')');
                }

                $sizeBytes = filesize($filePath);
                $sizeFormatted = $sizeBytes >= 1048576 
                    ? (round($sizeBytes / 1048576, 2) . ' MB') 
                    : (round($sizeBytes / 1024, 2) . ' KB');

                // Determine public relative URL
                $relUrl = str_replace([public_path(), '\\'], ['', '/'], $filePath);
                $url = asset(ltrim($relUrl, '/'));

                $results[] = [
                    'id' => md5($filePath),
                    'type' => 'pdf_text',
                    'type_label' => 'Matched Inside PDF Text',
                    'icon' => 'find_in_page',
                    'title' => $title,
                    'url' => $url,
                    'snippet' => $snippet,
                    'meta' => "PDF Document • {$sizeFormatted} • Text Match Found",
                    'badge_class' => 'bg-danger-subtle text-danger border border-danger-subtle',
                    'is_pdf' => true,
                    'file_name' => $filename,
                ];

                if (count($results) >= $limit) {
                    break;
                }
            }
        }

        return $results;
    }

    /**
     * Extract a neat snippet surrounding the search query.
     */
    public function extractSnippet(string $text, string $query, int $radius = 120): string
    {
        $clean = preg_replace('/\s+/', ' ', strip_tags($text));
        $clean = trim($clean);

        if (empty($clean)) {
            return '';
        }

        $pos = mb_stripos($clean, $query);
        if ($pos === false) {
            return Str::limit($clean, $radius * 2);
        }

        $start = max(0, $pos - $radius);
        $length = mb_strlen($query) + ($radius * 2);
        $snippet = mb_substr($clean, $start, $length);

        $prefix = $start > 0 ? '...' : '';
        $suffix = ($start + $length < mb_strlen($clean)) ? '...' : '';

        return $prefix . trim($snippet) . $suffix;
    }
}
