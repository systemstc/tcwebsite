@extends('layouts.admin')

@section('title', 'CMS Dynamic Pages')

@section('content')
<div class="container-fluid px-0">

    <!-- 1. HEADER & ACTION BUTTONS -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--cms-primary-dark);">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 28px;">auto_stories</span>
                CMS Dynamic Pages Directory
            </h4>
            <p class="text-muted small mb-0">Create, manage, search, and visually design any website page across Ministry, Offerings, Documents, and Connect menus.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-sm">
                <span class="material-symbols-outlined" style="font-size: 18px;">perm_media</span>
                <span>Media Library</span>
            </a>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1 shadow-sm">
                <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                <span>Create New Page</span>
            </a>
        </div>
    </div>

    <!-- 2. SUMMARY METRIC PILLS & QUICK FILTERS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ !request('menu') && !request('status') ? 'border-primary border-2 active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #721835 !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Total Pages</small>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalCount }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index', ['menu' => 'ministry']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ request('menu') == 'ministry' ? 'active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #0d6efd !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Ministry</small>
                    <h4 class="fw-bold mb-0 text-primary">{{ $ministryCount }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index', ['menu' => 'offerings']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ request('menu') == 'offerings' ? 'active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #0dcaf0 !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Offerings</small>
                    <h4 class="fw-bold mb-0 text-info">{{ $offeringsCount }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index', ['menu' => 'documents']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ request('menu') == 'documents' ? 'active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #ffc107 !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Documents</small>
                    <h4 class="fw-bold mb-0 text-warning">{{ $documentsCount }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index', ['menu' => 'connect']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ request('menu') == 'connect' ? 'active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #16a34a !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Connect</small>
                    <h4 class="fw-bold mb-0 text-success">{{ $connectCount }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.pages.index', ['status' => 'published']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 rounded-3 text-center h-100 quick-stat-card {{ request('status') == 'published' ? 'active-stat' : '' }}" style="background: #ffffff; border-left: 4px solid #6c757d !important;">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Published</small>
                    <h4 class="fw-bold mb-0 text-secondary">{{ $publishedCount }}</h4>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. ADVANCED SEARCH & FILTER BAR -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('admin.pages.index') }}" method="GET" id="pagesFilterForm">
                <div class="row g-2 align-items-center">
                    <!-- Search Input -->
                    <div class="col-12 col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <span class="material-symbols-outlined text-muted" style="font-size: 18px;">search</span>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   id="pageSearchInput" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Search by title, slug, or keywords..." 
                                   value="{{ request('search') }}"
                                   onkeyup="instantFilterPages(this.value)">
                            @if(request('search'))
                                <a href="{{ route('admin.pages.index', request()->except('search')) }}" class="input-group-text bg-white text-muted" title="Clear search">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Filter by Menu Location -->
                    <div class="col-6 col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <span class="material-symbols-outlined text-muted" style="font-size: 18px;">folder</span>
                            </span>
                            <select name="menu" class="form-select border-start-0 ps-0" onchange="document.getElementById('pagesFilterForm').submit()">
                                <option value="all" {{ !request('menu') || request('menu') == 'all' ? 'selected' : '' }}>All Menu Locations</option>
                                <option value="ministry" {{ request('menu') == 'ministry' ? 'selected' : '' }}>Ministry (About Us)</option>
                                <option value="offerings" {{ request('menu') == 'offerings' ? 'selected' : '' }}>Offerings & Services</option>
                                <option value="documents" {{ request('menu') == 'documents' ? 'selected' : '' }}>Documents & Publications</option>
                                <option value="connect" {{ request('menu') == 'connect' ? 'selected' : '' }}>Connect (Contact / Tech Issues)</option>
                                <option value="media" {{ request('menu') == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="none" {{ request('menu') == 'none' ? 'selected' : '' }}>Unlisted / Standalone</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter by Status -->
                    <div class="col-6 col-md-2">
                        <select name="status" class="form-select form-select-sm" onchange="document.getElementById('pagesFilterForm').submit()">
                            <option value="all" {{ !request('status') || request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published Only</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafts Only</option>
                        </select>
                    </div>

                    <!-- Sort Order -->
                    <div class="col-6 col-md-2">
                        <select name="sort" class="form-select form-select-sm" onchange="document.getElementById('pagesFilterForm').submit()">
                            <option value="updated" {{ !request('sort') || request('sort') == 'updated' ? 'selected' : '' }}>Recently Updated</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="order" {{ request('sort') == 'order' ? 'selected' : '' }}>Menu Order</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest (ID)</option>
                        </select>
                    </div>

                    <!-- Filter & Reset Buttons -->
                    <div class="col-6 col-md-1 text-end d-flex gap-1 justify-content-end">
                        <button type="submit" class="btn btn-sm btn-dark w-100" title="Apply Filters">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'menu', 'status', 'sort']))
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset all filters">
                                <i class="fa fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. PAGES TABLE -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark" style="font-size: 14.5px;">All Pages</span>
                <span class="badge bg-secondary rounded-pill" id="pageCountBadge">{{ $pages->total() }}</span>
                @if(request('menu') && request('menu') !== 'all')
                    <span class="badge bg-primary text-uppercase" style="font-size: 10px;">Menu: {{ request('menu') }}</span>
                @endif
                @if(request('search'))
                    <span class="badge bg-info text-dark" style="font-size: 10px;">Search: "{{ request('search') }}"</span>
                @endif
            </div>
            <small class="text-muted">Showing {{ $pages->count() }} of {{ $pages->total() }} pages</small>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover m-0" id="pagesTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th style="min-width: 250px;">Page Title</th>
                        <th style="min-width: 140px;">Menu Section</th>
                        <th style="min-width: 120px;">Template Type</th>
                        <th style="min-width: 170px;">URL Route</th>
                        <th style="min-width: 90px;">Status</th>
                        <th style="min-width: 130px;">Last Updated</th>
                        <th style="min-width: 260px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="pagesTableBody">
                    @forelse($pages as $p)
                        @php
                            $isTechIssue = ($p->slug === 'industry-tech-issues');
                            $isContact = ($p->slug === 'contact-us');
                        @endphp
                        <tr class="page-row {{ $isTechIssue ? 'table-warning-subtle' : '' }}" data-title="{{ strtolower($p->title_en . ' ' . $p->title_hi) }}" data-slug="{{ strtolower($p->slug) }}" data-menu="{{ strtolower($p->menu_location) }}">
                            <td class="text-center text-muted fw-bold" style="font-size: 12px;">{{ $p->id }}</td>
                            <td>
                                <div class="fw-bold text-dark page-title-en">
                                    {{ $p->title_en ?: $p->title_hi }}
                                    @if($isTechIssue)
                                        <span class="badge bg-danger text-white ms-1" style="font-size: 10px;">
                                            <i class="fa fa-gears me-1"></i> Interactive Portal
                                        </span>
                                    @elseif($isContact)
                                        <span class="badge bg-success text-white ms-1" style="font-size: 10px;">
                                            <i class="fa fa-address-book me-1"></i> Contact Portal
                                        </span>
                                    @endif
                                </div>
                                @if($p->title_hi && $p->title_en)
                                    <small class="text-muted d-block page-title-hi">{{ $p->title_hi }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $menuBadges = [
                                        'ministry' => ['bg' => 'bg-primary', 'label' => 'Ministry'],
                                        'offerings' => ['bg' => 'bg-info text-dark', 'label' => 'Offerings'],
                                        'documents' => ['bg' => 'bg-warning text-dark', 'label' => 'Documents'],
                                        'media' => ['bg' => 'bg-danger', 'label' => 'Media'],
                                        'connect' => ['bg' => 'bg-success', 'label' => 'Connect'],
                                        'none' => ['bg' => 'bg-light text-muted border', 'label' => 'Standalone'],
                                    ];
                                    $mBadge = $menuBadges[$p->menu_location] ?? ['bg' => 'bg-secondary', 'label' => ucfirst($p->menu_location ?: 'Standalone')];
                                @endphp
                                <a href="{{ route('admin.pages.index', ['menu' => $p->menu_location ?: 'none']) }}" class="text-decoration-none">
                                    <span class="badge {{ $mBadge['bg'] }} px-2 py-1 shadow-xs" style="font-size: 11.5px;">{{ $mBadge['label'] }}</span>
                                </a>
                                @if($p->sort_order)
                                    <span class="badge bg-light text-muted border ms-1" title="Sort Order in Menu">#{{ $p->sort_order }}</span>
                                @endif
                            </td>
                            <td>
                                @if($p->template_type === 'act_history')
                                    <span class="badge text-white" style="background: #721835; font-size: 11px;"><i class="fa-solid fa-scale-balanced me-1"></i> Act & History</span>
                                @elseif($isTechIssue)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 11px;">Dynamic Module</span>
                                @else
                                    <span class="badge bg-light text-dark border" style="font-size: 11px;">{{ ucfirst($p->template_type ?: 'Standard') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($isTechIssue)
                                    <a href="{{ route('industry-tech-issues.index') }}" target="_blank" class="text-decoration-none" title="Open live public portal">
                                        <code class="px-2 py-1 rounded bg-danger-subtle border border-danger-subtle text-danger fw-bold" style="font-size: 11.5px;">/industry-tech-issues</code>
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-danger" style="font-size: 10px;"></i>
                                    </a>
                                @else
                                    <a href="{{ route('page.show', $p->slug) }}" target="_blank" class="text-decoration-none text-muted" title="Open live public URL">
                                        <code class="px-2 py-1 rounded bg-light border text-dark" style="font-size: 11.5px;">/page/{{ $p->slug }}</code>
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-primary" style="font-size: 10px;"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($p->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 11px;">
                                        <i class="fa-solid fa-circle-check me-1"></i> Published
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1" style="font-size: 11px;">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted d-block" style="font-size: 11.5px;">{{ $p->updated_at->format('d M Y') }}</small>
                                <small class="text-muted d-block" style="font-size: 10.5px;">{{ $p->updated_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 align-items-center">
                                    @if($isTechIssue)
                                        <!-- Shortcut to Industry Tech Issues Admin Management -->
                                        <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-danger btn-sm py-1 px-2 fw-semibold" style="font-size: 11.5px;" title="Manage Tech Issues, Solutions & Replies">
                                            <i class="fa fa-screwdriver-wrench me-1"></i> Manage Portal
                                        </a>
                                    @elseif($isContact)
                                        <!-- Shortcut to Contact Us Admin Management -->
                                        <a href="{{ route('admin.contact-us.index') }}" class="btn btn-success btn-sm py-1 px-2 fw-semibold" style="font-size: 11.5px;" title="Manage Contact Details">
                                            <i class="fa fa-address-book me-1"></i> Manage Portal
                                        </a>
                                    @endif

                                    <!-- View Live Site -->
                                    <a href="{{ $isTechIssue ? route('industry-tech-issues.index') : route('page.show', $p->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm py-1 px-2" style="font-size: 11.5px;" title="View Live Page">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    <!-- Live Visual Editor (Elementor-Style) -->
                                    <a href="{{ route('admin.pages.visual-editor', $p->id) }}" class="btn btn-sm text-white fw-semibold py-1 px-2 d-flex align-items-center gap-1 shadow-sm" style="background: #721835; font-size: 11.5px;" title="Live Drag & Drop Visual Editor">
                                        <i class="fa-solid fa-paintbrush"></i>
                                        <span>Visual Editor</span>
                                    </a>

                                    <!-- Traditional Edit Form -->
                                    <a href="{{ route('admin.pages.edit', $p->id) }}" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size: 11.5px;" title="Edit Settings & Content">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.pages.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" style="font-size: 11.5px;" title="Delete Page">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noPagesRow">
                            <td colspan="8" class="text-center py-5 text-muted">
                                <span class="material-symbols-outlined mb-2" style="font-size: 48px; opacity: 0.5;">search_off</span>
                                <h6 class="fw-bold text-dark">No pages found</h6>
                                <p class="small mb-3">No pages match your search query or selected filters.</p>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-primary">Reset Filters</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-center">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</div>

<style>
    .quick-stat-card {
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .quick-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }
    .quick-stat-card.active-stat {
        background-color: #faf5f8 !important;
        box-shadow: 0 2px 8px rgba(114, 24, 53, 0.15) !important;
    }
    .page-row:hover {
        background-color: #fdfafc !important;
    }
</style>

<script>
    // Real-time Instant Filter on keyup
    function instantFilterPages(keyword) {
        const query = keyword.toLowerCase().trim();
        const rows = document.querySelectorAll('#pagesTableBody tr.page-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const title = row.getAttribute('data-title') || '';
            const slug = row.getAttribute('data-slug') || '';
            const menu = row.getAttribute('data-menu') || '';

            if (!query || title.includes(query) || slug.includes(query) || menu.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update count badge
        const badge = document.getElementById('pageCountBadge');
        if (badge) {
            badge.innerText = visibleCount;
        }

        // Show/hide no results notice
        let noRow = document.getElementById('clientNoResultsRow');
        if (visibleCount === 0 && rows.length > 0) {
            if (!noRow) {
                noRow = document.createElement('tr');
                noRow.id = 'clientNoResultsRow';
                noRow.innerHTML = `<td colspan="8" class="text-center py-5 text-muted">
                    <span class="material-symbols-outlined mb-2" style="font-size: 42px; opacity: 0.5;">search_off</span>
                    <h6 class="fw-bold text-dark">No matching pages found</h6>
                    <p class="small mb-0">No pages matched "${keyword}". Clear search to view all.</p>
                </td>`;
                document.getElementById('pagesTableBody').appendChild(noRow);
            }
            noRow.style.display = '';
        } else if (noRow) {
            noRow.style.display = 'none';
        }
    }
</script>
@endsection
