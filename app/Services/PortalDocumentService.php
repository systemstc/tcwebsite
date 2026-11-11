<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Page;
use App\Models\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PortalDocumentService
{
    /**
     * Get the most recently uploaded/published documents from across all portal sections.
     * Checks:
     * 1. The dedicated Document CMS model (`documents` table)
     * 2. Embedded document cards across all active CMS pages
     * 3. Media library uploaded documents (PDFs)
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getRecentDocuments(int $limit = 4)
    {
        return Cache::remember('portal_recent_documents_' . $limit, 300, function () use ($limit) {
            $allDocs = [];

            // 1. Documents CMS Table
            $cmsDocs = Document::where('is_active', true)
                ->orderBy('published_date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->take(15)
                ->get();

            foreach ($cmsDocs as $d) {
                $rawTitle = $d->title_en ?: $d->title_hi ?: 'Official Document';
                $title = trim(html_entity_decode(strip_tags($rawTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $sub = trim(html_entity_decode(strip_tags($d->description_en ?: $d->description_hi ?: ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

                $dateStr = $d->published_date ? date('d.m.Y', strtotime($d->published_date)) : ($d->created_at ? $d->created_at->format('d.m.Y') : '16.10.2026');
                $timestamp = $d->published_date ? strtotime($d->published_date) : ($d->created_at ? $d->created_at->timestamp : time());

                $fileUrl = $d->file_url ?: 'assets/images/sample_doc.pdf';
                if (!str_starts_with($fileUrl, 'http://') && !str_starts_with($fileUrl, 'https://')) {
                    $fileUrl = asset(ltrim($fileUrl, '/'));
                }

                $category = !empty($d->category) ? ucwords(str_replace(['_', '-'], ' ', $d->category)) : 'Document';

                $allDocs[] = [
                    'title' => $title,
                    'sub' => $sub ?: $category,
                    'category' => $category,
                    'url' => $fileUrl,
                    'size' => $d->file_size ?: '1.25 MB',
                    'date' => $dateStr,
                    'timestamp' => $timestamp,
                ];
            }

            // 2. Scan Embedded Document Cards across active CMS Pages
            $pages = Page::where('is_active', true)
                ->select(['id', 'slug', 'title_en', 'content_en', 'updated_at', 'created_at'])
                ->get();

            foreach ($pages as $p) {
                $content = $p->content_en;
                if (empty($content) || !str_contains($content, 'dbim-doc-card-row')) {
                    continue;
                }

                if (preg_match_all('/<div[^>]*class="[^"]*dbim-doc-card-row[^"]*"[^>]*>([\s\S]*?)<\/div>\s*<\/div>/i', $content, $matches)) {
                    foreach ($matches[1] as $inner) {
                        $title = '';
                        if (preg_match('/<span[^>]*class="[^"]*doc-title-text[^"]*"[^>]*>([\s\S]*?)<\/span>/i', $inner, $tm)) {
                            $title = trim(html_entity_decode(strip_tags($tm[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                        }

                        if (empty($title)) {
                            continue;
                        }

                        $url = '';
                        if (preg_match('/href="([^"]+)"/i', $inner, $um)) {
                            $url = trim($um[1]);
                        }
                        if (empty($url) || $url === '#') {
                            continue;
                        }

                        $date = '';
                        if (preg_match('/<div[^>]*class="[^"]*doc-date-col[^"]*"[^>]*>([\s\S]*?)<\/div>/i', $inner, $dm)) {
                            $date = trim(strip_tags($dm[1]));
                        }

                        $size = '';
                        if (preg_match('/<span[^>]*class="[^"]*doc-size-text[^"]*"[^>]*>([\s\S]*?)<\/span>/i', $inner, $sm)) {
                            $size = trim(strip_tags($sm[1]));
                        }

                        // Determine timestamp
                        $ts = 0;
                        if ($date) {
                            $parts = explode('.', $date);
                            if (count($parts) === 3 && is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2])) {
                                $ts = strtotime("{$parts[2]}-{$parts[1]}-{$parts[0]}");
                            }
                        }
                        if (!$ts) {
                            $ts = $p->updated_at ? $p->updated_at->timestamp : ($p->created_at ? $p->created_at->timestamp : time());
                        }

                        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
                            $url = asset(ltrim($url, '/'));
                        }

                        $allDocs[] = [
                            'title' => $title,
                            'sub' => $p->title_en ?: 'Textiles Committee',
                            'category' => $p->title_en ?: 'Publication',
                            'url' => $url,
                            'size' => $size ?: '1.25 MB',
                            'date' => $date ?: date('d.m.Y', $ts),
                            'timestamp' => $ts,
                        ];
                    }
                }
            }

            // 3. Scan Uploaded Documents in Media Library (if not already found)
            $mediaDocs = Media::where('file_type', 'document')
                ->orWhere('extension', 'pdf')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            foreach ($mediaDocs as $m) {
                $rawTitle = $m->title ?: $m->name ?: pathinfo($m->file_name, PATHINFO_FILENAME);
                $title = trim(html_entity_decode(strip_tags($rawTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $url = $m->disk_path ? asset($m->disk_path) : ($m->url ? (str_starts_with($m->url, 'http') ? $m->url : asset(ltrim($m->url, '/'))) : '#');

                $allDocs[] = [
                    'title' => $title,
                    'sub' => 'Media Library / Upload',
                    'category' => 'Official Upload',
                    'url' => $url,
                    'size' => $m->size ?: '1.25 MB',
                    'date' => $m->created_at ? $m->created_at->format('d.m.Y') : '16.10.2026',
                    'timestamp' => $m->created_at ? $m->created_at->timestamp : time(),
                ];
            }

            // 4. Scan Tenders & Vacancies with uploaded documents
            $tenderDocs = \App\Models\Tender::where('is_active', true)
                ->whereNotNull('document_url')
                ->where('document_url', '!=', '')
                ->orderBy('published_date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->take(15)
                ->get();

            foreach ($tenderDocs as $t) {
                $rawTitle = $t->title_en ?: $t->title_hi ?: 'Tender Notice';
                $title = trim(html_entity_decode(strip_tags($rawTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $sub = $t->type === 'vacancy' ? 'Vacancies & Careers' : 'Tenders & Proposals';
                $category = $t->type === 'vacancy' ? 'Vacancy' : 'Tender';

                $dateStr = $t->published_date ? date('d.m.Y', strtotime($t->published_date)) : ($t->created_at ? $t->created_at->format('d.m.Y') : date('d.m.Y'));
                $timestamp = $t->published_date ? strtotime($t->published_date) : ($t->created_at ? $t->created_at->timestamp : time());

                $fileUrl = $t->document_url;
                if (!str_starts_with($fileUrl, 'http://') && !str_starts_with($fileUrl, 'https://')) {
                    $fileUrl = asset(ltrim($fileUrl, '/'));
                }

                $allDocs[] = [
                    'title' => $title,
                    'sub' => $sub,
                    'category' => $category,
                    'url' => $fileUrl,
                    'size' => 'PDF',
                    'date' => $dateStr,
                    'timestamp' => $timestamp,
                ];
            }

            // Deduplicate by normalized title
            $uniqueDocs = [];
            foreach ($allDocs as $doc) {
                $key = strtolower(preg_replace('/[^a-z0-9]/', '', $doc['title']));
                if (empty($key)) {
                    continue;
                }
                if (!isset($uniqueDocs[$key]) || $uniqueDocs[$key]['timestamp'] < $doc['timestamp']) {
                    $uniqueDocs[$key] = $doc;
                }
            }

            // Sort by latest timestamp descending
            usort($uniqueDocs, function ($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });

            return collect(array_slice($uniqueDocs, 0, $limit));
        });
    }

    /**
     * Clear document cache on upload / update.
     */
    public static function clearCache()
    {
        Cache::forget('portal_recent_documents_4');
        Cache::forget('portal_recent_documents_6');
        Cache::forget('portal_recent_documents_8');
    }

    /**
     * Normalize document rows in HTML:
     * - Resolves true file size from local disk files
     * - Generates matching SVG icon and color for the file extension (PDF, DOCX, XLSX, etc.)
     */
    public static function normalizeDocumentRowsHtml(?string $html): ?string
    {
        if (empty($html)) return $html;

        return preg_replace_callback('/<div[^>]*class=["\'][^"\']*(?:dbim-doc-card-row|doc-card-row)[^"\']*["\'][^>]*>([\s\S]*?)<\/div>\s*<\/div>/i', function($m) {
            $rowHtml = $m[0];

            // 1. Locate href
            if (!preg_match('/<a[^>]+href=["\']([^"\']+)["\']/i', $rowHtml, $hrefMatch)) {
                return $rowHtml;
            }

            $href = trim($hrefMatch[1]);
            if (empty($href) || $href === '#') return $rowHtml;

            // 2. Check extension from href
            $pathWithoutQuery = strtok($href, '?#');
            $ext = '';
            if (preg_match('/\.([a-zA-Z0-9]+)$/', $pathWithoutQuery, $em)) {
                $ext = strtoupper($em[1]);
            }

            // 3. Resolve disk file & size
            $realPath = null;
            if (str_starts_with($href, '/')) {
                $realPath = public_path(ltrim($href, '/'));
            } elseif (str_starts_with($href, 'uploads/')) {
                $realPath = public_path($href);
            } elseif (str_contains($href, '/uploads/')) {
                $parts = explode('/uploads/', $href);
                $realPath = public_path('uploads/' . end($parts));
            }

            $realSize = null;
            if ($realPath && file_exists($realPath) && is_file($realPath)) {
                $bytes = filesize($realPath);
                $realSize = $bytes >= 1048576 
                    ? round($bytes / 1048576, 2) . ' MB' 
                    : round($bytes / 1024, 2) . ' KB';

                if (empty($ext)) {
                    $ext = strtoupper(pathinfo($realPath, PATHINFO_EXTENSION));
                }
            }

            // 4. Update file size text
            if ($realSize) {
                $rowHtml = preg_replace(
                    '/(<span[^>]*class=["\'][^"\']*(?:doc-size-text|doc-size-badge)[^"\']*["\'][^>]*>)(.*?)(<\/span>)/i',
                    '${1}' . $realSize . '${3}',
                    $rowHtml
                );
            }

            // 5. Update icon SVG and badge color
            if (!empty($ext)) {
                $color = '#500a2f'; // default maroon for PDF
                if (in_array($ext, ['DOC', 'DOCX'])) $color = '#185abd';
                elseif (in_array($ext, ['XLS', 'XLSX', 'CSV'])) $color = '#107c41';
                elseif (in_array($ext, ['PPT', 'PPTX'])) $color = '#d83b01';
                elseif (in_array($ext, ['ZIP', 'RAR', '7Z', 'TAR', 'GZ'])) $color = '#6f42c1';
                elseif (in_array($ext, ['TXT', 'RTF'])) $color = '#555555';

                $fontSize = strlen($ext) > 3 ? '5.2' : '6.5';
                $textX = strlen($ext) > 3 ? '5' : '6';

                $newSvg = '<svg class="doc-pdf-svg" width="22" height="24" viewBox="0 0 24 24" fill="none" stroke="' . $color . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; vertical-align: middle;">'
                    . '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>'
                    . '<polyline points="14 2 14 8 20 8"></polyline>'
                    . '<text x="' . $textX . '" y="18" fill="' . $color . '" font-size="' . $fontSize . '" font-family="\'Noto Sans\', sans-serif" font-weight="900" stroke="none">' . $ext . '</text>'
                    . '</svg>';

                $rowHtml = preg_replace('/<svg[^>]*class=["\'][^"\']*doc-pdf-svg[^"\']*["\'][^>]*>.*?<\/svg>/is', $newSvg, $rowHtml);
            }

            return $rowHtml;
        }, $html);
    }
}
