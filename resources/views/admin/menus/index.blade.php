@extends('layouts.admin')

@section('title', 'Header Menu Management')

@section('content')
<div class="row g-4">
    <!-- Left Column: Add New Menu Item -->
    <div class="col-lg-4">
        <div class="cms-card" id="addMenuCard">
            <div class="cms-card-header d-flex align-items-center justify-content-between">
                <h5 class="cms-card-title mb-0">
                    <span class="material-symbols-outlined text-primary">add_link</span> Add New Menu Item
                </h5>
                <span class="badge bg-light text-muted border">Nav Builder</span>
            </div>
            <div class="cms-card-body">
                <!-- Helper notice when '+ Sub-item' is clicked from any row -->
                <div id="subItemNotice" class="alert alert-info py-2 px-3 mb-3 d-none align-items-center justify-content-between">
                    <div>
                        <i class="fa fa-level-down-alt me-1 text-primary"></i>
                        <span>Adding child under: <strong id="subItemTargetName"></strong></span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none text-muted p-0" onclick="cancelSubItemTarget()" title="Reset to Top Tab">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.menus.store') }}" method="POST" id="addMenuForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Menu Title (English) <span class="text-danger">*</span></label>
                        <input type="text" name="title_en" id="menuTitleEn" class="form-control" required placeholder="e.g. Schemes, Handloom Mark, Contact">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Menu Title (Hindi)</label>
                        <input type="text" name="title_hi" class="form-control" placeholder="e.g. योजनाएं, हथकरघा मार्क">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Menu (Dropdown Level)</label>
                        <select name="parent_id" id="parentMenuSelect" class="form-select">
                            <option value="">-- None (Top Level Navigation Tab) --</option>
                            @foreach($parentOptions as $opt)
                                <option value="{{ $opt->id }}">{!! $opt->title !!}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Choose a parent to make this a Submenu or Nested Layer.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link Type <span class="text-danger">*</span></label>
                        <select name="type" id="menuTypeSelect" class="form-select" onchange="toggleLinkInputs(this.value)">
                            <option value="page">Link to CMS Dynamic Page</option>
                            <option value="custom">Custom URL or Anchor (#)</option>
                        </select>
                    </div>

                    <!-- Option A: CMS Page Selector -->
                    <div class="mb-3" id="pageSelectGroup">
                        <label class="form-label fw-semibold">Select CMS Page <span class="text-danger">*</span></label>
                        <select name="page_id" class="form-select">
                            <option value="">-- Choose a CMS Page --</option>
                            @foreach($allPages as $pg)
                                <option value="{{ $pg->id }}">{{ $pg->title_en }} (/page/{{ $pg->slug }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Option B: Custom URL -->
                    <div class="mb-3 d-none" id="customUrlGroup">
                        <label class="form-label fw-semibold">Custom URL / Anchor</label>
                        <input type="text" name="url" class="form-control" placeholder="e.g. #keyOfferings or https://example.com">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Target</label>
                            <select name="target" class="form-select">
                                <option value="_self">Same Tab (_self)</option>
                                <option value="_blank">New Tab (_blank)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0" min="0">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="newActive" checked>
                        <label class="form-check-label fw-semibold" for="newActive">Enabled / Visible</label>
                    </div>

                    <button type="submit" class="btn btn-cms-primary w-100">
                        <i class="fa fa-plus me-1"></i> Add to Menu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Drag & Drop Header Navigation Tree -->
    <div class="col-lg-8">
        <div class="cms-card">
            <div class="cms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="cms-card-title mb-0">
                        <span class="material-symbols-outlined text-primary">account_tree</span> Active Header Navigation Structure
                    </h5>
                    <span id="saveStatusBadge" class="badge bg-success-subtle text-success border">
                        <i class="fa-solid fa-check me-1"></i> Up to date
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="expandAllMenuLayers()" title="Expand all submenu trees">
                        <i class="fa-solid fa-up-right-and-down-left-from-center me-1"></i> Expand All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="collapseAllMenuLayers()" title="Collapse all submenu trees">
                        <i class="fa-solid fa-down-left-and-up-right-to-center me-1"></i> Collapse All
                    </button>
                    <button type="button" class="btn btn-sm text-white fw-bold" id="btnSaveTree" onclick="saveMenuTree(true)" style="background: #721835;" title="Save current arrangement">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Hierarchy
                    </button>
                </div>
            </div>

            <!-- Helpful Drag and Drop Guide Banner -->
            <div class="bg-light border-bottom px-3 py-2 d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 12.5px;">
                <div class="text-secondary">
                    <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                    <strong>Drag & Drop enabled:</strong> Grab any row by the <i class="fa-solid fa-grip-vertical text-muted"></i> handle to reorder or nest inside any menu or submenu. You can also use <strong>↳ Indent</strong> / <strong>↰ Outdent</strong> or click <strong>+ Sub-item</strong>.
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge px-2 py-1" style="background: #1e1b24; color: #fff;">Top Tab</span>
                    <span class="badge px-2 py-1" style="background: #721835; color: #fff;">Submenu (L2)</span>
                    <span class="badge px-2 py-1" style="background: #0f766e; color: #fff;">Sub-layer (L3)</span>
                    <span class="badge px-2 py-1" style="background: #4338ca; color: #fff;">Layer 4</span>
                </div>
            </div>

            <div class="cms-card-body p-3">
                <div id="rootMenuSortable" class="menu-sortable-list" data-parent-id="">
                    @forelse($topMenus as $menu)
                        @include('admin.menus.item-row', ['item' => $menu, 'depth' => 0])
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-network-wired fa-3x mb-3 text-secondary opacity-50"></i>
                            <h6>No menu items configured yet</h6>
                            <p class="small">Use the form on the left to create your first top-level menu tab.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals for ALL Menu Items (Recursive hierarchy support) -->
@foreach($allMenuItems as $item)
    @include('admin.menus.edit-modal', [
        'item' => $item, 
        'parentOptions' => $parentOptions, 
        'allPages' => $allPages
    ])
@endforeach

<style>
    /* Drag & Drop Visual Tree Styling */
    .menu-item-card {
        margin-bottom: 6px;
        position: relative;
        transition: transform 0.15s ease;
    }
    .menu-item-header {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #ffffff;
        transition: all 0.2s ease;
    }
    .menu-item-header:hover {
        border-color: #cbd5e1;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    .drag-handle {
        cursor: grab !important;
        user-select: none;
    }
    .drag-handle:active {
        cursor: grabbing !important;
    }

    /* Distinct level borders */
    .depth-0 > .menu-item-header {
        border-left: 4px solid #1e1b24;
        background: #ffffff;
    }
    .depth-1 > .menu-item-header {
        border-left: 4px solid #721835;
        background: #faf8f9;
    }
    .depth-2 > .menu-item-header {
        border-left: 4px solid #0f766e;
        background: #f7faf9;
    }
    .depth-3 > .menu-item-header,
    .depth-4 > .menu-item-header {
        border-left: 4px solid #4338ca;
        background: #f8f8fc;
    }

    /* Empty nested dropzone (Shows user where to drop to create a sub-layer) */
    .menu-child-container {
        min-height: 4px;
        transition: all 0.2s ease;
    }
    .menu-child-container:empty {
        min-height: 34px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 6px;
        margin: 4px 0 8px 18px;
        background: #fbfcfe;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding-left: 14px;
        font-size: 11px;
        color: #94a3b8;
    }
    .menu-child-container:empty::before {
        content: "↳ Drop here to add layer inside this submenu";
        font-style: italic;
        pointer-events: none;
    }
    .menu-child-container.menu-drag-active {
        background: #fdf2f7 !important;
        border-color: #721835 !important;
    }

    /* SortableJS drag states */
    .menu-ghost-item {
        opacity: 0.4;
        background: #e2e8f0 !important;
        border: 2px dashed #721835 !important;
    }
    .menu-chosen-item {
        background: #fdf2f7 !important;
    }
    .menu-dragging-item {
        box-shadow: 0 10px 25px rgba(0,0,0,0.18) !important;
        transform: scale(1.01);
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    var sortableInstances = [];
    var saveTimer = null;

    document.addEventListener('DOMContentLoaded', function() {
        initAllSortableContainers();
        updateAllLevelBadges();
    });

    // Initialize Sortable on root and every nested child container
    function initAllSortableContainers() {
        // Destroy existing instances if re-initializing
        sortableInstances.forEach(function(inst) {
            try { inst.destroy(); } catch (e) {}
        });
        sortableInstances = [];

        var containers = document.querySelectorAll('.menu-sortable-list');
        containers.forEach(function(container) {
            var sortable = new Sortable(container, {
                group: 'nested-menu',
                animation: 160,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                handle: '.drag-handle',
                ghostClass: 'menu-ghost-item',
                chosenClass: 'menu-chosen-item',
                dragClass: 'menu-dragging-item',
                emptyInsertThreshold: 12,
                onStart: function() {
                    document.querySelectorAll('.menu-child-container:empty').forEach(function(el) {
                        el.classList.add('menu-drag-active');
                    });
                },
                onEnd: function(evt) {
                    document.querySelectorAll('.menu-child-container').forEach(function(el) {
                        el.classList.remove('menu-drag-active');
                    });
                    updateAllLevelBadges();
                    debounceAutoSave();
                }
            });
            sortableInstances.push(sortable);
        });
    }

    // Recalculate visual depth, badges, and button states based on DOM position
    function updateAllLevelBadges() {
        var root = document.getElementById('rootMenuSortable');
        if (!root) return;

        function traverse(container, depth) {
            var items = Array.from(container.children).filter(function(el) {
                return el.classList.contains('menu-item-card');
            });

            items.forEach(function(itemEl) {
                // Update depth class
                itemEl.className = itemEl.className.replace(/\bdepth-\d+\b/g, '').trim();
                itemEl.classList.add('depth-' + depth);
                itemEl.setAttribute('data-depth', depth);

                // Update level badge
                var badgeEl = itemEl.querySelector(':scope > .menu-item-header .level-badge');
                var outdentBtn = itemEl.querySelector(':scope > .menu-item-header .btn-outdent');

                if (badgeEl) {
                    if (depth === 0) {
                        badgeEl.style.backgroundColor = '#1e1b24';
                        badgeEl.style.color = '#ffffff';
                        badgeEl.textContent = 'Top Tab';
                    } else if (depth === 1) {
                        badgeEl.style.backgroundColor = '#721835';
                        badgeEl.style.color = '#ffffff';
                        badgeEl.textContent = 'Submenu';
                    } else if (depth === 2) {
                        badgeEl.style.backgroundColor = '#0f766e';
                        badgeEl.style.color = '#ffffff';
                        badgeEl.textContent = 'Sub-layer (L3)';
                    } else {
                        badgeEl.style.backgroundColor = '#4338ca';
                        badgeEl.style.color = '#ffffff';
                        badgeEl.textContent = 'Layer ' + (depth + 1);
                    }
                }

                if (outdentBtn) {
                    outdentBtn.disabled = (depth === 0);
                }

                // Traverse children
                var childContainer = itemEl.querySelector(':scope > .menu-child-container');
                if (childContainer) {
                    traverse(childContainer, depth + 1);
                }
            });
        }

        traverse(root, 0);
    }

    // Serialize DOM tree into array of { id, parent_id, sort_order, depth }
    function serializeMenuTree() {
        var flatList = [];
        var root = document.getElementById('rootMenuSortable');
        if (!root) return flatList;

        function walk(container, parentId, depth) {
            var items = Array.from(container.children).filter(function(el) {
                return el.classList.contains('menu-item-card');
            });

            items.forEach(function(itemEl, index) {
                var id = parseInt(itemEl.getAttribute('data-id'));
                flatList.push({
                    id: id,
                    parent_id: parentId ? parseInt(parentId) : null,
                    sort_order: index + 1,
                    depth: depth
                });

                var childContainer = itemEl.querySelector(':scope > .menu-child-container');
                if (childContainer) {
                    walk(childContainer, id, depth + 1);
                }
            });
        }

        walk(root, null, 0);
        return flatList;
    }

    // Auto-save debounce
    function debounceAutoSave() {
        showSaveStatus('saving');
        clearTimeout(saveTimer);
        saveTimer = setTimeout(function() {
            saveMenuTree(false);
        }, 600);
    }

    // Save menu tree to backend
    function saveMenuTree(isManual) {
        var items = serializeMenuTree();
        if (!items.length) return;

        showSaveStatus('saving');
        var btn = document.getElementById('btnSaveTree');
        if (btn) btn.disabled = true;

        fetch('{{ route("admin.menus.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ items: items })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (btn) btn.disabled = false;
            if (data.status === 'success') {
                showSaveStatus('saved');
            } else {
                showSaveStatus('error');
                alert(data.message || 'Error saving menu structure');
            }
        })
        .catch(function(err) {
            if (btn) btn.disabled = false;
            showSaveStatus('error');
            console.error('Save menu tree error:', err);
        });
    }

    function showSaveStatus(status) {
        var badge = document.getElementById('saveStatusBadge');
        if (!badge) return;

        if (status === 'saving') {
            badge.className = 'badge bg-warning-subtle text-warning border';
            badge.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving changes...';
        } else if (status === 'saved') {
            badge.className = 'badge bg-success-subtle text-success border';
            badge.innerHTML = '<i class="fa-solid fa-check me-1"></i> Saved successfully';
        } else if (status === 'error') {
            badge.className = 'badge bg-danger-subtle text-danger border';
            badge.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Save failed';
        }
    }

    // Quick Add Sub-item: Selects parent in left form and scrolls to it
    function quickAddSubItem(parentId, parentTitle) {
        var select = document.getElementById('parentMenuSelect');
        var notice = document.getElementById('subItemNotice');
        var nameEl = document.getElementById('subItemTargetName');
        var titleInput = document.getElementById('menuTitleEn');
        var card = document.getElementById('addMenuCard');

        if (select) {
            select.value = parentId;
        }
        if (notice && nameEl) {
            nameEl.textContent = parentTitle;
            notice.classList.remove('d-none');
            notice.classList.add('d-flex');
        }

        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        if (titleInput) {
            setTimeout(function() { titleInput.focus(); }, 350);
        }
    }

    function cancelSubItemTarget() {
        var select = document.getElementById('parentMenuSelect');
        var notice = document.getElementById('subItemNotice');
        if (select) select.value = '';
        if (notice) {
            notice.classList.add('d-none');
            notice.classList.remove('d-flex');
        }
    }

    // One-click Indent: Move under preceding sibling
    function indentMenuItem(btn, id) {
        var card = btn.closest('.menu-item-card');
        if (!card) return;

        var prevCard = card.previousElementSibling;
        while (prevCard && !prevCard.classList.contains('menu-item-card')) {
            prevCard = prevCard.previousElementSibling;
        }

        if (!prevCard) {
            alert('Cannot indent: There is no preceding menu item to nest under.');
            return;
        }

        var targetContainer = prevCard.querySelector(':scope > .menu-child-container');
        if (targetContainer) {
            targetContainer.appendChild(card);
            updateAllLevelBadges();
            initAllSortableContainers();
            debounceAutoSave();
        }
    }

    // One-click Outdent: Move out of current parent
    function outdentMenuItem(btn, id) {
        var card = btn.closest('.menu-item-card');
        if (!card) return;

        var currentParentContainer = card.closest('.menu-child-container');
        if (!currentParentContainer || currentParentContainer.id === 'rootMenuSortable') {
            return; // Already at root
        }

        var parentCard = currentParentContainer.closest('.menu-item-card');
        if (!parentCard) return;

        var grandParentContainer = parentCard.parentElement;
        if (grandParentContainer) {
            // Insert directly after parentCard
            grandParentContainer.insertBefore(card, parentCard.nextSibling);
            updateAllLevelBadges();
            initAllSortableContainers();
            debounceAutoSave();
        }
    }

    // Expand / Collapse All
    function expandAllMenuLayers() {
        document.querySelectorAll('.menu-child-container').forEach(function(el) {
            el.style.display = 'block';
        });
    }

    function collapseAllMenuLayers() {
        document.querySelectorAll('.menu-child-container').forEach(function(el) {
            if (el.id !== 'rootMenuSortable') {
                el.style.display = (el.children.length === 0) ? 'block' : 'none';
            }
        });
    }

    function toggleLinkInputs(val) {
        if (val === 'custom') {
            document.getElementById('pageSelectGroup').classList.add('d-none');
            document.getElementById('customUrlGroup').classList.remove('d-none');
        } else {
            document.getElementById('pageSelectGroup').classList.remove('d-none');
            document.getElementById('customUrlGroup').classList.add('d-none');
        }
    }
</script>
@endpush
@endsection
