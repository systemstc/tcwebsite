@php
    $hasChildren = $item->children && $item->children->count() > 0;
    $depthLabels = [
        0 => ['Top Tab', 'badge-level-0', '#1e1b24', '#ffffff'],
        1 => ['Submenu', 'badge-level-1', '#721835', '#ffffff'],
        2 => ['Sub-layer (L3)', 'badge-level-2', '#0f766e', '#ffffff'],
        3 => ['Layer 4', 'badge-level-3', '#4338ca', '#ffffff'],
    ];
    $lvl = min($depth, 3);
    $badge = $depthLabels[$lvl] ?? ['Level ' . ($depth + 1), 'badge-level-n', '#64748b', '#ffffff'];
@endphp

<div class="menu-item-card depth-{{ $depth }}" data-id="{{ $item->id }}" data-depth="{{ $depth }}">
    <div class="menu-item-header d-flex align-items-center justify-content-between p-2 mb-1 bg-white border rounded shadow-sm">
        <div class="d-flex align-items-center gap-2 flex-grow-1 overflow-hidden">
            <!-- Drag Handle -->
            <span class="drag-handle text-muted px-2 py-1 rounded" title="Drag to reorder or nest/unnest into any menu or submenu" style="cursor: grab; background: #f8fafc; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-grip-vertical text-secondary"></i>
            </span>

            <!-- Level Badge -->
            <span class="badge px-2 py-1 level-badge flex-shrink-0" style="background-color: {{ $badge[2] }}; color: {{ $badge[3] }}; font-size: 11px; font-weight: 600;">
                {{ $badge[0] }}
            </span>

            <!-- Title (English & Hindi) -->
            <div class="d-flex align-items-center gap-2 overflow-hidden text-truncate">
                <span class="fw-bold text-dark item-title text-truncate" style="font-size: 13.5px;">
                    {{ $item->title_en }}
                </span>
                @if($item->title_hi)
                    <span class="text-muted small d-none d-lg-inline text-truncate">({{ $item->title_hi }})</span>
                @endif
            </div>

            <!-- Destination Link Pill -->
            <div class="ms-1 flex-shrink-0">
                @if($item->type === 'page' && $item->page)
                    <span class="badge bg-success-subtle text-success border small" title="CMS Page: {{ $item->page->title_en }}">
                        <i class="fa-solid fa-file-lines me-1"></i>Page: {{ $item->page->slug }}
                    </span>
                @elseif($item->url)
                    <span class="badge bg-light text-secondary border small text-truncate" style="max-width: 160px;" title="{{ $item->url }}">
                        <i class="fa-solid fa-link me-1"></i>{{ $item->url }}
                    </span>
                @endif

                @if(!$item->is_active)
                    <span class="badge bg-warning text-dark small ms-1">Hidden</span>
                @endif
            </div>
        </div>

        <!-- Action Controls -->
        <div class="d-flex align-items-center gap-1 flex-shrink-0 ms-2">
            <!-- Quick Add Submenu / Layer Button -->
            <button type="button" class="btn btn-sm btn-outline-success py-0 px-2 btn-add-sub" onclick="quickAddSubItem({{ $item->id }}, '{{ addslashes($item->title_en) }}')" title="Add submenu / layer inside '{{ $item->title_en }}'" style="font-size: 11.5px; font-weight: 600;">
                <i class="fa fa-plus me-1"></i>Sub-item
            </button>

            <!-- Indent (↳ Make Submenu of above) -->
            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 btn-indent" onclick="indentMenuItem(this, {{ $item->id }})" title="Indent (Move under item above)" style="font-size: 11px;">
                <i class="fa-solid fa-arrow-turn-down fa-rotate-90"></i>
            </button>

            <!-- Outdent (↰ Move up a level) -->
            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 btn-outdent" onclick="outdentMenuItem(this, {{ $item->id }})" title="Outdent (Move out one level)" style="font-size: 11px;" {{ $depth === 0 ? 'disabled' : '' }}>
                <i class="fa-solid fa-arrow-turn-up fa-rotate-270"></i>
            </button>

            <!-- Edit Modal Trigger -->
            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit">
                <i class="fa fa-pencil" style="font-size: 11px;"></i>
            </button>

            <!-- Delete Form -->
            <form action="{{ route('admin.menus.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete \'{{ addslashes($item->title_en) }}\' and all its nested sub-items?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete">
                    <i class="fa fa-trash" style="font-size: 11px;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Recursive Nested Container for Children and Drop Zone -->
    <div class="menu-child-container menu-sortable-list ms-4 ps-2 border-start" data-parent-id="{{ $item->id }}">
        @if($hasChildren)
            @foreach($item->children as $child)
                @include('admin.menus.item-row', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        @endif
    </div>
</div>
